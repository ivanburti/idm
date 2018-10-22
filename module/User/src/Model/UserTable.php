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
        $select->join('organization', 'organization.organization_id = user.organization_organization_id', ['organization_name' => 'name', 'organization_is_enabled' => 'is_enabled', 'organization_is_external' => 'is_external']);

        return $select;
    }

    public function getUsers($onlyEnabled = true)
    {
        $select = $this->getSelectUsers();

        ($onlyEnabled) ? $select->where(['user.status' => 1 ]) : null;

        return $this->tableGateway->selectWith($select);
    }

    public function getUsersById($users = [], $onlyEnabled = true)
    {
        $select = $this->getSelectUsers();
        $select->where(['user_id' => $users]);

        ($onlyEnabled) ? $select->where(['user.status' => 1 ]) : null;

        return $this->tableGateway->selectWith($select);
    }

    public function getEmployees($onlyEnabled = true)
    {
        $select = $this->getSelectUsers();

        ($onlyEnabled) ? $select->where(['user.status' => 1]) : null;

        return $this->tableGateway->selectWith($select);
    }

    public function getServiceProviders($onlyEnabled = true)
    {
        $select = $this->getSelectUsers();

        ($onlyEnabled) ? $select->where(['user.status' => 1]) : null;

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

    public function getEmployeeByWorkIdOrganizationId($work_id, $organization_id)
    {
        $select = $this->getSelectUsers();
        $select->where([
            'work_id' => $work_id,
            'organization_organization_id' => $organization_id
        ]);

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
        $select->where(['organization_organization_id' => $organization_id]);

        return $this->tableGateway->selectWith($select);
    }

    public function saveUser(User $user)
    {
        $data = [
            'email' => $user->email,
            'full_name'  => $user->full_name,
            'birthday_date' => $user->birthday_date,
            'personal_id'  => $user->personal_id,
            'work_id' => $user->work_id,
            'hiring_date' => $user->hiring_date,
            'resignation_date' => $user->resignation_date,
            'position' => $user->position,
            'supervisor_name' => $user->supervisor_name,
            'status' => $user->status,
            'is_enabled' => $user->is_enabled,
            'organization_organization_id' => $user->organization_organization_id,
        ];

        $user_id = (int) $user->user_id;

        if ($user_id === 0) {
            $data['created_on'] = new Expression("NOW()");
            $this->tableGateway->insert($data);
            return $this->tableGateway->getLastInsertValue();
        }

        if (! $this->getUserById($user_id)) {
            throw new RuntimeException(sprintf('Cannot update resource with id %d; does not exist', $user_id));
        }

        $data['updated_on'] = new Expression("NOW()");

        $this->tableGateway->update($data, ['user_id' => $user_id]);
    }
}
