<?php

namespace User\Service;

use Exception;
use User\Model\UserTable;

class UserService
{
    private $userTable;

    public function __construct(UserTable $userTable)
    {
        $this->userTable = $userTable;
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

    public function getServiceProviderById($user_id){
        return $this->userTable->getServiceProviderById($user_id);
    }

    public function getUsersByOrganizationId($organization_id)
    {
        return $this->userTable->getUsersByOrganizationId($organization_id);
    }
}
