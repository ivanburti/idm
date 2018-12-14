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

class UserController extends AbstractActionController
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

	public function searchAction()
	{
		$form = $this->userForm->getUserSearchForm();

		$viewData = ['form' => $form, 'users' => []];

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return $viewData;
		}

		$form->setInputFilter($this->userFilter->getUserSearchFilter());
		$form->setData($request->getPost());

		if (! $form->isValid()) {
			return $viewData;
		}

		$user = new User;
		$user->exchangeArray($form->getData());

		$viewData['users'] = $this->userService->searchUsers($user);
		return $viewData;
	}

	public function editAction()
	{
		$user_id = (int) $this->params()->fromRoute('id', 0);

		if ($this->userService->isServiceProvider($user_id)) {
			return $this->redirect()->toRoute('user/service-provider', ['action' => 'edit', 'id' => $user_id]);
		}

		return $this->redirect()->toRoute('user/employee', ['action' => 'edit', 'id' => $user_id]);
	}

	public function detailsAction()
	{
		$user_id = (int) $this->params()->fromRoute('id', 0);
		$user = $this->userService->getUserById($user_id);

		return [
			'user' => $user,
			'organization' => $this->organizationService->getOrganizationById($user->getOrganizationId()),
			'accesses' => $this->accessService->getAccessesByUserId($user_id)
		];
	}

	public function disableAction()
	{
		$user_id = (int) $this->params()->fromRoute('id', 0);

		$request = $this->getRequest();
		if ($request->isPost()) {
			$this->userService->disableUser($user_id);

			return $this->redirect()->toRoute('user', ['action' => 'details', 'id' => $user_id]);
		}

		return [
            'user' => $this->userService->getUserById($user_id),
        ];
	}
}
