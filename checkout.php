<?php
include("includes/db.connection.php");
session_start();

// If cart is empty, redirect back
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .checkout-wrapper {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            color: #000000ff;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        table, th, td {
            border: 1px solid #e0e0e0;
        }

        th {
            background: #5e5e5eff;
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            color: #333;
        }

        th:last-child, td:last-child {
            text-align: right;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-top: 5px;
            margin-bottom: 15px;
            font-size: 14px;
            background: #fafafa;
            transition: all 0.2s ease-in-out;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #f26522;
            background: #fff;
        }

        label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        .btn {
            background: #f26522;
            color: white;
            padding: 12px 20px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            border-radius: 6px;
            width: 100%;
            transition: background 0.3s ease-in-out;
        }

        .btn:hover {
            background: #d35400;
        }

        .total-row th {
            font-size: 1.1em;
        }
    </style>
</head>
<body>

<div class="checkout-wrapper">
    <h2>Checkout</h2>

    <!-- Cart Summary -->
    <table>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>
        <?php 
        $total = 0;
        foreach ($_SESSION['cart'] as $item): 
            $price = floatval(str_replace(',', '', $item['price']));
            $subtotal = $price * $item['quantity'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td>₱<?= number_format($price, 2) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>₱<?= number_format($subtotal, 2) ?></td>
        </tr>
        <?php endforeach; ?>
        <tr class="total-row">
            <th colspan="3" style="text-align: right;">Total</th>
            <th>₱<?= number_format($total, 2) ?></th>
        </tr>
    </table>

    <!-- Checkout Form -->
    <form action="place_order.php" method="POST">
        <label>Full Name:</label>
        <input type="text" name="fullname" placeholder="Enter your full name" required>

        <label>Address:</label>
        <textarea name="address" rows="3" placeholder="Enter your delivery address" required></textarea>

        <label>Payment Method:</label>
        <select name="payment_method" required>
            <option value="">-- Select Payment Method --</option>
            <option value="COD">Cash on Delivery</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <option value="GCash">GCash</option>
        </select>

        

        <button type="submit" class="btn">Place Order</button>
    </form>
</div>

</body>
</html>
