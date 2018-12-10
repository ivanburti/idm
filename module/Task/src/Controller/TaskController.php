<?php

namespace Task\Controller;

use Zend\Mvc\Controller\AbstractActionController;
#use Organization\Form\OrganizationForm;
#use Organization\Filter\OrganizationFilter;
#use Organization\Service\OrganizationService;
#use User\Service\UserService;

class TaskController extends AbstractActionController
{
	#private $organizationForm;
	#private $organizationFilter;
	#private $organizationService;
	#private $userService;

	public function __construct()
	#public function __construct(OrganizationForm $organizationForm, OrganizationFilter $organizationFilter, OrganizationService $organizationService, UserService $userService)
	{
		#$this->organizationForm = $organizationForm;
		#$this->organizationFilter = $organizationFilter;
		#$this->organizationService = $organizationService;
		#$this->userService = $userService;
	}

	public function searchAction()
	{
	}
}
