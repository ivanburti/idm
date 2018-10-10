<?php

namespace Access\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Access\Form\AccessForm;
use Access\Service\AccessService;
use Resource\Service\ResourceService;
use User\Service\UserService;
use User\Model\User;

class AccessController extends AbstractActionController
{
	private $accessForm;
	private $accessService;
	private $resourceService;
	private $userService;

	public function __construct(AccessForm $accessForm, AccessService $accessService, ResourceService $resourceService, UserService $userService)
	{
		$this->accessForm = $accessForm;
		$this->accessService = $accessService;
		$this->resourceService = $resourceService;
		$this->userService = $userService;
	}

	public function indexAction()
	{
		return [
			'accesses' => $this->accessService->getAccesses()
		];
	}

	public function detailAction()
	{
		$access_id = (int) $this->params()->fromRoute('id', 0);

		$access = $this->accessService->getAccessById($access_id);

		return [
			'access' => $access,
			'resource' => $this->resourceService->getResourceById($access->getResourceId()),
			'user' => !$access->isOrphan() ? $this->userService->getUserById($access->getUserId()) : new User(),
		];
	}

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
}
