<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Exports\ProductExport;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * This method is used to list all the products inserted into database and the view page for it.
     * 
     */
    public function index()
    {
        return view('products.products');
    }

    /** 
     * This method is used to export products as Excel file for download
     * 
     */ 
    public function export()
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }


    /**
     * This method is used to import products from Excel file (except image)
     * 
     */ 
    public function import()
    {
        $validate = validator()->make(request()->all(), [
            'import_file' => 'required|mimes:xlsx,xls,csv'
        ])->errors();

        if ($validate->any()) {
            return response()->json([
                'status' => 'validation_failed',
                'message' => $validate->first()
            ], 422);
        }

        $file = request()->file('import_file');

        try {
            Excel::import(new ProductImport, $file);
            return response()->json(['message' => 'Products imported successfully'], 200);
        } 
        catch (\Exception $e) {
            return response()->json(['message' => 'Error importing products: ' . $e->getMessage()], 500);
        }
    }
}
