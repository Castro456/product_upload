@component('mail::message')
# New Product Details

**Product Details:**
- Name: {{ $product->product_name }}
- Price: {{ $product->price }}
- SKU: {{ $product->sku }}
- Description: {{ $product->description }}

**Attachments:**
@foreach ($images as $image)
- Attached: {{ $image['name'] }}
@endforeach

Thanks,<br>
{{ config('app.name') }}
@endcomponent