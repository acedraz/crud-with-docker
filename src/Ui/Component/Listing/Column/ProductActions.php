<?php

namespace Ui\Component\Listing\Column;

class ProductActions
{
    const URL_PATH_DELETE = '../Controller/ProductController.php';
    const URL_PATH_EDIT = '../View/editProduct.php';

    public function getActions()
    {
        $data = array(
            'Edit' => self::URL_PATH_EDIT,
            'Delete' => self::URL_PATH_DELETE
        );
        return $data;
    }
}