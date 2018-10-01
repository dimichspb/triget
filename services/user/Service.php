<?php
namespace app\services\user;

use app\models\user\AccessToken;
use app\models\user\Id;
use app\models\user\User;
use app\models\user\Username;
use app\repositories\user\RepositoryInterface;

class Service
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getById(Id $id)
    {
        return $this->repository->get($id);
    }

    public function getByUsername(Username $username)
    {
        return $this->repository->find([
            'username' => $username,
        ]);
    }

    public function getByAccessToken(AccessToken $accessToken)
    {
        return $this->repository->find([
            'access_token' => $accessToken,
        ]);
    }

    public function add(User $user)
    {
        return $this->repository->add($user);
    }

    public function nextId()
    {
        return $this->repository->nextId();
    }
}