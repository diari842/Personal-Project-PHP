<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $quantity = $_POST["quantity"];

    $result = $conn->query("SELECT price, stock FROM products WHERE id = '$product_id'");
    $product = $result->fetch_assoc();

    if ($product["stock"] >= $quantity) {
        $total_price = $product["price"] * $quantity;
        $conn->query("INSERT INTO sales (product_id, quantity, total_price) VALUES ('$product_id', '$quantity', '$total_price')");
        $conn->query("UPDATE products SET stock = stock - '$quantity' WHERE id = '$product_id'");
        echo "Sale successful! <a href='dashboard.php'>Back</a>";
    } else {
        echo "Not enough stock.";
    }
}

$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head><title>Sell Product</title></head>
<body>
    <h2>Sell Product</h2>
    <form method="POST">
        <label>Product:</label>
        <select name="product_id">
            <?php while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row["id"]}'>{$row["name"]} ({$row["stock"]} left)</option>";
            } ?>
        </select><br>
        <label>Quantity:</label>
        <input type="number" name="quantity" required><br>
        <button type="submit">Sell</button>
    </form>
</body>
</html>