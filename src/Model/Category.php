<?php

namespace Model;

use Model\AbstractModel\AbstractModel;

class Category extends AbstractModel
{
    const TABLE_NAME = 'category';
    const FILL_TABLE = [
        "id",
        "code",
        "name",
    ];
}