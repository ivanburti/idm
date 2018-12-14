<?php

namespace People\Controller;

use RuntimeException;
use Zend\Mvc\Controller\AbstractActionController;
use People\Filter\UserFilter;
use People\Service\UserService;
use Organization\Service\OrganizationService;
use Access\Service\AccessService;
use Organization\Model\Organization;
use People\Model\User;

class UserConsoleController extends AbstractActionController
{
	private $userFilter;
	private $userService;
	private $organizationService;
	private $accessService;

	public function __construct(UserFilter $userFilter, UserService $userService, OrganizationService $organizationService, AccessService $accessService)
	{
		$this->userFilter = $userFilter;
		$this->userService = $userService;
		$this->organizationService = $organizationService;
		$this->accessService = $accessService;
	}

	public function updateEmployeesAction()
	{
		ini_set('max_execution_time', 300);

		$organizations = $this->organizationService->getInternalListByEmployerNumber();
		$filter = $this->userFilter->getEmployeeFilter();

		foreach ($this->userService->getUserSources() as $source) {
			if (! $source->isEnabled()) {
				continue;
			}

			$data = $source->getData();

			foreach ($data as $row) {
				$user = new User();
				$user->exchangeArray($row);
				$user->setOrganizationId(array_search($row['employer_number'], $organizations));

				$filter->setData($user->getArrayCopy());
				if (! $filter->isValid()) {
					//Generate alert
					continue;
				}

				try {
					$user = $this->userService->getEmployeeByWorkIdOrganizationId($user->getWorkId(), $user->getOrganizationId());
				} catch (RuntimeException $e) {
					$user = $this->userService->addEmployee($user);
				}

				$this->userService->updateEmployee($user, $row);
			}
		}
	}

	public function disableAction()
	{
		$users = $this->userService->getUsers();

		foreach($users as $user) {
			if ($user->getResignationDate() && $user->isEnabled()) {
				if (date_create($user->getResignationDate()) < date_create()) {
					$this->userService->disableUser($user->getUserId());
				}
			}
		}
	}
}
