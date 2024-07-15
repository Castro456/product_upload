<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
  public function model(array $row)
  {

    Validator::make($row, [
      'product_name' => 'required',
      'price' => 'required|numeric',
      'sku' => [
        'required',
        Rule::unique('products', 'sku')
      ],
      'description' => 'required',
      // 'image_path' => 'required',
    ])->validate();

    // Not implemented image insert
    $product = Product::create([
      'product_name' => $row['product_name'],
      'price' => $row['price'],
      'sku' => $row['sku'],
      'description' => $row['description'],
    ]);

    return $product;
  }
}