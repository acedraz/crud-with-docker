<!doctype html>
<html lang="pt-br">
<body>
<?php include("init.php"); ?>
<?php include("../frontend/head.php"); ?>
<?php include("../frontend/sidebar.php"); ?>
<?php include("../frontend/header.php"); ?>
<?php include("../frontend/menu.php"); ?>
<?php

use Model\Product;
use Ui\Component\Listing\Column\ProductActions;
use Model\Category;

$categoryObject = new Category();
$productObject = new Product();
$products = $productObject->all();
$ActionsObject = new ProductActions();
$actions = $ActionsObject->getActions();
?>
<!-- Main Content -->
<main class="content">
    <div class="header-list-page">
        <h1 class="title">Products</h1>
        <a href="../View/addProduct.php" class="btn-action">Add new Product</a>
    </div>
    <table class="data-grid">
        <tr class="data-row">
            <th class="data-grid-th">
                <span class="data-grid-cell-content">Image</span>
            </th>
            <th class="data-grid-th">
                <span class="data-grid-cell-content">Name</span>
            </th>
            <th class="data-grid-th">
                <span class="data-grid-cell-content">SKU</span>
            </th>
            <th class="data-grid-th">
                <span class="data-grid-cell-content">Price</span>
            </th>
            <th class="data-grid-th">
                <span class="data-grid-cell-content">Quantity</span>
            </th>
            <th class="data-grid-th">
                <span class="data-grid-cell-content">Categories</span>
            </th>

            <th class="data-grid-th">
                <span class="data-grid-cell-content">Actions</span>
            </th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr class="data-row">
                <td class="data-grid-td">
                    <div class="product-image">
                        <img src="<?php echo Product::PRODUCT_MEDIA_PATH.$product['image']; ?>" layout="responsive" width="164" height="145" alt="<?php echo $product['name']; ?>" />
                    </div>
                </td>
                <td class="data-grid-td">
                    <span class="data-grid-cell-content"><?php echo $product['name'] ?></span>
                </td>

                <td class="data-grid-td">
                    <span class="data-grid-cell-content"><?php echo $product['sku'] ?></span>
                </td>

                <td class="data-grid-td">
                    <span class="data-grid-cell-content">R$ <?php echo $product['price'] ?></span>
                </td>

                <td class="data-grid-td">
                    <span class="data-grid-cell-content"><?php echo $product['qty'] ?></span>
                </td>

                <td class="data-grid-td">
                    <span class="data-grid-cell-content">
                    <?php foreach (json_decode($product['category']) as $category): ?>
                        <?php if (is_numeric($category)) : ?>
                            <?php
                            $categoryObject->loadById((int)$category);
                            echo $categoryObject->getData('name');
                            ?>
                            <Br />
                        <?php else : ?>
                            <?php echo $category; ?>
                            <Br />
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </span>
                </td>

                <td class="data-grid-td">
                    <div class="actions">
                        <?php foreach ($actions as $key => $action): ?>
                            <form method="<?php echo $action; ?>" action="<?php echo $action; ?>"">
                            <?php if ($key == 'Delete') : ?>
                                <input type="hidden" name="_put">
                            <?php endif; ?>
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <input type="submit" value="<?php echo $key; ?>" style="margin-top:15px;margin-left:5px;">
                            </form>
                        <?php endforeach; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>
<!-- Main Content -->
<?php include("../frontend/footer.php"); ?>
</body>
</html>