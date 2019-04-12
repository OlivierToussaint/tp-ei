<?php

namespace App\Repository;


use App\Model\Post;

class PostRepository
{
    private $base;

    public function __construct(\PDO $base)
    {
        $this->base = $base;
    }

    public function add(Post $post)
    {
        $response = $this->base->prepare('INSERT INTO post (title, content, user_id, post_date) VALUES(:title, :content, :user_id, :post_date)');
        $response->bindValue(':title', $post->getTitle());
        $response->bindValue(':content', $post->getContent());
        $response->bindValue(':user_id', $post->getUserId());
        $response->bindValue(':post_date', $post->getPostDate());

        $response->execute();

        $post->setId($this->base->lastInsertId());
    }

    public function find(int $id)
    {
        $response = $this->base->prepare('SELECT * FROM post WHERE id = :id');
        $response->bindValue(':id', $id);
        $response->execute();
        return $response->fetchObject('App\Model\Post');
    }

    public function findAll()
    {
        $response = $this->base->prepare('SELECT * FROM post');
        $result = $response->execute();
        if ($result === true) {
            $records = $response->fetchAll(\PDO::FETCH_CLASS, 'App\Model\Post');
            return $records;
        }

        return false;
    }

}