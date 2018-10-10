<?php

namespace User\Service;

use Exception;
use User\Model\UserTable;
use Organization\Model\OrganizationTable;

class UserService
{
    private $userTable;
    private $organizationTable;

    public function __construct(UserTable $userTable, OrganizationTable $organizationTable)
    {
        $this->userTable = $userTable;
        $this->organizationTable = $organizationTable;
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
        $user_id = (int) $user_id;
        return $this->userTable->getUserById($user_id);
    }

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























    /*



    public function getEmployeeById($user_id)
    {
        return $this->getEmployeeById($user_id);
    }

    public function getServiceProviderById($user_id)
    {
        $user = $this->getUserById($user_id);

        return $user;
    }



    public function getUsers()
    {
        return $this->userTable->getUsers();
    }

    public function getUserList()
    {
        $users = array_column($this->getUsers()->toArray(), 'full_name', 'user_id');
        asort($users);
        return $users;
    }



    public function searchUser(User $user)
    {
        return $this->userTable->searchUser($user);
    }

    public function addEmployee(Array $data)
    {
        $user = $this->checkEmployeeByOrganizationIdAndWorkId($data['organizations_organization_id'], $data['work_id']);
        if (! $user) {
            $user = new User();
            $user->exchangeArray($data);
            $user_id = $this->addUser($user);
            $user->setUserId($user_id);
        }

        $this->updateEmployee($user->getUserId(), $data);
    }

    public function checkEmployeeByOrganizationIdAndWorkId($organization_id, $work_id) {
        $where = [
            'organizations_organization_id' => $organization_id,
            'work_id' => $work_id
        ];

        return $this->userTable->checkUser($where);
    }

    public function updateEmployee($user_id, Array $data)
    {
        $user = $this->getEmployee($user_id);

        $user->setFullName($data['full_name']);
        $user->setResignationDate($data['resignation_date']);
        $user->setPosition($data['position']);
        $user->setSupervisor($data['supervisor_name']);
        $this->updateUser($user);

        if ($user->getResignationDate() && $user->isEnabled()) {
            if (date_create($user->getResignationDate()) < date_create()) {
                $this->disableEmployee($user_id);
            }
        }
    }

    public function addServiceProvider(Array $data)
    {
        $user = $this->checkEmployeeByOrganizationIdAndWorkId($data['organization_id'], $data ['work_id']);
        if ($user) {
            $this->updateEmployee($user, $data);
            return;
        }

        $user = new User();
        $user->exchangeArray($data);
    }

    public function addUser(User $user)
    {
        $this->userTable->saveUser($user);
    }

    public function updateUser(User $user)
    {
        $this->userTable->saveUser($user);
    }
    */
}
