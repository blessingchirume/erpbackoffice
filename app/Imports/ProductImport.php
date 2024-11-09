<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Item([
            'item_code' => $row['item_code'],
            'description' => $row['item_description'],
            // 'category' => $row['category'],
            // 'image_url' => $row['image_url'],
            // 'price' => $row['price'],
        ]);
    }

    public function mDate($field)
    {
        $year = substr($field, 0, 2);
        $year = substr($field, 0, 2);
        $year = substr($field, 0, 2);
    }
}
