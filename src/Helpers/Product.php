<?php

namespace GGPHP\Admin\Helpers;

class Product
{
    public function randSku($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz-';
        $sku = substr(str_shuffle(str_repeat($characters, ceil($length/strlen($characters)))), 1, $length);

        if (substr($sku, -1) === '-' || substr($sku, 0, 1) === '-') {
            $sku = $this->randSKU();
        }

        return $sku;
    }
}
