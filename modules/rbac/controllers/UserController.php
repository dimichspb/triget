<?php

namespace app\modules\rbac\controllers;

use app\modules\rbac\forms\LoginForm;
use app\modules\rbac\forms\CreateForm;
use app\modules\rbac\forms\RegisterForm;
use app\modules\rbac\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use yii\web\User;

/**
 * Default controller for the `rbac` module
 */
class UserController extends Controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Module
     */
    public $module;

    /**
     * UserController constructor.
     * @param $id
     * @param Module $module
     * @param Request $request
     * @param User $user
     * @param array $config
     */
    public function __construct($id, Module $module, Request $request, User $user, array $config = [])
    {
        $this->request = $request;
        $this->module = $module;
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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Register action.
     *
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionRegister()
    {
        if (!$this->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($model->load($this->request->post()) && $this->module->register($model)) {
            return $this->goBack();
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!$this->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load($this->request->post()) && $this->module->login($model)) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        $this->user->logout();

        return $this->goHome();
    }
}
