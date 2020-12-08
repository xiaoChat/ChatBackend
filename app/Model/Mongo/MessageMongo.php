<?php

declare(strict_types=1);

namespace App\Model\Mongo;

class MessageMongo extends BaseMongo
{
    protected $tableName = 'test';

    public function add()
    {
        $this->softDeletes(['id' => '999745651']);
        // $this->update(['id' => '999745651'], ['sdf' => '12112121']);
        // $this->delete(['id' => '999745651']);
    }
}
