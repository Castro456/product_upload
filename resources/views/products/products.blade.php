@extends('layouts.header')
<link rel="stylesheet" href="{{ asset('css/toastr.scss') }}">
@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Product Management</h1>

        <table id="products-table" class="table table-striped">
          <thead>
              <tr>
                  <th>Name</th>
                  <th>Price</th>
                  <th>SKU</th>
                  <th>Description</th>
                  <th>Images</th>
              </tr>
          </thead>
          <tbody>

          </tbody>
        </table>

        <div class="mb-3">
          <button id="export-btn" class="btn btn-primary">Export Products</button>
        </div>

        <form id="import-form" enctype="multipart/form-data">
          <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="mb-3">
              <input type="file" id="import-file" name="import_file" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Import Products</button>
        </form>

        <div id="response-message" class="mt-3"></div>
    </div>

<script src="{{ asset('js/jquery.js') }}"></script>
{{-- <script>
    var products = @json($products); // Pass product data to JavaScript
</script> --}}
<script src="{{ asset('js/products.js') }}"></script>

@endsection
