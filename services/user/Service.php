<?php
namespace app\services\user;

use app\models\user\AccessToken;
use app\models\user\Id;
use app\models\user\Name;
use app\models\user\Phone;
use app\models\user\User;
use app\models\user\Username;
use app\repositories\user\RepositoryInterface;

class Service
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * Service constructor.
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get User by Id
     * @param Id $id
     * @return mixed
     */
    public function getById(Id $id)
    {
        return $this->repository->get($id);
    }

    /**
     * Get User by Username
     * @param Username $username
     * @return mixed
     */
    public function getByUsername(Username $username)
    {
        return $this->repository->find([
            'username' => $username,
        ]);
    }

    /**
     * Get User by Phone
     * @param Phone $phone
     * @return mixed
     */
    public function getByPhone(Phone $phone)
    {
        return $this->repository->find([
            'phone' => $phone,
        ]);
    }

    /**
     * Get User by AccessToken
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getByAccessToken(AccessToken $accessToken)
    {
        return $this->repository->find([
            'access_token' => $accessToken,
        ]);
    }

    /**
     * Add User to repository
     * @param User $user
     * @return mixed
     */
    public function add(User $user)
    {
        return $this->repository->add($user);
    }

    /**
     * Get next Id from repository
     * @return mixed
     */
    public function nextId()
    {
        return $this->repository->nextId();
    }

    /**
     * Create User by Name and Phone
     * @param Name $name
     * @param Phone $phone
     * @return User
     * @throws \yii\base\Exception
     */
    public function createByNameAndPhone(Name $name, Phone $phone)
    {
        $user = new User(
            $this->nextId()
        );
        $user->setUsername(new Username($phone->getValue()));
        $user->setPassword($phone->getValue());
        $user->setName($name);
        $user->setPhone($phone);
        $user->generateAccessToken();
        $user->generateAuthKey();

        return $user;
    }
}