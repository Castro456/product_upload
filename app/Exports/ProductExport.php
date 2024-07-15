<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection, WithHeadings, WithMapping
{
  public function collection()
  {
    return Product::with('product_image')->get(); //Get the product images
  }

  public function map($product): array
  {
    $imagePaths = $product->product_image->pluck('product_image_path')->implode(', ');

    return [
      $product->product_name,
      $product->price,
      $product->sku,
      $product->description,
      $imagePaths, // Concatenated image paths
    ];
  }

  public function headings(): array //Heading for the excel file
  {
    return [
      'Name',
      'Price',
      'SKU',
      'Description',
      'Images',
    ];
  }

}