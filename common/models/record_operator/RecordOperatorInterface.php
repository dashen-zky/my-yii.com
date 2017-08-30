<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 17-8-30
 * Time: 下午3:19
 */

namespace common\models\record_operator;

interface RecordOperatorInterface
{

    const InsertRecordRules = 'insertRecordRules';
    const UpdateReocrdRules = 'updateRecordRules';
    /**
     *
     * @param $record
     * @param $formData
     * @return mixed
     */

    public function insertRecord($record, &$formData);
    public function updateRecord($record, &$formData);
    public function deleteRecord($record, &$formData);
    public function disabledRecord($record, &$formData);

    public function beforeInsertRecord(RecordOperatorEvent $event);
    public function afterInsertRecord(RecordOperatorEvent $event);
    public function beforeUpdateRecord(RecordOperatorEvent $event);
    public function afterUpdateRecord(RecordOperatorEvent $event);
    public function beforeDeleteRecord(RecordOperatorEvent $event);
    public function afterDeleteRecord(RecordOperatorEvent $event);

}