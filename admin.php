<?php
session_start();

if (isset($_POST['password'])) {
    $password = $_POST['password'];
    if ($password === "Albina") {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_panel.php");
        exit;
    } else {
        $error = "Parol qáte!";
    }
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8" />
    <title>Admin Kiriw</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(135deg, #28a745 0%, #a8e063 100%);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }
        .login-box {
            background: white;
            padding: 40px 35px;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(40, 167, 69, 0.25);
            width: 320px;
            text-align: center;
            animation: fadeInUp 0.6s ease forwards;
        }
        @keyframes fadeInUp {
            from {opacity: 0; transform: translateY(40px);}
            to {opacity: 1; transform: translateY(0);}
        }
        h2 {
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 1.8rem;
            color: #28a745;
            text-shadow: 0 2px 6px rgba(40, 167, 69, 0.4);
        }
        input[type="password"] {
            width: 100%;
            padding: 14px 12px;
            margin-bottom: 20px;
            font-size: 1rem;
            border-radius: 8px;
            border: 1.5px solid #ddd;
            transition: border-color 0.3s ease;
        }
        input[type="password"]:focus {
            border-color: #28a745;
            outline: none;
            box-shadow: 0 0 8px rgba(40, 167, 69, 0.3);
        }
        button {
            width: 100%;
            padding: 14px 0;
            background-color: #28a745;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        button:hover {
            background-color: #218838;
            box-shadow: 0 8px 20px rgba(33, 136, 56, 0.6);
        }
        .error {
            color: #e74c3c;
            margin-top: 15px;
            font-weight: 600;
            font-size: 0.95rem;
            text-shadow: 0 0 3px rgba(231, 76, 60, 0.5);
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Admin Kiriw</h2>
    <form method="post" action="">
        <input type="password" name="password" placeholder="Parolni kiritiń" required autocomplete="off" />
        <button type="submit">Kiriw</button>
    </form>
    <?php if(isset($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
</div>

</body>
</html>
