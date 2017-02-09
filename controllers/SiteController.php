<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller {

    public function beforeAction($action) {
        if (empty(\Yii::$app->session['user'])) {
            if (Yii::$app->controller->action->id != "login") {
                if (Yii::$app->controller->action->id == "reg") {

                } else {
                    $this->redirect(['site/login']);
                }
            }
        } elseif (Yii::$app->session['timeout'] < date('dHi')) {
            unset(\Yii::$app->session['user']);
            $this->redirect(['site/login']);
        } else {
            Yii::$app->session['timeout'] = Yii::$app->params['timeout'];
        }

        if (Yii::$app->controller->action->id == "index") {
            $this->layout = 'main_index'; //your layout name site index
        }
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        // return $this->render('index');
        return $this->redirect(['products/index']);
    }

    public function actionPage() {
        return $this->render('page');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $login = new \app\models\User();
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            $user = \app\models\User::findOne(['username' => $model->username, 'password' => $model->password]);
            if (!empty($user->id)) {
                \Yii::$app->session['user'] = $user;
                \Yii::$app->getSession()->setFlash('su', \Yii::t('app', 'ທ່ານ​ເຂົ້າ​ລະ​ບົບ​ຖືກ​ຕ້ອງກຳ​ລັງ​ເຂົ້າ​ຫາ​ຂໍ້​ມູນ​......'));
                \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
                \Yii::$app->session['timeout'] = Yii::$app->params['timeout'];
                \Yii::$app->session['height_screen'] = ($_POST['hsc'] - 131);
                // $user->height_screen = ($_POST['hsc'] - 131);
                //$user->save();
                return $this->redirect(['site/index']);
            } else {
                \Yii::$app->getSession()->setFlash('su', \Yii::t('app', 'ທ່ານ​ປ້ອນ​ຊື່ຫຼື​ລະ​ຫັດ​ເຂົ້າ​ລະ​ບົບ​ບໍ່ຖືກ'));
                \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
            }
        }
        return $this->render('login', [
                    'model' => $model,
                    'login' => $login,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        unset(\Yii::$app->session['user']);
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        return $this->render('about');
    }

    public function actionReg() {
        $model = new \app\models\User();
        if ($model->load(Yii::$app->request->post())) {
            $model->photo = 'prof.png';
            if ($model->save()) {
                \Yii::$app->getSession()->setFlash('reg', \Yii::t('app', 'ທ່ານ​ລົງ​ທະ​ບຽນ​ສຳ​ເລັດ​ແລ້ວ​ລໍ​ຖ້າປະ​ມານ 30 ວິ​ນາ​ທີ​........'));
                \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
                return $this->redirect(['login']);
            } else {
                return $this->render('form', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->render('form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionCompare() {
        return $this->render('compare');
    }

}
