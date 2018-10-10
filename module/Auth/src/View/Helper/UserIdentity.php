<?php

namespace Auth\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Auth\Service\UserManager;

class UserIdentity extends AbstractHelper
{
	private $userManager;
	private $user;

	public function __construct(UserManager $userManager)
	{
		$this->userManager = $userManager;
		//$this->user = $this->userManager->identifyUser();
	}

	public function getId()
	{
		return (int) 1;
	}

	public function getEmail()
	{
		return 'ivan.castro@netshoes.com';
		//return $this->user->getEmail();
	}

	public function getFullName()
	{
		return 'Ivan Burti';
		//return $this->user->getFullName();
	}

	public function getUsername()
	{
		return 'ivan.castro';
	}
}
