<?php

namespace People\Service;

use RuntimeException;
use People\Model\UserTable;
use Organization\Model\OrganizationTable;
use People\Model\User;

class UserService
{
    private $userTable;
    private $organizationTable;

    public function __construct(UserTable $userTable, OrganizationTable $organizationTable)
    {
        $this->userTable = $userTable;
        $this->organizationTable = $organizationTable;
    }

    public function getUserById($user_id)
    {
        $user_id = (int) $user_id;
        $user = $this->userTable->getUserById($user_id);

        $organization = $this->organizationTable->getOrganizationById($user->getOrganizationId());

        $user->setOrganization($organization);
        return $user;
    }

    public function getEmployeeById($user_id)
    {
        $user = $this->getUserById($user_id);

        $this->organizationTable->getInternalById();

        return $user;
    }

    public function getServiceProviderById($user_id){
        return $this->userTable->getServiceProviderById($user_id);
    }

    public function getEmployees()
    {
        $organizations = array_column($this->organizationTable->getInternals()->toArray(), 'organization_id');
        return $this->userTable->getUsersByOrganizationId(array_keys($organizations));
    }

    public function getEmployeeList()
    {
        $users = array_column($this->getEmployees()->toArray(), 'full_name', 'user_id');
        asort($users);
        return $users;
    }

    public function getServiceProviders()
    {
        $organizations = array_column($this->organizationTable->getExternals()->toArray(), 'organization_id');
        return $this->userTable->getUsersByOrganizationId(array_keys($organizations));
    }

    public function getServiceProviderList()
    {
        $users = array_column($this->getServiceProviders()->toArray(), 'full_name', 'user_id');
        asort($users);
        return $users;
    }

    public function addServiceProvider($data)
    {
        $user = new User();
        $user->exchangeArray($data);

        $this->organizationTable->getExternalById($user->getOrganizationId());

        $user_id = $this->userTable->saveUser($user);
        $this->userTable->enableUser($user_id);
        return $user_id;
    }

    public function editServiceProvider($user_id, User $user)
    {
        $user_id = (int) $user_id;
        $current_user = $this->getServiceProviderById($user_id);

        if (! array_diff($current_user->getArrayCopy(), $user->getArrayCopy())) {
            return true;
        }

        $diff = array_diff($user->getArrayCopy(), $current_user->getArrayCopy());

        return $this->userTable->saveUser($user);
    }

    public function addEmployee($data)
    {
        $user = new User();
        $user->exchangeArray($data);

        $this->organizationTable->getInternalById($user->getOrganizationId());

        $user_id = $this->userTable->saveUser($user);
        return $user_id;
    }

    public function searchUsers(User $user)
    {
        return $this->userTable->searchUsers($user, true);
    }

    /*
    public function getUsers($onlyEnabled = true)
    {
        return $this->userTable->getUsers($onlyEnabled);
    }

    public function getUserList($onlyEnabled = true)
    {
        $users = array_column($this->getUsers($onlyEnabled)->toArray(), 'full_name', 'user_id');
        asort($users);
        return $users;
    }

    public function getUsersById($users = [], $onlyEnabled = true)
    {
        return $this->userTable->getUsersById($users, $onlyEnabled);
    }

    public function getUserById($user_id){
        return $this->userTable->getUserById($user_id);
    }

    public function getUsersByOrganizationId($organization_id)
    {
        return $this->userTable->getUsersByOrganizationId($organization_id);
    }
    */





    public function getEmployeeByWorkIdOrganizationId($work_id, $organization_id)
    {
        return $this->userTable->getEmployeeByWorkIdOrganizationId($work_id, $organization_id);
    }


    public function getUserSources()
    {
        return $this->userSourceTable->getSources();
    }

    public function updateEmployee(User $user)
    {
        $old = $this->getEmployeeById($user->getUserId());

        $old_data = array_diff($old->getArrayCopy(), $user->getArrayCopy());
        if (! $old_data) {
            return true;
        }

        $new_data = array_diff($user->getArrayCopy(), $old->getArrayCopy());

        return $this->userTable->saveUser($user);
    }

    public function disableUser($user_id)
    {
        $user_id = (int) $user_id;
        $user = $this->getUserById($user_id);

        if (! $user->isEnabled()) {
            throw new RuntimeException(sprintf('Cannot disable user with id %d, user is already disabled.', $user_id));
        }
        $user->setIsNotEnabled();

        return $this->userTable->saveUser($user);
    }
}
