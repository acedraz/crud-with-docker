#!/usr/bin/php
<?php
date_default_timezone_set('America/Sao_Paulo');

function namespaceAutoload($rawClass)
{
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $rawClass);

    $path = str_replace(["\\", "file"], [DIRECTORY_SEPARATOR, $class], $rawClass);
    if (file_exists("./" .$path . ".php")) {
        require_once "./$path.php";
    }
}
spl_autoload_register("namespaceAutoload");
use Model\Product;
$file = fopen($argv[1], "r");
while (($column = fgetcsv($file, 10000, ";")) !== FALSE) {
    $data = array(
        "name" => $column[0],
        "sku" => $column[1],
        "description" => $column[2],
        "qty" => $column[3],
        "price" => $column[4],
        "category" => explode('|',$column[5]),
        "image" => 'vaalue'
    );
    $product = new Product();
    $data['category'] = json_encode($data['category']);
    $product->setData($data);
    $select = $product->select("SELECT * FROM product WHERE sku = :SKU", array(
        ":SKU" => $product->getData('sku'),
    ));
    if ($select) {
        exit;
    }
    $product->save();
}
?>