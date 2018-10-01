<?php
namespace app\repositories\user;

use app\models\user\Id;
use app\models\user\User;

interface RepositoryInterface
{
    public function get(Id $id);
    public function find(array $criteria = []);
    public function add(User $user);

    public function count(array $criteria = []);
    public function all(array $criteria = [], array $orderBy = null, $offset = null, $limit = null);
    public function update(User $user);
    public function delete(User $user);
    public function nextId();

}