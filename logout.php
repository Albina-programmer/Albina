<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title>Chiqish...</title>
  <meta http-equiv="refresh" content="2;url=index.php">
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #e6f5e6;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
    }

    .logout-box {
      text-align: center;
      background: #ffffff;
      border: 2px solid #4caf50;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(76, 175, 80, 0.3);
      animation: slideIn 0.8s ease forwards;
    }

    .logout-box h2 {
      color: #388e3c;
      font-size: 28px;
      margin-bottom: 15px;
    }

    .loader {
      border: 6px solid #c8e6c9;
      border-top: 6px solid #4caf50;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      animation: spin 1s linear infinite;
      margin: 20px auto;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @keyframes slideIn {
      from {
        transform: translateY(40px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .fade-out {
      animation: fadeOut 1.5s ease-in-out forwards;
    }

    @keyframes fadeOut {
      to {
        opacity: 0;
        transform: scale(0.95);
      }
    }
  </style>
</head>
<body>

<div class="logout-box">
  <h2>Admin panelden shıǵıwdasız...</h2>
  <div class="loader"></div>
  <p style="color: #4caf50;">Siz dizmnen shıqtıńız. Qayta baǵdarlanıp atır...</p>
</div>

</body>
</html>
