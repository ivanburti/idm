<?php

namespace Application\Controller;

use RuntimeException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Console\Request as ConsoleRequest;
use Organization\Service\OrganizationService;

class ApplicationController extends AbstractActionController
{
    private $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    public function resetpasswordAction()
    {
        $request = $this->getRequest();

        // Make sure that we are running in a console, and the user has not
        // tricked our application into running this action from a public web
        // server:
        if (! $request instanceof ConsoleRequest) {
            throw new RuntimeException('You can only use this action from a console!');
        }

        // Get user email from the console, and check if the user requested
        // verbosity:
        $userEmail   = $request->getParam('userEmail');
        $verbose     = $request->getParam('verbose') || $request->getParam('v');

        $organizations = $this->organizationService->getOrganizations();
        foreach ($organizations as $organization) {
            echo $organization->getName();
        }

        // Reset new password
        //$newPassword = Rand::getString(16);

        // Fetch the user and change his password, then email him ...
        /* ... */

        if ($verbose) {
            return "Done! New password for user $userEmail is '$newPassword'. "
                . "It has also been emailed to him.\n";
        }

        return "Done! $userEmail has received an email with his new password.\n";

    }
}
