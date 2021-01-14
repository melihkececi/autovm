<?php

namespace app\modules\admin\models\forms;

use Yii;
use yii\base\Model;

class RdnsayarForm extends Model
{
    public $VipHosting_one_data_types;
    public $VipHosting_one_data_delete;
	
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['VipHosting_one_data_types', 'VipHosting_one_data_delete'],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'VipHosting_one_data_types' => Yii::t('app', 'Birden fazla eklenemeyecek tipleri seçiniz.'),
            'VipHosting_one_data_delete' => Yii::t('app', 'Birden fazla olan verileri otomatik sil'),
        ];
    }
}
