<?php declare(strict_types=1);

session_start();

$userfound = false;

require_once __DIR__ . '/vendor/autoload.php';
$json_file = 'user.json';
$latte = new Latte\Engine;

if (file_exists($json_file)) {
    $json_data = file_get_contents($json_file);
    $users = json_decode($json_data, true);
} else {
    $users = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $user_data = [
            'username' => $username,
            'email' => $email,
            'password' => $hashed_password
    ];
    foreach ($users as $user) {
        if ($email === $user['email']) {
            echo "<p style ='color:red'>email already registered</p>";
            $userfound = true;
        }
    }
    if ($userfound === false) {
        $users[] = $user_data;
        file_put_contents($json_file, json_encode($users, JSON_PRETTY_PRINT));
        echo "<p style ='color:green'>User created</p>";
        header('Location: ' . "http://localhost:8000/index.php");
    }
}
$params = [ ];

$latte->render('user.latte', $params);

$output = $latte->renderToString('user.latte', $params);