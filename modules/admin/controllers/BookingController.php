<?php

namespace app\modules\admin\controllers;

use app\models\booking\Booking;
use app\models\booking\Confirmed;
use app\models\booking\Id;
use app\models\booking\SearchModel;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Session;
use yii\web\UploadedFile;
use yii\web\User;

/**
 * Default controller for the `admin` module
 *
 */
class BookingController extends Controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var \app\modules\admin\Module
     */
    public $module;

    public function __construct($id, Module $module, Request $request, Session $session,
                                \yii\web\User $user, array $config = [])
    {
        $this->request = $request;
        $this->session = $session;
        $this->user = $user;

        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'confirm', 'decline',],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'confirm' => ['post'],
                    'decline' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Booking confirm
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionConfirm($id)
    {
        $model = $this->findModel($id);

        $model->setConfirmed(new Confirmed(true));

        $this->module->updateBooking($model);

        return $this->goBack();
    }

    /**
     * Booking decline
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDecline($id)
    {
        $model = $this->findModel($id);

        $model->setConfirmed(new Confirmed(false));

        $this->module->updateBooking($model);

        return $this->goBack();
    }

    public function actionIndex()
    {
        $searchModel = new SearchModel();
        $searchModel->load($this->request->queryParams);

        $dataProvider = $this->module->getBookingDataProvider($searchModel);

        $this->user->setReturnUrl(['admin/booking/index']);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return Booking
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = $this->module->getBookingById(new Id($id));

        if (is_null($model)) {
            throw new NotFoundHttpException(\Yii::t('app', 'Booking not found'));
        }

        return $model;
    }
}
