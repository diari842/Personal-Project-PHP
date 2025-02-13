<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include "config.php";

$result = $conn->query("SELECT COUNT(*) AS total_products FROM products");
$total_products = $result->fetch_assoc()["total_products"];

$result = $conn->query("SELECT SUM(quantity) AS total_sales FROM sales");
$total_sales = $result->fetch_assoc()["total_sales"];

echo "<h2>Welcome, " . $_SESSION["username"] . "!</h2>";
echo "<p>Total Products: $total_products</p>";
echo "<p>Total Sales: $total_sales</p>";
echo "<a href='add_product.php'>Add Product</a> | <a href='sell_product.php'>Sell Product</a> | <a href='logout.php'>Logout</a>";
?>