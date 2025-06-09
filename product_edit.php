<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit;
}

require 'db.php';

$message = "";

// URL arqalı id alınadı
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin_panel.php");
    exit;
}

$id = (int) $_GET['id'];

// aldın ónim maǵluwmatlardı alıw
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    $message = "❌ Ónim tawılmadı!";
}

// Form jiberilgende
if ($_SERVER["REQUEST_METHOD"] === "POST" && $product) {
    $name = trim($_POST['name']);
    $category = trim($_POST['category']);
    $info = trim($_POST['info']);
    $price = trim($_POST['price']);

    $newFileName = $product['image']; 

    // Eger taza suwret juklengen bolsa
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $fileName = $_FILES['image']['name'];
        $fileTmp = $_FILES['image']['tmp_name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExt, $allowed)) {
            $newFileName = uniqid('img_', true) . '.' . $fileExt;
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmp, $uploadPath)) {
                // Eski rasmni o'chirish (agar bor bo'lsa va yangisiga almashtirilsa)
                if ($product['image'] && file_exists($uploadDir . $product['image'])) {
                    unlink($uploadDir . $product['image']);
                }
            } else {
                $message = "❌ Jańa súwretti júklewde qátelik júz berdi!";
            }
        } else {
            $message = "❌ Súwret tek jpg, jpeg, png, gif formatlarında boliwi kerek!";
        }
    }

    
    if (!$message) {
        $stmt = $pdo->prepare("UPDATE products SET name = ?, category = ?, info = ?, price = ?, image = ? WHERE id = ?");
        $updated = $stmt->execute([$name, $category, $info, $price, $newFileName, $id]);

        if ($updated) {
            $message = "✅ Ónim tabıslı juklendi!";
            // Jańalanǵan maǵlıwmatlardı qayta alıw (formada kórsetiw ushın)
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $product = $stmt->fetch();
        } else {
            $message = "❌ Ónim jańalawda qátelik boldı!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
<meta charset="UTF-8" />
<title>Ónimdi túzetiw</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #e6f2e6;
        padding: 30px;
        color: #064420;
    }
    h1 {
        text-align: center;
        color: #145214;
        margin-bottom: 30px;
    }
    form {
        max-width: 520px;
        margin: auto;
        background: #f7fcf7;
        padding: 25px 30px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(20, 82, 20, 0.2);
        border: 1px solid #a7d7a7;
        transition: box-shadow 0.3s ease;
    }
    form:hover {
        box-shadow: 0 12px 30px rgba(20, 82, 20, 0.35);
    }
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 700;
        font-size: 15px;
    }
    input[type="text"], textarea, select, input[type="file"] {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 18px;
        border-radius: 8px;
        border: 2px solid #a7d7a7;
        font-size: 15px;
        color: #064420;
        background-color: #f0faf0;
        transition: border-color 0.25s ease, box-shadow 0.25s ease;
        box-sizing: border-box;
    }
    input[type="text"]:focus,
    textarea:focus,
    select:focus,
    input[type="file"]:focus {
        outline: none;
        border-color: #3ca13c;
        box-shadow: 0 0 6px #3ca13caa;
        background-color: #eaffea;
    }
    textarea {
        resize: vertical;
        min-height: 80px;
    }
    button {
        width: 100%;
        background-color: #3ca13c;
        border: none;
        color: white;
        padding: 14px;
        font-size: 18px;
        font-weight: 700;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        box-shadow: 0 5px 10px rgba(60, 161, 60, 0.6);
    }
    button:hover {
        background-color: #2e7d2e;
        box-shadow: 0 7px 15px rgba(46, 125, 46, 0.8);
    }
    .msg {
        max-width: 520px;
        margin: 0 auto 25px auto;
        padding: 12px 18px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 15px;
        text-align: center;
        box-sizing: border-box;
    }
    .msg.success {
        background-color: #d4edda;
        color: #155724;
        border: 1.5px solid #a4d79a;
        box-shadow: 0 0 12px #a4d79aaa;
    }
    .msg.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1.5px solid #e49a9a;
        box-shadow: 0 0 12px #e49a9aaa;
    }
    a.back {
        display: block;
        max-width: 520px;
        margin: 20px auto 0 auto;
        text-align: center;
        color: #3ca13c;
        font-weight: 700;
        text-decoration: none;
        font-size: 15px;
        transition: color 0.3s ease;
    }
    a.back:hover {
        color: #2e7d2e;
        text-decoration: underline;
    }
    .current-image {
        max-width: 180px;
        margin-bottom: 18px;
        border-radius: 10px;
        border: 2px solid #a7d7a7;
        display: block;
    }
</style>
</head>
<body>

<h1>Ónimdi túzetiw</h1>

<?php if ($message): ?>
    <div class="msg <?= strpos($message, '✅') === 0 ? 'success' : 'error' ?>">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<?php if ($product): ?>
<form method="post" enctype="multipart/form-data" autocomplete="off">
    <label for="name">Ónim atı:</label>
    <input type="text" id="name" name="name" required value="<?= htmlspecialchars($product['name']) ?>">

    <label for="category">Kategoriya:</label>
    <select id="category" name="category" required>
        <option value="smartfon" <?= $product['category'] === 'smartfon' ? 'selected' : '' ?>>Telefon</option>
        <option value="aksessuar" <?= $product['category'] === 'aksessuar' ? 'selected' : '' ?>>Aksessuar</option>
    </select>

    <label for="info">Ónim tuwralı maǵluwmat:</label>
    <textarea id="info" name="info" required><?= htmlspecialchars($product['info']) ?></textarea>

    <label for="price">Baxası:</label>
    <input type="text" id="price" name="price" required value="<?= htmlspecialchars($product['price']) ?>">

    <label>Házirdegi suwret:</label>
    <?php if ($product['image'] && file_exists('uploads/' . $product['image'])): ?>
        <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="Ónim suwreti" class="current-image">
    <?php else: ?>
        <p>Suwret joq</p>
    <?php endif; ?>

    <label for="image">Suwret jańalaw (ıxtıyariy):</label>
    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.gif">

    <button type="submit">Saqlaw</button>
</form>
<?php endif; ?>

<a href="admin_panel.php" class="back">Admin panelga qaytıew</a>

</body>
</html>
