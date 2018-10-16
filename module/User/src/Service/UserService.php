<?php

namespace User\Service;

use Exception;
use User\Filter\UserFilter;
use User\Model\UserTable;
use Organization\Model\OrganizationTable;
use User\Model\User;

class UserService
{
    private $userFilter;
    private $userTable;
    private $organizationTable;

    public function __construct(UserFilter $userFilter, UserTable $userTable, OrganizationTable $organizationTable)
    {
        $this->userFilter = $userFilter;
        $this->userTable = $userTable;
        $this->organizationTable = $organizationTable;
    }

    public function getUsers($onlyEnabled = true)
    {
        return $this->userTable->getUsers($onlyEnabled);
    }

    public function getUserList()
    {
        $users = array_column($this->getUsers(false)->toArray(), 'full_name', 'user_id');
        asort($users);
        return $users;
    }

    public function getEmployees($onlyEnabled = true)
    {
        return $this->userTable->getEmployees();
    }

    public function getEmployeeList()
    {
        $users = array_column($this->getEmployees()->toArray(), 'full_name', 'user_id');
        asort($users);
        return $users;
    }

    public function getServiceProviders($onlyEnabled = true)
    {
        return $this->userTable->getServiceProviders();
    }

    public function getServiceProviderList()
    {
        $users = array_column($this->getServiceProviders()->toArray(), 'full_name', 'user_id');
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

    public function getEmployeeByWorkIdOrganizationId($work_id, $organization_id)
    {
        $work_id = (int) $work_id;
        $organization_id = (int) $organization_id;
        return $this->userTable->getEmployeeByWorkIdOrganizationId($work_id, $organization_id);
    }

    public function addEmployee($data)
    {
        $filter = $this->userFilter->getEmployeeFilter();
        $filter->setData($data);
        if (! $filter->isValid()) {
            throw new \Exception("Validation error", 1);
        }

        $user = new User();
        $user->exchangeArray($filter->getValues());
        $user->status = 1;

        return $this->userTable->saveUser($user);
    }

    public function updateEmployee($user_id, $data)
    {
        $user_id = (int) $user_id;
        $user = $this->getEmployeeById($user_id);

        $filter = $this->userFilter->getEmployeeFilter();
        $filter->setData($data);
        if (! $filter->isValid()) {
            throw new \Exception("Validation error", 1);
        }
        $data = $filter->getValues();

        $user->setFullName($data['full_name']);
        $user->setResignationDate($data['resignation_date']);
        $user->setPosition($data['position']);
        $user->setSupervisorName($data['supervisor_name']);

        $this->userTable->saveUser($user);
        return $user;
    }

    public function disableEmployee($user_id)
    {
        $user_id = (int) $user_id;

        $user = $this->getEmployeeById($user_id);

        $user->status = 2;
        $this->userTable->saveUser($user);
        return $user;
    }











    /*

    public function getUsersById($users = []){
        return $this->userTable->getUsersById($users);
    }

    public function searchUsers($data)
    {
        return $this->userTable->searchUsers($data);
    }

    public function getUsersByOrganizationId($organization_id)
    {
        $organization_id = (int) $organization_id;

        return $this->userTable->getUsersFromOrganization($organization_id);
    }




    public function getEmployeeById($user_id)
    {
        return $this->getEmployeeById($user_id);
    }

    public function getServiceProviderById($user_id)
    {
        $user = $this->getUserById($user_id);

        return $user;
    }




    public function searchUser(User $user)
    {
        return $this->userTable->searchUser($user);
    }



    public function checkEmployeeByOrganizationIdAndWorkId($organization_id, $work_id) {
        $where = [
            'organizations_organization_id' => $organization_id,
            'work_id' => $work_id
        ];

        return $this->userTable->checkUser($where);
    }

    */
}
