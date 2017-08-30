<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 17-8-30
 * Time: 下午2:51
 */

namespace common\models\record_operator;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecordInterface;

/**
 * Class RecordOperator
 * 继承　BaseRecordOperator 并　重写　insertRecord 和 updateRecord 方法　
 * 基于　insertRecordRules 和　updateRecordRules 来重写
 * @package common\models\record_operator
 */
class RecordOperator extends  BaseRecordOperator
{
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

            if (!$this->recordOperatorRulesHandler($event,self::InsertRecordRules)) {
                throw new Exception('insertRulesHandler failed');
            }

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
                throw new \Exception('updateRecord failed');
            }

            $record->update();

            if (!$this->recordOperatorRulesHandler($event,self::UpdateReocrdRules)) {
                throw new Exception('updateRulesHandler failed');
            }

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

    public function recordOperatorRulesHandler($event,$ruleFunction)
    {
        $rules = $this->getRules($event, $ruleFunction);
        if (empty($rules)) {
            return true;
        }

        foreach ($rules as $rule) {
            if(is_callable($rule)) {
                if(!call_user_func($rule, $event)) {
                    throw new Exception('delete record failed');
                }
                continue;
            }

            if (!isset($rule['class']) || empty($rule['class'])) {
                throw new Exception('the class is needed in this rule');
            }

            if (!isset($rule['operator']) || empty($rule['operator'])) {
                throw new Exception('the operator is needed in this rule');
            }

            if (!isset($rule['params']) || empty($rule['params'])) {
                throw new Exception('the params is needed in this rule');
            }

            if (isset($rule['operator_condition']) && $rule['operator_condition']) {
                $model = new $rule['class'];
                if(isset($rule['scenario'])) {
                    $model->setScenario($rule['scenario']);
                }
                call_user_func([$model, $rule['operator']], $rule['params']);
            }
        }
        return true;
    }


    public function getRules($event, $ruleFunction)
    {
        $record = $event->record;
        if (!method_exists($record, $ruleFunction)) {
            return null;
        }

        $rules = $record->$ruleFunction($event);
        if(empty($rules)) {
            return null;
        }

        $scenario = $record->getScenario();
        if(!isset($rules[$scenario]) || empty($rules[$scenario])) {
            return null;
        }

        return $rules[$scenario];
    }


}