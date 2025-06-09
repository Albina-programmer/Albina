<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit;
}

require 'db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Avval mahsulot rasm nomini olish (agar rasmni serverdan ham o'chirish kerak bo'lsa)
    $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if ($product) {
        // Rasm faylini o'chirish (agar fayl mavjud bo'lsa)
        $imagePath = 'uploads/' . $product['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Mahsulotni bazadan o'chirish
        $stmtDelete = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmtDelete->execute([$id]);

        $_SESSION['message'] = "✅ Mahsulot muvaffaqiyatli o‘chirildi!";
    } else {
        $_SESSION['message'] = "❌ Mahsulot topilmadi!";
    }
} else {
    $_SESSION['message'] = "❌ Mahsulot ID kiritilmadi!";
}


// Admin panelga qaytish
header("Location: admin_panel.php");
exit;
?>
