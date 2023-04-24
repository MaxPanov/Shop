<?php

class Basket {

    private static $products;

    static function getProducts($user_id): ?array {

        $products = DB::query("SELECT P.`product_id`, P.`name`, P.`price`, P.`weight`, B.`basket_id`, B.`count` FROM `Product` P, `Basket` B WHERE B.`user_id` = $user_id AND B.`product_id` = P.`product_id`", [], Product::class);
        self::$products = $products;
        return $products;
    }

    static function getPrice() {

        $endPrice = 0;
        if (self::$products) foreach (self::$products as $product) {
            $endPrice += ($product->count * $product->price);
        }

        return $endPrice;
    }

    static function getWeight() {

        $endWeight = 0;
        if (self::$products) foreach (self::$products as $product) {
            $endWeight += ($product->count * $product->weight);
        }

        return $endWeight;
    }
}