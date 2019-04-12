<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use App\Model\User;

$base = new PDO('mysql:host=localhost;dbname=tp2', 'root', '');
$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal("session", $_SESSION);


echo $twig->render('index.html.twig');