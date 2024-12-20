<?php
namespace app\controllers;

use Yii;
use yii\base\BaseObject;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use app\models\Request;

class RequestController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // CORS Filter
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['https://example.com'],
                'Access-Control-Request-Method' => ['POST', 'GET', 'PUT'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['create'],
        ];

        return $behaviors;
    }

    public function actionCreate()
    {
        $model = new Request();
        $model->load(Yii::$app->request->post(), '');
        if ($model->save()) {
            return $model;
        }
        return $model->errors;
    }

    public function actionIndex($status = null, $date_from = null, $date_to = null)
    {
        $query = Request::find();

        if ($status) {
            $query->andWhere(['status' => $status]);
        }

        if ($date_from) {
            $query->andWhere(['>=', 'created_at', $date_from]);
        }

        if ($date_to) {
            $query->andWhere(['<=', 'created_at', $date_to]);
        }

        return $query->all();
    }

    public function actionUpdate($id)
    {
        $model = Request::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("Request not found.");
        }

        $data = Yii::$app->request->bodyParams;
        if (!isset($data['status']) || $data['status'] !== 'Resolved') {
            throw new BadRequestHttpException("Status must be 'Resolved'.");
        }

        if (empty($data['comment'])) {
            throw new BadRequestHttpException("Comment is required when setting status to 'Resolved'.");
        }

        $model->status = $data['status'];
        $model->comment = $data['comment'];

        if ($model->save()) {

            Yii::$app->mailer->compose()
                ->setTo($model->email)
                ->setSubject('Your Request has been Resolved')
                ->setTextBody($model->comment)
                ->send();

            return $model;
        }

        return $model->errors;
    }


    public static function testCreateRequest()
    {
        $response = Yii::$app->runAction('request/create', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'This is a test message.',
        ]);

        if (isset($response['id'])) {
            echo "Create Request: PASSED\n";
        } else {
            echo "Create Request: FAILED\n";
        }
    }

    public static function testGetRequests()
    {
        $response = Yii::$app->runAction('request/index', []);

        if (is_array($response)) {
            echo "Get Requests: PASSED\n";
        } else {
            echo "Get Requests: FAILED\n";
        }
    }

    public static function testUpdateRequest()
    {
        $response = Yii::$app->runAction('request/update', [
            'id' => 1,
            'status' => 'Resolved',
            'comment' => 'This is a resolution comment.',
        ]);

        if (isset($response['status']) && $response['status'] === 'Resolved') {
            echo "Update Request: PASSED\n";
        } else {
            echo "Update Request: FAILED\n";
        }
    }


}
