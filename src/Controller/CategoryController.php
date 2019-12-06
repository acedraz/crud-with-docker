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

use Model\Category;

class CategoryController
{
    public static function saveAction()
    {
        $category = new Category();
        $category->setData($_POST);
        $select = $category->select("SELECT * FROM category WHERE name = :NAME AND code = :CODE", array(
            ":NAME" => $category->getData('name'),
            ":CODE" => $category->getData('code')
        ));

        if ($select) {
            header("Location: /View/categories.php");
            exit;
        }
        $category->save();
    }

    /**
     * @param $data
     */
    public function deleteAction($data)
    {
        $category = new Category();
        $category->loadById($data['id']);
        $category->delete();
    }

    public function editAction($data)
    {
        $category = new Category();
        $category->loadById($data['_edit']);

        $category->setData($data);

        $category->query("UPDATE category set name=:name, code=:code where id=:id", array(
            ":name" => $category->getData('name'),
            ":code" => $category->getData('code'),
            ":id" => $category->getData('id'),
        ));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['_edit'])) {
    CategoryController::saveAction();
    header("Location: /View/categories.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] && isset($_GET['_put'])) {
    CategoryController::deleteAction($_GET);
    header("Location: /View/categories.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_edit'])) {
    CategoryController::editAction($_POST);
    header("Location: /View/categories.php");
}