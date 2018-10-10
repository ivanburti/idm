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

    public function getUsers($conditions = [])
    {
        $select = $this->tableGateway->getSql()->select();
        $select->join('organizations', 'organizations.organization_id = users.organizations_organization_id', ['organization_name' => 'name', 'organization_status' => 'status', 'organization_type' => 'type']);

        if ($conditions) {
            $select->where($conditions);
        }

        return $this->tableGateway->selectWith($select);
    }

    public function searchUsers($data)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->join('organizations', 'organizations.organization_id = users.organizations_organization_id', ['organization_name' => 'name', 'organization_status' => 'status', 'organization_type' => 'type']);

        ($data['full_name']) ? $select->where->like('full_name', '%'.$data['full_name'].'%') : null;

        return $this->tableGateway->selectWith($select);
    }

    public function getEmployees($onlyEnabled = true)
    {
        $conditions = [
            'organizations.type' => 1
        ];

        ($onlyEnabled) ? $conditions['users.status'] = 1 : null;

        return $this->getUsers($conditions);
    }

    public function getServiceProviders($onlyEnabled = true)
    {
        $conditions = [
            'organizations.type' => 2
        ];

        ($onlyEnabled) ? $conditions['users.status'] = 1 : null;

        return $this->getUsers($conditions);
    }

    public function getUserById($user_id)
    {
        $user_id = (int) $user_id;

        $rowset = $this->getUsers(['user_id' => $user_id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find user with user_id'));
        }

        return $row;
    }

    public function getUsersFromOrganization($organization_id)
    {
        $organization_id = (int) $organization_id;

        $conditions = [
            'organizations_organization_id' => $organization_id,
        ];

        return $this->getUsers($conditions);
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

    public function getUsersById($users = [])
    {
        $conditions = [
            'user_id' => $users,
        ];

        return $this->getUsers($conditions);
    }







    /*


    public function searchUser(User $user)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->join('organizations', 'organizations.organization_id = users.organizations_organization_id', ['organization_status' => 'status']);

        if ($user->getFullName()) {
            $select->where->like('full_name', '%'.$user->getFullName().'%');
        }

        return $this->tableGateway->selectWith($select);
    }

    public function searchOrganizations($data)
    {
        $select = $this->tableGateway->getSql()->select();

        ($data['alias']) ? $select->where->like('alias', '%'.$data['alias'].'%') : null;
        ($data['name']) ? $select->where->like('alias', '%'.$data['alias'].'%') : null;
        ($data['type']) ? $select->where(['type' => $data['type']]) : null;
        ($data['status']) ? $select->where(['status' => $data['status']]) : null;

        return $this->tableGateway->selectWith($select);
    }
    */
}
