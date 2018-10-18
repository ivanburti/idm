<?php

namespace User\Model;

use RuntimeException;
use Zend\Db\Sql\Expression;
use Zend\Db\TableGateway\TableGatewayInterface;

class UserTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    private function getSelectUsers()
    {
        $select = $this->tableGateway->getSql()->select();
        $select->join('organizations', 'organizations.organization_id = users.organizations_organization_id', ['organization_name' => 'name', 'organization_is_enabled' => 'is_enabled', 'organization_is_external' => 'is_external']);

        return $select;
    }

    public function getUsers($onlyEnabled = true)
    {
        $select = $this->getSelectUsers();

        ($onlyEnabled) ? $select->where(['users.status' => 1 ]) : null;

        return $this->tableGateway->selectWith($select);
    }

    public function getUsersById($users = [], $onlyEnabled = true)
    {
        $select = $this->getSelectUsers();
        $select->where(['user_id' => $users]);

        ($onlyEnabled) ? $select->where(['users.status' => 1 ]) : null;

        return $this->tableGateway->selectWith($select);
    }

    public function getEmployees($onlyEnabled = true)
    {
        $select = $this->getSelectUsers();

        ($onlyEnabled) ? $select->where(['users.status' => 1]) : null;

        return $this->tableGateway->selectWith($select);
    }

    public function getServiceProviders($onlyEnabled = true)
    {
        $select = $this->getSelectUsers();

        ($onlyEnabled) ? $select->where(['users.status' => 1]) : null;

        return $this->tableGateway->selectWith($select);
    }

    public function getUserById($user_id)
    {
        $user_id = (int) $user_id;

        $select = $this->getSelectUsers();
        $select->where(['user_id' => $user_id]);

        $rowset = $this->tableGateway->selectWith($select);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find user with user_id'));
        }

        return $row;
    }

    public function getEmployeeById($user_id)
    {
        $user_id = (int) $user_id;

        $select = $this->getSelectUsers();
        $select->where(['user_id' => $user_id]);

        $rowset = $this->tableGateway->selectWith($select);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find user with user_id'));
        }

        return $row;
    }

    public function getServiceProviderById($user_id)
    {
        $user_id = (int) $user_id;

        $select = $this->getSelectUsers();
        $select->where(['user_id' => $user_id]);

        $rowset = $this->tableGateway->selectWith($select);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find user with user_id'));
        }

        return $row;
    }

    public function getUsersByOrganizationId($organization_id)
    {
        $organization_id = (int) $organization_id;

        $select = $this->getSelectUsers();
        $select->where(['organizations_organization_id' => $organization_id]);

        return $this->tableGateway->selectWith($select);
    }
}
