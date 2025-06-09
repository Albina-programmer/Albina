<?php
session_start();

// Buyurtma sessiyada borligini tekshiramiz
if (!isset($_SESSION['order'])) {
    header("Location: index.php");
    exit;
}

$order = $_SESSION['order'];

// Bazaga jazıladı, biraq paydalanıwshıǵa sulıw bet kórsetiledi.
include "db.php";

// Tek bir márte jazılıwın támiyinlew ushın sessiyada flag qosamız.
if (!isset($_SESSION['order_saved'])) {

    // $ belgisi yamasa basqa belgilerdi alıp taslaymiz.
    $clean_price = preg_replace('/[^0-9.]/', '', $order['product_price']);

    $sql = "INSERT INTO orders (name, surname, phone, email, product_name, product_price)
            VALUES (:name, :surname, :phone, :email, :product_name, :product_price)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name'          => $order['name'],
        ':surname'       => $order['surname'],
        ':phone'         => $order['phone'],
        ':email'         => $order['email'],
        ':product_name'  => $order['product_name'],
        ':product_price' => $clean_price, // tozalangan narx
    ]);

    $_SESSION['order_saved'] = true;
}

?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8" />
    <title>Buyurtpa tasdıyıqlandı</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f8;
            color: #333;
            padding: 50px 30px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .confirmation-box {
            background: white;
            border-radius: 20px;
            padding: 40px 50px;
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.15);
            max-width: 500px;
            width: 100%;
            text-align: center;
            animation: fadeIn 0.8s ease forwards;
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }
        h1 {
            color: #28a745;
            font-size: 2.4rem;
            margin-bottom: 30px;
            text-shadow: 0 2px 6px rgba(40,167,69,0.5);
        }
        p {
            font-size: 1.2rem;
            margin: 15px 0;
            color: #555;
        }
        .label {
            font-weight: 700;
            color: #007BFF;
            margin-right: 6px;
        }
        hr {
            border: none;
            border-top: 1.5px solid #eee;
            margin: 30px 0;
        }
        .btn-home {
            margin-top: 35px;
            display: inline-block;
            padding: 14px 35px;
            background-color: #007BFF;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
            border-radius: 35px;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        .btn-home:hover {
            background-color: #0056b3;
            box-shadow: 0 8px 25px rgba(0, 86, 179, 0.6);
        }
    </style>
</head>
<body>

<div class="confirmation-box">
    <h1>Buyırtpa tabıslı qabıl etildi!</h1>

    <p><span class="label">Atı:</span> <?= htmlspecialchars($order['name']) ?></p>
    <p><span class="label">Familiya:</span> <?= htmlspecialchars($order['surname']) ?></p>
    <p><span class="label">Telefon:</span> <?= htmlspecialchars($order['phone']) ?></p>
    <p><span class="label">Email:</span> <?= htmlspecialchars($order['email']) ?></p>
    <hr>
    <p><span class="label">Ónim:</span> <?= htmlspecialchars($order['product_name']) ?></p>
    <p><span class="label">Baxası:</span> <?= number_format($order['product_price'], 0, ',', ' ') ?> $ </p>

    <a href="index.php" class="btn-home">Bas betke qaytıw</a>
</div>

</body>
</html>
