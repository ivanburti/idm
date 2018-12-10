<?php

namespace Auth\Controller;

use Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Auth\Service\UserManager;
use Auth\Model\User;
use Auth\Model\UserTable;
use Auth\Form\UserForm;
use Auth\Form\PasswordChangeForm;
use Auth\Form\PasswordResetForm;

class UserController extends AbstractActionController
{
    private $userTable;
    private $userManager;
    private $authenticationService;

    public function __construct(UserTable $userTable, UserManager $userManager)
    {
        $this->userTable = $userTable;
        $this->userManager = $userManager;
    }

    public function indexAction()
    {
        return new ViewModel([
            'users' => $this->userTable->fetchAll()
        ]);
    }

    public function addAction()
    {
        $form = new UserForm();

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $user = new User();
        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $this->userManager->addUser($form->getData());
        return $this->redirect()->toRoute('users');
    }


    public function viewAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (0 === $id) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        try {
            $user = $this->userTable->getUser($id);
        } catch (\Exception $e) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'user' => $user
        ]);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (0 === $id) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        try {
            $user = $this->userTable->getUser($id);
        } catch (Exception $e) {
            return $this->redirect()->toRoute('user');
        }

        $form = new UserForm();
        $form->bind($user);

        $request = $this->getRequest();
        $viewData = ['user' => $user, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->userManager->updateUser($user, $data);

        return $this->redirect()->toRoute('user');
    }

    public function changePasswordAction()
    {
        $form = new PasswordChangeForm();

        $request = $this->getRequest();
        $viewData = ['form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $user = new User();
        $form->setInputFilter($user->getInputFilterChangePasswd());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->userManager->changePassword($form->getData());

        return $this->redirect()->toRoute('logout');
    }

    public function resetPasswordAction()
    {
        // Create form
        $form = new PasswordResetForm();

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if($form->isValid()) {

                // Look for the user with such email.
                $user = $this->entityManager->getRepository(User::class)
                        ->findOneByEmail($data['email']);
                if ($user!=null) {
                    // Generate a new password for user and send an E-mail
                    // notification about that.
                    $this->userManager->generatePasswordResetToken($user);

                    // Redirect to "message" page
                    return $this->redirect()->toRoute('users',
                            ['action'=>'message', 'id'=>'sent']);
                } else {
                    return $this->redirect()->toRoute('users',
                            ['action'=>'message', 'id'=>'invalid-email']);
                }
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * This action displays an informational message page.
     * For example "Your password has been resetted" and so on.
     */
    public function messageAction()
    {
        // Get message ID from route.
        $id = (string)$this->params()->fromRoute('id');

        // Validate input argument.
        if($id!='invalid-email' && $id!='sent' && $id!='set' && $id!='failed') {
            throw new \Exception('Invalid message ID specified');
        }

        return new ViewModel([
            'id' => $id
        ]);
    }

    /**
     * This action displays the "Reset Password" page.
     */
    public function setPasswordAction()
    {
        $token = $this->params()->fromQuery('token', null);

        // Validate token length
        if ($token!=null && (!is_string($token) || strlen($token)!=32)) {
            throw new \Exception('Invalid token type or length');
        }

        if($token===null ||
           !$this->userManager->validatePasswordResetToken($token)) {
            return $this->redirect()->toRoute('users',
                    ['action'=>'message', 'id'=>'failed']);
        }

        // Create form
        $form = new PasswordChangeForm('reset');

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if($form->isValid()) {

                $data = $form->getData();

                // Set new password for the user.
                if ($this->userManager->setNewPasswordByToken($token, $data['new_password'])) {

                    // Redirect to "message" page
                    return $this->redirect()->toRoute('users',
                            ['action'=>'message', 'id'=>'set']);
                } else {
                    // Redirect to "message" page
                    return $this->redirect()->toRoute('users',
                            ['action'=>'message', 'id'=>'failed']);
                }
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }
}
