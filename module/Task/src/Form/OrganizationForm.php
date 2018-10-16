<?php

namespace Organization\Form;

use Zend\Form\Form;
use Organization\Service\OrganizationService;
use User\Service\UserService;

class OrganizationForm extends Form
{
    private $organizationService;
    private $userService;

    public function __construct(OrganizationService $organizationService, UserService $userService)
    {
        parent::__construct('form-organization');

        $this->organizationService = $organizationService;
        $this->userService = $userService;

        $this->add([
            'type'  => 'text',
            'name' => 'alias',
            'options' => [
                'label' => 'Alias',
            ],
            'attributes' => [
                'id' => 'alias',
            ],
        ]);

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
            'type'  => 'select',
            'name' => 'type',
            'options' => [
                'label' => 'Type',
                'empty_option' => 'Select ...',
                'value_options' => $this->organizationService->getOrganizationTypeList()
            ],
            'attributes' => [
                'id' => 'type',
            ],
        ]);

        $this->add([
            'type'  => 'text',
            'name' => 'employer_number',
            'options' => [
                'label' => 'Employer Number',
            ],
            'attributes' => [
                'id' => 'employer_number',
            ],
        ]);

        $this->add([
            'type'  => 'text',
            'name' => 'expires_on',
            'options' => [
                'label' => 'Expires On',
            ],
            'attributes' => [
                'id' => 'expires_on',
            ],
        ]);

        $this->add([
            'type'  => 'select',
            'name' => 'status',
            'options' => [
                'label' => 'Status',
                'empty_option' => 'Select ...',
                'value_options' => $this->organizationService->getOrganizationStatusList()
            ],
            'attributes' => [
                'id' => 'status',
            ],
        ]);

        $this->add([
            'type'  => 'select',
            'name' => 'owners',
            'options' => [
                'label' => 'Organization Owner',
                //'empty_option' => 'Select ...',
                'value_options' => $this->userService->getEmployeeList(),
            ],
            'attributes' => [
                'multiple' => 'multiple',
                'id' => 'organization_owner',
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
