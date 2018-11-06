<?php

namespace User\Model;

use RuntimeException;
use Zend\Db\Sql\Expression;
use Zend\Db\TableGateway\TableGatewayInterface;

class SourceTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getSources($onlyEnabled = true)
    {
        return $this->tableGateway->select();
    }

    public function getSourcesById($user_source_id)
    {
        $user_source_id = (int) $user_source_id;

        $rowset = $this->tableGateway->select(['user_source_id' => $user_source_id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find user source with user_source_id'));
        }

        return $row;
    }


}
