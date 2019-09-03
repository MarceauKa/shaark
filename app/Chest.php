<?php

namespace App;

use App\Concerns\Models\Postable;
use Illuminate\Database\Eloquent\Model;

class Chest extends Model
{
    use Postable;

    protected $fillable = [
        'title',
        'content',
    ];

    protected $casts = [
        'content' => 'json',
    ];

    public function getPermalinkAttribute(): string
    {
        return route('chest.view', $this->hash_id);
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
        ];
    }
}
