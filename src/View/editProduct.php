<!doctype html>
<html lang="pt-br">
<body>
<?php include("init.php"); ?>
<?php
use Model\Product;
use Model\Category;

$categoryObject = new Category();
$categories = $categoryObject->all();
$productObject = new Product();
$productObject->loadById($_GET['id']);
?>
<?php include("../frontend/head.php"); ?>
<?php include("../frontend/sidebar.php"); ?>
<?php include("../frontend/header.php"); ?>
<?php include("../frontend/menu.php"); ?>
<!-- Main Content -->
<main class="content">
    <h1 class="title new-item">New Product</h1>
    <form method="POST" action="../Controller/ProductController.php" enctype="multipart/form-data">
        <input type="hidden" name="_edit" value=<?php echo $productObject->getData('id') ?>>
        <div class="input-field">
            <label for="sku" class="label">Product SKU</label>
            <input type="text" id="sku" name="sku" class="input-text" value="<?php echo $productObject->getData('sku') ?>" />
        </div>
        <div class="input-field">
            <label for="name" class="label">Product Name</label>
            <input type="text" id="name" name="name" class="input-text" value="<?php echo $productObject->getData('name') ?>"/>
        </div>
        <div class="input-field">
            <label for="price" class="label">Price</label>
            <input type="text" id="price" name="price"  class="input-text" value="<?php echo $productObject->getData('price') ?>"/>
        </div>
        <div class="input-field">
            <label for="quantity" class="label">Quantity</label>
            <input type="text" id="qty" name="qty"  class="input-text" value="<?php echo $productObject->getData('qty') ?>"/>
        </div>
        <div class="input-field">
            <label for="category" class="label">Categories</label>
            <select multiple id="category" name="category[]" class="input-text">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id'] ?>"
                        <?php foreach (json_decode($productObject->getData('category')) as $categoryId): ?>
                            <?php if ((int)$categoryId == $category['id']) : ?>
                                selected
                            <? endif; ?>
                        <?php endforeach; ?>
                    ><?php echo $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input-field">
            <label for="description" class="label">Description</label>
            <textarea id="description" name="description"  class="input-text"><?php echo $productObject->getData('description') ?></textarea>
        </div>
        <div class="input-field">
            <label for="quantity" class="label">Image</label>
            <input type="file" name="image" id="image" class="input-text" value="<?php echo $productObject->getData('image') ?>">
        </div>
        <div class="actions-form">
            <a href="../View/products.php" class="action back">Back</a>
            <input class="btn-submit btn-action" type="submit" value="Save Product" />
        </div>
    </form>
</main>
<!-- Main Content -->
<?php include("../frontend/footer.php"); ?>
</body>
</html>
