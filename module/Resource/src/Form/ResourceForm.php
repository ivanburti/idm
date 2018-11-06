<?php

namespace Resource\Form;

use Zend\Form\Form;
use Resource\Service\ResourceService;
use User\Service\UserService;

class ResourceForm extends Form
{
    private $resourceService;
    private $userService;

    public function __construct(ResourceService $resourceService, UserService $userService)
    {
        parent::__construct('form-organization');

        $this->resourceService = $resourceService;
        $this->userService = $userService;

        $this->add([
            'type'  => 'text',
            'name' => 'name',
            'options' => [
                'label' => 'Name',
            ],
            'attributes' => [
                'id' => 'name',
            ],
        ]);

        $this->add([
            'type'  => 'textarea',
            'name' => 'description',
            'options' => [
                'label' => 'Description',
            ],
            'attributes' => [
                'id' => 'description',
            ],
        ]);

        $this->add([
            'type'  => 'select',
            'name' => 'owners',
            'options' => [
                'label' => 'Resource Owners',
                'value_options' => $this->userService->getEmployeeList(),
            ],
            'attributes' => [
                'multiple' => 'multiple',
                'id' => 'owners',
            ],
        ]);

        $this->add([
            'type'  => 'select',
            'name' => 'approvers',
            'options' => [
                'label' => 'Resource Approvers',
                'value_options' => $this->userService->getEmployeeList(),
            ],
            'attributes' => [
                'multiple' => 'multiple',
                'id' => 'approvers',
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
