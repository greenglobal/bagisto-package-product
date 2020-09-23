<?php

namespace GGPHP\Product\Helpers;

class Product
{
    public function randSku($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz-';

        do {
            $sku = substr(str_shuffle(str_repeat($characters, ceil($length/strlen($characters)))), 1, $length);
        } while (substr($sku, -1) === '-' || substr($sku, 0, 1) === '-');

        return $sku;
    }
}
