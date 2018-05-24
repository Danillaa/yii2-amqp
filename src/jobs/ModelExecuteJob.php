<?php
namespace matrozov\yii2amqp\jobs;

/**
 * Interface ModelExecuteJob
 * @package matrozov\yii2amqp\jobs
 */
interface ModelExecuteJob extends ExecuteJob
{
    public function validate();
    public function save();

    public function getErrors();
}