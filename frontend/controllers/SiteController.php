<?php
namespace frontend\controllers;

use frontend\models\HaHa;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','ha-ha'],
                'rules' => [
                    [
                        'actions' => ['signup','user-insert','ha-ha'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'test' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionKolJrttInsert()
    {
        $public_name_array = ['我','是','一','个','兵','哈','嘿','擦','嘞','牛','气','冲','天'];
        $desc_array = ['汽车小百科','行业','技巧','攻略','百度','谷歌','互联网','金融'];
        $latest_article_array = ['去店里洗车时要盯好','发现这样做','立马把他掀翻','发货发给','的规划分局的','而一个人就','发货的股份'];
        $length = count($public_name_array);
        $desc_length = count($desc_array);
        $latest_article_length = count($latest_article_array);
        $formData = [];
        $data = [];
        $str = '';
        $second = '';
        for ($i = 0; $i <= 300 ; $i++){
            $formData[$i]['uuid']  = time() . Yii::$app->security->generateRandomString(5);
            $data[$i]['uuid']  = time() . Yii::$app->security->generateRandomString(5);
            $data[$i]['client_uuid']  = '1476700600yE3mLZZ7';
            $data[$i]['jrtt_kol_uuid']  = $formData[$i]['uuid'];
            $data[$i]['created_time']  = time();
            $formData[$i]['public_id'] = substr(time(),4).mt_rand(1000,9999);
            $suiji = mt_rand(6,8);
            $formData[$i]['public_name'] = '';
            for ($j = 0 ; $j < $suiji ;$j++){
                $index = mt_rand(0,$length-1);
                $formData[$i]['public_name'] .= $public_name_array[$index];
            }
            $formData[$i]['cates'] = '#'.rand(1,5).'#';
            $formData[$i]['areas'] = '#'.rand(1,5).'#';
            $formData[$i]['fans_num'] = rand(10000,20000);
            $formData[$i]['head_img'] = 'http://p1.pstatp.com/thumb/'.time().'oob';
            $formData[$i]['home_url'] = 'http://www.toutiao.com/c/user/'.$formData[$i]['uuid'].'/#mid='.time();
            $suiji = mt_rand(3,5);
            $desc = [];
            for ($j = 0 ;$j < $suiji ; $j++){
                $index = mt_rand(1,$desc_length-1);
                if(in_array($desc_array[$index],$desc)){
                    continue ;
                }
                $desc[] = $desc_array[$index];
            }
            $formData[$i]['desc'] = implode(',',$desc);
            $desc = [];
            for ($j = 0 ;$j < $suiji ; $j++){
                $index = mt_rand(1,$latest_article_length-1);
                if(in_array($latest_article_array[$index],$desc)){
                    continue ;
                }
                $desc[] = $latest_article_array[$index];
            }
            $formData[$i]['latest_article_title'] = implode(',',$desc);
            $formData[$i]['latest_post_time'] = time();
            $formData[$i]['article_url'] = 'http://www.toutiao.com/'.$formData[$i]['uuid'].'/';
            $formData[$i]['article_price'] = mt_rand(800,1100);
            $formData[$i]['video_price'] = mt_rand(1800,2100);
            $formData[$i]['index_media_communication'] = mt_rand(8,20);
            $formData[$i]['index_cost_performance'] = mt_rand(15,30);
            $formData[$i]['index_fake'] = mt_rand(20,50);
            $formData[$i]['index_history_post'] = mt_rand(10,30);
            $desc = [];
            $suiji = mt_rand(1,4);
            for ($j = 0 ;$j < $suiji ; $j++){
                $index = mt_rand(1,$desc_length-1);
                if(in_array($desc_array[$index],$desc)){
                    continue ;
                }
                $desc[$j]['code'] = mt_rand(110,120);
                $desc[$j]['name'] = $desc_array[$index];
                $desc[$j]['rank'] = $desc[$j]['code'];
            }
            $formData[$i]['rank_info'] = json_encode($desc);
            $formData[$i]['read_num'] = mt_rand(10,30);
            $formData[$i]['comment_num'] = mt_rand(10,30);
        }

        foreach ($formData as $key => $value){
            $str .= '(';
            foreach ($value as $k => $v){
                $str .= "'".$v."',";
            }
            $str = substr($str,0,-1);
            $str .= '),';
        }
        foreach ($data as $va){
            $second .= '(';
            foreach ($va as $vaa){
                $second .= "'".$vaa."',";
            }
            $second = substr($second,0,-1);
            $second .= '),';

        }
        $str = substr($str,0,-1);
        $str .= ';';

        $second = substr($second,0,-1);
        $second .= ';';

        print_r($str);echo '<hr>';print_r($second);die;
    }

    public function actionUserInsert()
    {
        $public_name_array = ['我','是','一','个','兵','哈','嘿','擦','嘞','牛','气','冲','天'];
        $desc_array = ['汽车小百科','行业','技巧','攻略','百度','谷歌','互联网','金融'];
        $latest_article_array = ['去店里洗车时要盯好','发现这样做','立马把他掀翻','发货发给','的规划分局的','而一个人就','发货的股份'];
        $length = count($public_name_array);
        $desc_length = count($desc_array);
        $latest_article_length = count($latest_article_array);
        $formData = [];
        $data = [];
        $str = '';
        $second = '';
        for ($i = 0; $i <= 2 ; $i++){
            $formData[$i]['uuid']  = time() . Yii::$app->security->generateRandomString(5);
            $data[$i]['uuid']  = time() . Yii::$app->security->generateRandomString(5);
            $data[$i]['jrtt_kol_uuid']  = $formData[$i]['uuid'];
            $data[$i]['client_uuid']  = '1476700600yE3mLZZ7';
            $data[$i]['created']  = time();
            $formData[$i]['public_id'] = substr(time(),4).mt_rand(1000,9999);
            $suiji = mt_rand(6,8);
            $formData[$i]['public_name'] = '';
            for ($j = 0 ; $j < $suiji ;$j++){
                $index = mt_rand(0,$length-1);
                $formData[$i]['public_name'] .= $public_name_array[$index];
            }
            $formData[$i]['cate'] = '#'.rand(1,5).'#';
            $formData[$i]['areas'] = '#'.rand(1,5).'#';
            $formData[$i]['fans_num'] = rand(10000,20000);
            $formData[$i]['head_img'] = 'http://p1.pstatp.com/thumb/'.time().'oob';
            $formData[$i]['home_url'] = 'http://www.toutiao.com/c/user/'.$formData[$i]['uuid'].'/#mid='.time();
            $suiji = mt_rand(3,5);
            $desc = [];
            for ($j = 0 ;$j < $suiji ; $j++){
                $index = mt_rand(1,$desc_length-1);
                if(in_array($desc_array[$index],$desc)){
                    continue ;
                }
                $desc[] = $desc_array[$index];
            }
            $formData[$i]['desc'] = implode(',',$desc);
            $desc = [];
            for ($j = 0 ;$j < $suiji ; $j++){
                $index = mt_rand(1,$latest_article_length-1);
                if(in_array($latest_article_array[$index],$desc)){
                    continue ;
                }
                $desc[] = $latest_article_array[$index];
            }
            $formData[$i]['latest_article_title'] = implode(',',$desc);
            $formData[$i]['latest_post_time'] = time();
            $formData[$i]['article_url'] = 'http://www.toutiao.com/'.$formData[$i]['uuid'].'/';
            $formData[$i]['article_price'] = mt_rand(800,1100);
            $formData[$i]['video_price'] = mt_rand(1800,2100);
            $formData[$i]['index_media_communication'] = mt_rand(8,20);
            $formData[$i]['index_cost_performance'] = mt_rand(15,30);
            $formData[$i]['index_fake'] = mt_rand(20,50);
            $formData[$i]['index_history_post'] = mt_rand(10,30);
            $formData[$i]['rank_info'] = mt_rand(10,30);
            $formData[$i]['read_num'] = mt_rand(10,30);
            $formData[$i]['comment_num'] = mt_rand(10,30);
        }
        foreach ($formData as $key => $value){
            $str .= '(';
            foreach ($value as $k => $v){
                $str .= "'".$v."',";
            }
            $str = substr($str,0,-1);
            $str .= '),';
        }
        foreach ($data as $key => $value){
            $second = '(';
            foreach ($value as $k => $v){
                $second .= "'".$v."',";
            }
            $second = substr($second,0,-1);
        }
        $str = substr($str,0,-1);
        $second = substr($second,0,-1);
        $str .= ';';
        $second .= ';';
        print_r($str);echo '<hr>';



    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    public function actionKolWeiboInsert()
    {
        $public_name_array = ['我','是','一','个','兵','哈','嘿','擦','嘞','牛','气','冲','天'];
        $sex_array = [0=>'男',1=>'女'];
        $desc_array = ['汽车小百科','行业','技巧','攻略','百度','谷歌','互联网','金融'];
        $latest_article_array = ['去店里洗车时要盯好','发现这样做','立马把他掀翻','发货发给','的规划分局的','而一个人就','发货的股份'];
        $length = count($public_name_array);
        $desc_length = count($desc_array);
        $latest_article_length = count($latest_article_array);
        $formData = [];
        $data = [];
        $str = '';
        $second = '';
        for ($i = 0; $i <= 300 ; $i++){
            $formData[$i]['uuid']  = time() . Yii::$app->security->generateRandomString(5);
            $data[$i]['uuid']  = time() . Yii::$app->security->generateRandomString(5);
            $data[$i]['client_uuid']  = '1476700600yE3mLZZ7';
            $data[$i]['weibo_kol_uuid']  = $formData[$i]['uuid'];
            $data[$i]['created_time']  = time();
            $formData[$i]['public_id'] = substr(time(),4).mt_rand(1000,9999);
            $suiji = mt_rand(6,8);
            $formData[$i]['public_name'] = '';
            for ($j = 0 ; $j < $suiji ;$j++){
                $index = mt_rand(0,$length-1);
                $formData[$i]['public_name'] .= $public_name_array[$index];
            }

            $formData[$i]['home_url'] = 'http://www.weibo.com/user/'.$formData[$i]['uuid'].'/#mid='.time();
            $suiji = mt_rand(3,5);
            $desc = [];
            for ($j = 0 ;$j < $suiji ; $j++){
                $index = mt_rand(1,$desc_length-1);
                if(in_array($desc_array[$index],$desc)){
                    continue ;
                }
                $desc[] = $desc_array[$index];
            }
            $formData[$i]['desc'] = implode(',',$desc);
            $formData[$i]['head_img'] = 'http://weibo.pstatp.com/user/thumb/'.time().'oob';
            $formData[$i]['cates'] = '#'.rand(1,5).'#'.rand(1,5).'#';
            $formData[$i]['areas'] = '#'.rand(1,5).'#'.rand(1,5).'#';
            $formData[$i]['fans_num'] = mt_rand(10000,20000);
            $formData[$i]['sex'] = mt_rand(0,1);
            $formData[$i]['hard_ad_price'] = mt_rand(100,100000);
            $formData[$i]['soft_ad_price'] = mt_rand(100,100000);
            $formData[$i]['is_v_account'] = 0;
            $formData[$i]['forward_num'] = mt_rand(100,100000);
            $formData[$i]['comment_num'] = mt_rand(100000,200000);
            $formData[$i]['index_media_communication'] = mt_rand(1,20);
            $formData[$i]['index_cost_performance'] = mt_rand(100,3000);
            $formData[$i]['index_fake'] = mt_rand(1,100)*0.01;
            $formData[$i]['index_history_post'] = mt_rand(10,120);
            $desc = [];
            $suiji = mt_rand(1,4);
            for ($j = 0 ;$j < $suiji ; $j++){
                $index = mt_rand(1,$desc_length-1);
                if(in_array($desc_array[$index],$desc)){
                    continue ;
                }
                $desc[$j]['code'] = mt_rand(110,120);
                $desc[$j]['name'] = $desc_array[$index];
                $desc[$j]['rank'] = $desc[$j]['code'];
            }
            $formData[$i]['rank_info'] = json_encode($desc);
            $desc = [];
            for ($j = 0 ;$j < $suiji ; $j++){
                $index = mt_rand(1,$latest_article_length-1);
                if(in_array($latest_article_array[$index],$desc)){
                    continue ;
                }
                $desc[] = $latest_article_array[$index];
            }
            $formData[$i]['latest_article_title'] = implode(',',$desc);
            $formData[$i]['latest_post_time'] = time();
            $formData[$i]['article_url'] = 'http://weibo.autohome.com.cn/info/'.$formData[$i]['uuid'].'#pvareaid=2808114';
            $formData[$i]['interact_avg_num'] = mt_rand(1000,2000);
            $formData[$i]['origin_interact_avg_num'] = mt_rand(1000,2000);
            $formData[$i]['fans_active_ratio'] = mt_rand(1000,2000);
            $formData[$i]['origin_ratio'] = mt_rand(1000,2000);
        }

        $query1 = 'INSERT INTO kol_weibo(';
        foreach ($formData as $key => $value){
            $str .= '(';
            foreach ($value as $k => $v){
                if ($key < 1){
                    $query1 .= '`'.$k.'`,';
                }
                $str .= "'".$v."',";
            }
            $str = substr($str,0,-1);
            $str .= '),';
        }
        $query1 = substr($query1,0,-1);
        $query1 .= '),';
        $query1 = substr($query1,0,-1);

        $query2 = 'INSERT INTO weibo_kol_client_mapping(';
        foreach ($data as $key => $va){
            $second .= '(';
            foreach ($va as $k => $vaa){
                if ($key < 1){
                    $query2 .= '`'.$k.'`,';
                }
                $second .= "'".$vaa."',";
            }
            $second = substr($second,0,-1);
            $second .= '),';

        }
        $query2 = substr($query2,0,-1);
        $query2 .= '),';
        $query2 = substr($query2,0,-1);

        $str = substr($str,0,-1);
        $str .= ';';

        $second = substr($second,0,-1);
        $second .= ';';

        $query = Yii::$app->db;
        $query->createCommand($query1.' VALUES '.$str)->execute();
        $query->createCommand($query2.' VALUES '.$second)->execute();

    }

    public function actionHaHa()
    {
        $a = 1;
        call_user_func(array($this,'add'),$a);
        echo  $a;
    }

    public function add(&$num)
    {
        $num++;
    }




}
