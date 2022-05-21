<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NewsletterExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize {

    protected $subscribers;

    public function __construct($subscribers) {
        $this->subscribers = $subscribers;
    }

    public function collection() : Collection {
        return $this->subscribers;
    }

    public function headings() : array {
        return [
            'ID',
            'Email',
            'Subscribed Since',
        ];
    }

    public function map($row) : array {
        return [
            $row->id,
            $row->email,
            $row->created_at,
        ];
    }
}
