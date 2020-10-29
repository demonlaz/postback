<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "statistics".
 *
 * @property int $id
 * @property int $campaign_id
 * @property string $cid
 * @property int $install
 * @property int $trial
 * @property int $click
 * @property string|null $sub1
 * @property int $created_at
 * @property int $updated_at
 */
class Statistics extends \yii\db\ActiveRecord
{
    public $countClick;
    public $countTrial;
    public $countInstall;
    public $cRi;
    public $cRt;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statistics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['campaign_id', 'cid'], 'required'],
            [['campaign_id', 'install', 'trial', 'click',], 'integer'],
            [['cid', 'sub1'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'campaign_id' => 'ID',
            'cid' => 'Cid',
            'install' => 'Install',
            'trial' => 'Trial',
            'click' => 'Click',
            'sub1' => 'Sub1',
            'cRi' => 'CRi, %',
            'cRt' => 'CRt, %',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'countClick' => 'Click',
            'countTrial' => 'Trial',
            'countInstall' => 'Install',
        ];
    }
}
