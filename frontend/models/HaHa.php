<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 17-8-29
 * Time: 下午6:13
 */

namespace frontend\models;

use common\models\BaseRecord;

class HaHa extends BaseRecord
{
    public static function tableName()
    {
        return static::TableUser;
    }

    public function buildRecordListRules()
    {
        return [
            static::SCENARIO_DEFAULT => [
                'rules' => [
                    'user'=>[
                        'alias'=>'t1',
                        'table_name'=>static::tableName(),
                        'join_condition'=>false,
                        'select_build_way'=>0,
                    ],
                ],
            ],
        ];

    }
    public function getList()
    {
         return $this->recordList(
            [
                'user'=>[
                    'uuid',
                ],
            ],
            [
                '=',
                'uuid',
                'dd'
            ]
        );
    }
}