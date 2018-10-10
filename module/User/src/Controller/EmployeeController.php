<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Form\UserForm;
use User\Filter\UserFilter;
use User\Service\UserService;
use Access\Service\AccessService;

class EmployeeController extends AbstractActionController
{
	private $userForm;
	private $userFilter;
	private $userService;
	private $accessService;

	public function __construct(UserForm $userForm, UserFilter $userFilter, UserService $userService, AccessService $accessService)
	{
		$this->userForm = $userForm;
		$this->userFilter = $userFilter;
		$this->userService = $userService;
		$this->accessService = $accessService;
	}

	public function indexAction()
	{
		return [
			'employees' => $this->userService->getEmployees()
		];
	}

	public function addAction()
	{
		$form = $this->userForm;
		$form->configureEmployeeForm();

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return ['form' => $form];
		}

		$filter = $this->userFilter;
		$form->setInputFilter($filter->getInputFilter());

		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return ['form' => $form];
		}

		$this->userService->createEmployee($form->getData());

		return $this->redirect()->toRoute('user/employee');
	}

	public function editAction()
	{
		$user_id = (int) $this->params()->fromRoute('id', 0);

		$user = $this->userService->getEmployee($user_id);

		$form = $this->userForm;
		$form->bind($user);

		return ['form' => $form];
	}
}
