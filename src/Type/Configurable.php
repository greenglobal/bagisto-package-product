<?php

namespace GGPHP\Product\Type;

use Webkul\Product\Type\Configurable as WebkulConfigurable;
use Webkul\Product\Models\ProductAttributeValue;
use Webkul\Product\Models\ProductFlat;
use Illuminate\Support\Str;

class Configurable extends WebkulConfigurable {

    public function createVariant($product, $permutation, $data = [])
    {
        if (! count($data)) {
            $superAttribute = app('Webkul\Product\Repositories\ProductRepository')->getSuperAttributes($product);
            $optionName = [];

            // Get option of super attributes
            foreach ($permutation as $key => $value) {
                foreach ($superAttribute as $attribute) {
                    if ($attribute['id'] == $key) {
                        foreach ($attribute['options'] as $option) {
                            if ($option['id'] == $value) {
                                $optionName[] = $option['admin_name'];
                                break;
                            }
                        }
                    }
                }
            }

            $data = [
                'sku'         => $product->sku . '-variant-' . implode('-', $permutation),
                'name'        => !empty($optionName) ? implode("-", $optionName): '',
                'inventories' => [],
                'price'       => 0,
                'weight'      => 0,
                'status'      => 1
            ];
        }

        $typeOfVariants = 'simple';
        $productInstance = app(config('product_types.' . $product->type . '.class'));

        if (isset($productInstance->variantsType) && ! in_array($productInstance->variantsType , ['bundle', 'configurable', 'grouped'])) {
            $typeOfVariants = $productInstance->variantsType;
        }

        $variant = $this->productRepository->getModel()->create([
            'parent_id'           => $product->id,
            'type'                => $typeOfVariants,
            'attribute_family_id' => $product->attribute_family_id,
            'sku'                 => $data['sku'],
        ]);

        foreach (['sku', 'name', 'price', 'weight', 'status'] as $attributeCode) {
            $attribute = $this->attributeRepository->findOneByField('code', $attributeCode);

            if ($attribute->value_per_channel) {
                if ($attribute->value_per_locale) {
                    foreach (core()->getAllChannels() as $channel) {
                        foreach (core()->getAllLocales() as $locale) {
                            $this->attributeValueRepository->create([
                                'product_id'   => $variant->id,
                                'attribute_id' => $attribute->id,
                                'channel'      => $channel->code,
                                'locale'       => $locale->code,
                                'value'        => $data[$attributeCode],
                            ]);
                        }
                    }
                } else {
                    foreach (core()->getAllChannels() as $channel) {
                        $this->attributeValueRepository->create([
                            'product_id'   => $variant->id,
                            'attribute_id' => $attribute->id,
                            'channel'      => $channel->code,
                            'value'        => $data[$attributeCode],
                        ]);
                    }
                }
            } else {
                if ($attribute->value_per_locale) {
                    foreach (core()->getAllLocales() as $locale) {
                        $this->attributeValueRepository->create([
                            'product_id'   => $variant->id,
                            'attribute_id' => $attribute->id,
                            'locale'       => $locale->code,
                            'value'        => $data[$attributeCode],
                        ]);
                    }
                } else {
                    $this->attributeValueRepository->create([
                        'product_id'   => $variant->id,
                        'attribute_id' => $attribute->id,
                        'value'        => $data[$attributeCode],
                    ]);
                }
            }
        }

        foreach ($permutation as $attributeId => $optionId) {
            $this->attributeValueRepository->create([
                'product_id'   => $variant->id,
                'attribute_id' => $attributeId,
                'value'        => $optionId,
            ]);
        }

        $this->productInventoryRepository->saveInventories($data, $variant);

        return $variant;
    }

    public function update(array $data, $id, $attribute = "id")
    {
        $product = parent::update($data, $id, $attribute);

        if (request()->route()->getName() != 'admin.catalog.products.massupdate') {
            $previousVariantIds = $product->variants->pluck('id');

            if (isset($data['variants'])) {
                foreach ($data['variants'] as $variantId => $variantData) {
                    if (Str::contains($variantId, 'variant_')) {
                        $permutation = [];

                        foreach ($product->super_attributes as $superAttribute) {
                            $permutation[$superAttribute->id] = $variantData[$superAttribute->code];
                        }

                        $this->createVariant($product, $permutation, $variantData);
                    } else {
                        if (is_numeric($index = $previousVariantIds->search($variantId))) {
                            $previousVariantIds->forget($index);
                        }

                        $variantData['channel'] = $data['channel'];
                        $variantData['locale'] = $data['locale'];
                        // add parent name for variants
                        $variantData['parent_name'] = $data['name'];

                        $this->updateVariant($variantData, $variantId);
                    }
                }
            }

            foreach ($previousVariantIds as $variantId) {
                $this->productRepository->delete($variantId);
            }
        }

        return $product;
    }

    public function updateVariant(array $data, $id)
    {
        $variant = $this->productRepository->find($id);
        $productVariant = ProductFlat::where('product_id', $id)->first();

        if ($productVariant && isset($data['parent_name'])) {
            // covert string to format url key, then update variant.
            $urlKey = str_replace(' ', '-', trim(strtolower($data['parent_name'] . '-' . $productVariant->name), ' '));
            $productVariant->update(['url_key' => $urlKey]);
        }

        $variant->update(['sku' => $data['sku']]);

        foreach (['sku', 'name', 'price', 'weight', 'status'] as $attributeCode) {
            $attribute = $this->attributeRepository->findOneByField('code', $attributeCode);

            $attributeValue = $this->attributeValueRepository->findOneWhere([
                'product_id'   => $id,
                'attribute_id' => $attribute->id,
                'channel'      => $attribute->value_per_channel ? $data['channel'] : null,
                'locale'       => $attribute->value_per_locale ? $data['locale'] : null,
            ]);

            if (! $attributeValue) {
                $this->attributeValueRepository->create([
                    'product_id'   => $id,
                    'attribute_id' => $attribute->id,
                    'value'        => $data[$attribute->code],
                    'channel'      => $attribute->value_per_channel ? $data['channel'] : null,
                    'locale'       => $attribute->value_per_locale ? $data['locale'] : null,
                ]);
            } else {
                $this->attributeValueRepository->update([
                    ProductAttributeValue::$attributeTypeFields[$attribute->type] => $data[$attribute->code]
                ], $attributeValue->id);
            }
        }

        $this->productInventoryRepository->saveInventories($data, $variant);

        return $variant;
    }
}
