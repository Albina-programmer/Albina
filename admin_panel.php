<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit;
}

require 'db.php';

// Ónimdi óshiriw (GET orqali id)
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];

    // Eski suwretti óshiriw
    $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$delete_id]);
    $old_image = $stmt->fetchColumn();

    if ($old_image && file_exists('uploads/' . $old_image)) {
        unlink('uploads/' . $old_image);
    }

    // ónimdi óshiriw
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$delete_id]);

    header("Location: admin_panel.php");
    exit;
}

// Ónimdi alıw
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="uz">
<head>
<meta charset="UTF-8" />
<title>Admin panel - Ónimdi bosqarıw</title>
<style>
    body {
        background-color: #e6f2e6;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #064420;
        margin: 0;
        padding: 20px;
    }
    h1 {
        text-align: center;
        margin-bottom: 25px;
        color: #145214;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    .top-bar {
        max-width: 1200px;
        margin: 0 auto 25px auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn {
        background-color: #3ca13c;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 16px;
        text-decoration: none;
        box-shadow: 0 5px 12px rgba(60,161,60,0.6);
        transition: background-color 0.3s ease;
    }
    .btn:hover {
        background-color: #2e7d2e;
        box-shadow: 0 7px 15px rgba(46,125,46,0.8);
    }
    table {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        border-collapse: collapse;
        box-shadow: 0 8px 25px rgba(20, 82, 20, 0.15);
        background: #f7fcf7;
        border-radius: 12px;
        overflow: hidden;
    }
    thead {
        background-color: #3ca13c;
        color: #f0faf0;
    }
    th, td {
        padding: 14px 20px;
        text-align: left;
        font-size: 15px;
        border-bottom: 1px solid #a7d7a7;
    }
    tbody tr:hover {
        background-color: #e0f2e0;
    }
    img.product-image {
        max-width: 70px;
        border-radius: 8px;
        border: 2px solid #a7d7a7;
    }
    .actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .actions a {
        margin: 0;
        color: #064420;
        font-weight: 700;
        text-decoration: none;
        padding: 6px 10px;
        border-radius: 6px;
        border: 1.5px solid #3ca13c;
        font-size: 14px;
        transition: background-color 0.3s ease, color 0.3s ease;
        white-space: nowrap;
    }
    .actions a:hover {
        background-color: #3ca13c;
        color: white;
        box-shadow: 0 5px 12px rgba(60,161,60,0.6);
    }
    .actions a:last-child {
        color: #c0392b;
        border-color: #c0392b;
    }
    .logout {
        background-color: #c0392b;
        border: none;
        color: white;
        font-weight: 700;
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 5px 12px rgba(192,57,43,0.7);
        transition: background-color 0.3s ease;
        text-decoration: none;
    }
    .logout:hover {
        background-color: #8e281f;
        box-shadow: 0 7px 15px rgba(142,40,31,0.9);
    }
    .footer {
        max-width: 1200px;
        margin: 40px auto 0 auto;
        text-align: center;
        font-size: 14px;
        color: #2d462d;
        user-select: none;
    }
</style>
</head>
<body>

<h1>Admin panel - Ónimdi bosqarıw</h1>

<div class="top-bar">
    <a href="add_product.php" class="btn">➕ Jańa ónim qosıw</a>
    <a href="logout.php" class="logout">Shıǵıw</a>
</div>

<?php if (count($products) === 0): ?>
    <p style="text-align:center; font-weight:700; font-size:18px; margin-top: 50px;">Ónim bul jerde joq</p>
<?php else: ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Suwreti</th>
            <th>Atı</th>
            <th>Kategoriya</th>
            <th>Maǵluwmat</th>
            <th>Baxası (so‘m)</th>
            <th>Buyrıqlar</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?= htmlspecialchars($product['id']) ?></td>
            <td>
                <?php if ($product['image'] && file_exists('uploads/' . $product['image'])): ?>
                    <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image" />
                <?php else: ?>
                    <span style="color:#888;">Suwret joq</span>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($product['name']) ?></td>
            <td><?= htmlspecialchars($product['category']) ?></td>
            <td><?= nl2br(htmlspecialchars($product['info'])) ?></td>
            <td><?= number_format($product['price'], 0, ',', ' ') ?></td>
            <td class="actions">
                <a href="product_edit.php?id=<?= $product['id'] ?>">✏️ Ózgertiw</a>
                <a href="admin_panel.php?delete=<?= $product['id'] ?>" onclick="return confirm('Ónim óshirilsinbe?');">🗑️ Óshiriw</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

<div class="footer">
    &copy; <?= date('Y') ?> TelefonUZ Admin Panel
</div>

</body>
</html>
