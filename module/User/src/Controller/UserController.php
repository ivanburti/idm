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
		$form = $this->userForm;

		$viewData = [
			'form' => $form,
			'users' => [],
		];

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return $viewData;
		}

		$form->setInputFilter($this->userFilter->getUserSearchFilter());
		$form->setData($request->getPost());

		$viewData['form'] = $form;

		if (! $form->isValid()) {
			return $viewData;
		}

		$viewData['users'] = $this->userService->searchUsers($request->getPost());

		$users = $this->userService->searchUsers($user);
		return $viewData;
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

	public function editAction()
	{
		$user_id = (int) $this->params()->fromRoute('id', 0);

		$user = $this->userService->getUserById($user_id);

		$organization = $this->organizationService->getOrganizationById($user->getOrganizationId());

		if ($organization->isInternal()) {
			$route = 'user/employee';
		}

		if ($organization->isExternal()) {
			$route = 'user/service-provider';
		}

		return $this->redirect()->toRoute($route, ['action' => 'edit', 'id' => $user_id]);
	}

}
