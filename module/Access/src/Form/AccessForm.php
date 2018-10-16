<?php

namespace Access\Form;

use Zend\Form\Form;
use Access\Service\AccessService;
use Resource\Service\ResourceService;
use User\Service\UserService;
use Access\Model\Access;

class AccessForm extends Form
{
    private $resourceService;
    private $userService;
    private $accessService;
    private $access;

    public function __construct(AccessService $accessService, ResourceService $resourceService, UserService $userService)
    {
        parent::__construct('form-access');

        $this->resourceService = $resourceService;
        $this->userService = $userService;
        $this->accessService = $accessService;
        $this->access = new Access();

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
                //'empty_option' => 'All',
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
                //'empty_option' => 'All',
                'value_options' => $userService->getUserList(),
            ],
            'attributes' => [
                'id' => 'users_user_id'
            ],
        ]);

        $this->add([
            'type'  => 'select',
            'name' => 'status',
            'options' => [
                'label' => 'Status',
                //'empty_option' => 'All',
                'value_options' => $this->access->getStatusList(),
            ],
            'attributes' => [
                'id' => 'status'
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
