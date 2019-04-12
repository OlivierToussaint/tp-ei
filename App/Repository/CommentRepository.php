<?php

namespace App\Repository;


use App\Model\Comment;

class CommentRepository
{
    private $base;

    public function __construct(\PDO $base)
    {
        $this->base = $base;
    }

    public function add(Comment $comment)
    {
        $response = $this->base->prepare('INSERT INTO comment (post_id, user_id , content, comment_date, publish) VALUES(:post_id, :user_id, :content, :comment_date, :publish)');
        $response->bindValue(':post_id', $comment->getPostId());
        $response->bindValue(':user_id', $comment->getUserId());
        $response->bindValue(':comment_date', $comment->getCommentDate());
        $response->bindValue(':content', $comment->getContent());
        $response->bindValue(':publish', $comment->getPublish());

        $response->execute();

        $comment->setId($this->base->lastInsertId());
    }

    public function find(int $id)
    {
        $response = $this->base->prepare('SELECT * FROM comment WHERE id = :id');
        $response->bindValue(':id', $id);
        $response->execute();
        return $response->fetchObject('App\Model\Comment');
    }

    public function findAll()
    {
        $response = $this->base->prepare('SELECT * FROM comment');
        $result = $response->execute();
        if ($result === true) {
            $records = $response->fetchAll(\PDO::FETCH_CLASS, 'App\Model\Comment');
            return $records;
        }

        return false;
    }

    public function findByPost($post_id)
    {
        $response = $this->base->prepare('SELECT * FROM comment WHERE post_id = :post_id');
        $response->bindValue(':post_id', $post_id);

        $result = $response->execute();
        if ($result === true) {
            $records = $response->fetchAll(\PDO::FETCH_CLASS, 'App\Model\Comment');
            return $records;
        }

        return false;
    }
}