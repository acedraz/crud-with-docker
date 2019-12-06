<!doctype html>
<html lang="pt-br">
<body>
<?php include("init.php"); ?>
<?php
use Model\Category;

$category = new Category();
$category->loadById($_GET['id']);
?>
<?php include("../frontend/head.php"); ?>
<?php include("../frontend/sidebar.php"); ?>
<?php include("../frontend/header.php"); ?>
<?php include("../frontend/menu.php"); ?>
<!-- Main Content -->
<main class="content">
    <h1 class="title new-item">New Category</h1>
    <form method="POST" action="../Controller/CategoryController.php">
        <input type="hidden" name="_edit" value=<?php echo $category->getData('id') ?>>
        <div class="input-field">
            <label for="category-name" class="label">Category Name</label>
            <input type="text" id="name" name="name" class="input-text" value="<?php echo $category->getData('name') ?>"  />
        </div>
        <div class="input-field">
            <label for="category-code" class="label">Category Code</label>
            <input type="text" id="code" name="code"  class="input-text" value="<?php echo $category->getData('code') ?>"  />
        </div>
        <div class="actions-form">
            <a href="../View/categories.php" class="action back">Back</a>
            <input class="btn-submit btn-action"  type="submit" value="Save" />
        </div>
    </form>
</main>
<!-- Main Content -->
<?php include("../frontend/footer.php"); ?>
</body>
</html>