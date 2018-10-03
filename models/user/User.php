<?php
namespace app\models\user;

use app\models\BaseModel;
use app\services\user\Service;
use Doctrine\Common\Collections\ArrayCollection;

class User extends BaseModel implements \yii\web\IdentityInterface
{
    /**
     * @var Id
     */
    protected $id;

    /**
     * @var Username
     */
    protected $username;

    /**
     * @var AuthKey
     */
    protected $authKey;

    /**
     * @var AccessToken
     */
    protected $accessToken;

    /**
     * @var PasswordHash
     */
    protected $passwordHash;

    /**
     * @var Phone
     */
    protected $phone;

    /**
     * @var Name
     */
    protected $name;

    /**
     * @var ArrayCollection
     */
    protected $bookings;

    public function __construct(Id $id, Username $username = null, AuthKey $authKey = null, AccessToken $accessToken = null,
                                PasswordHash $passwordHash = null, Phone $phone = null , Name $name = null, ArrayCollection $bookings = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->authKey = $authKey;
        $this->accessToken = $accessToken;
        $this->passwordHash = $passwordHash;
        $this->phone = $phone;
        $this->name = $name;
        $this->bookings = $bookings? $bookings: new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        /** @var Service $service */
        $service = \Yii::$container->get(Service::class);

        return $service->getById($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /** @var Service $service */
        $service = \Yii::$container->get(Service::class);

        return $service->getByAccessToken($token);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public static function findByUsername($username)
    {
        /** @var Service $service */
        $service = \Yii::$container->get(Service::class);

        return $service->getByUsername($username);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey->getValue() === $authKey;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->authKey = new AuthKey(\Yii::$app->security->generateRandomString());
    }

    /**
     * Generates access token
     */
    public function generateAccessToken()
    {
        $this->accessToken = new AccessToken(\Yii::$app->security->generateRandomString());
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->passwordHash->getValue());
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->passwordHash = new PasswordHash(\Yii::$app->security->generatePasswordHash($password));
    }

    /**
     * @return Username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param Username $username
     */
    public function setUsername(Username $username)
    {
        $this->username = $username;
    }

    /**
     * @return AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return PasswordHash
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * @return Phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param Phone $phone
     */
    public function setPhone(Phone $phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Name $name
     */
    public function setName(Name $name)
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection
     */
    public function getBookings()
    {
        return $this->bookings;
    }
}
