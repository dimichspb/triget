<?php

namespace app\modules\admin\controllers;

use app\models\room\Id;
use app\models\room\Room;
use app\models\room\SearchModel;
use app\modules\admin\forms\CreateForm;
use app\modules\admin\forms\UpdateForm;
use yii\base\Module;
use yii\filters\AccessControl;
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
class RoomController extends Controller
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
                        'actions' => ['index', 'view', 'update', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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

        $dataProvider = $this->module->getDataProvider($searchModel);

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

    public function actionCreate()
    {
        $form = new CreateForm();

        if ($form->load($this->request->post())) {
            $form->image = UploadedFile::getInstance($form, 'image');
            if ($form->validate()) {
                $model = $this->module->createAndUpload($form);
                return $this->redirect(['room/view', 'id' => $model->getId()]);
            }
        }

        return $this->render('create', [
            'form' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new UpdateForm();

        if ($form->load($this->request->post())) {
            $form->image = UploadedFile::getInstance($form, 'image');
            if ($form->validate()) {
                $model = $this->module->updateAndUpload($form, $model);
                return $this->redirect(['room/view', 'id' => $model->getId()]);
            }
        }

        $form->name = $model->getName()->getValue();
        $form->description = $model->getDescription()->getValue();

        return $this->render('update', [
            'form' => $form,
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return Room
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = $this->module->getRoomById(new Id($id));

        if (is_null($model)) {
            throw new NotFoundHttpException(\Yii::t('app', 'Room not found'));
        }

        return $model;
    }
}
