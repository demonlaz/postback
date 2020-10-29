<?php

namespace app\controllers;

use app\models\search\StatisticsSearch;
use app\models\Statistics;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
        ];
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchStatistics = new StatisticsSearch();
        $dataProvider = $searchStatistics->search(Yii::$app->request->queryParams);
        return $this->render('index',
            [
                'searchStatistics' => $searchStatistics,
                'dataProvider' => $dataProvider
            ]
        );
    }

    /**
     * @return array|bool[]
     */
    public function actionAdd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $get = Yii::$app->request->get();
        $statistic = new Statistics();
        switch ($get['event']) {
            case 'click':
                $statistic->click = 1;
                break;
            case 'trial_started':
                $statistic->trial = 1;
                break;
            case 'install':
                $statistic->install = 1;
                break;
            default :
                return ['success' => false, 'error' => true, 'errors' => ['event' => 'Не верное значение!']];
                break;

        }
        $statistic->campaign_id = $get['campaign_id'];
        $statistic->cid = $get['cid'];
        $statistic->sub1 = $get['sub1'];

        if ($statistic->save()) {
            return ['success' => true, 'error' => false];
        } else {
            return ['success' => false, 'error' => true, 'errors' => $statistic->errors];
        }
    }

    /**
     * @return array
     */
    public function actionGetJson()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $array = [];
        $searchStatistics = new StatisticsSearch();
        $dataProvider = $searchStatistics->searchApi(Yii::$app->request->queryParams,Yii::$app->request->get());
        foreach ($dataProvider->models as $model) {
            $array[] = [
                'campaign_id' => $model->campaign_id,
                'countClick' => $model->countClick,
                'cRi' => $model->cRi === null ? 0 : $model->cRi,
                'countInstall' => $model->countInstall,
                'countTrial' => $model->countTrial,
                'cRt' => $model->cRt === null ? 0 : $model->cRt
            ];

        }
        return $array;
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
}
