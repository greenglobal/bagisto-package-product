<?php

namespace GGPHP\Product\Helpers;

class Product
{
    public function getAllAttributeFamily()
    {
        $families = \DB::table('attribute_families')->get();
        $data = [
            [
                'title' => '',
                'value' => 0
            ]
        ];

        if ($families) {
            foreach ($families as $family) {
                $data[] = [
                    'title' => $family->name,
                    'value' => $family->id
                ];
            }
        }

        return $data;
    }
}
