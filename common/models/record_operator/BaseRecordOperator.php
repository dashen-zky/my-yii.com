<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 17-8-30
 * Time: 下午2:56
 */

namespace common\models\record_operator;


use Yii;
use yii\base\Component;
use yii\base\Exception;
use yii\db\ActiveRecordInterface;

class BaseRecordOperator extends Component implements RecordOperatorInterface
{
    /**
     * 插入数据记录之前　要触发的　事件
     * @param RecordOperatorEvent $event
     * @return bool
     */
    public function beforeInsertRecord(RecordOperatorEvent $event)
    {
        $this->trigger(RecordOperatorEvent::BeforeInsertRecord, $event);
        return $event->isValid;
    }

    /**
     * 插入数据记录之后　要触发的　事件
     * @param RecordOperatorEvent $event
     * @return bool
     */
    public function afterInsertRecord(RecordOperatorEvent $event)
    {
        $this->trigger(RecordOperatorEvent::AfterInserRecord, $event);
        return $event->isValid;
    }

    /**
     * 更新数据记录之前　要触发的　事件
     * @param RecordOperatorEvent $event
     * @return bool
     */
    public function beforeUpdateRecord(RecordOperatorEvent $event)
    {
        $this->trigger(RecordOperatorEvent::BeforeUpdateRecord, $event);
        return $event->isValid;
    }

    /**
     * 更新数据记录之后　要触发的　事件
     * @param RecordOperatorEvent $event
     * @return bool
     */
    public function afterUpdateRecord(RecordOperatorEvent $event)
    {
        $this->trigger(RecordOperatorEvent::AfterUpdateRecord, $event);
        return $event->isValid;
    }

    /**
     * 记录删除之前　要触发的　事件
     * @param RecordOperatorEvent $event
     * @return bool
     */
    public function beforeDeleteRecord(RecordOperatorEvent $event)
    {
        $this->trigger(RecordOperatorEvent::BeforeDeleteRecord, $event);
        return $event->isValid;
    }

    /**
     * 记录删除之后　要触发的　事件
     * @param RecordOperatorEvent $event
     * @return bool
     */
    public function afterDeleteRecord(RecordOperatorEvent $event)
    {
        $this->trigger(RecordOperatorEvent::AfterDeleteRecord, $event);
        return $event->isValid;
    }

    /**
     * 单个的　插入数据记录操作
     * @param $record
     * @param $formData
     * @return bool
     * @throws Exception
     * @throws \Exception
     */
    public function insertRecord($record, &$formData)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            if (empty($formData)) {
                throw new Exception('$formData should not be empty');
            }

            if (!$record instanceof ActiveRecordInterface) {
                throw new Exception('$record should be instanceof ActiveRecordInterface');
            }

            $event = new RecordOperatorEvent($record, $formData);

            if(!$this->beforeInsertRecord($event)) {
                throw new \Exception('beforeInsertRecord failed');
            }

            $record->insert();

            if(!$this->afterInsertRecord($event)) {
                throw new \Exception('afterInsertRecord failed');
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        $transaction->commit();
        return true;
    }

    /**
     * 单个的　数据记录　更新操作
     * @param $record
     * @param $formData
     * @return bool
     * @throws Exception
     * @throws \Exception
     */
    public function updateRecord($record, &$formData)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            if (empty($formData)) {
                throw new Exception('$formData should not be empty');
            }

            if (!$record instanceof ActiveRecordInterface) {
                throw new Exception('$record should be instanceof ActiveRecordInterface');
            }

            $event = new RecordOperatorEvent($record, $formData);

            if(!$this->beforeUpdateRecord($event)) {
                throw new \Exception('beforeUpdateRecord failed');
            }

            $record->update();

            if(!$this->afterUpdateRecord($event)) {
                throw new \Exception('afterUpdateRecord failed');
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        $transaction->commit();
        return true;
    }

    public function deleteRecord($record, &$formData)
    {
        // TODO: Implement deleteRecord() method.
    }

    public function disabledRecord($record, &$formData)
    {
        // TODO: Implement disabledRecord() method.
    }
}