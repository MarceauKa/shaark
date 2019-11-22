<?php

namespace App\Services\Shaark\Concerns;

use App\Services\Shaark\Shaark;
use Illuminate\Http\Request;

/**
 * @mixin Shaark
 */
trait ControlsComments
{
    public function authorizedToSeeComments(Request $request): bool
    {
        if (false === $this->getCommentsEnabled()) {
            return false;
        }

        $user = $request->user();

        if ($user && $user->exists) {
            return true;
        }

        return $this->getCommentsGuestView();
    }

    public function authorizedToAddComments(Request $request): bool
    {
        if (false === $this->getCommentsEnabled()) {
            return false;
        }

        $user = $request->user();

        if ($user && $user->exists) {
            return true;
        }

        return $this->getCommentsGuestAdd();
    }
}
