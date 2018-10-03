<?php
namespace app\services\booking;

use app\forms\room\BookingForm;
use app\models\booking\Confirmed;
use app\models\booking\EndDate;
use app\models\room\Id as RoomId;
use app\models\booking\Id;
use app\models\booking\Booking;
use app\models\booking\SearchModel;
use app\models\booking\StartDate;
use app\models\user\Name;
use app\models\user\Phone;
use app\repositories\booking\RepositoryInterface;
use yii\data\ArrayDataProvider;
use app\services\room\Service as RoomService;
use app\services\user\Service as UserService;

class Service
{
    protected $repository;
    protected $roomService;
    protected $userService;

    protected $filesystem;

    public function __construct(RepositoryInterface $repository, RoomService $roomService, UserService $userService)
    {
        $this->repository = $repository;
        $this->roomService = $roomService;
        $this->userService = $userService;
    }

    public function getById(Id $id)
    {
        return $this->repository->get($id);
    }

    public function find(array $criteria = [])
    {
        return $this->repository->find($criteria);
    }

    public function all(array $criteria = [], array $orderBy = [], $offset = null, $limit = null)
    {
        return $this->repository->all($criteria, $orderBy, $offset, $limit);
    }

    public function add(Booking $booking)
    {
        return $this->repository->add($booking);
    }

    public function update(Booking $booking)
    {
        return $this->repository->update($booking);
    }

    public function nextId()
    {
        return $this->repository->nextId();
    }

    public function count(array $criteria = [])
    {
        return $this->repository->count($criteria);
    }

    public function create(BookingForm $form)
    {
        $room = $this->roomService->getById(new RoomId($form->id));
        $user = $this->userService->getByPhone(new Phone($form->phone));

        if (!$user) {
            $user = $this->userService->createByNameAndPhone(new Name($form->name), new Phone($form->phone));
            $this->userService->add($user);
        }

        $booking = new Booking(
            $this->nextId(),
            $room,
            $user,
            new StartDate($form->getStartDate()),
            new EndDate($form->getEndDate()),
            new Confirmed(false)
        );

        return $booking;
    }

    public function getDataProvider(SearchModel $searchModel)
    {
        $offset = ($searchModel->page - 1) * $searchModel->limit;

        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->all($searchModel->getAttributes(['id', 'room', 'name']), [], $offset, $searchModel->limit),
            'totalCount' => $this->count($searchModel->getAttributes(['id', 'room', 'name'])),
            'key' => function (Booking $model) {
                return $model->getId();
            }
        ]);

        return $dataProvider;
    }

    /**
     * @param RoomId $id
     * @param StartDate $startDate
     * @param EndDate $endDate
     * @return Booking[]
     */
    public function checkAvailability(RoomId $id, StartDate $startDate, EndDate $endDate)
    {
        $room = $this->roomService->getById($id);
        return $this->repository->findInDateRange($room, $startDate, $endDate);
    }
}