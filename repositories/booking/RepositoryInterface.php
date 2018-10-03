<?php
namespace app\repositories\booking;

use app\models\booking\Booking;
use app\models\booking\EndDate;
use app\models\booking\Id;
use app\models\booking\StartDate;
use app\models\room\Room;

interface RepositoryInterface
{
    public function get(Id $id);
    public function find(array $criteria = []);
    public function add(Booking $booking);

    public function count(array $criteria = []);
    public function all(array $criteria = [], array $orderBy = null, $offset = null, $limit = null);
    public function update(Booking $booking);
    public function delete(Booking $booking);
    public function nextId();

    public function findInDateRange(Room $room, StartDate $startDate, EndDate $endDate);
}