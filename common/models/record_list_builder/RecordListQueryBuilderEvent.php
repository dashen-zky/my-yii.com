<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 17-8-28
 * Time: 上午9:43
 */

namespace common\models\record_list_builder;

use yii\base\Event;

class RecordListQueryBuilderEvent extends Event
{
    public $select;
    public $condition;
    public $record;
    public $isValid = true;

    public function __construct($record, &$select, &$condition, $config = [])
    {
        $this->record = $record;
        $this->select = $select;
        $this->condition = $condition;
        parent::__construct($config);
    }
}