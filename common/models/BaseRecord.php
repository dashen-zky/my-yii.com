<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 17-8-24
 * Time: 上午10:23
 */

namespace common\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use common\models\record_list_builder\RecordListQueryBuilder;
use yii\data\Pagination;

class BaseRecord extends ActiveRecord
{
    public $enablePageSize = false;
    public $pageSize = 100;

    public function recordList($selects, $condition=null,$fetchOne = false, $enablePage = true, $orderBy = null)
    {
        // 把　要查询的字段　和　查询的条件　拼接好
        try {
            $recordListBuilder = Yii::$container->get(RecordListQueryBuilder::className()); // 列表查询构造器
            $query = $recordListBuilder->recordListBuilder($this, $selects, $condition);
        } catch (Exception $e) {
            throw $e;
        }

        if ($fetchOne) {
            $record = $query->asArray()->one();
            return $record;
        }

        if (!$enablePage) {
            if ($this->enablePageSize) {
                return $query->orderBy($orderBy)->limit($this->pageSize)->asArray()->all();
            }
            return $query->orderBy($orderBy)->asArray()->all();
        }

        $pagination = new Pagination([
            'totalCount'=>$query->count(),
            'pageSize' => $this->pageSize,
        ]);

        $_orderBy = empty($orderBy)?['t1.id' => SORT_DESC,] : $orderBy;

        try {
            $list = $query->orderBy($_orderBy)->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
        } catch (\Exception $e) {
            throw $e;
        }

        return [
            'pagination' => $pagination,
            'list'=> $list,
        ];
    }
}