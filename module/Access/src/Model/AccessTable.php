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

    public function searchAccesses($data)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->join('resource', 'access.resource_resource_id = resource.resource_id', ['resource_name' => 'name']);
        $select->join('user', 'access.user_user_id = user.user_id', ['user_full_name' => 'full_name'], 'left');

        ($data['username']) ? $select->where->like('access.username', '%'.$data['username'].'%') : null;
        ($data['resource_resource_id']) ? $select->where(['access.resource_resource_id' => $data['resource_resource_id']]) : null;
        ($data['user_user_id']) ? $select->where(['access.user_user_id' => $data['user_user_id']]) : null;
        ($data['status']) ? $select->where(['access.status' => $data['status']]) : null;

        return $this->tableGateway->selectWith($select);
    }

    public function getOrphans()
    {
        $select = $this->tableGateway->getSql()->select();
        $select->join('resource', 'access.resource_resource_id = resource.resource_id', ['resource_name' => 'name']);
        $select->join('user', 'access.user_user_id = user.user_id', ['user_full_name' => 'full_name'], 'left');
        $select->where->isNull('user_user_id');
        $select->where->isNull('is_generic');
        $select->order('username ASC');

        return $this->tableGateway->selectWith($select);
    }

    public function getAccesses($conditions = [])
    {
        $select = $this->tableGateway->getSql()->select();
        $select->join('resource', 'access.resource_resource_id = resource.resource_id', ['resource_name' => 'name']);
        $select->join('user', 'access.user_user_id = user.user_id', ['user_full_name' => 'full_name'], 'left');
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

        return $this->getAccesses(['user_user_id' => $user_id]);
    }

    public function getAccessesByResourceId($resource_id)
    {
        $resource_id = (int) $resource_id;

        return $this->getAccesses(['resource_resource_id' => $resource_id]);
    }

    public function saveAccess(Access $access)
    {
        $data = [
            'username' => $access->username,
            'status'  => $access->status,
            'resource_resource_id' => $access->resource_resource_id,
            'user_user_id'  => $access->user_user_id,
            'is_generic' => $access->is_generic,
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
