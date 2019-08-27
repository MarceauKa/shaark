<?php

namespace App\Exports;

use App\Story;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StoriesExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Story::with('post.tags')
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Titre',
            'Slug',
            'Contenu',
            'Privé ?',
            'Tags',
            'Créé le',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->title,
            $row->slug,
            $row->content,
            $row->post->is_private ? 'Oui' : 'Non',
            $row->post->tags->pluck('name')->implode(', '),
            $row->created_at,
        ];
    }


}