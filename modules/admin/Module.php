<?php

namespace app\modules\admin;

use app\forms\room\UploadForm;
use app\models\room\Description;
use app\models\room\Id;
use app\models\room\Image;
use app\models\room\Name;
use app\models\room\Room;
use app\models\room\SearchModel;
use app\modules\admin\forms\CreateForm;
use app\modules\admin\forms\UpdateForm;
use app\services\room\Service;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    public $defaultRoute = 'room/index';

    protected $service;

    public function __construct($id, \yii\base\Module $parent, Service $service, array $config = [])
    {
        $this->service = $service;

        parent::__construct($id, $parent, $config);
    }

    public function getRoomById(Id $id)
    {
        return $this->service->getById($id);
    }

    public function getDataProvider(SearchModel $searchModel)
    {
        return $this->service->getDataProvider($searchModel);
    }

    public function upload(UploadForm $form, Room $model)
    {
        $filename = $model->getId()->getValue() . '.' . $form->image->extension;
        $this->service->upload($form, $filename);

        return $filename;
    }

    public function createRoom(CreateForm $form)
    {
        $room = new Room($this->service->nextId());
        $room->setName(new Name($form->name));
        $room->setDescription(new Description($form->description));

        $this->service->add($room);

        return $room;
    }

    public function createAndUpload(CreateForm $form)
    {
        $model = $this->createRoom($form);
        if ($form->image) {
            $filename = $this->upload($form, $model);
            $model->setImage(new Image($filename));
        }
        $this->service->update($model);

        return $model;
    }

    public function updateAndUpload(UpdateForm $form, Room $model)
    {
        $model->setName(new Name($form->name));
        $model->setDescription(new Description($form->description));
        if ($form->image) {
            $filename = $this->upload($form, $model);
            $model->setImage(new Image($filename));
        }
        $this->service->update($model);

        return $model;
    }
}
