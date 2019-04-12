<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use App\Model\User;

$base = new PDO('mysql:host=localhost;dbname=tp2', 'root', '');
$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal("session", $_SESSION);

if (isset($_POST['email']) && isset($_POST['name']) && isset($_POST['password'])) {
    $user = new User();
    $user->setEmail($_POST['email']);
    $user->setName($_POST['name']);
    $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));

    $userRepository = new \App\Repository\UserRepository($base);
    $userRepository->add($user);
    echo "Votre utilisateur a bien été créé";
}

echo $twig->render('user_add.html.twig');