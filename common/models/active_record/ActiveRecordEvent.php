<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 17-8-30
 * Time: 下午3:40
 */

namespace common\models\active_record;

use yii\base\Event;

class ActiveRecordEvent extends Event
{
    public $record;
    public $formData;
    public $isValid = true;

    public function __construct($record, $formData = null, $config= [])
    {
        $this->record = $record;
        $this->formData = $formData;
        parent::__construct($config);
    }
}