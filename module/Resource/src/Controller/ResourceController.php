<?php

namespace Resource\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Resource\Form\ResourceForm;
use Resource\Filter\ResourceFilter;
use Resource\Service\ResourceService;
use User\Service\UserService;
use Access\Service\AccessService;
use Resource\Model\Resource;

class ResourceController extends AbstractActionController
{
	private $resourceForm;
	private $resourceFilter;
	private $resourceService;
	private $userService;
	private $accessService;

	public function __construct(ResourceForm $resourceForm, ResourceFilter $resourceFilter, ResourceService $resourceService, UserService $userService, AccessService $accessService)
	{
		$this->resourceForm = $resourceForm;
		$this->resourceFilter = $resourceFilter;
		$this->resourceService = $resourceService;
		$this->userService = $userService;
		$this->accessService = $accessService;
	}

	public function indexAction()
	{
		return [
			'resources' => $this->resourceService->getResources(),
		];
	}

	public function addAction()
	{
		$form = $this->resourceForm;

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return ['form' => $form];
		}

		$filter = $this->resourceFilter;
		$form->setInputFilter($filter->getResourceAddInputFilter());

		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return ['form' => $form];
		}

		$resource = new Resource();
		$resource->exchangeArray($form->getData());

		$resource_id = $this->resourceService->addResource($resource);

		return $this->redirect()->toRoute('resource', ['action' => 'details', 'id' => $resource_id]);
	}

	public function detailsAction()
	{
		$resource_id = (int) $this->params()->fromRoute('id', 0);

		$resource = $this->resourceService->getResourceById($resource_id);

		return [
			'resource' => $resource,
			'owners' => $this->userService->getUsersById($resource->owners),
			'approvers' => $this->userService->getUsersById($resource->approvers),
			'accesses' => $this->accessService->getAccessesByResourceId($resource_id)
		];
	}

	public function editAction()
    {
        $resource_id = (int) $this->params()->fromRoute('id', 0);

		$resource = $this->resourceService->getResourceById($resource_id);

        $form = $this->resourceForm;
        $form->bind($resource);

        $request = $this->getRequest();
        $viewData = ['resource' => $resource, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

		$filter = $this->resourceFilter;
		$form->setInputFilter($filter->getResourceUpdateInputFilter());

		$form->setData($request->getPost());
        if (! $form->isValid()) {
            return $viewData;
        }

    	$this->resourceService->updateResource($resource);

        return $this->redirect()->toRoute('resource', ['action' => 'details', 'id' => $resource_id]);
    }

	public function enableAction()
	{
		$resource_id = (int) $this->params()->fromRoute('id', 0);

		$this->resourceService->enableResource($resource_id);

		return $this->redirect()->toRoute('resource', ['action' => 'details', 'id' => $resource_id]);
	}
}
