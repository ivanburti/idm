<?php

namespace Access\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class AccessTable
{
    private $select;
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;

        $this->select = $this->tableGateway->getSql()->select();
        $this->select->join('resource', 'access.resource_resource_id = resource.resource_id', ['resource_name' => 'name', 'resource_is_enabled' => 'is_enabled']);
        $this->select->join('user', 'access.user_user_id = user.user_id', ['user_full_name' => 'full_name', 'user_is_enabled' => 'is_enabled'], 'left');
        $this->select->where->isNull('is_generic');
    }

    public function getOrphans()
    {
        $select = $this->select;
        $select->where->isNull('user_user_id');

        return $this->tableGateway->selectWith($select);
    }

    public function getAccesses()
    {
        $select = $this->select;

        return $this->tableGateway->selectWith($select);
    }

    public function searchAccesses(Access $access)
    {
        $select = $this->select;

        ($access->username) ? $select->where->like('username', '%'.$access->username.'%') : null;
        ($access->user_user_id) ? $select->where->isNull('user_user_id') : null;

        return $this->tableGateway->selectWith($select);
    }

    public function getAccessById($access_id)
    {
        $access_id = (int) $access_id;

        $select = $this->select;
        $select->where(['access_id' => $access_id]);
        $rowset = $this->tableGateway->selectWith($select);

        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find row with identifier %d', $access_id));
        }

        return $row;
    }

    public function getAccessesByUserId($user_id)
    {
        $select = $this->select;
        $select->where(['user_user_id' => (int) $user_id]);
        return $this->tableGateway->selectWith($select);
    }

    public function getAccessesByResourceId($resource_id)
    {
        $select = $this->select;
        $select->where(['resource_resource_id' => (int) $resource_id]);
        return $this->tableGateway->selectWith($select);
    }

    public function saveAccess(Access $access)
    {
        $data = [
            'username' => $access->username,
            'is_enabled'  => $access->is_enabled,
            'is_generic'  => $access->is_generic,
            'comment'  => $access->comment,
            'resource_resource_id' => $access->resource_resource_id,
            'user_user_id'  => $access->user_user_id,
        ];

        $access_id = (int) $access->access_id;

        if ($access_id === 0) {
            $data['created_on'] = new Expression("NOW()");
            $this->tableGateway->insert($data);
            return $this->tableGateway->getLastInsertValue();
        }

        if (! $this->getAccessById($access_id)) {
            throw new RuntimeException(sprintf('Cannot update access with identifier %d; does not exist', $access_id));
        }

        //$data['updated_on'] = new Expression("NOW()");
        return $this->tableGateway->update($data, ['access_id' => $access_id]);
    }

}
