<?php
namespace app\services\room;

use app\forms\room\UploadForm;
use app\models\room\Id;
use app\models\room\Name;
use app\models\room\Room;
use app\models\room\SearchModel;
use app\modules\admin\forms\CreateForm;
use app\repositories\room\RepositoryInterface;
use yii\data\ArrayDataProvider;

class Service
{
    protected $repository;

    protected $filesystem;

    public function __construct(RepositoryInterface $repository, FilesystemInterface $filesystem)
    {
        $this->repository = $repository;
        $this->filesystem = $filesystem;
    }

    public function getById(Id $id)
    {
        return $this->repository->get($id);
    }

    public function getByName(Name $name)
    {
        return $this->repository->find([
            'name' => $name,
        ]);
    }

    public function find(array $criteria = [])
    {
        return $this->repository->find($criteria);
    }

    public function all(array $criteria = [], array $orderBy = [], $offset = null, $limit = null)
    {
        return $this->repository->all($criteria, $orderBy, $offset, $limit);
    }

    public function add(Room $room)
    {
        return $this->repository->add($room);
    }

    public function update(Room $room)
    {
        return $this->repository->update($room);
    }

    public function nextId()
    {
        return $this->repository->nextId();
    }

    public function count(array $criteria = [])
    {
        return $this->repository->count($criteria);
    }

    public function getDataProvider(SearchModel $searchModel)
    {
        $offset = ($searchModel->page - 1) * $searchModel->limit;

        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->all($searchModel->getAttributes(['id', 'name']), [], $offset, $searchModel->limit),
            'totalCount' => $this->count($searchModel->getAttributes(['id', 'name'])),
            'key' => function (Room $model) {
                return $model->getId();
            }
        ]);

        return $dataProvider;
    }

    public function upload(UploadForm $form, $filename)
    {
        $stream = fopen($form->image->tempName, 'r+');
        $this->filesystem->saveFileToUploadBucket($filename, $stream);
        fclose($stream);

        unlink($form->image->tempName);
    }

    public function getSmallImage(Room $model)
    {
        $result = $this->filesystem->getFileFrom200x200Bucket($model->getImage()->getValue());

        return $result;
    }

    public function getLargeImage(Room $model)
    {
        $result = $this->filesystem->getFileFrom400x400Bucket($model->getImage()->getValue());

        return $result;
    }
}