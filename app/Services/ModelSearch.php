<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Laravel\Scout\Builder as ScoutBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class ModelSearch
{
    const SEARCH_MODE_DEFAULT = 'sql';
    const SEARCH_MODE_SCOUT = 'scout';

    /** @var string $model */
    protected $model;
    /** @var array $columns */
    protected $columns;
    /** @var callable $callback */
    protected $callback;
    /** @var string $search */
    protected $search;
    /** @var string $mode */
    protected $mode = 'scout';
    /** @var int $limit */
    protected $limit = 10;

    public function __construct(string $model, array $columns = [])
    {
        if (false === class_exists($model)) {
            throw new \InvalidArgumentException("$model is not a valid class");
        }

        $this->model = $model;
        $this->columns = $columns;
    }

    public function withCallback(callable $callback): self
    {
        $this->callback = $callback;

        return $this;
    }

    public function useDefaultSearch(bool $default = true): self
    {
        $this->mode = $default ? self::SEARCH_MODE_DEFAULT : self::SEARCH_MODE_SCOUT;

        return $this;
    }

    public function search(string $search, int $limit = 10): Collection
    {
        $this->search = $search;
        $this->limit = $limit;

        if ($this->mode === self::SEARCH_MODE_SCOUT) {
            $query = $this->searchScout();
        }

        if ($this->mode === self::SEARCH_MODE_DEFAULT) {
            $query = $this->searchDefault();
        }

        if ($query) {
            return $query
                ->take($this->limit)
                ->get();
        }

        throw new \RuntimeException("Empty search columns or missing search term");
    }

    protected function searchDefault(): EloquentBuilder
    {
        /** @var Model $model */
        $model = $this->model;
        $columnsMorphed = [];
        $columnsWhere = [];

        collect($this->columns)->each(function ($item, $key) use (&$columnsMorphed, &$columnsWhere) {
            if (is_array($item)) {
                $columnsMorphed[$key] = $item;
            } else {
                $columnsWhere[] = $item;
            }
        });

        /** @var EloquentBuilder $query */
        $query = $model::query();

        if (! empty($columnsMorphed)) {
            foreach ($columnsMorphed as $morph => $columns) {
                $query = $model::whereHasMorph($morph, ['*'], function (\Illuminate\Database\Eloquent\Builder $query) use ($columns) {
                    foreach ($columns as $key => $column) {
                        $query->where($column, 'LIKE', sprintf('%%%s%%', $this->search), $key === 0 ? 'and' : 'or');
                    }
                });
            }
        }

        if (! empty($columnsWhere)) {
            $query = $model::where(function (\Illuminate\Database\Eloquent\Builder $query) use ($columnsWhere) {
                foreach ($columnsWhere as $key => $column) {
                    $query->where($column, 'LIKE', sprintf('%%%s%%', $this->search), $key === 0 ? 'and' : 'or');
                }
            });
        }

        if ($this->callback) {
            $query->where($this->callback);
        }

        return $query;
    }

    protected function searchScout(): ScoutBuilder
    {
        /** @var Model $model */
        $model = $this->model;
        /** @var ScoutBuilder $query */
        $query = $model::search($this->search);

        if ($this->callback) {
            $query->query($this->callback);
        }

        return $query;
    }
}
