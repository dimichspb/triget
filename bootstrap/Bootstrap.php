<?php
namespace app\bootstrap;

use app\helpers\EntityManagerBuilder;
use app\models\room\types\DescriptionType;
use app\models\room\types\ImageType;
use app\models\user\types\AccessTokenType;
use app\models\user\types\AuthKeyType;
use app\models\user\types\PasswordHashType;
use app\models\user\types\PhoneType;
use app\models\user\types\UsernameType;
use app\services\room\Filesystem;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use League\Flysystem\Adapter\Local;
use League\Flysystem\FilesystemInterface;
use yii\base\BootstrapInterface;
use yii\di\Container;
use yii\web\User;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        /** @var Container $container */
        $container = \Yii::$container;

        \Yii::$app->db->open();
        $pdo = \Yii::$app->db->pdo;

        $runtime = \Yii::getAlias('@runtime');
        $models = \Yii::getAlias('@app/models');

        $container->set(EntityManager::class, function () use ($pdo, $runtime, $models) {
            return (new EntityManagerBuilder())
                ->withProxyDir($runtime . '/proxy', 'Proxies', true)
                ->withMapping(new SimplifiedYamlDriver([
                    $models . '/user/mapping' => 'app\models\user',
                    $models . '/room/mapping' => 'app\models\room',
                ]))

                ->withCache(new FilesystemCache($runtime . '/cache'))
                ->withTypes([
                    \app\models\user\types\IdType::NAME => \app\models\user\types\IdType::class,
                    UsernameType::NAME => UsernameType::class,
                    AuthKeyType::NAME => AuthKeyType::class,
                    AccessTokenType::NAME => AccessTokenType::class,
                    PasswordHashType::NAME => PasswordHashType::class,
                    PhoneType::NAME => PhoneType::class,
                    \app\models\user\types\NameType::NAME => \app\models\user\types\NameType::class,

                    \app\models\room\types\IdType::NAME => \app\models\room\types\IdType::class,
                    \app\models\room\types\NameType::NAME => \app\models\room\types\NameType::class,
                    DescriptionType::NAME => DescriptionType::class,
                    ImageType::NAME => ImageType::class,
                ])
                ->withAutocommit(true)
                ->build(['pdo' => $pdo]);
        });

        $container->set(FilesystemInterface::class, new \League\Flysystem\Filesystem(
            new Local(\Yii::getAlias('@runtime/files'))
        ));
        $container->set(\app\services\room\FilesystemInterface::class, Filesystem::class);

        $container->set(\app\repositories\user\RepositoryInterface::class,\app\repositories\user\DoctrineRepository::class);
        $container->set(\app\repositories\room\RepositoryInterface::class,\app\repositories\room\DoctrineRepository::class);

        if ($app instanceof \yii\web\Application) {
            $container->set(User::class, \Yii::$app->user);
        }
    }
}