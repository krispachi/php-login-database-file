<?php
session_start();
if(!empty($_SESSION["LOGIN"])) {
    header("Location: /");
}

function login() {
    if(file_exists("basis-data/user.txt")) {
        $file = fopen("basis-data/user.txt", "r");
        if(!$file) {
            echo "<script>alert('Gagal membuka database')</script>";
            return;
        }

        $username = $_POST["username"];
        $password = $_POST["password"];
        
        while(!feof($file)) {
            $datas = fgets($file);
            if(!empty(trim($datas))) {
                $datas = explode(";", $datas);
                $dataArray = [];
                foreach($datas as $data) {
                    $array = explode("=", $data);
                    $dataArray[$array[0]] = rtrim($array[1]); 
                }
                
                if($dataArray["username"] == $username && $dataArray["password"] == $password) {
                    $_SESSION["LOGIN"]["username"] = $dataArray["username"];
                    unset($_SESSION["PERCOBAAN-LOGIN"]);
                    header("Location: /");
                }
            }
        }

        if(isset($_SESSION["PERCOBAAN-LOGIN"])) {
            $_SESSION["PERCOBAAN-LOGIN"]++;
        } else {
            $_SESSION["PERCOBAAN-LOGIN"] = 1;
        }

        if($_SESSION["PERCOBAAN-LOGIN"] === 3) {
            unset($_SESSION["PERCOBAAN-LOGIN"]);
            header("Location: tong-sampah.php");
        }
        echo "<script>alert('Username atau Password salah')</script>";
        
        fclose($file);
    } else {
        echo "<script>alert('Database tidak tersedia')</script>";
        return;
    }
}

if($_SERVER["REQUEST_METHOD"] === "POST") {
    login();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        
        .mb-3 {
            margin-bottom: 1rem;
        }

        form label {
            display: block;
            margin-bottom: 1rem;
        }
        form input {
            width: 100%;
            padding: 1rem;
        }
        form button {
            margin: 1rem 0;
            padding: 0.4rem 0.8rem;
        }

        h2 {
            margin-bottom: 1rem;
        }

        button a {
            color: black;
            display: block;
            text-decoration: none;
            padding: 0.4rem 0.8rem;
        }
    </style>
</head>
<body>
    <h2>Login</h2>

    <form action="" method="post">
        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit">Log In !!!</button>
    </form>
    <button><a href="registrasi.php">Registrasi</a></button>

    <script>
        if(window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>