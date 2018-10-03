<?php
namespace app\services\room;

use app\forms\room\UploadForm;
use app\models\room\Id;
use app\models\room\Name;
use app\models\room\Room;
use app\models\room\SearchModel;
use app\repositories\room\RepositoryInterface;
use yii\data\ArrayDataProvider;

class Service
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * Service constructor.
     * @param RepositoryInterface $repository
     * @param FilesystemInterface $filesystem
     */
    public function __construct(RepositoryInterface $repository, FilesystemInterface $filesystem)
    {
        $this->repository = $repository;
        $this->filesystem = $filesystem;
    }

    /**
     * Get Room by Id
     * @param Id $id
     * @return mixed
     */
    public function getById(Id $id)
    {
        return $this->repository->get($id);
    }

    /**
     * Get Room by Name
     * @param Name $name
     * @return mixed
     */
    public function getByName(Name $name)
    {
        return $this->repository->find([
            'name' => $name,
        ]);
    }

    /**
     * Find one by criteria
     * @param array $criteria
     * @return mixed
     */
    public function find(array $criteria = [])
    {
        return $this->repository->find($criteria);
    }

    /**
     * Find all by criteria
     * @param array $criteria
     * @param array $orderBy
     * @param null $offset
     * @param null $limit
     * @return mixed
     */
    public function all(array $criteria = [], array $orderBy = [], $offset = null, $limit = null)
    {
        return $this->repository->all($criteria, $orderBy, $offset, $limit);
    }

    /**
     * Add Room to repository
     * @param Room $room
     * @return mixed
     */
    public function add(Room $room)
    {
        return $this->repository->add($room);
    }

    /**
     * Update Room in repository
     * @param Room $room
     * @return mixed
     */
    public function update(Room $room)
    {
        return $this->repository->update($room);
    }

    /**
     * Get repository next Id
     * @return mixed
     */
    public function nextId()
    {
        return $this->repository->nextId();
    }

    /**
     * Count Rooms
     * @param array $criteria
     * @return mixed
     */
    public function count(array $criteria = [])
    {
        return $this->repository->count($criteria);
    }

    /**
     * Prepare Room DataProvider
     * @param SearchModel $searchModel
     * @return ArrayDataProvider
     */
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

    /**
     * Upload image
     * @param UploadForm $form
     * @param $filename
     */
    public function upload(UploadForm $form, $filename)
    {
        $stream = fopen($form->image->tempName, 'r+');
        $this->filesystem->saveFileToUploadBucket($filename, $stream);
        fclose($stream);

        unlink($form->image->tempName);
    }

    /**
     * Get Small image
     * @param Room $model
     * @return mixed
     */
    public function getSmallImage(Room $model)
    {
        $result = $this->filesystem->getFileFrom200x200Bucket($model->getImage()->getValue());

        return $result;
    }

    /**
     * Get Large image
     * @param Room $model
     * @return mixed
     */
    public function getLargeImage(Room $model)
    {
        $result = $this->filesystem->getFileFrom400x400Bucket($model->getImage()->getValue());

        return $result;
    }
}