<?php

namespace Access\Form;

use Zend\Form\Form;
use Resource\Service\ResourceService;
use User\Service\UserService;

class AccessForm extends Form
{
    private $resourceService;
    private $userService;

    public function __construct(ResourceService $resourceService, UserService $userService)
    {
        parent::__construct('form-access');

        $this->resourceService = $resourceService;
        $this->userService = $userService;

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Save',
                'id' => 'submit',
            ],
        ]);

        /*
        $this->add([
            'type'  => 'text',
            'name' => 'username',
            'options' => [
                'label' => 'Username',
            ],
            'attributes' => [
                'id' => 'username'
            ],
        ]);
        */
    }

    private function setUsernameField() {
        $this->add([
            'type'  => 'text',
            'name' => 'username',
            'options' => [
                'label' => 'Username',
            ],
            'attributes' => [
                'id' => 'username',
                'placeholder' => 'Username'
            ],
        ]);
    }

    private function setResourceIdField() {
        $this->add([
            'type'  => 'select',
            'name' => 'resource_resource_id',
            'options' => [
                'label' => 'Resource',
                'empty_option' => 'Select a resource ...',
                'value_options' => $this->resourceService->getResourceList(),
            ],
            'attributes' => [
                'id' => 'resource_resource_id'
            ],
        ]);
    }

    private function setUserIdField() {
        $this->add([
            'type'  => 'select',
            'name' => 'user_user_id',
            'options' => [
                'label' => 'User',
                'empty_option' => 'Select a user ...',
                'value_options' => $this->userService->getUserList(),
            ],
            'attributes' => [
                'id' => 'user_user_id'
            ],
        ]);
    }

    private function setIsOrphanField()
    {
        $this->add([
            'type'  => 'checkbox',
            'name' => 'user_user_id',
            'options' => [
                'label' => 'Only Orphans',
            ],
            'attributes' => [
                'id' => 'user_user_id',
            ],
        ]);
    }

    public function getAccessForm()
    {
        $this->setUsernameField();
        $this->setResourceIdField();
        $this->setUserIdField();

        return $this;
    }

    public function getAccessSearchForm()
    {
        $this->setUsernameField();
        $this->setIsOrphanField();

        return $this;
    }
}
