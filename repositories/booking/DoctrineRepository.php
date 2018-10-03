<?php
namespace app\repositories\booking;

use app\models\booking\EndDate;
use app\models\booking\Id;
use app\models\booking\Booking;
use app\models\booking\StartDate;
use app\models\room\Id as RoomId;
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
     * DoctrineBookingRepository constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->entityRepository = $em->getRepository(Booking::class);
    }

    /**
     * @param Id $id
     * @return Booking|null
     */
    public function get(Id $id)
    {
        try {
            /** @var Booking $booking */
            $booking = $this->entityRepository->find($id);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $booking;
    }

    /**
     * Find one by criteria
     * @param array $criteria
     * @return mixed
     */
    public function find(array $criteria = [])
    {
        try {
            /** @var Booking $booking */
            $bookings = $this->entityRepository->findBy($criteria);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return reset($bookings);
    }

    /**
     * Add new Booking to repository
     * @param Booking $booking
     */
    public function add(Booking $booking)
    {
        try {
            $this->em->persist($booking);
            $this->em->flush($booking);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Update Booking in repository
     * @param Booking $booking
     */
    public function update(Booking $booking)
    {
        try {
            $this->em->flush($booking);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Delete Booking from repository
     * @param Booking $booking
     */
    public function delete(Booking $booking)
    {
        try {
            $this->em->remove($booking);
            $this->em->flush($booking);
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
     * Get all Bookings by criteria
     * @param array $criteria
     * @param array|null $orderBy
     * @param int $offset
     * @param int $limit
     * @return Booking[]
     */
    public function all(array $criteria = [], array $orderBy = null, $offset = null, $limit = null)
    {
        try {
            $bookings = $this->entityRepository->findBy($criteria, $orderBy, $limit, $offset);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $bookings;
    }

    /**
     * Count Bookings by criteria
     * @param array $criteria
     * @return int
     */
    public function count(array $criteria = [])
    {
        return $this->entityRepository->count($criteria);
    }

    /**
     * Find bookings for particular room for specified period
     * @param Room $room
     * @param StartDate $startDate
     * @param EndDate $endDate
     * @return mixed
     */
    public function findInDateRange(Room $room, StartDate $startDate, EndDate $endDate)
    {
        $query = $this->em
            ->createQuery(
                'SELECT b FROM app\models\booking\Booking b WHERE b.room = :room AND b.startDate < :endDate AND b.endDate > :startDate'
            )
            ->setParameter('room', $room)
            ->setParameter('startDate', $startDate->getDbValue())
            ->setParameter('endDate', $endDate->getDbValue());

        return $query->getResult();
    }

}