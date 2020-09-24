@php
    $productFlat = app('Webkul\Product\Repositories\ProductFlatRepository')->where('product_id', $product->id)->first();
@endphp
<input
    type="text"
    v-validate="'{{$validations}}'"
    class="control"
    id="{{ $attribute->code }}"
    name="{{ $attribute->code }}"
    value="{{ $attribute->code == 'url_key' && $productFlat ? $productFlat->url_key : (old($attribute->code) ?: $product[$attribute->code]) }}"
    {{ in_array($attribute->code, ['sku', 'url_key']) ? 'v-slugify' : '' }}
    data-vv-as="&quot;{{ $attribute->admin_name }}&quot;"
    {{ $attribute->code == 'name' && ! $product[$attribute->code]  ? 'v-slugify-target=\'url_key\'' : '' }} />
