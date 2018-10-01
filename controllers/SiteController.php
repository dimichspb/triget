<?php

namespace app\controllers;

use yii\base\Module;
use yii\web\Controller;
use yii\web\Request;


class SiteController extends Controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * SiteController constructor.
     * @param $id
     * @param Module $module
     * @param Request $request
     * @param array $config
     */
    public function __construct($id, Module $module, Request $request, array $config = [])
    {
        $this->request = $request;

        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
