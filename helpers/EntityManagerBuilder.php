<?php
namespace app\helpers;

use Doctrine\Common\Cache\CacheProvider;
use Doctrine\Common\EventManager;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;

class EntityManagerBuilder
{
    private $proxyNamespace;
    private $proxyDir;
    private $proxyAutoGenerate;
    private $cacheProvider;
    private $mappingDriver;
    private $subscribers = [];
    private $listeners = [];
    private $types = [];
    private $autoCommit;
    private $sqlLogger;

    /**
     * With proxy directory
     * @param $dir
     * @param $namespace
     * @param $autoGenerate
     * @return $this
     */
    public function withProxyDir($dir, $namespace, $autoGenerate)
    {
        $this->proxyDir = $dir;
        $this->proxyNamespace = $namespace;
        $this->proxyAutoGenerate = $autoGenerate;
        return $this;
    }

    /**
     * With cache
     * @param CacheProvider $cache
     * @return $this
     */
    public function withCache(CacheProvider $cache)
    {
        $this->cacheProvider = $cache;
        return $this;
    }

    /**
     * With mapping
     * @param MappingDriver $driver
     * @return $this
     */
    public function withMapping(MappingDriver $driver)
    {
        $this->mappingDriver = $driver;
        return $this;
    }

    /**
     * With subscribers
     * @param array $subscribers
     * @return $this
     */
    public function withSubscribers(array $subscribers)
    {
        $this->subscribers = $subscribers;
        return $this;
    }

    /**
     * With listeners
     * @param array $listeners
     * @return $this
     */
    public function withListeners(array $listeners)
    {
        $this->listeners = $listeners;
        return $this;
    }

    /**
     * With types
     * @param array $types
     * @return $this
     */
    public function withTypes(array $types)
    {
        $this->types = $types;
        return $this;
    }

    /**
     * With Autocommit
     * @param $autocommit
     * @return $this
     */
    public function withAutocommit($autocommit)
    {
        $this->autoCommit = $autocommit;
        return $this;
    }

    /**
     * With SQLLogger
     * @param $sqlLogger
     * @return $this
     */
    public function withSQLLogger($sqlLogger)
    {
        $this->sqlLogger = $sqlLogger;
        return $this;
    }

    /**
     * Build Entity manager
     * @param $params
     * @return EntityManager
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     */
    public function build($params)
    {
        $this->checkParameters();

        $config = new Configuration();

        $config->setProxyDir($this->proxyDir);
        $config->setProxyNamespace($this->proxyNamespace);
        $config->setAutoGenerateProxyClasses($this->proxyAutoGenerate);
        $config->setAutoCommit($this->autoCommit);
        $config->setSQLLogger($this->sqlLogger);

        $config->setMetadataDriverImpl($this->mappingDriver);

        if (!$this->cacheProvider) {
            $config->setMetadataCacheImpl($this->cacheProvider);
            $config->setQueryCacheImpl($this->cacheProvider);
        }

        $evm = new EventManager();

        foreach ($this->subscribers as $subscriber) {
            $evm->addEventSubscriber($subscriber);
        }

        foreach ($this->listeners as $name => $listener) {
            $evm->addEventListener($name, $listener);
        }

        foreach ($this->types as $name => $type) {
            if (Type::hasType($name)) {
                Type::overrideType($name, $type);
            } else {
                Type::addType($name, $type);
            }
        }

        return EntityManager::create($params, $config, $evm);
    }

    /**
     * Check params
     */
    private function checkParameters()
    {
        if (empty($this->proxyDir) || empty($this->proxyNamespace)) {
            throw new \InvalidArgumentException('Specify proxy settings.');
        }

        if (!$this->mappingDriver) {
            throw new \InvalidArgumentException('Specify mapping driver.');
        }
    }
}