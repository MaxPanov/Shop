<?php 

include_once "DB.php";

#[AllowDynamicProperties]

class Product {

    private $product_id;
    private $name;
    private $price;
    private $weight;

    function __get($property) {
        return $this->$property;
    }

    function __set($name, $value) {
        $this->$name = $value;
    }

    static function getProducts(): ?array {
        $products = DB::query("SELECT * FROM `Product`", [], self::class);
        return $products;
    }
}