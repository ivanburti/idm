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
		return $this->redirect()->toRoute('user');
	}

	public function addAction()
	{
		$form = $this->userForm->getServiceProviderForm();

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
		$user = $this->userService->getServiceProviderById($user_id);

		$form = $this->userForm->getServiceProviderForm();
		$form->bind($user);

		$viewData = ['user' => $user, 'form' => $form];

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return $viewData;
		}

		$form->setInputFilter($this->userFilter->getServiceProviderFilter());
		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return $viewData;
		}

		var_dump($user);
		exit();

		$this->accessService->editAccess($access);

		return $this->redirect()->toRoute('access', ['action' => 'orphans']);
	}
}
