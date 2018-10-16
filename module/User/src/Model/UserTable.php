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
        $select->join('organizations', 'organizations.organization_id = users.organizations_organization_id', ['organization_name' => 'name', 'organization_status' => 'status', 'organization_type' => 'type']);

        return $select;
    }

    public function getEmployeeByWorkIdOrganizationId($work_id, $organization_id)
    {
        $work_id = (int) $work_id;
        $organization_id = (int) $organization_id;

        $select = $this->getSelectUsers();
        $select->where([
            'work_id' => $work_id,
            'organizations_organization_id' => $organization_id,
            'type' => 1
        ]);

        $rowset = $this->tableGateway->selectWith($select);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Cannot update user with user_id %d; does not exist', $work_id));
        }

        return $row;
    }

    public function getUsers($onlyEnabled = true)
    {
        $select = $this->getSelectUsers();

        ($onlyEnabled) ? $select->where(['users.status' => 1 ]) : null;

        return $this->tableGateway->selectWith($select);
    }

    public function getEmployees($onlyEnabled = true)
    {
        $select = $this->getSelectUsers();
        $select->where(['organizations.type' => 1]);

        ($onlyEnabled) ? $select->where(['users.status' => 1 ]) : null;

        return $this->tableGateway->selectWith($select);
    }

    public function getServiceProviders($onlyEnabled = true)
    {
        $select = $this->getSelectUsers();
        $select->where(['organizations.type' => 2]);

        ($onlyEnabled) ? $select->where(['users.status' => 1 ]) : null;

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
        $select->where([
            'user_id' => $user_id,
            'organizations.type' => 1
        ]);

        $rowset = $this->tableGateway->selectWith($select);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find employee with user_id'));
        }

        return $row;
    }

    public function getServiceProviderById($user_id)
    {
        $user_id = (int) $user_id;

        $select = $this->getSelectUsers();
        $select->where([
            'user_id' => $user_id,
            'organizations.type' => 2
        ]);

        $rowset = $this->tableGateway->selectWith($select);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find service provider with user_id'));
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

    public function searchUsers($data)
    {
        $select = $this->getSelectUsers();

        ($data['full_name']) ? $select->where->like('full_name', '%'.$data['full_name'].'%') : null;

        return $this->tableGateway->selectWith($select);
    }

    public function saveUser(User $user)
    {
        $data = [
            'full_name' => $user->full_name,
            'birthday_date'  => $user->birthday_date,
            'personal_id' => $user->personal_id,
            'work_id'  => $user->work_id,
            'hiring_date' => $user->hiring_date,
            'resignation_date'  => $user->resignation_date,
            'position' => $user->position,
            'supervisor_name'  => $user->supervisor_name,
            'status' => $user->status,
            'organizations_organization_id'  => $user->organizations_organization_id,
        ];

        $user_id = (int) $user->getUserId();
        if ($user_id === 0) {
            $data['created_on'] = new Expression("NOW()");
            $this->tableGateway->insert($data);
            return $this->tableGateway->getLastInsertValue();
        }

        if (! $this->getUserById($user_id)) {
            throw new RuntimeException(sprintf('Cannot update user with user_id %d; does not exist', $user_id));
        }

        $data['updated_on'] = new Expression("NOW()");

        $this->tableGateway->update($data, ['user_id' => $user_id]);
    }
}
