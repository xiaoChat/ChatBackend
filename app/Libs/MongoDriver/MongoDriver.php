<?php

declare(strict_types=1);

namespace App\Libs\MongoDriver;

use Hyperf\Task\Annotation\Task;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use MongoDB\Driver\WriteConcern;

class MongoDriver
{
    /**
     * @var Manager
     */
    public $manager;

    /**
     * @Task
     */
    public function insert(string $namespace, array $document)
    {
        $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
        $bulk = new BulkWrite();
        $bulk->insert($document);

        $result = $this->manager()->executeBulkWrite($namespace, $bulk, $writeConcern);
        return $result->getUpsertedCount();
    }

    /**
     * @Task
     */
    public function update(string $namespace, array $document, array $newData, array $options = [])
    {
        $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
        $bulk = new BulkWrite();
        $bulk->update($document, $newData, $options);

        $result = $this->manager()->executeBulkWrite($namespace, $bulk, $writeConcern);
        return $result->getUpsertedCount();
    }

    /**
     * @Task
     */
    public function delete(string $namespace, array $document, array $options = [])
    {
        $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
        $bulk = new BulkWrite();
        $bulk->delete($document, $options);

        $result = $this->manager()->executeBulkWrite($namespace, $bulk, $writeConcern);
        return $result->getUpsertedCount();
    }

    /**
     * @Task
     */
    public function query(string $namespace, array $filter = [], array $options = [])
    {
        $query = new Query($filter, $options);
        $cursor = $this->manager()->executeQuery($namespace, $query);
        return $cursor->toArray();
    }

    protected function manager()
    {
        if ($this->manager instanceof Manager) {
            return $this->manager;
        }
        $uri = 'mongodb://root:123456@mongo:27017';
        return $this->manager = new Manager($uri, []);
    }
}
