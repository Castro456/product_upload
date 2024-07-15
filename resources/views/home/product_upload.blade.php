 @extends('layouts.header')

 @section('content')
     <div class="row justify-content-center">
         <div class="col-12" id="product-upload"> 
            {{-- col-sm-8 col-md-6 --}}
             <form class="form mt-2" action="" method="post" id="product-upload-form">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                 <h3 class="text-center text-dark">Product Details Upload</h3>
                 <br>

                  <div class="row">
                    <div class="col-6 mb-4">
                       <label for="product-name" class="text-dark">Product Name:</label><br>
                       <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter product name">
                    </div>
                    <div class="col-6 mb-4">
                       <label for="price" class="text-dark">Price:</label><br>
                       <input type="text" name="price" id="price" class="form-control" placeholder="Enter product price. Eg: 20 or 20.50">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-6 mb-4">
                       <label for="price" class="text-dark">SKU Number:</label><br>
                       <input type="text" name="ske" id="sku" class="form-control" placeholder="Enter product SKU">
                    </div>
                    <div class="col-6 mb-4">
                       <label for="description" class="text-dark">Description:</label><br>
                       <textarea class="form-control" name="description" id="description" placeholder="Enter product description"></textarea>
                    </div>
                  </div>

                  <div class="row">
                     <div class="row mb-3">
                        <label for="images" class="col-sm-4 col-form-label text-dark">Upload Product Images:</label>
                        <div class="col-6">
                           <input type="file" class="form-control mb-2" id="images" name="images[]" accept=".jpeg, .jpg, .png" multiple onchange="previewImages(event)">
                           <div id="image-preview-container" class="d-flex flex-wrap"></div>
                           <button type="button" class="btn btn-sm btn-danger mt-2" id="clear-image" onclick="clearImages()">Clear Images</button>
                        </div>
                     </div>
                  </div>
                  <br>

                 <div class="form-group text-center">
                    <input name="submit" class="btn btn-dark btn-md" value="Submit" id="submit">
                 </div>
             </form>
         </div>
     </div>
 @endsection

 <script src="{{ asset('js/jquery.js') }}"></script>
 <script src="{{ asset('js/product_upload.js') }}"></script>
 <script>
   
</script>