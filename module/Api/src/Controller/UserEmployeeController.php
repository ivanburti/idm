<?php

namespace Api\Controller;

use Exception;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use User\Filter\UserFilter;
use User\Service\UserService;
use Organization\Service\OrganizationService;
use User\Model\User;

class UserEmployeeController extends AbstractRestfulController
{
	private $userFilter;
	private $userService;
	private $organizationService;

	public function __construct(UserFilter $userFilter, UserService $userService, OrganizationService $organizationService)
	{
		$this->userFilter = $userFilter;
		$this->userService = $userService;
		$this->organizationService = $organizationService;
	}

	public function getList()
	{
		return new JsonModel($this->userService->getEmployees());
	}

	public function get($user_id)
	{
		$user_id = (int) $user_id;
		$user = $this->userService->getEmployee($user_id);

		return new JsonModel($user->getArrayCopy());
	}

	public function create($data)
	{
		$organization = $this->organizationService->getInternalByEmployerNumber($data['employer_number']);

		$data['organizations_organization_id'] = $organization->getOrganizationId();

		$filter = $this->userFilter->getEmployeeFilter();

		$filter->setData($data);
		if (! $filter->isValid()) {
			$this->getResponse()->setStatusCode(500);
			return new JsonModel($filter->getMessages());
		}

		try {
			$user = $this->userService->getEmployeeByWorkIdOrganizationId($data['work_id'], $data['organizations_organization_id']);
			$user_id = $user->getUserId();
		} catch (Exception $e) {
			$user_id = $this->userService->addEmployee($filter->getValues());
		}

		return $this->update($user_id, $data);

	}

	public function update($user_id, $data)
	{
		$user_id = (int) $user_id;

		$filter = $this->userFilter->getEmployeeFilter();
		$filter->setData($data);
		if (! $filter->isValid()) {
			$this->getResponse()->setStatusCode(500);
			return new JsonModel($filter->getMessages());
		}

		$user = $this->userService->updateEmployee($user_id, $filter->getValues());

		if ($user->getResignationDate() && $user->isEnabled()) {
            if (date_create($user->getResignationDate()) < date_create()) {
                return $this->delete($user->getUserId());
            }
        }

		return new JsonModel(['User updated']);
	}

	public function delete($user_id)
	{
		$user_id = (int) $user_id;

		$this->userService->disableEmployee($user_id);

		return new JsonModel(['User disabled']);
	}
}
