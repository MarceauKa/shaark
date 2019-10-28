<?php

namespace App\Http\Controllers\Api\Manage;

use App\Http\Controllers\Controller;
use App\Services\LinkArchive\LinkArchive;
use App\Services\LinkArchive\YoutubeDlProvider;
use App\Services\Shaarli\Shaarli;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('demo');
    }

    public function check(Request $request, Shaarli $shaarli, string $type)
    {
        if (false === in_array($type, ['pdf', 'media'])) {
            abort(404);
        }

        if ($type === 'pdf') {
            if (false === $shaarli->getLinkArchivePdf()) {
                return $this->sendError(__('Archive as PDF is not enabled'));
            }

            $exec = $shaarli->getNodeBin();
            exec($exec . ' --version', $result);

            if (empty($result)) {
                return $this->sendError(__('Your node path is unreachable: :path', ['path' => $exec]));
            }

            $dir = base_path('node_modules/puppeteer/.local-chromium');

            if (false === is_dir($dir)) {
                return $this->sendError(__('Puppeteer dependencies not installed, run `npm install @nesk/puphpeteer --no-save`'));
            }

            try {
                $name = LinkArchive::archive(url()->route('home'), 'pdf');
            } catch (\Exception $e) {
                return $this->sendError(__('Unable to create archive, error is: :message', ['message' => $e->getMessage()]));
            }

            Storage::disk('archives')->delete($name);
        }

        if ($type === 'media') {
            if (false === $shaarli->getLinkArchiveMedia()) {
                return $this->sendError(__('Archive as Media is not enabled'));
            }

            $exec = $shaarli->getYoutubeDlBin();
            exec($exec . ' --version', $result);

            if (empty($result)) {
                return $this->sendError(__('Your youtube-dl path is unreachable: :path', ['path' => $exec]));
            }

            $status = YoutubeDlProvider::test('https://www.youtube.com/watch?v=oavMtUWDBTM');

            if ($status === false) {
                return $this->sendError(__("Unknow error. Check if python is correctly installed on your system"));
            }
        }

        return response()->json([
            'status' => 'success',
        ]);
    }

    protected function sendError(string $message): JsonResponse
    {
        return response()->json([
            'status' => 'fail',
            'message' => $message
        ], 422);
    }
}
