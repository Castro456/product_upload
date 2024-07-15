<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
  public function model(array $row)
  {
    // Need to add validation

    return new Product([
      'product_name' => $row['name'],
      'price' => $row['price'],
      'sku' => $row['sku'],
      'description' => $row['description'],
      // 'image' => $row['images'] // Image insertion not implemented.
    ]);
  }
}