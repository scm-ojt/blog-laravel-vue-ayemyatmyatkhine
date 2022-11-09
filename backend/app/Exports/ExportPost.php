<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportPost implements FromCollection ,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $posts = Post::with('user')->get();
        $result = [];
        foreach ($posts as $data) {
            $result[] = [
                $data->title,
                $data->body,
                $data->user->name
            ];
        }
        return collect([$result]);
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'Title','Description','Created User'   
        ];
    }
}
