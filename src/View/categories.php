<!doctype html>
<html lang="pt-br">
<body>
<?php include("init.php"); ?>
<?php include("../frontend/head.php"); ?>
<?php include("../frontend/sidebar.php"); ?>
<?php include("../frontend/header.php"); ?>
<?php include("../frontend/menu.php"); ?>
<?php

use Model\Category;
use Ui\Component\Listing\Column\CategoryActions;

$categoryObject = new Category();
$categories = $categoryObject->all();
$ActionsObject = new CategoryActions();
$actions = $ActionsObject->getActions();
?>
<!-- Main Content -->
<main class="content">
    <div class="header-list-page">
        <h1 class="title">Categories</h1>
        <a href="../View/addCategory.php" class="btn-action">Add new Category</a>
    </div>
    <table class="data-grid">
        <tr class="data-row">
            <th class="data-grid-th">
                <span class="data-grid-cell-content">Name</span>
            </th>
            <th class="data-grid-th">
                <span class="data-grid-cell-content">Code</span>
            </th>
            <th class="data-grid-th">
                <span class="data-grid-cell-content">Actions</span>
            </th>
        </tr>
        <?php foreach ($categories as $category): ?>
        <tr class="data-row">
            <td class="data-grid-td">
                <span class="data-grid-cell-content"><?php echo $category['name'] ?></span>
            </td>

            <td class="data-grid-td">
                <span class="data-grid-cell-content"><?php echo $category['code']; ?></span>
            </td>

            <td class="data-grid-td">
                <div class="actions">
                    <?php foreach ($actions as $key => $action): ?>
                        <form method="<?php echo $action; ?>" action="<?php echo $action; ?>"">
                        <?php if ($key == 'Delete') : ?>
                            <input type="hidden" name="_put">
                        <?php endif; ?>
                            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
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