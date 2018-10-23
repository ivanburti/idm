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
			'resource_list' => $this->resourceService->getResourceList(),
			'accesses' => $this->accessService->getOrphans()
		];
	}

	public function editAction()
	{
		$access_id = (int) $this->params()->fromRoute('id', 0);
		$access = $this->accessService->getAccessById($access_id);

		$form = $this->accessForm;
		$form->bind($access);
		$viewData = ['access' => $access, 'form' => $form];

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return $viewData;
		}

		$form->setInputFilter($this->accessFilter->getInputFilter());
		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return $viewData;
		}

		$this->accessService->editAccess($access);

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

	public function disableAction() {
		$access_id = (int) $this->params()->fromRoute('id', 0);

		$access = $this->accessService->getAccessById($access_id);
	}
}
