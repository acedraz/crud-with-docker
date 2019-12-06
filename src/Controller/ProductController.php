<?php

function namespaceAutoload($rawClass)
{
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $rawClass);

    $path = str_replace(["\\", "file"], [DIRECTORY_SEPARATOR, $class], $rawClass);
    if (file_exists("../" .$path . ".php")) {
        require_once "../$path.php";
    }
}
spl_autoload_register("namespaceAutoload");

use Model\Product;

class ProductController
{
    public static function saveAction()
    {
        $product = new Product();
        $_POST['category'] = json_encode($_POST['category']);
        $_POST['image'] = basename($_FILES["image"]["name"]);
        $product->setData($_POST);
        $select = $product->select("SELECT * FROM product WHERE sku = :SKU", array(
            ":SKU" => $product->getData('sku'),
        ));
        if ($select) {
            header("Location: /View/products.php");
            exit;
        }
        $product->save();
        $target_dir = Product::PRODUCT_MEDIA_PATH;
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file( $_FILES['image']['tmp_name'],$target_file);

    }

    /**
     * @param $data
     */
    public function deleteAction($data)
    {
        $product = new Product();
        $product->loadById($data['id']);
        $product->delete();
    }

    public function editAction($data)
    {
        $product = new Product();
        $product->loadById($data['_edit']);
        $data['image'] = $product->getData('image');
        if ($_FILES["image"]["name"]) {
            $data['image'] = basename($_FILES["image"]["name"]);
            $target_dir = Product::PRODUCT_MEDIA_PATH;
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file( $_FILES['image']['tmp_name'],$target_file);
        }
        $data['category'] = json_encode($data['category']);
        $product->setData($data);
        $product->query("UPDATE product set sku=:sku, name=:name, price=:price, qty=:qty, category=:category, description=:description, image=:image where id=:id", array(
            ":sku" => $product->getData('sku'),
            ":name" => $product->getData('name'),
            ":price" => $product->getData('price'),
            ":qty" => $product->getData('qty'),
            ":category" => $product->getData('category'),
            ":description" => $product->getData('description'),
            ":image" => $product->getData('image'),
            ":id" => $product->getData('id'),
        ));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['_edit'])) {
    ProductController::saveAction();
    header("Location: /View/products.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] && isset($_GET['_put'])) {
    ProductController::deleteAction($_GET);
    header("Location: /View/products.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_edit'])) {
    ProductController::editAction($_POST);
    header("Location: /View/products.php");
}