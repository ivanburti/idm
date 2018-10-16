<?php

namespace Access\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Access\Form\AccessForm;
use Access\Filter\AccessFilter;
use Access\Service\AccessService;
use Resource\Service\ResourceService;
use User\Service\UserService;
use User\Model\User;

class AccessController extends AbstractActionController
{
	private $accessForm;
	private $accessFilter;
	private $accessService;
	private $resourceService;
	private $userService;

	public function __construct(AccessForm $accessForm, AccessFilter $accessFilter, AccessService $accessService, ResourceService $resourceService, UserService $userService)
	{
		$this->accessForm = $accessForm;
		$this->accessFilter = $accessFilter;
		$this->accessService = $accessService;
		$this->resourceService = $resourceService;
		$this->userService = $userService;
	}

	public function indexAction()
	{
		$form = $this->accessForm;

		$viewData = [
			'form' => $form,
			'accesses' => [],
		];

		$request = $this->getRequest();
		if (! $request->getQuery('submit')) {
			return $viewData;
		}

		$form->setInputFilter($this->accessFilter->getAccessSearchFilter());
		$form->setData($request->getQuery());

		$viewData['form'] = $form;
		if (! $form->isValid()) {
			return $viewData;
		}

		$viewData['accesses'] = $this->accessService->searchAccesses($form->getData());
		return $viewData;
	}

	public function orphansAction()
	{
		return [
			'accesses' => $this->accessService->getOrphans()
		];
	}

	public function linkAction()
	{
		$access_id = (int) $this->params()->fromRoute('id', 0);

		$access = $this->accessService->getAccessById($access_id);

		$form = $this->accessForm;
		$form->bind($access);

		$request = $this->getRequest();
		$viewData = ['access' => $access, 'form' => $form];

		if (! $request->isPost()) {
			return $viewData;
		}

		$filter = $this->accessFilter;
		$form->setInputFilter($filter->getAccessLinkFilter());

		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return $viewData;
		}

		$this->accessService->linkAccess($access_id, $access->users_user_id);

		return $this->redirect()->toRoute('access', ['action' => 'orphans']);
	}

	public function detailsAction()
	{
		$access_id = (int) $this->params()->fromRoute('id', 0);

		$access = $this->accessService->getAccessById($access_id);

		return [
			'access' => $access,
			'resource' => $this->resourceService->getResourceById($access->getResourceId()),
			'user' => !$access->isOrphan() ? $this->userService->getUserById($access->getUserId()) : new User(),
		];
	}

	/*
	public function editAction()
	{
		$access_id = (int) $this->params()->fromRoute('id', 0);

		$access = $this->accessService->getAccessById($access_id);

		$form = $this->accessForm;
        $form->bind($access);

		$request = $this->getRequest();
		$viewData = ['form' => $form];

		if (! $request->isPost()) {
			return $viewData;
		}

		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return $viewData;
		}

		$this->accessService->updateAccess($access);

		return $this->redirect()->toRoute('access', ['action' => 'detail', 'id' => $access_id]);
	}

	public function disableAction() {
		$access_id = (int) $this->params()->fromRoute('id', 0);

		$access = $this->accessService->getAccessById($access_id);
	}
	*/
}
