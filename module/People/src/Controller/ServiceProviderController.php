<?php

namespace People\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use People\Form\UserForm;
use People\Filter\UserFilter;
use People\Service\UserService;
use Organization\Service\OrganizationService;
use Access\Service\AccessService;
use Organization\Model\Organization;
use People\Model\User;

class ServiceProviderController extends AbstractActionController
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
			'users' => $this->userService->getServiceProviders(),
		];
	}

	public function addAction()
	{
		$form = $this->userForm->getServiceProviderForm();

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return ['form' => $form];
		}

		$form->setInputFilter($this->userFilter->getServiceProviderFilter());
		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return ['form' => $form];
		}

		$this->userService->addServiceProvider($form->getData());

		return $this->redirect()->toRoute('user', ['action' => 'details', 'id' => $user_id]);
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

		$this->userService->editServiceProvider($user_id, $user);

		return $this->redirect()->toRoute('user', ['action' => 'details', 'id' => $user_id]);
	}
}
