<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigiDex - Enciclopédia Digimon</title>
    
    <!-- Bootstrap CSS (opcional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.cdnfonts.com/css/digimon" rel="stylesheet">
    <!-- CSS Personalizado -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        header {
            background: #2c3e50;
            color: white;
            padding: 1rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .logo img {
            height: 40px;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-links {
            display: flex;
            gap: 20px;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .nav-links a:hover, .nav-links a.active {
            background: #e74c3c;
        }
        .btn-login {
            background: #e74c3c;
            color: white;
            padding: 5px 15px;
            border-radius: 4px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <img src="assets/img/Icone Digimon.png" alt="DigiDex">
                    <h1>A Enciclopédia dos Monstros Digitais</h1>
                </div>
                
                <div class="nav-links">
                    <a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">Início</a>
                    
                    <?php if(isset($_SESSION['logado'])): ?>
                        <a href="protegido.php" class="<?= basename($_SERVER['PHP_SELF']) == 'protegido.php' ? 'active' : '' ?>">Admin</a>
                        <a href="logout.php">Sair</a>
                    <?php else: ?>
                        <a href="login.php" class="btn-login <?= basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : '' ?>">Login</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>
    
    <main class="container">