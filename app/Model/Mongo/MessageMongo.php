<?php

declare(strict_types=1);

namespace App\Model\Mongo;

class MessageMongo extends BaseMongo
{
    protected $tableName = 'test';

    public function add()
    {
        // $this->insert(['id' => '1111111111']);
        // $this->update(['id' => '999745651'], ['sdf' => '12112121']);
        // $this->delete(['sdf' => '12112121']);
        // $this->softDeletes(['sdf' => '12112121']);
        return $this->query(['id' => '1111111111']);
    }
}
