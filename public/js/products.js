$(document).ready(function () {
  var baseUrl = window.location.origin

  function fetchProducts() {
    $('#products-table tbody').empty(); // Clear existing rows

    $.each(products, function(index, product) {
        var imagesHtml = '';
        $.each(product.product_image, function(i, image) {
            imagesHtml += '<img src="' + image.image_url + '" alt="Product Image" style="max-width: 100px;">';
        });

        var row = '<tr>' +
                    '<td>' + product.product_name + '</td>' +
                    '<td>' + product.price + '</td>' +
                    '<td>' + product.sku + '</td>' +
                    '<td>' + product.description + '</td>' +
                    '<td>' + imagesHtml + '</td>' +
                  '</tr>';

        $('#products-table tbody').append(row); // Insert values into tbody table
    });
  }
  fetchProducts(); // Call the function in file load

  // Export products as excel file
  $('#export-btn').click(function() {
    window.location.href = baseUrl + '/products/export';
  });
  
  // Import product from excel file
  $('#import-form').submit(function(event) {
      event.preventDefault();
      var formData = new FormData();
      formData.append('import_file', $('#import-file')[0].files[0]);

      toastr.options = {
        "positionClass": "toast-bottom-right",
      }

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: baseUrl + '/products/import',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            toastr.success('Product imported successfully')
            fetchProducts(); // Refresh product list after import
          },
          error: function(xhr) {
            var errorMessage = 'Error importing products: ' + xhr.responseText;
            toastr.error(errorMessage)
          }
      });
    });

})