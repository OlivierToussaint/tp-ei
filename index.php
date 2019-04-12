<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/base.php';

use App\Model\User;

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal("session", $_SESSION);


echo $twig->render('index.html.twig');