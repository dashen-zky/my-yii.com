<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 17-8-30
 * Time: 下午3:42
 */

namespace common\models\record_operator;


use common\models\active_record\ActiveRecordEvent;

class RecordOperatorEvent extends ActiveRecordEvent
{
    const BeforeInsertRecord = 'beforeInsertRecord';
    const AfterInsertRecord = 'afterInsertRecord';
    const BeforeUpdateRecord = 'beforeUpdateRecord';
    const AfterUpdateRecord = 'afterUpdateRecord';
    const BeforeDeleteRecord = 'beforeDeleteRecord';
    const AfterDeleteRecord = 'afterDeleteRecord';
}