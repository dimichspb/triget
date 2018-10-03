<?php

namespace app\modules\admin;

use app\forms\room\UploadForm;
use app\models\booking\Booking;
use app\models\room\Description;
use app\models\room\Id as RoomId;
use app\models\booking\Id as BookingId;
use app\models\room\Image;
use app\models\room\Name;
use app\models\room\Room;
use app\models\room\SearchModel as RoomSearchModel;
use app\models\booking\SearchModel as BookingSearchModel;
use app\modules\admin\forms\CreateForm;
use app\modules\admin\forms\UpdateForm;
use app\services\room\Service as RoomService;
use app\services\booking\Service as BookingService;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'room/index';

    /**
     * @var RoomService
     */
    protected $roomService;

    /**
     * @var BookingService
     */
    protected $bookingService;

    public function __construct($id, \yii\base\Module $parent, RoomService $roomService, BookingService $bookingService,
                                array $config = [])
    {
        $this->roomService = $roomService;
        $this->bookingService = $bookingService;

        parent::__construct($id, $parent, $config);
    }

    /**
     * Get Room by Id
     * @param RoomId $id
     * @return mixed
     */
    public function getRoomById(RoomId $id)
    {
        return $this->roomService->getById($id);
    }

    /**
     * Prepare Room DataProvider
     * @param RoomSearchModel $searchModel
     * @return \yii\data\ArrayDataProvider
     */
    public function getRoomDataProvider(RoomSearchModel $searchModel)
    {
        return $this->roomService->getDataProvider($searchModel);
    }

    /**
     * Get Booking by Id
     * @param BookingId $id
     * @return mixed
     */
    public function getBookingById(BookingId $id)
    {
        return $this->bookingService->getById($id);
    }

    /**
     * Prepare Booking DataProvider
     * @param BookingSearchModel $searchModel
     * @return \yii\data\ArrayDataProvider
     */
    public function getBookingDataProvider(BookingSearchModel $searchModel)
    {
        return $this->bookingService->getDataProvider($searchModel);
    }

    /**
     * Update booking
     * @param Booking $booking
     * @return mixed
     */
    public function updateBooking(Booking $booking)
    {
        return $this->bookingService->update($booking);
    }

    /**
     * Upload file
     * @param UploadForm $form
     * @param Room $model
     * @return string
     */
    public function upload(UploadForm $form, Room $model)
    {
        $filename = $model->getId()->getValue() . '.' . $form->image->extension;
        $this->roomService->upload($form, $filename);

        return $filename;
    }

    /**
     * Create Room from form
     * @param CreateForm $form
     * @return Room
     */
    public function createRoom(CreateForm $form)
    {
        $room = new Room($this->roomService->nextId());
        $room->setName(new Name($form->name));
        $room->setDescription(new Description($form->description));

        $this->roomService->add($room);

        return $room;
    }

    /**
     * Create new Room and upload image
     * @param CreateForm $form
     * @return Room
     */
    public function createAndUpload(CreateForm $form)
    {
        $model = $this->createRoom($form);
        if ($form->image) {
            $filename = $this->upload($form, $model);
            $model->setImage(new Image($filename));
        }
        $this->roomService->update($model);

        return $model;
    }

    /**
     * Update Room and upload image
     * @param UpdateForm $form
     * @param Room $model
     * @return Room
     */
    public function updateAndUpload(UpdateForm $form, Room $model)
    {
        $model->setName(new Name($form->name));
        $model->setDescription(new Description($form->description));
        if ($form->image) {
            $filename = $this->upload($form, $model);
            $model->setImage(new Image($filename));
        }
        $this->roomService->update($model);

        return $model;
    }
}
