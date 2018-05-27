<?php
namespace matrozov\yii2amqp\jobs\model;

use matrozov\yii2amqp\jobs\rpc\RpcExecuteJob;

/**
 * Interface ModelExecuteJob
 * @package matrozov\yii2amqp\jobs
 */
interface ModelExecuteJob extends RpcExecuteJob
{
    public function validate();
    public function save();

    public function getErrors();
}