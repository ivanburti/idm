<?php

namespace Access\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class AccessTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getAccesses($conditions = [])
    {
        $select = $this->tableGateway->getSql()->select();
        $select->join('resources', 'accesses.resources_resource_id = resources.resource_id', ['resource_name' => 'name']);
        $select->join('users', 'accesses.users_user_id = users.user_id', ['user_full_name' => 'full_name'], 'left');
        if ($conditions) {
            $select->where($conditions);
        }

        return $this->tableGateway->selectWith($select);
    }

    public function getAccessById($access_id)
    {
        $access_id = (int) $access_id;
        $rowset = $this->tableGateway->select(['access_id' => $access_id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find row with identifier %d', $access_id));
        }

        return $row;
    }

    public function getAccessesByUserId($user_id)
    {
        $user_id = (int) $user_id;

        return $this->getAccesses(['users_user_id' => $user_id]);
    }

    public function getAccessesByResourceId($resource_id)
    {
        $resource_id = (int) $resource_id;

        return $this->getAccesses(['resources_resource_id' => $resource_id]);
    }

    public function saveAccess(Access $access)
    {
        $data = [
            'username' => $access->username,
            'status'  => $access->status,
            'resources_resource_id' => $access->resources_resource_id,
            'users_user_id'  => $access->users_user_id,
        ];

        $access_id = (int) $access->access_id;

        if ($access_id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getAccessById($access_id)) {
            throw new RuntimeException(sprintf('Cannot update access with identifier %d; does not exist', $access_id));
        }

        $this->tableGateway->update($data, ['access_id' => $access_id]);
    }


}
