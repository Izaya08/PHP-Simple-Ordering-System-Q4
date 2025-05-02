<?php
session_start();

// Taco Bell menu items 
$menu = [
    1 => ['name' => 'Taco', 'price' => 129],
    2 => ['name' => 'Soda', 'price' => 50],
    3 => ['name' => 'Burrito', 'price' => 150],
    4 => ['name' => 'Quesadilla', 'price' => 99],
];

// Set or update quantities
foreach ($menu as $id => $item) {
    if (!isset($_SESSION["qty$id"])) $_SESSION["qty$id"] = 0;
    if (isset($_POST["plus$id"])) $_SESSION["qty$id"]++;
    if (isset($_POST["minus$id"])) $_SESSION["qty$id"] = max(0, $_SESSION["qty$id"] - 1);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Taco Bell Menu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { background: #f8fafc; font-family: Arial, sans-serif; }
        .container { max-width: 420px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); padding: 32px 28px 24px 28px; }
        h1 { text-align: center; color: #6b1e6b; margin-bottom: 28px; }
        .menu-item { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #eee; }
        .menu-item:last-child { border-bottom: none; }
        .item-label { font-weight: 500; color: #4b2e83; min-width: 110px; }
        .price { color: #6b1e6b; font-size: 15px; margin-left: 8px; }
        .quantity-controls { display: flex; align-items: center; gap: 6px; }
        .quantity-controls input[type="submit"] { background: #6b1e6b; color: #fff; border: none; border-radius: 4px; width: 28px; height: 28px; font-size: 18px; cursor: pointer; }
        .quantity { min-width: 22px; text-align: center; font-weight: bold; color: #333; }
        .confirm-btn { width: 100%; background: #6b1e6b; color: #fff; border: none; border-radius: 6px; padding: 12px 0; font-size: 17px; font-weight: bold; margin-top: 18px; cursor: pointer; }
        .order-summary { margin-top: 32px; background: #f3e6f7; border-radius: 8px; padding: 18px 20px; color: #4b2e83; }
        .order-summary h2 { margin-top: 0; color: #6b1e6b; }
    </style>
</head>
<body>
<div class="container">
    <form method="post">
        <h1>🌮 Taco Bell Menu</h1>
        <?php foreach ($menu as $id => $item): ?>
            <div class="menu-item">
                <span class="item-label"><?= chr(64 + $id) ?>. <?= htmlspecialchars($item['name']) ?></span>
                <span class="price"><?= $item['price'] ?> Php</span>
                <div class="quantity-controls">
                    <input type="submit" value="-" name="minus<?= $id ?>">
                    <span class="quantity"><?= $_SESSION["qty$id"] ?></span>
                    <input type="submit" value="+" name="plus<?= $id ?>">
                    <input type="checkbox" name="select<?= $id ?>" value="1">
                </div>
            </div>
        <?php endforeach; ?>
        <input type="submit" name="confirm" value="Confirm Order" class="confirm-btn">
    </form>
    <?php
    if (isset($_POST["confirm"])) {
        $total = 0;
        echo '<div class="order-summary"><h2>Order Summary</h2>';
        $hasOrder = false;
        foreach ($menu as $id => $item) {
            if (isset($_POST["select$id"])) {
                $qty = $_SESSION["qty$id"];
                $lineTotal = $item['price'] * $qty;
                echo htmlspecialchars($item['name']) . " x $qty = $lineTotal Php<br>";
                $total += $lineTotal;
                $hasOrder = true;
            }
        }
        echo $hasOrder ? "<strong>Total: $total Php</strong>" : "No items selected.";
        echo '</div>';
    }
    ?>
</div>
</body>
</html>
