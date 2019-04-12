<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/base.php';

use App\Model\Comment;


$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal("session", $_SESSION);

$postRepository = new \App\Repository\PostRepository($base);
$post = $postRepository->find($_GET['id']);
if ($post === false) {
    echo "pas de post";
} else {
    $commentRepository = new \App\Repository\CommentRepository($base);

    if (isset($_POST['content'])) {
        $date = new DateTime('now');
        $comment = new Comment();
        $comment->setContent($_POST['content']);
        $comment->setUserId($_SESSION['id']);
        $comment->setPostId($post->getId());
        $comment->setCommentDate($date->format('Y-m-d H:i:s'));
        $comment->setPublish(1);

        $commentRepository->add($comment);
        echo "Votre commentaire a bien créé";

    }

    $comments = $commentRepository->findByPost($post->getId());
    $userRepository = new \App\Repository\UserRepository($base);

    echo $twig->render('post_show.html.twig', ['post' => $post, 'comments' => $comments, 'userRepository' => $userRepository]);
}
