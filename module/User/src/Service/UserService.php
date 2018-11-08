<?php

namespace User\Service;

use RuntimeException;
use User\Model\UserTable;
use User\Model\User;

class UserService
{
    private $userTable;
    private $userSourceTable;

    public function __construct(UserTable $userTable)
    {
        $this->userTable = $userTable;
        $this->userSourceTable = $userSourceTable;
    }

    public function searchUsers(User $user)
    {
        return $this->userTable->searchUsers($user, true);
    }

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

    public function getEmployees($onlyEnabled = true)
    {
        return $this->userTable->getEmployees($onlyEnabled);
    }

    public function getEmployeeList($onlyEnabled = true)
    {
        $users = array_column($this->getEmployees($onlyEnabled)->toArray(), 'full_name', 'user_id');
        asort($users);
        return $users;
    }

    public function getServiceProviders($onlyEnabled = true)
    {
        return $this->userTable->getServiceProviders($onlyEnabled);
    }

    public function getServiceProviderList($onlyEnabled = true)
    {
        $users = array_column($this->getServiceProviders($onlyEnabled)->toArray(), 'full_name', 'user_id');
        asort($users);
        return $users;
    }

    public function getUserById($user_id){
        return $this->userTable->getUserById($user_id);
    }

    public function getEmployeeById($user_id){
        return $this->userTable->getEmployeeById($user_id);
    }

    public function getEmployeeByWorkIdOrganizationId($work_id, $organization_id)
    {
        return $this->userTable->getEmployeeByWorkIdOrganizationId($work_id, $organization_id);
    }

    public function getServiceProviderById($user_id){
        return $this->userTable->getServiceProviderById($user_id);
    }

    public function getUsersByOrganizationId($organization_id)
    {
        return $this->userTable->getUsersByOrganizationId($organization_id);
    }

    public function getUserSources()
    {
        return $this->userSourceTable->getSources();
    }

    public function addEmployee(User $user)
    {
        $user->setIsEnabled();
        $user_id = $this->userTable->saveUser($user);

        return $this->getEmployeeById($user_id);
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

    public function updateServiceProvider(User $user)
    {
        $old = $this->getServiceProviderById($user->getUserId());

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
