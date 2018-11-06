<?php

namespace User\Form;

use Zend\Form\Form;
use Organization\Service\OrganizationService;

class UserForm extends Form
{
    private $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;

        parent::__construct('form-user');

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Save',
                'id' => 'submit',
            ],
        ]);
    }

    private function setFullNameField() {
        $this->add([
            'type'  => 'text',
            'name' => 'full_name',
            'options' => [
                'label' => 'Full Name',
            ],
            'attributes' => [
                'id' => 'full_name',
            ],
        ]);
    }

    private function setBirthdayDateField()
    {
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
    }

    private function setPersonalIdField()
    {
        $this->add([
            'type'  => 'text',
            'name' => 'personal_id',
            'options' => [
                'label' => 'Personal Identification',
            ],
            'attributes' => [
                'id' => 'personal_id',
            ],
        ]);
    }

    private function setWorkIdField()
    {
        $this->add([
            'type'  => 'text',
            'name' => 'work_id',
            'options' => [
                'label' => 'Work Identification',
            ],
            'attributes' => [
                'id' => 'work_id',
            ],
        ]);
    }

    private function setHirindDateField()
    {
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
    }

    private function setResignationDateField()
    {
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
    }

    private function setPositionField()
    {
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
    }

    private function setSupervisorField()
    {
        $this->add([
            'type'  => 'text',
            'name' => 'supervisor_name',
            'options' => [
                'label' => 'Supervisor Name',
            ],
            'attributes' => [
                'id' => 'supervisor_name'
            ],
        ]);
    }

    private function setOrganizationIdField($organizations = [])
    {
        $this->add([
            'type'  => 'select',
            'name' => 'organization_organization_id',
            'options' => [
                'label' => 'Organization',
                'empty_option' => 'Select ...',
                'value_options' => $organizations
            ],
            'attributes' => [
                'id' => 'organization_organization_id',
            ],
        ]);
    }

    private function setIsEnabledField()
    {
        $this->add([
            'type'  => 'checkbox',
            'name' => 'is_enabled',
            'options' => [
                'label' => 'Only Enabled',
            ],
            'attributes' => [
                'id' => 'is_enabled',
            ],
        ]);
    }

    private function setIsExternalField()
    {
        $this->add([
            'type'  => 'checkbox',
            'name' => 'organization_is_external',
            'options' => [
                'label' => 'Only External',
            ],
            'attributes' => [
                'id' => 'organization_is_external',
            ],
        ]);
    }

    public function getUserSearchForm()
    {
        $this->setFullNameField();

        return $this;
    }

    public function getEmployeeForm()
    {
        $this->setFullNameField();
        $this->setBirthdayDateField();
        $this->setPersonalIdField();
        $this->setWorkIdField();
        $this->setHirindDateField();
        $this->setResignationDateField();
        $this->setPositionField();
        $this->setSupervisorField();
        $this->setOrganizationIdField($this->organizationService->getInternalList());
        return $this;
    }

    public function getServiceProviderForm()
    {
        $this->setFullNameField();
        $this->setBirthdayDateField();
        $this->setPersonalIdField();
        $this->setWorkIdField();
        $this->setOrganizationIdField($this->organizationService->getExternalList());
        return $this;
    }
}
