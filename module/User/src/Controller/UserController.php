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
		$form = $this->userForm->getUserSearchForm();
		$user = new User;

		$request = $this->getRequest();
		if ($request->getQuery('submit')) {
			$form->setInputFilter($this->userFilter->getUserSearchFilter());
			$form->setData($request->getQuery());

			if (! $form->isValid()) {
				throw new \RuntimeException("Error Processing Request", 1);
			}

			$user->exchangeArray($form->getData());
		}

		$paginator = $this->userService->searchUsers($user);

	    $page = (int) $this->params()->fromRoute('id', 1);
	    $page = ($page < 1) ? 1 : $page;
	    $paginator->setCurrentPageNumber($page);

	    $paginator->setItemCountPerPage(10);

	    return ['form' => $form, 'users' => $paginator];
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

		if ($organization->isExternal()) {
			return $this->redirect()->toRoute('user/service-provider', ['action' => 'edit', 'id' => $user_id]);
		}

		return $this->redirect()->toRoute('user/employee', ['action' => 'edit', 'id' => $user_id]);
	}

}
