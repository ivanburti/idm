<?php

namespace Report\Controller;

use Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Report\Service\ReportService;
use Access\Service\AccessService;
use Report\Form\ReportForm;
use Report\Filter\ReportFilter;
use Report\Model\Report;

class ReportController extends AbstractActionController
{
	private $resourceService;
	private $accessService;

	public function __construct()
	//public function __construct(ReportService $resourceService, AccessService $accessService)
	{
		//$this->resourceService = $resourceService;
		//$this->accessService = $accessService;
	}

	public function indexAction()
	{
		return [
			//'resources' => $this->resourceService->getReports(),
		];
	}

	public function addAction()
	{
		$form = new ReportForm();

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return ['form' => $form];
		}

		$filter = new ReportFilter();
		$form->setInputFilter($filter->getInputFilter());

		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return ['form' => $form];
		}

		$this->resourceService->addReport($form->getData());

		return $this->redirect()->toRoute('resource');
	}

	public function editAction()
    {
        $resource_id = (int) $this->params()->fromRoute('id', 0);

		$resource = $this->resourceService->getReportById($resource_id);

        $form = new ReportForm();

		$form->get('status')->setOptions(['options' => $resource->getStatusList()]);
        $form->bind($resource);

        $request = $this->getRequest();
        $viewData = ['resource_id' => $resource_id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setData($request->getPost());
        if (! $form->isValid()) {
            return $viewData;
        }

        $this->resourceService->updateReport($resource);

        return $this->redirect()->toRoute('resource', ['action' => 'index']);
    }

}
