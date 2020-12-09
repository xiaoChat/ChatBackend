<?php

declare(strict_types=1);

namespace App\Model\Mongo;

use App\Libs\MongoDriver\MongoDriver;
use Hyperf\Utils\ApplicationContext;

class BaseMongo
{
    // Client
    protected $Client;

    protected $dbName;

    protected $tableName;

    // 自动添加时间
    protected $createAt = 'created_at';
    protected $updateAt = 'updated_at';
    protected $deleteAt = 'deleted_at';

    public function __construct()
    {
        $this->dbName = 'chat';
        $this->Client = ApplicationContext::getContainer()->get(MongoDriver::class);
    }

    /**
     * 添加数据.
     */
    public function insert(array $data)
    {
        $data[$this->createAt] = date('Y-m-d H:i:s');
        $data[$this->updateAt] = date('Y-m-d H:i:s');
        return $this->Client->insert($this->getName(), $data);
    }

    /**
     * 查询数据.
     */
    public function query(array $filter, array $options = [])
    {
        $filter['$or'] = [
            [$this->deleteAt => ['$exists' => false]],
            [$this->deleteAt => ['$eq' => null]],
        ];
        return $this->Client->query($this->getName(), $filter, $options);
    }

    /**
     * 更新数据.
     */
    public function update(array $data, array $newData, array $options = [])
    {
        $newData[$this->updateAt] = date('Y-m-d H:i:s');
        $_newData = ['$set' => $newData];
        return $this->Client->update($this->getName(), $data, $_newData, $options);
    }

    /**
     * 删除数据.
     */
    public function delete(array $filter, array $options = [])
    {
        return $this->Client->delete($this->getName(), $filter, $options);
    }

    /**
     * 软删除.
     */
    public function softDeletes(array $filter, array $options = [])
    {
        $newData =  [
            $this->deleteAt => date('Y-m-d H:i:s')
        ];
        $_newData = ['$set' => $newData];
        return $this->Client->update($this->getName(), $filter, $_newData, $options);
    }

    private function getName()
    {
        return $this->dbName . '.' . $this->tableName;
    }
}
