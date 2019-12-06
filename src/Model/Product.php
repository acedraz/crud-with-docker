<?php

namespace Model;

use Model\AbstractModel\AbstractModel;

class Product extends AbstractModel
{
    const PRODUCT_MEDIA_PATH = '../media/pictures/product/';
    const TABLE_NAME = 'product';
    const FILL_TABLE = [
        "id",
        "name",
        "sku",
        "price",
        "description",
        "qty",
        "category",
        "image"
    ];
}