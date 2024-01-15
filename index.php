<?php
session_start();
if(empty($_SESSION["LOGIN"])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: monospace;
        }
        body {
            padding: 1rem;
        }
        h2, h3 {
            margin-bottom: 1rem;
        }
        a {
            color: black;
            display: block;
            text-decoration: none;
            padding: 0.4rem 0.8rem;
        }
    </style>
</head>
<body>
    <h2>Dashboard</h2>
    <h3>Selamat datang mastah <?= $_SESSION["LOGIN"]["username"] ?></h3>
    <button><a href="logout.php">Log Out</a></button>
</body>
</html>