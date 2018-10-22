<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Form\UserForm;
use User\Service\UserService;
use Organization\Service\OrganizationService;
use Access\Service\AccessService;
use Organization\Model\Organization;
use User\Model\User;

class UserConsoleController extends AbstractActionController
{
	private $userForm;
	private $userService;
	private $organizationService;
	private $accessService;

	public function __construct(UserForm $userForm, UserService $userService, OrganizationService $organizationService, AccessService $accessService)
	{
		$this->userForm = $userForm;
		$this->userService = $userService;
		$this->organizationService = $organizationService;
		$this->accessService = $accessService;
	}

	public function employeesUpdateAction()
	{
		ini_set('max_execution_time', 300);
		
		$form = $this->userForm->getEmployeeForm();
		$filter = $form->getInputFilter();

		foreach ($this->userService->getUserSources() as $source) {
			$data = $source->getData();

			foreach ($data as $row) {
				$organization_id = $this->organizationService->getInternalByEmployerNumber($row['employer_number'])->getOrganizationId();

				$user = new User();
				$user->exchangeArray($row);
				$user->setOrganizationId($organization_id);

				$filter->setData($user->getArrayCopy());
				if (! $filter->isValid()) {
					var_dump($user);
					var_dump($filter->getMessages());
					continue;
				}

				try {
					$user = $this->userService->getEmployeeByWorkIdOrganizationId($user->getWorkId(), $user->getOrganizationId());
				} catch (\Exception $e) {
					$user = $this->userService->addEmployee($user);
				}

				$this->userService->updateEmployee($user, $row);

				if ($user->getResignationDate() && $user->isEnabled()) {
					if (date_create($user->getResignationDate()) < date_create()) {
						$this->userService->disableEmployee($user->getUserId());
					}
				}
			}

		}
	}
}
