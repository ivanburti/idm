<?php

namespace User\Service;

use RuntimeException;
use User\Model\UserTable;
use User\Model\UserSourceTable;
use User\Model\User;

class UserService
{
    private $userTable;
    private $userSourceTable;

    public function __construct(UserTable $userTable,  UserSourceTable $userSourceTable)
    {
        $this->userTable = $userTable;
        $this->userSourceTable = $userSourceTable;
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

    public function updateEmployee(User $user, $data)
    {
        $this->getEmployeeById($user->getUserId());

        $user->setFullName($data['full_name']);
        $user->setSupervisorName($data['supervisor_name']);
        $user->setPosition($data['position']);
        $user->setResignationDate($data['resignation_date']);

        $this->userTable->saveUser($user);
    }

    public function disableEmployee(int $user_id)
    {
        $user = $this->getEmployeeById($user_id);
        $user->setIsNotEnabled();

        $this->userTable->saveUser($user);
    }
}
