<?php
namespace app\controllers;

use app\forms\room\BookingForm;
use yii\base\Module;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\Session;
use yii\web\User;
use app\services\booking\Service as BookingService;

class BookingController extends Controller
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
     * @var BookingService
     */
    protected $bookingService;

    public function __construct($id, Module $module, Request $request, Response $response, Session $session,
                                BookingService $bookingService, \yii\web\User $user, array $config = [])
    {
        $this->request = $request;
        $this->response = $response;
        $this->session = $session;
        $this->user = $user;
        $this->bookingService = $bookingService;

        parent::__construct($id, $module, $config);
    }
    /**
     * Room booking action
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionCreate()
    {
        $form = new BookingForm();

        if (!$form->load($this->request->post())) {
            throw new BadRequestHttpException('Booking form can not be loaded');
        }
        if (!$form->validate()) {
            throw new BadRequestHttpException('Booking form can not be validated');
        }

        $booking = $this->bookingService->create($form);

        $this->bookingService->add($booking);

        return $this->render('success', [
            'form' => $form,
        ]);
    }

    /**
     * Room booking ajax validation
     * @return string
     * @throws BadRequestHttpException
     * @throws MethodNotAllowedHttpException
     */
    public function actionValidate()
    {
        $this->response->format = Response::FORMAT_JSON;

        $form = new BookingForm();

        if (!$this->request->isAjax) {
            throw new MethodNotAllowedHttpException();
        }

        if (!$form->load($this->request->post())) {
            throw new BadRequestHttpException();
        }

        return Json::encode(ActiveForm::validate($form));
    }
}