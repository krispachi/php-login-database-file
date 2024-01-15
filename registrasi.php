<?php
// Larang jika tanda password isi = dan ;
session_start();
if(!empty($_SESSION["LOGIN"])) {
    header("Location: /");
}

function registrasi() {
    if(!file_exists("basis-data")) {
        mkdir("basis-data", 0777);
    }

    $username = $_POST["username"];
    $password = $_POST["password"];

    if(file_exists("basis-data/user.txt")) {
        // Cek file
        $file = fopen("basis-data/user.txt", "r");
        if(!$file) {
            echo "<script>alert('Gagal membuka database')</script>";
            return;
        }
        
        while(!feof($file)) {
            $datas = fgets($file);
            if(!empty(trim($datas))) {
                $datas = explode(";", $datas);
                $dataArray = [];
                foreach($datas as $data) {
                    $array = explode("=", $data);
                    $dataArray[$array[0]] = rtrim($array[1]); 
                }
                
                if($dataArray["username"] == $username) {
                    echo "<script>alert('Username sudah tersedia')</script>";
                    return;
                }
            }
        }

        fclose($file);
        
        register($username, $password);
    } else {
        register($username, $password);
    }
}

function register($username, $password) {
    // Write
    $file = fopen("basis-data/user.txt", "a");
    if(!$file) {
        echo "<script>alert('Gagal membuka database')</script>";
        return;
    }

    $data = "username=" . $username . ";password=" . $password . "\n";
    fwrite($file, $data);
    fclose($file);

    header("Location: login.php");
}

if($_SERVER["REQUEST_METHOD"] === "POST") {
    registrasi();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
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
    <h2>Registrasi</h2>
    
    <form action="" method="post">
        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit">Registrasi</button>
    </form>
    <button><a href="login.php">Login</a></button>

    <script>
        if(window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>