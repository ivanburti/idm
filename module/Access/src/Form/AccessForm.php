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
            'type'  => 'text',
            'name' => 'username',
            'options' => [
                'label' => 'Username',
            ],
            'attributes' => [
                'id' => 'username'
            ],
        ]);

        $this->add([
            'type'  => 'select',
            'name' => 'resources_resource_id',
            'options' => [
                'label' => 'Resource',
                'empty_option' => 'Select...',
                'value_options' => $resourceService->getResourceList(),
            ],
            'attributes' => [
                'id' => 'resources_resource_id'
            ],
        ]);

        $this->add([
            'type'  => 'select',
            'name' => 'users_user_id',
            'options' => [
                'label' => 'User',
                'empty_option' => 'Select...',
                'value_options' => $userService->getEmployeeList(),
            ],
            'attributes' => [
                'id' => 'users_user_id'
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Save',
                'id' => 'submit',
            ],
        ]);
    }
}
