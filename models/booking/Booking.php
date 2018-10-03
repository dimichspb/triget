<?php
namespace app\models\booking;

use app\models\BaseModel;
use app\models\room\Id as RoomId;
use app\models\room\Room;
use app\models\user\Id as UserId;
use app\models\user\User;

class Booking extends BaseModel
{
    protected $id;
    protected $startDate;
    protected $endDate;
    protected $confirmed;
    protected $room;
    protected $user;

    public function __construct(Id $id, Room $room, User $user, StartDate $startDate,
                                EndDate $endDate, Confirmed $confirmed)
    {
        $this->id = $id;
        $this->room = $room;
        $this->user = $user;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->confirmed = $confirmed;
    }

    /**
     * @return Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return StartDate
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return EndDate
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return Confirmed
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }

    public function setConfirmed(Confirmed $confirmed)
    {
        $this->confirmed = $confirmed;
    }

    /**
     * @return Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}