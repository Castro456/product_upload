<?php

namespace App\Http\Controllers;

use App\Mail\AdminNotification;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class APIProductController extends Controller
{

    /**
     * Store a newly created product in the database
     * 
     * @param product_name
     * @param price
     * @param sku
     * @param description
     * @param images
     * 
     * @return json
     */
    public function store(Request $request)
    {
        $validator = validator()->make(request()->all(), [
            'product_name' => 'bail|required|string|max:255',
            'price' => 'bail|required|numeric|min:0',
            'sku' => 'bail|required|string|unique:products,sku',
            'description' => 'bail|nullable|string',
            'images.*' => 'bail|image|mimes:jpeg,png,jpg|max:2048' // max 2MB per image
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $new_product = new Product();
            $new_product->product_name = request('product_name');
            $new_product->price = request('price');
            $new_product->sku = request('sku');
            $new_product->description = request('description');

            $new_product->save();
            $product_id = $new_product->id;

            $product = Product::findOrFail($product_id);

            if($product_id) {
                if (request()->hasFile('images')) {
                    foreach (request()->file('images') as $image) {
                        $imagePath = $image->store('product_images', 'public');
    
                        // Insert images into product_image table
                        $new_product_image = ProductImage::create([
                            'product_id' => $product_id,
                            'product_image_path' => $imagePath
                        ]);

                        // Store the image for email attachments
                        $imagePaths[] = [
                            'path' => storage_path('app/public/' . $imagePath),
                            'name' => $image->getClientOriginalName(), // original file name
                            'mime' => $image->getClientMimeType(), // mime type
                        ];
                    }

                    $details = [
                        'to' => 'castrosid456@gmail.com', // to/admin email address
                        'product' => $product,
                        'images' => $imagePaths ?? [],
                    ];

                    // Queue for email to list new products with it's attachments to the admin.
                    Mail::to($details['to'])->queue(new AdminNotification($details));
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Product details updated successfully'
                ], 200);
            }
            else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Product details are not created'
                ], 500);
            }
        } 
        catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
