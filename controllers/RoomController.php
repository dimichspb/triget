<?php

namespace app\controllers;

use app\models\room\Id;
use app\models\room\SearchModel;
use app\models\room\Room;
use app\services\room\Service;
use yii\base\Module;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\Session;
use yii\web\User;

class RoomController extends \yii\web\Controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Service
     */
    protected $service;

    public function __construct($id, Module $module, Request $request, Response $response, Session $session,
                                Service $service, \yii\web\User $user, array $config = [])
    {
        $this->request = $request;
        $this->response = $response;
        $this->session = $session;
        $this->user = $user;
        $this->service = $service;

        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'book' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Room index
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchModel();
        $searchModel->load($this->request->getQueryParams());

        $dataProvider = $this->service->getDataProvider($searchModel);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionBook($id)
    {
        $model = $this->findModel($id);

        return $this->render('book', [
            'model' => $model,
        ]);
    }

    public function actionImage($id)
    {
        $model = $this->findModel($id);

        return $this->response->sendStreamAsFile($this->service->getLargeImage($model), $model->getImage());
    }

    public function actionThumbnail($id)
    {
        $model = $this->findModel($id);

        return $this->response->sendStreamAsFile($this->service->getSmallImage($model), $model->getImage());
    }

    /**
     * @param $id
     * @return Room
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = $this->service->getById(new Id($id));

        if (is_null($model)) {
            throw new NotFoundHttpException(\Yii::t('app', 'Room not found'));
        }

        return $model;
    }
}
