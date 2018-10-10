<?php

namespace User\Form;

use Zend\Form\Form;
use Organization\Service\OrganizationService;
use User\Service\UserService;

class UserForm extends Form
{
    private $organizationService;
    private $userService;

    public function __construct(OrganizationService $organizationService, UserService $userService)
    {
        parent::__construct('form-user');

        //$this->organizationService = $organizationService;
		//$this->userService = $userService;

        $this->add([
            'type'  => 'text',
            'name' => 'email',
            'options' => [
                'label' => 'Email',
            ],
            'attributes' => [
                'id' => 'email'
            ],
        ]);

        $this->add([
            'type'  => 'text',
            'name' => 'full_name',
            'options' => [
                'label' => 'Full Name',
            ],
            'attributes' => [
                'id' => 'full_name'
            ],
        ]);

        $this->add([
            'type'  => 'text',
            'name' => 'birthday_date',
            'options' => [
                'label' => 'Birthday Date',
            ],
            'attributes' => [
                'id' => 'birthday_date',
                'type' => 'date',
            ],
        ]);

        $this->add([
            'type'  => 'text',
            'name' => 'personal_id',
            'options' => [
                'label' => 'Personal Identification',
            ],
            'attributes' => [
                'id' => 'personal_id'
            ],
        ]);

        $this->add([
            'type'  => 'text',
            'name' => 'work_id',
            'options' => [
                'label' => 'Work Identification',
            ],
            'attributes' => [
                'id' => 'work_id'
            ],
        ]);

        $this->add([
            'type'  => 'text',
            'name' => 'hiring_date',
            'options' => [
                'label' => 'Hiring date',
            ],
            'attributes' => [
                'id' => 'hiring_date',
                'type' => 'date',
            ],
        ]);

        $this->add([
            'type'  => 'text',
            'name' => 'resignation_date',
            'options' => [
                'label' => 'Resignation Date',
            ],
            'attributes' => [
                'id' => 'resignation_date',
                'type' => 'date',
            ],
        ]);

        $this->add([
            'type'  => 'text',
            'name' => 'position',
            'options' => [
                'label' => 'Position',
            ],
            'attributes' => [
                'id' => 'position'
            ],
        ]);

        $this->add([
            'type'  => 'select',
            'name' => 'supervisor_name',
            'options' => [
                'label' => 'Supervisor Name',
                'empty_option' => 'Select...'
            ],
            'attributes' => [
                'id' => 'supervisor_name'
            ],
        ]);

        $this->add([
            'type'  => 'select',
            'name' => 'organizations_organization_id',
            'options' => [
                'label' => 'Organization',
                'empty_option' => 'Select...'
                //'value_options' => $organizationService->getInternalList()
            ],
            'attributes' => [
                'id' => 'organizations_organization_id'
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
