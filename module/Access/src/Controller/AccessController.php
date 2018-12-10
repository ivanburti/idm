<?php

namespace Access\Controller;

use RuntimeException;
use Zend\Mvc\Controller\AbstractActionController;
use Access\Form\AccessForm;
use Access\Filter\AccessFilter;
use Access\Service\AccessService;
use Resource\Service\ResourceService;
use User\Service\UserService;
use Access\Model\Access;

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

	public function searchAction()
	{
		$form = $this->accessForm->getAccessSearchForm();

		$viewData = ['form' => $form, 'accesses' => []];

		$request = $this->getRequest();
        if (! $request->isPost()) {
            return $viewData;
        }

		$form->setInputFilter($this->accessFilter->getAccessSearchFilter());
		$form->setData($request->getPost());

		if (! $form->isValid()) {
			return $viewData;
		}

		$access = new Access();
		$access->exchangeArray($form->getData());

		$viewData['accesses'] = $this->accessService->searchAccesses($access);
		return $viewData;

		$access = new Access();
	}

	public function setGenericAction()
	{
		$access_id = (int) $this->params()->fromRoute('id', 0);
		$access = $this->accessService->getAccessById($access_id);

		$access->setIsGeneric();
		$this->accessService->editAccess($access);

		return $this->redirect()->toRoute('access', ['action' => 'details', 'id' => $access_id]);
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

	public function orphansAction()
	{
		return [
			'accesses' => $this->accessService->getOrphans(),
		];
	}

	public function linkAction()
	{
		$access_id = (int) $this->params()->fromRoute('id', 0);
		$access = $this->accessService->getAccessById($access_id);

		$form = $this->accessForm->getAccessForm();
		$form->bind($access);
		$viewData = ['access' => $access, 'form' => $form];

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return $viewData;
		}

		$form->setInputFilter($this->accessFilter->getAccessFilter());
		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return $viewData;
		}

		$this->accessService->editAccess($access);

		return $this->redirect()->toRoute('access', ['action' => 'orphans']);
	}
}
