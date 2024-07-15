function previewImages(event) {
  var previewContainer = document.getElementById('image-preview-container');
  previewContainer.innerHTML = ''; // Clear previous previews
  
  var files = event.target.files;
  for (var i = 0; i < files.length; i++) {
      var file = files[i];
      var reader = new FileReader();
      
      reader.onload = function(e) {
        var imageElement = document.createElement('div');
        imageElement.className = 'position-relative m-2';
        
        var image = document.createElement('image');
        image.className = 'image-preview';
        image.style.maxWidth = '150px';
        image.style.maxHeight = '150px';
        image.src = e.target.result;
        
        imageElement.appendChild(image);
        previewContainer.appendChild(imageElement);
      }
      
      reader.readAsDataURL(file);
  }
}

// Clear all previewed images
function clearImages() {
  var previewContainer = document.getElementById('image-preview-container');
  previewContainer.innerHTML = ''; 
  document.getElementById('images').value = '';
}

$(document).ready(function() {
  var baseURL = window.location.origin

  // A JS library for showing the responses
  toastr.options = {
      "positionClass": "toast-bottom-right",
  }
  
  $('#submit').click(function() {
    var productName = $('#product_name').val()
    var price = $('#price').val()
    var sku = $('#sku').val()
    var description = $('#description').val()
    let checkPrice = /^\d+(\.\d{1,2})?$/
  
    if(productName == '' || productName == null){
      toastr.warning('Product name cannot be empty')
      return false
    }
    else if(price == '' || price == null){
      toastr.warning('Product price cannot be empty')
      return false
    }
    else if(!(checkPrice.test(price))){
      toastr.warning('Product price can only contain numbers/decimals')
      return false
    }
    else if(sku == '' || sku == null){
      toastr.warning('Product SKU cannot be empty')
      return false
    }
    else if(description == '' || description == null){
      toastr.warning('Product description cannot be empty')
      return false
    }

    var formData = new FormData();
    formData.append('product_name', productName);
    formData.append('price', price);
    formData.append('sku', sku);
    formData.append('description', description);

    var validImgFormats = ['image/jpeg', 'image/jpg', 'image/png']; //Only these types of image format are allowed.
    var allImageFiles = $('#images')[0].files;

    if(allImageFiles.length <= 0 || allImageFiles == '' || allImageFiles == null) {
      toastr.warning('Please choose product image')
      return false
    }
    
    //Validate all the selected images are of correct format
    for (var i = 0; i < allImageFiles.length; i++) {
      if ($.inArray(allImageFiles[i].type, validImgFormats) === -1) {
        toastr.warning('Only JPEG and PNG images are allowed')
        return false
      }
    }

    for (var i = 0; i < allImageFiles.length; i++) {
        formData.append('images[]', allImageFiles[i]);
    }

    $('#submit').val('Uploading...')
    $('#submit').prop('disabled',true)

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url : baseURL + '/api/product/store',
      data: formData,
      type : 'POST',
      processData: false, //Don't process the form data
      contentType: false,
      success : function(result) {
        if(result.status == 'success') {
          $('#submit').val('Upload')
          $('#submit').prop('disabled',false)
          $('#product').val('')
          $('#price').val('')
          $('#sku').val('')
          $('#description').val('')
          $('#images').val('')
          toastr.success(result.message)
          getStudents();
        }
      },
      error: function(error) {
        toastr.warning(error.message)
        $('#submit').val('Upload')
        $('#submit').prop('disabled',false)
      }
    });
  })
})
