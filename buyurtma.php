<?php
session_start();
require 'db.php';

if (!isset($_GET['product_id'])) {
    echo "Mahsulot tanlanmadi.";
    exit;
}

$product_id = (int)$_GET['product_id'];

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    echo "Ónim tawılmadı.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    if (empty($name) || empty($surname) || empty($phone) || empty($email)) {
        $error = "Iltimas barlıq qatardı toltırıń.";
    } elseif (!preg_match('/^\d{2}-\d{3}-\d{2}-\d{2}$/', $phone)) {
        $error = "Telefon nómeri 90-123-45-67 formatda bolıwı kerek.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Elektron pochta manzil qáte.";
    } else {
        $_SESSION['order'] = [
            'name' => $name,
            'surname' => $surname,
            'phone' => $phone,
            'email' => $email,
            'product_name' => $product['name'],
            'product_price' => $product['price']
        ];
        header("Location: buyurtma_tasdiq.php");
        exit;
    }
} else {
    $name = $_SESSION['user_name'] ?? '';
    $surname = $_SESSION['user_surname'] ?? '';
    $phone = '';
    $email = $_SESSION['user_email'] ?? '';
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Buyurtpa beriw</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    :root {
        --green-primary: #28a745;
        --green-dark: #1e7e34;
        --green-light: #d4edda;
        --green-border: #c3e6cb;
        --blue-primary: #007bff;
        --blue-dark: #0056b3;
        --gray-light: #f0f4f8;
        --gray-medium: #6c757d;
        --gray-dark: #343a40;
        --white: #fff;
        --shadow: rgba(40, 167, 69, 0.2);
    }

    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Roboto', sans-serif;
        background-color: var(--gray-light);
        margin: 0;
        padding: 40px 20px;
        color: var(--gray-dark);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    h2 {
        color: var(--green-primary);
        font-weight: 700;
        margin-bottom: 30px;
        text-align: center;
        font-size: 2rem;
        letter-spacing: 1px;
        text-shadow: 0 2px 4px var(--green-dark);
    }

    .product-info {
        font-weight: 700;
        font-size: 1.4rem;
        margin-bottom: 40px;
        color: var(--green-dark);
        background-color: var(--green-light);
        border: 2px solid var(--green-border);
        border-radius: 15px;
        padding: 20px 30px;
        width: 100%;
        max-width: 480px;
        text-align: center;
        box-shadow: 0 8px 16px var(--shadow);
    }

    form {
        background: var(--white);
        padding: 35px 40px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.25);
        max-width: 480px;
        width: 100%;
        transition: box-shadow 0.3s ease;
    }
    form:hover {
        box-shadow: 0 12px 28px rgba(40, 167, 69, 0.4);
    }

    label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--green-dark);
        font-size: 1.05rem;
        user-select: none;
    }

    input[type="text"], input[type="email"] {
        width: 100%;
        padding: 14px 18px;
        margin-bottom: 28px;
        font-size: 1rem;
        border-radius: 12px;
        border: 2.5px solid #cdecca;
        background-color: #f9fff9;
        color: var(--gray-dark);
        font-weight: 500;
        transition: border-color 0.25s ease, box-shadow 0.25s ease;
        outline-offset: 2px;
    }
    input[type="text"]:focus, input[type="email"]:focus {
        border-color: var(--green-primary);
        box-shadow: 0 0 10px var(--green-primary);
        outline: none;
    }

    .submit-btn {
        background-color: var(--green-primary);
        color: var(--white);
        font-size: 1.3rem;
        font-weight: 700;
        border: none;
        width: 100%;
        padding: 18px 0;
        border-radius: 35px;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.35);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        user-select: none;
    }
    .submit-btn:hover {
        background-color: var(--green-dark);
        box-shadow: 0 10px 30px rgba(30, 126, 52, 0.6);
    }
    .submit-btn:active {
        transform: scale(0.98);
    }

    .error {
        background-color: #f8d7da;
        color: #842029;
        padding: 15px 20px;
        margin-bottom: 25px;
        border-radius: 12px;
        border: 2px solid #f5c2c7;
        font-weight: 600;
        text-align: center;
        max-width: 480px;
        width: 100%;
        box-shadow: 0 4px 10px rgba(255, 0, 0, 0.15);
    }

    .back-link {
        margin-top: 25px;
        font-weight: 600;
        font-size: 1.05rem;
        color: var(--green-primary);
        text-decoration: none;
        transition: color 0.3s ease, text-decoration 0.3s ease;
        user-select: none;
    }
    .back-link:hover {
        color: var(--green-dark);
        text-decoration: underline;
    }

    @media (max-width: 520px) {
        body {
            padding: 20px 10px;
        }
        form, .product-info {
            padding: 25px 20px;
            border-radius: 15px;
        }
        h2 {
            font-size: 1.6rem;
        }
        .submit-btn {
            font-size: 1.1rem;
            padding: 14px 0;
        }
    }
</style>
</head>
<body>

<h2>Buyurtpa beriw</h2>

<div class="product-info" role="region" aria-label="Tańlanǵan ónim haqqında maǵlıwmat">
    Siz tańlaǵan ónim: <strong><?= htmlspecialchars($product['name']) ?></strong><br>
    Baxası: <strong><?= htmlspecialchars($product['price']) ?> UZS</strong>
</div>

<?php if (!empty($error)): ?>
    <div class="error" role="alert"><?= $error ?></div>
<?php endif; ?>

<form method="POST" action="" novalidate>
    <label for="name">Atıńız:</label>
    <input type="text" id="name" name="name" required value="<?= htmlspecialchars($name) ?>" autocomplete="given-name" />

    <label for="surname">Familiyańız:</label>
    <input type="text" id="surname" name="surname" required value="<?= htmlspecialchars($surname) ?>" autocomplete="family-name" />

    <label for="phone">Telefon (90-123-45-67 formatda):</label>
    <input type="text" id="phone" name="phone" required placeholder="90-123-45-67" value="<?= htmlspecialchars($phone) ?>" autocomplete="tel" pattern="\d{2}-\d{3}-\d{2}-\d{2}" title="Telefon nómer 90-123-45-67 formatda bolıw kerek" />

    <label for="email">Elektron pochta:</label>
    <input type="email" id="email" name="email" required value="<?= htmlspecialchars($email) ?>" autocomplete="email" />

    <button type="submit" class="submit-btn">Buyurtpanı tastıyıqlaw</button>
</form>

<a href="index.php" class="back-link" aria-label="Bas betke qaytıw">&larr; Artqa</a>

<script>
const phoneInput = document.getElementById('phone');

phoneInput.addEventListener('input', function(e) {
    // Tek nómer alıw
    let digits = this.value.replace(/\D/g, '');

    // Maksimal uzınlıq 9 san (mısal: 901234567)
    if (digits.length > 9) {
        digits = digits.substring(0, 9);
    }

    // Formatl: 90-123-45-67
    let formatted = '';
    if (digits.length > 0) {
        formatted += digits.substring(0, 2);
    }
    if (digits.length >= 3) {
        formatted += '-' + digits.substring(2, 5);
    }
    if (digits.length >= 6) {
        formatted += '-' + digits.substring(5, 7);
    }
    if (digits.length >= 8) {
        formatted += '-' + digits.substring(7, 9);
    }

    this.value = formatted;
});
</script>

</body>
</html>
