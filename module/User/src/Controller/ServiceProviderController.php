<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Form\UserForm;
use User\Filter\UserFilter;
use User\Service\UserService;
use Organization\Service\OrganizationService;
use Access\Service\AccessService;

class ServiceProviderController extends AbstractActionController
{
	private $userForm;
	private $userFilter;
	private $userService;
	private $accessService;
	private $organizationService;

	public function __construct(UserForm $userForm, userFilter $userFilter, UserService $userService, OrganizationService $organizationService, AccessService $accessService)
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
			'users' => $this->userService->getServiceProviders()
		];
	}

	public function addAction()
	{
		$form = $this->userForm;
		//$form->configureServiceProviderForm();

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return ['form' => $form];
		}

		$filter = $this->userFilter;
		$form->setInputFilter($filter->getInputFilter());

		$form->setData($request->getPost());
		if (! $form->isValid()) {
			var_dump($form->getMessages());
			return ['form' => $form];
		}

		$user_id = $this->userService->createEmployee($form->getData());

		return $this->redirect()->toRoute('user/employee', ['action' => 'detail', 'id' => $user_id]);
	}

	public function editAction()
	{
		$user_id = (int) $this->params()->fromRoute('id', 0);

		$user = $this->userService->getEmployee($user_id);

		$form = $this->userForm;
		$form->bind($user);

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return ['form' => $form];
		}
	}

	public function viewAction()
	{
		$user_id = (int) $this->params()->fromRoute('id', 0);

		return [
			'user' => $this->userService->getEmployee($user_id),
			'owners' => [],
			'accesses' => $this->accessService->getUserAccesses($user_id),
		];
	}
}
