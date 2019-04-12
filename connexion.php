<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use App\Model\User;

$base = new PDO('mysql:host=localhost;dbname=tp2', 'root', '');
$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal("session", $_SESSION);

if (isset($_POST['email']) && isset($_POST['password'])) {

    $userRepository = new \App\Repository\UserRepository($base);
    $userRepository->login($_POST['email'],$_POST['password']);
    header('Location: index.php');
    exit;
}

echo $twig->render('connexion.html.twig');