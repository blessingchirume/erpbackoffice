<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Product([
            'name' => $row['name'],
            'description' => $row['description'],
            'product_category_id' => $row['product_category_id'],
            'unit_cost' => $row['unit_cost'],
            'price' => $row['price'],
            'stock' => $row['stock'],
            'stock_defective' => $row['stock_defective'],
        ]);
    }

    public function mDate($field)
    {
        $year = substr($field, 0, 2);
        $year = substr($field, 0, 2);
        $year = substr($field, 0, 2);
    }
}
