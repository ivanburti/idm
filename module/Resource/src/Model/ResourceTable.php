<?php

namespace Resource\Model;

use Zend\Db\TableGateway\TableGatewayInterface;
use RuntimeException;
use Zend\Db\Sql\Expression;

class ResourceTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getResources()
    {
        return $this->tableGateway->select();
    }

    public function getResourceById($resource_id)
    {
        $resource_id = (int) $resource_id;
        $rowset = $this->tableGateway->select(['resource_id' => $resource_id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find row with identifier %d', $resource_id));
        }

        return $row;
    }

    public function saveResource(Resource $resource)
    {
        $data = [
            'name' => $resource->name,
            'description'  => $resource->description,
            'resource_auth' => $resource->resource_auth,
            'resource_email'  => $resource->resource_email,
            'status' => $resource->status,
            'owners' => json_encode($resource->owners),
            'approvers' => json_encode($resource->approvers),
        ];

        $resource_id = (int) $resource->resource_id;

        if ($resource_id === 0) {
            $data['created_on'] = new Expression("NOW()");
            $this->tableGateway->insert($data);
            return $this->tableGateway->getLastInsertValue();
        }

        if (! $this->getResourceById($resource_id)) {
            throw new RuntimeException(sprintf('Cannot update resource with id %d; does not exist', $resource_id));
        }

        $data['updated_on'] = new Expression("NOW()");

        $this->tableGateway->update($data, ['resource_id' => $resource_id]);
    }
}
