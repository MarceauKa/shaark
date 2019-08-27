<?php

namespace App\Exports;

use App\Link;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LinksExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Link::with('post.tags')
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Titre',
            'URL',
            'Contenu',
            'Extra',
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
            $row->url,
            $row->content,
            $row->extra,
            $row->post->is_private ? 'Oui' : 'Non',
            $row->post->tags->pluck('name')->implode(', '),
            $row->created_at,
        ];
    }


}