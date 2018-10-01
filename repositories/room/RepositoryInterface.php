<?php
namespace app\repositories\room;

use app\models\room\Id;
use app\models\room\Room;
use Doctrine\ORM\EntityManager;

interface RepositoryInterface
{
    public function get(Id $id);
    public function find(array $criteria = []);
    public function add(Room $room);

    public function count(array $criteria = []);
    public function all(array $criteria = [], array $orderBy = null, $offset = null, $limit = null);
    public function update(Room $room);
    public function delete(Room $room);
    public function nextId();
}