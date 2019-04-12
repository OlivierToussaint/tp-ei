<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use App\Model\Post;
if (isset($_SESSION['id']) && isset($_SESSION['admin']) && $_SESSION['admin'] == 1 ) {
    $base = new PDO('mysql:host=localhost;dbname=tp2', 'root', '');
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    $twig->addGlobal("session", $_SESSION);

    if (isset($_POST['title']) && isset($_POST['content'])) {
        $date = new DateTime('now');
        $post = new Post();
        $post->setTitle($_POST['title']);
        $post->setContent($_POST['content']);
        $post->setUserId($_SESSION['id']);
        $post->setPostDate($date->format('Y-m-d H:i:s'));

        $postRepository = new \App\Repository\PostRepository($base);
        $postRepository->add($post);
        echo "Votre post a bien été créé";
    }

    echo $twig->render('post_add.html.twig');
} else {
    echo "vous n'avez pas acces a cette page";
}
