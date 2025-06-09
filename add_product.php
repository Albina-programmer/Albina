<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit;
}

require 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $info = $_POST['info'];
    $price = $_POST['price'];
    $image = "";

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
                $image = $newFileName;
            } else {
                $message = "❌ Súwret júklewde qátelik!";
            }
        } else {
            $message = "❌ tek jpg, jpeg, png, gif fayllar qabıl qıladi!";
        }
    }

    if ($image || isset($_FILES['image'])) {
        $stmt = $pdo->prepare("INSERT INTO products (name, category, info, price, image) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $category, $info, $price, $image])) {
            $message = "✅ Ónim tabıslı qosıldı!";
        } else {
            $message = "❌ Ónimdi qosıwda qáte júz berdi!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <title>Ónim qosıw</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 30px;
        }
        form {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], textarea, select, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
            height: 70px;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #218838;
        }
        .msg {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            font-weight: bold;
            text-align: center;
        }
        .msg.success {
            background-color: #d4edda;
            color: #155724;
        }
        .msg.error {
            background-color: #f8d7da;
            color: #721c24;
        }
        a.back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007BFF;
            font-weight: bold;
            text-decoration: none;
        }
        a.back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Ónim qosıw</h1>

<?php if ($message): ?>
    <div class="msg <?= strpos($message, '✅') === 0 ? 'success' : 'error' ?>">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <label for="name">Ónim atı:</label>
    <input type="text" id="name" name="name" required>

    <label for="category">Kategoriya:</label>
    <select id="category" name="category" required>
        <option value="smartfon">Telefon</option>
        <option value="aksessuar">Aksessuar</option>
    </select>

    <label for="info">Ónim haqqında :</label>
    <textarea id="info" name="info" required></textarea>

    <label for="price">Baxası:</label>
    <input type="text" id="price" name="price" required>

    <label for="image">Súwret (jpg, png, gif):</label>
    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.gif" required>

    <button type="submit">Ónim qosıw</button>
</form>

<a href="admin_panel.php" class="back">⬅ Admin panelga qaytıw</a>

</body>
</html>
