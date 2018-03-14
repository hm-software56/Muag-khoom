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
                if (Yii::$app->controller->action->id == "key") {
                   // return $this->render('');
                }
                else if (Yii::$app->controller->action->id == "install") {
                    $this->layout="main_1";
                    
                        return $this->render('install');
                    
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
        if (!empty(\Yii::$app->session['user']) && \Yii::$app->session['user']->user_type == "POS") {
            return $this->redirect(['products/sale']);
        } else {
            return $this->redirect(['products/dashbord']);
        }
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
        $atkey = \app\models\ShopProfile::find()->one();
        $key = $atkey->key_active;
        $key_acitvated = substr($key, 25, 2) . substr($key, 17, -8) . "-" . substr($key, 6, -19) . "-" . substr($key, 0, -25);
        \Yii::$app->session['key_acitvated']= $key_acitvated;

        if(isset($_GET['true']))
        {
            unset(Yii::$app->session['key']);
            unset(Yii::$app->session['keys']);
            unset(Yii::$app->session['step']);
        }
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $login = new \app\models\User();
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if(date('Y-m-d')>$key_acitvated)
            {
                \Yii::$app->getSession()->setFlash('su', \Yii::t('app', ' ​ໝົດອາ​ຍຸ​ການ​ນຳ​ໃຊ້ລະ​ບົບ ຖ້າ​ຕ້ອງ​ການ​ໃຊ້​ງານ​ຕໍ່​ທ່ານ​ຕ​ິດ​ຕໍ່ເບີ​ໂທ​ທັງ​ລູ່ມ.'));
                \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
                return $this->render('login', [
                    'model' => $model,
                    'login' => $login,
                ]);
            }

            $user = \app\models\User::findOne(['username' => $model->username, 'password' => $model->password]);
            if (!empty($user->id)) {
                \Yii::$app->session['user'] = $user;
                \Yii::$app->getSession()->setFlash('su', \Yii::t('app', 'ທ່ານ​ເຂົ້າ​ລະ​ບົບ​ຖືກ​ຕ້ອງກຳ​ລັງ​ເຂົ້າ​ຫາ​ຂໍ້​ມູນ​......'));
                \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
                \Yii::$app->session['timeout'] = Yii::$app->params['timeout'];
                \Yii::$app->session['height_screen'] = ($_POST['hsc'] - 133);
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

    public function actionKey()
    {
       if(isset($_POST['key'])&&$_POST['key'])
       {
            $atkey = \app\models\ShopProfile::find()->one();
            $key = $_POST['key'];
            $key_acitvated = substr($key, 25, 2) . substr($key, 17, -8) . "-" . substr($key, 6, -19) . "-" . substr($key, 0, -25);
            if (empty($atkey->key_active) || date('Y-m-d') <= $key_acitvated) {
                $atkey->key_active = $key;
                $atkey->save();
                \Yii::$app->getSession()->setFlash('success_key', \Yii::t('app', 'Successfull activated Key '));
            } else {
                \Yii::$app->getSession()->setFlash('error_key', \Yii::t('app', 'Your key expired please try again.'));
            }
       }
       return $this->redirect(['site/login']);
    }

    public function actionKeygenerate()
    {
        $try_m= 'last day of 5 month'; /// try to use 5 moth
        $key_generate = date('dis'). date('m', strtotime("" . $try_m . "")) . mt_rand(100000000, 999999999) . date('y', strtotime("" . $try_m . "")) .date('his') . substr(date('Y', strtotime("" . $try_m . "")), 0, 2);
        Yii::$app->session['key']= $key_generate;
        Yii::$app->session['keys'] =base64_encode($key_generate);
        return $this->redirect(['site/install']);
    }

    public function actionInstall($step=null)
    {
        Yii::$app->session['host']='';
        Yii::$app->session['username']='';
        Yii::$app->session['password'] = '';
        Yii::$app->session['database'] = '';
        if(isset($_POST['host']) && isset($_POST['username']) && isset($_POST['password']))
        {
            $host= $_POST['host'];
            $user= $_POST['username'];
            $pass= $_POST['password'];
            $db = $_POST['database'];

            Yii::$app->session['host'] = $host;
            Yii::$app->session['username'] =$user;
            Yii::$app->session['password'] =$pass;
            Yii::$app->session['database'] =$db;
            
            // connection hosting 
            $link = @mysqli_connect($host, $user, $pass);
            if (!$link) {
                    \Yii::$app->getSession()->setFlash('error',Yii::t('app','ຂໍ້​ມູນ​ບໍ່​ຖືກ​ຕ້ອງ. ທ່ານກວດ​ Host name, Username ແລະ  Password ເຂົ້າ Database ໃຫ້​ຖືກ​ຕ້ອງ'));
            }else{
                if(isset($_POST['database']))
                {
                        // create Database 
                        $sql_database = 'CREATE DATABASE '.$db.' DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ';
                        if (mysqli_query($link, $sql_database)) {
                            
                            // Add host, username, passwprd, database name in file db.php
                            $file = Yii::$app->basePath . '/config/db.php';
                            $f = fopen($file, "w");
                            $database_inf = "<?php
                                return [
                                    'class' => 'yii\db\Connection',
                                    'dsn' => 'mysql:host=".$host.";dbname=".$db."',
                                    'username' => '".$user."',
                                    'password' => '".$pass."',
                                    'charset' => 'utf8',
                                ];
                                ?>";
                            if (fwrite($f, $database_inf) > 0) {
                                fclose($f);
                                $file_index = Yii::$app->basePath . '/index.php';
                                $f_index = fopen($file_index, "w");
                                $index = "<?php
                                    header('location:web/index.php?r=site/login');
                                    ?>";
                                if (fwrite($f_index, $index) > 0) {
                                    fclose($f_index);
                                    Yii::$app->session['step'] = 2;
                                }
                            }

                        } else {
                            \Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Database ນີ້​ມີ​ແລ້ວ​ທ່ານ​ຕ້ອງ​ປ່ຽນ​ຊື່ database ໃໝ່'));
                        }
                }
                
            }
        }else {
            // unset(Yii::$app->session['step']);exit;
                if (Yii::$app->session['step'] == 2) {
                    if(isset($_POST['data']) && $_POST ['data']=='0')
                    {
                        \Yii::$app->db->createCommand(file_get_contents(Yii::$app->basePath . '/database/db_demo.sql'))->execute();
                        $profile=\app\models\ShopProfile::find()->one();
                        $profile->key_active=\Yii::$app->session['key'];
                        $profile->save();
                        \Yii::$app->session['step']=3;
                        unset(Yii::$app->session['key']);
                        //return $this->redirect(['site/login']);
                    }
                    if (isset($_POST['data']) && $_POST['data'] == '1') {
                        \Yii::$app->db->createCommand(file_get_contents(Yii::$app->basePath . '/database/db_blank.sql'))->execute();
                        $profile = \app\models\ShopProfile::find()->one();
                        $profile->key_active = \Yii::$app->session['key'];
                        $profile->save();
                        \Yii::$app->session['step'] = 3;
                        unset(Yii::$app->session['key']);
                        //return $this->redirect(['site/login']);
                    }
                }
            if (Yii::$app->session['step'] ==3) {
                if (isset($_POST['user_admin']) && isset($_POST['password_admin'])) {
                    $user=new \app\models\User();
                    $user->photo="user_photo.png";
                    $user->first_name="Adminstrator";
                    $user->last_name="Adminstrator";
                    $user->username=$_POST['user_admin'];
                    $user->password=$_POST['password_admin'];
                    $user->status=1;
                    $user->user_type='Admin';
                    $user->date=date('Y-m-d');
                    $user->save();
                    \Yii::$app->session['step'] =4;
                }
            }
        }
        if(empty(Yii::$app->session['step']))
        {
            if(isset($_POST['next']))
            {
                Yii::$app->session['step'] = 1;
            }
           
            unset(Yii::$app->session['key']);
        }
        return $this->render('install');
       
    }

}
