<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use App\Model\Post;

$base = new PDO('mysql:host=localhost;dbname=tp2', 'root', '');
$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal("session", $_SESSION);

$postRepository = new \App\Repository\PostRepository($base);
$userRepository = new \App\Repository\UserRepository($base);
$posts = $postRepository->findAll();

echo $twig->render('post_all.html.twig', ['userRepository' => $userRepository, 'posts' => $posts]);