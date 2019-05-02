<?php

namespace App\Repository;


use App\Model\User;

class UserRepository
{
    private $base;

    public function __construct(\PDO $base)
    {
        $this->base = $base;
    }

    public function add(User $user)
    {
        $response = $this->base->prepare('INSERT INTO user (name, password, email) VALUES(:name, :password, :email)');
        $response->bindValue(':name', $user->getName());
        $response->bindValue(':password', $user->getPassword());
        $response->bindValue(':email', $user->getEmail());


        $response->execute();

        $user->setId($this->base->lastInsertId());
    }

    public function find(int $id)
    {
        $response = $this->base->prepare('SELECT * FROM user WHERE id = :id');
        $response->bindValue(':id', $id);
        $response->execute();
        return $response->fetchObject('App\Model\User');
    }

    public function findByEmail(string $email)
    {
        $response = $this->base->prepare('SELECT * FROM user WHERE email = :email');
        $response->bindValue(':email', $email);
        $response->execute();
        return $response->fetch();
    }


    public function login(string $email, string $password)
    {
        if ($result = $this->findByEmail($email)) {

            if (password_verify($password, $result['password'])) {
                $user = $this->find($result['id']);
                $_SESSION['id'] = $user->getId();
                $_SESSION['name'] =  $user->getName();
                $_SESSION['email'] =  $user->getEmail();
                $_SESSION['admin'] =  $user->getAdmin();
                return $user;
            }
            return false;
        }
        return false;
    }

    public function getNameById(int $id)
    {
        $response = $this->base->prepare('SELECT * FROM user WHERE id = :id');
        $response->bindValue(':id', $id);
        $response->execute();
        $user = $response->fetchObject('App\Model\User');
        return $user->getName();
    }
}