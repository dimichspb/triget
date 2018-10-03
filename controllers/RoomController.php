<?php
namespace app\controllers;

use app\forms\room\BookingForm;
use app\models\room\Id;
use app\models\room\SearchModel;
use app\models\room\Room;
use app\services\room\Service as RoomService;
use yii\base\Module;
use yii\bootstrap\ActiveForm;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\Session;
use yii\web\User;
use yii\helpers\Json;


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
     * @var RoomService
     */
    protected $roomService;

    public function __construct($id, Module $module, Request $request, Response $response, Session $session,
                                RoomService $roomService, \yii\web\User $user, array $config = [])
    {
        $this->request = $request;
        $this->response = $response;
        $this->session = $session;
        $this->user = $user;
        $this->roomService = $roomService;

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
                    'validate' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Room index action
     * @return string
     */
    public function actionIndex()
    {
        $form = new BookingForm();

        $searchModel = new SearchModel();
        $searchModel->load($this->request->getQueryParams());

        $dataProvider = $this->roomService->getDataProvider($searchModel);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'form' => $form,
        ]);
    }

    /**
     * View room action
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $form = new BookingForm();

        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
            'form' => $form,
        ]);
    }

    /**
     *
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \yii\web\RangeNotSatisfiableHttpException
     */
    public function actionImage($id)
    {
        $model = $this->findModel($id);

        return $this->response->sendStreamAsFile($this->roomService->getLargeImage($model), $model->getImage());
    }

    public function actionThumbnail($id)
    {
        $model = $this->findModel($id);

        return $this->response->sendStreamAsFile($this->roomService->getSmallImage($model), $model->getImage());
    }

    /**
     * @param $id
     * @return Room
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = $this->roomService->getById(new Id($id));

        if (is_null($model)) {
            throw new NotFoundHttpException(\Yii::t('app', 'Room not found'));
        }

        return $model;
    }
}
