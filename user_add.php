<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/base.php';

use App\Model\User;

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