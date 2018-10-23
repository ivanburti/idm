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
            'name' => 'resource_resource_id',
            'options' => [
                'label' => 'Resource',
                'empty_option' => 'Select a resource ...',
                'value_options' => $resourceService->getResourceList(),
            ],
            'attributes' => [
                'id' => 'resource_resource_id'
            ],
        ]);

        $this->add([
            'type'  => 'select',
            'name' => 'user_user_id',
            'options' => [
                'label' => 'User',
                'empty_option' => 'Select a user ...',
                'value_options' => $userService->getUserList(),
            ],
            'attributes' => [
                'id' => 'user_user_id'
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Submit',
                'id' => 'submit',
            ],
        ]);
    }
}
