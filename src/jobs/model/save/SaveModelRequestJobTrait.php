<?php
namespace matrozov\yii2amqp\jobs\model\save;

use matrozov\yii2amqp\Connection;
use matrozov\yii2amqp\jobs\model\ModelRequestJobTrait;
use matrozov\yii2amqp\jobs\model\ModelResponseJob;

/**
 * Trait SaveModelRequestJobTrait
 * @package matrozov\yii2amqp\jobs\model\save
 */
trait SaveModelRequestJobTrait
{
    use ModelRequestJobTrait {
        send as protected;
    }

    /**
     * @param Connection $connection
     *
     * @return bool|\matrozov\yii2amqp\jobs\rpc\RpcResponseJob|null
     * @throws
     */
    public function save(Connection $connection = null)
    {
        if (!$this->beforeModelRequest()) {
            return false;
        }

        $response = $this->send($connection);

        /* @var ModelResponseJob $response */
        if (!$this->afterModelRequest($response)) {
            return false;
        }

        if (is_array($response->result)) {
            /** @var SaveModelRequestJob $this */
            $this->setAttributes($response->result, false);
        }

        return $response->success;
    }
}