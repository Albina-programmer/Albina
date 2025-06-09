<?php
session_start();
require 'db.php';

$filter = isset($_GET['category']) ? $_GET['category'] : 'all';

if ($filter === 'all') {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
} else {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category = ? ORDER BY id DESC");
    $stmt->execute([$filter]);
}

$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8" />
    <title>Mobil telefonlar hám aksessuarlar dukanı</title>
    <style>
        /* Global */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background: #e6f4ea;
            color: #2f4f2f;
            padding: 40px 50px;
            min-height: 100vh;
            margin: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        h1 {
            text-align: center;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 50px;
            color: #2c7a2c;
            letter-spacing: 2px;
            text-shadow: 0 2px 6px rgba(40, 167, 69, 0.3);
            user-select: none;
        }

        /* admin */
.admin {
    position: fixed;
    top: 20px;
    right: 20px; 
    background: linear-gradient(135deg, #198038, #28a745);
    color: white;
    padding: 12px 22px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1rem;
    box-shadow: 0 6px 16px rgba(25, 102, 25, 0.6);
    text-decoration: none;
    transition:
        background 0.4s ease,
        box-shadow 0.4s ease,
        transform 0.3s ease;
    user-select: none;
    z-index: 1000;
}
.admin:hover {
    background: linear-gradient(135deg, #28a745, #198038);
    box-shadow: 0 12px 24px rgba(40, 167, 69, 0.8);
    transform: translateY(-4px);
}
.admin:active {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(25, 102, 25, 0.5);
}

        /* Category filters */
        .category {
            text-align: center;
            margin-bottom: 50px;
        }
        .category a {
            display: inline-block;
            padding: 12px 30px;
            margin: 0 15px;
            font-weight: 700;
            font-size: 1.2rem;
            color: #2f4f2f;
            text-decoration: none;
            border-radius: 50px;
            background: #c6e3c6;
            box-shadow:
                0 3px 6px rgba(40, 167, 69, 0.3),
                inset 0 -3px 6px rgba(0,0,0,0.1);
            transition: 
                background-color 0.4s ease,
                color 0.4s ease,
                box-shadow 0.4s ease,
                transform 0.3s ease;
            user-select: none;
        }
        .category a:hover,
        .category a.active {
            background: linear-gradient(135deg, #28a745, #198038);
            color: #ffffff;
            box-shadow:
                0 6px 14px rgba(40, 167, 69, 0.6),
                inset 0 -3px 12px rgba(0,0,0,0.2);
            transform: translateY(-5px) scale(1.05);
        }

        /* Products grid */
        .products {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Product card */
        .product-card {
            background: white;
            width: calc(33.333% - 30px);
            border-radius: 20px;
            padding: 25px 20px 30px;
            box-shadow:
                0 10px 25px rgba(40, 167, 69, 0.15);
            transition: 
                transform 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            cursor: pointer;
            user-select: none;
        }
        .product-card:hover {
            transform: translateY(-12px);
            box-shadow:
                0 20px 40px rgba(40, 167, 69, 0.35),
                0 0 12px 3px rgba(40, 167, 69, 0.45);
        }

        /* Image container */
        .product-image {
            width: 75%;
            margin: 0 auto 25px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(40, 167, 69, 0.15);
            transition: box-shadow 0.4s ease;
        }
        .product-card:hover .product-image {
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.4);
        }
        .product-image img {
            width: 100%;
            display: block;
            transition: transform 0.5s ease;
            border-radius: 15px;
        }
        .product-card:hover .product-image img {
            transform: scale(1.1) rotate(2deg);
            filter: drop-shadow(0 0 6px rgba(40, 167, 69, 0.6));
        }

        /* Product info */
        .product-name {
            font-weight: 700;
            font-size: 1.5rem;
            color: #1b451b;
            margin-bottom: 14px;
            text-align: center;
            text-shadow: 0 1px 3px rgba(40, 167, 69, 0.2);
        }
        .product-info {
            flex-grow: 1;
            font-size: 1rem;
            line-height: 1.5;
            color: #3c683c;
            margin-bottom: 22px;
            text-align: center;
            min-height: 80px;
        }
        .product-price {
            font-weight: 800;
            font-size: 1.3rem;
            color: #196619;
            margin-bottom: 30px;
            text-align: center;
            text-shadow: 0 1px 2px rgba(25, 102, 25, 0.3);
        }

        /* Buy button */
        .buy-btn {
            background: linear-gradient(135deg, #198038, #28a745);
            color: white;
            font-weight: 700;
            font-size: 1.15rem;
            border: none;
            padding: 15px 0;
            border-radius: 50px;
            box-shadow: 0 6px 16px rgba(25, 102, 25, 0.6);
            cursor: pointer;
            user-select: none;
            transition:
                background 0.4s ease,
                box-shadow 0.4s ease,
                transform 0.3s ease;
            width: 100%;
            letter-spacing: 1px;
        }
        .buy-btn:hover {
            background: linear-gradient(135deg, #28a745, #198038);
            box-shadow: 0 12px 24px rgba(40, 167, 69, 0.8);
            transform: translateY(-4px);
        }
        .buy-btn:active {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(25, 102, 25, 0.5);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .product-card {
                width: calc(50% - 30px);
            }
        }
        @media (max-width: 600px) {
            body {
                padding: 30px 20px;
            }
            h1 {
                font-size: 2.3rem;
                margin-bottom: 40px;
            }
            .category a {
                font-size: 1rem;
                padding: 10px 22px;
                margin: 0 10px;
            }
            .product-card {
                width: 100%;
                padding: 20px 18px 25px;
            }
            .product-name {
                font-size: 1.3rem;
            }
            .buy-btn {
                font-size: 1.05rem;
                padding: 13px 0;
            }
        }

        /* Message when no products */
        .no-products-msg {
            text-align: center;
            font-size: 1.3rem;
            color: #4c7c4c;
            margin-top: 50px;
            user-select: none;
        }
    </style>
</head>
<body>


<a href="admin.php" class="admin" tabindex="0" aria-label="admin">kiriw</a>

<h1>Mobil telefonlar hám aksessuarlar dukanı</h1>

<div class="category">
    <a href="index.php?category=all" class="<?= $filter=='all' ? 'active' : '' ?>">Hámmesi</a>
    <a href="index.php?category=smartfon" class="<?= $filter=='smartfon' ? 'active' : '' ?>">Telefonlar</a>
    <a href="index.php?category=aksessuar" class="<?= $filter=='aksessuar' ? 'active' : '' ?>">Aksessuarlar</a>
</div>

<div class="products">
    <?php if (count($products) === 0): ?>
        <p class="no-products-msg">Hesh qanday ónim joq.</p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="product-card" tabindex="0" aria-label="<?= htmlspecialchars($product['name']) ?>">
                <div class="product-image">
                    <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" />
                </div>
                <div class="product-name"><?= htmlspecialchars($product['name']) ?></div>
                <div class="product-info"><?= htmlspecialchars($product['info']) ?></div>
                <div class="product-price"><?= htmlspecialchars($product['price']) ?> $</div>
                <form method="GET" action="buyurtma.php" style="margin:0;">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit" class="buy-btn">Buyurtpa beriw</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
