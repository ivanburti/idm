<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Form\UserForm;
use User\Filter\UserFilter;
use User\Service\UserService;
use Organization\Service\OrganizationService;
use Access\Service\AccessService;
use Organization\Model\Organization;
use User\Model\User;

class EmployeeController extends AbstractActionController
{
	private $userForm;
	private $userFilter;
	private $userService;
	private $organizationService;
	private $accessService;

	public function __construct(UserForm $userForm, UserFilter $userFilter, UserService $userService, OrganizationService $organizationService, AccessService $accessService)
	{
		$this->userForm = $userForm;
		$this->userFilter = $userFilter;
		$this->userService = $userService;
		$this->organizationService = $organizationService;
		$this->accessService = $accessService;
	}

	public function indexAction()
	{
		return [
			'users' => $this->userService->getEmployees(),
		];
	}

	public function addAction()
	{
		$form = $this->userForm->getEmployeeForm();

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return ['form' => $form];
		}

		$form->setInputFilter($this->userFilter->getEmployeeFilter());
		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return ['form' => $form];
		}

		$user_id = $this->userService->createEmployee($form->getData());

		return $this->redirect()->toRoute('user', ['action' => 'details', 'id' => $user_id]);
	}

	public function editAction()
	{
		$user_id = (int) $this->params()->fromRoute('id', 0);
		$user = $this->userService->getUserById($user_id);

		$organization = $this->organizationService->getOrganizationById($user->getOrganizationId());

		if ($organization->isExternal()) {
			return $this->redirect()->toRoute('user', ['action' => 'edit-service-provider', 'id' => $user_id]);
		}

		$form = $this->userForm->getEmployeeForm();
		$form->bind($user);

		$viewData = ['user' => $user, 'form' => $form];
		$request = $this->getRequest();
		if (! $request->isPost()) {
			return $viewData;
		}

		$form->setInputFilter($this->userFilter->getEmployeeFilter());
		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return $viewData;
		}

		$this->userService->updateEmployee($user);

		return $this->redirect()->toRoute('user', ['action' => 'details', 'id' => $user_id]);
	}
}
