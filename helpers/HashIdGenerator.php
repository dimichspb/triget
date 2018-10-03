<?php
namespace app\helpers;

use Doctrine\ORM\Id\AbstractIdGenerator;

class HashIdGenerator extends AbstractIdGenerator
{
    /**
     * Generate hash
     * @param \Doctrine\ORM\EntityManager $em
     * @param null|object $entity
     * @return mixed|string
     */
    public function generate(\Doctrine\ORM\EntityManager $em, $entity)
    {
        return md5(serialize($entity));
    }
}