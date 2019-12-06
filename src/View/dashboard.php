<?php include("./frontend/head.php"); ?>
<?php include("./frontend/sidebar.php"); ?>
<?php include("./frontend/header.php"); ?>
<?php include("./frontend/menu.php"); ?>
<?php
use Model\Product;

$productObject = new Product();
$products = $productObject->all();
?>
<main class="content">
    <div class="header-list-page">
        <h1 class="title">Dashboard</h1>
    </div>
    <div class="infor">
        You have <?php echo count($products); ?> products added on this store: <a href="../View/addProduct.php" class="btn-action">Add new Product</a>
    </div>
    <ul class="product-list">
        <?php
        foreach ($products as $product):
            ?>
            <li>
                <div class="product-image">
                    <img src="<?php echo Product::PRODUCT_MEDIA_PATH.$product['image']; ?>" layout="responsive" width="164" height="145" alt="<?php echo $product['name']; ?>" />
                </div>
                <div class="product-info">
                    <div class="product-name"><span><?php echo $product['name']; ?></span></div>
                    <div class="product-price">
                        <span class="special-price">
                            <?= ($product['qty'] > 0) ? $product['qty']." available" : "Out of stock" ?>
                        </span>
                        <span>R$<?php echo str_replace(".",",", $product['price']); ?></span></div>
                </div>
            </li>
        <?php
        endforeach;
        ?>
    </ul>
</main>
<?php include("./frontend/footer.php"); ?>