<?php

namespace GGPHP\Product\Http\Controllers;

use Webkul\Product\Http\Requests\ProductForm;
use Webkul\Product\Http\Controllers\ProductController as WebkulProductController;

class ProductController extends WebkulProductController
{
    public function update(ProductForm $request, $id)
    {
        $data = request()->all();

        if (core()->getConfigData('catalog.products.general.channel-default')) {
            array_merge($data, ['channels' => 'default']);
        }

        $multiselectAttributeCodes = array();

        $productAttributes = $this->productRepository->findOrFail($id);

        foreach ($productAttributes->attribute_family->attribute_groups as $attributeGroup) {
            $customAttributes = $productAttributes->getEditableAttributes($attributeGroup);

            if (count($customAttributes)) {
                foreach ($customAttributes as $attribute) {
                    if ($attribute->type == 'multiselect') {
                        array_push($multiselectAttributeCodes, $attribute->code);
                    }
                }
            }
        }

        if (count($multiselectAttributeCodes)) {
            foreach ($multiselectAttributeCodes as $multiselectAttributeCode) {
                if (! isset($data[$multiselectAttributeCode])) {
                    $data[$multiselectAttributeCode] = array();
                }
            }
        }

        $product = $this->productRepository->update($data, $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Product']));

        return redirect()->route($this->_config['redirect']);
    }
}
