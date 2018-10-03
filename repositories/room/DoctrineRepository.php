<?php
namespace app\repositories\room;

use app\models\room\Id;
use app\models\room\Room;
use app\repositories\RepositoryException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\Uuid;

class DoctrineRepository implements RepositoryInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $entityRepository;

    /**
     * DoctrineRoomRepository constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->entityRepository = $em->getRepository(Room::class);
    }

    /**
     * @param Id $id
     * @return Room|null
     */
    public function get(Id $id)
    {
        try {
            /** @var Room $room */
            $room = $this->entityRepository->find($id);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $room;
    }

    /**
     * Find one by criteria
     * @param array $criteria
     * @return mixed
     */
    public function find(array $criteria = [])
    {
        try {
            /** @var Room $room */
            $rooms = $this->entityRepository->findBy($criteria);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return reset($rooms);
    }

    /**
     * Add new Room to repository
     * @param Room $room
     */
    public function add(Room $room)
    {
        try {
            $this->em->persist($room);
            $this->em->flush($room);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Update room in repository
     * @param Room $room
     */
    public function update(Room $room)
    {
        try {
            $this->em->flush($room);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Delete Room from repository
     * @param Room $room
     */
    public function delete(Room $room)
    {
        try {
            $this->em->remove($room);
            $this->em->flush($room);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return Id
     */
    public function nextId()
    {
        try {
            $id = new Id(Uuid::uuid4()->toString());
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $id;
    }

    /**
     * Get all rooms by criteria
     * @param array $criteria
     * @param array|null $orderBy
     * @param int $offset
     * @param int $limit
     * @return Room[]
     */
    public function all(array $criteria = [], array $orderBy = null, $offset = null, $limit = null)
    {
        try {
            $rooms = $this->entityRepository->findBy($criteria, $orderBy, $limit, $offset);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $rooms;
    }

    public function count(array $criteria = [])
    {
        return $this->entityRepository->count($criteria);
    }

}