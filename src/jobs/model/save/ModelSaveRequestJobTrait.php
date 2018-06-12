<?php
namespace matrozov\yii2amqp\jobs\model\save;

use Yii;
use yii\base\ErrorException;
use matrozov\yii2amqp\Connection;
use matrozov\yii2amqp\jobs\rpc\RpcFalseResponseJob;

/**
 * Trait ModelSaveRequestJobTrait
 * @package matrozov\yii2amqp\traits
 */
trait ModelSaveRequestJobTrait
{
    /**
     * @param Connection|null            $connection
     *
     * @var ModelSaveInternalResponseJob $response
     *
     * @return bool
     * @throws
     */
    public function save(Connection $connection = null)
    {
        /* @var ModelGetRequestJob $this */
        if (!$this->validate()) {
            return false;
        }

        $connection = Connection::instance($connection);

        /* @var ModelGetRequestJob $this */
        $response = $connection->send($this);

        if (!$response) {
            return false;
        }

        if ($response instanceof RpcFalseResponseJob) {
            return false;
        }

        if (!($response instanceof ModelSaveInternalResponseJob)) {
            throw new ErrorException('Response isn\'t ModelSaveInternalResponseJob');
        }

        /* @var ModelSaveInternalResponseJob $response */
        /* @var ModelGetRequestJob $this */
        $this->addErrors($response->errors);

        if ($response->success) {
            foreach ($response->primaryKeys as $key => $value) {
                $this->$key = $value;
            }
        }

        return $response->success;
    }
}