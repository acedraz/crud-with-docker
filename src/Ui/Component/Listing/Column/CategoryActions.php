<?php

namespace Ui\Component\Listing\Column;

class CategoryActions
{
    const URL_PATH_DELETE = '../Controller/CategoryController.php';
    const URL_PATH_EDIT = '../View/editCategory.php';

    public function getActions()
    {
        $data = array(
            'Edit' => self::URL_PATH_EDIT,
            'Delete' => self::URL_PATH_DELETE
        );
        return $data;
    }
}