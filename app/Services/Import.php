<?php

namespace App\Services;

use App\Link;
use App\Tag;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Import
{
    /** @var array $options */
    private $options = [
        'phpprefix' => '<?php /* ',
        'phpsuffix' => ' */ ?>',
        'tags' => true,
        'extras' => false,
        'search' => false,
    ];
    /** @var array $config */
    protected $config;
    /** @var Collection $content */
    protected $content;
    /** @var Collection $tags */
    protected $tags;

    public function __construct(string $filepath, array $config = [])
    {
        $this->config = array_merge($this->options, $config);

        $this->readFile($filepath)
            ->createLinkModels();

        if ($this->config['tags']) {
            $this->createTagsModels()
                ->attachTagsToLinks();
        }

        if ($this->config['extras']) {
            $this->getExtras();
        }

        if ($this->config['search']) {
            $this->updateSearch();
        }
    }

    protected function readFile(string $filepath): self
    {
        try {
            if (false === file_exists($filepath) && false === is_readable($filepath)) {
                throw new \Exception("Import file can't be read: " . $filepath);
            }

            if (false === $content = file_get_contents($filepath)) {
                throw new \Exception("Import file is empty.");
            }

            $content = substr($content, strlen($this->config['phpprefix']), -strlen($this->config['phpsuffix']));

            if (false === $content = base64_decode($content)) {
                throw new \Exception("Unable to base64 decode.");
            }

            if (false === $content = gzinflate($content)) {
                throw new \Exception("Unable to gzinflate content.");
            }

            if (false === $content = unserialize($content)) {
                throw new \Exception("Unable to unserialize content.");
            }

            if (false === is_array($content)) {
                throw new \Exception("Database is not a valid array.");
            }

            $this->content = collect($content);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $this;
    }

    protected function createLinkModels(): self
    {
        $this->tags = collect();
        Link::disableSearchSyncing();

        try {
            $this->content = $this->content->transform(function ($item) {
                $model = new Link();
                $model->title = $item['title'];
                $model->url = $item['url'];
                $model->content = $item['description'];
                $model->is_private = $item['private'];
                $model->created_at = Carbon::createFromFormat('Ymd_His', $item['linkdate']);
                $model->save();

                if (!empty($item['tags'])) {
                    $new_tags = explode(' ', $item['tags']);

                    foreach ($new_tags as $tag) {
                        $this->tags->push(Str::slug($tag));
                    }
                }

                return [
                    'model' => $model,
                    'tags' => $item['tags'],
                    'new_tags' => $new_tags ?? null,
                ];
            });
        } catch (\Exception $e) {
            throw new \Exception("Unable to create links models: " . $e->getMessage());
        }

        return $this;
    }

    protected function createTagsModels(): self
    {
        try {
            $this->tags = $this->tags
                ->unique()
                ->reject(function ($tag) {
                    return empty($tag) || strlen(Str::slug($tag)) < 2;
                })
                ->transform(function ($tag) {
                    return Tag::findNamedOrCreate($tag);
                })
                ->keyBy
                ->name;
        } catch (\Exception $e) {
            throw new \Exception("Unable to create tags models: " . $e->getMessage());
        }

        return $this;
    }

    protected function attachTagsToLinks(): self
    {
        try {
            $this->content
                ->reject(function ($link) {
                    return empty($link['new_tags']);
                })
                ->map(function ($link) {
                    foreach ($link['new_tags'] as $tag) {
                        if ($this->tags->has($tag)) {
                            $link['model']->attachTag($this->tags[$tag]);
                        }
                    }
                });

            $this->content->transform(function ($link) {
                return $link['model'];
            });
        } catch (\Exception $e) {
            throw new \Exception("Unable to attach tags to links: " . $e->getMessage());
        }

        return $this;
    }

    protected function getExtras(): self
    {
        try {
            $this->content
                ->reject(function ($link) {
                    return empty($link->url);
                })
                ->map(function ($link) {
                    return $link->findExtra();
                });
        } catch (\Exception $e) {
            throw new \Exception("Unable to find extras for links: " . $e->getMessage());
        }

        return $this;
    }

    protected function updateSearch(): self
    {
        try {
            $this->content->each(function ($model) {
                $model->searchable();
            });
        } catch (\Exception $e) {
            throw new \Exception("Unable to update search index: " . $e->getMessage());
        }

        return $this;
    }

    public function result(): array
    {
        return [
            'links_count' => $this->content->count(),
            'tags_count' => $this->config['tags'] ? $this->tags->count() : 0,
        ];
    }
}
