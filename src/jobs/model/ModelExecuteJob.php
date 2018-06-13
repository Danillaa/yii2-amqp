<?php
namespace matrozov\yii2amqp\jobs\model;

use matrozov\yii2amqp\jobs\rpc\RpcExecuteJob;

interface ModelExecuteJob extends RpcExecuteJob
{
    public function validate();
    public function getErrors();

    public function executeSave();
}