<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Filter;
use Zend\Validator;
use Organization\Service\OrganizationService;

class UserForm extends Form
{
    private $inputFilter;
    private $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->inputFilter = new InputFilter();
        $this->organizationService = $organizationService;

        parent::__construct('form-user');

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

        $this->inputFilter->add([
            'name' => 'full_name',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
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

        $this->inputFilter->add([
            'name' => 'birthday_date',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
            'validators' => [
                ['name' => Validator\Date::class],
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

        $this->inputFilter->add([
            'name' => 'personal_id',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);

        $this->add([
            'type'  => 'select',
            'name' => 'organization_organization_id',
            'options' => [
                'label' => 'Organization',
                'empty_option' => 'Select ...',
            ],
            'attributes' => [
                'id' => 'organization_organization_id',
            ],
        ]);

        $this->inputFilter->add([
            'name' => 'organization_organization_id',
            'required' => true,
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Save',
                'id' => 'submit',
            ],
        ]);

        $this->setInputFilter($this->inputFilter);
    }

    public function getEmployeeForm()
    {
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
            'type'  => 'text',
            'name' => 'supervisor_name',
            'options' => [
                'label' => 'Supervisor Name',
            ],
            'attributes' => [
                'id' => 'supervisor_name'
            ],
        ]);

        $this->get('organization_organization_id')->setOptions(['value_options' => $this->organizationService->getInternalList()]);



        return $this;
    }

    public function getExternalForm()
    {

        return $this;
    }
}
