<?php

namespace Organization\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Filter;
use Zend\Validator;
use People\Service\UserService;

class OrganizationForm extends Form
{
    private $inputFilter;
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->inputFilter = new InputFilter();
        $this->userService = $userService;

        parent::__construct('form-organization');

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

        $this->inputFilter->add([
            'name' => 'alias',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
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

        $this->inputFilter->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
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

        $this->inputFilter->add([
            'name' => 'employer_number',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
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

        $this->setInputFilter($this->inputFilter);
    }

    public function getInternalForm()
    {
        return $this;
    }

    public function getExternalForm()
    {
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

        $this->inputFilter->add([
            'name' => 'expires_on',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);

        $this->add([
            'type'  => 'select',
            'name' => 'owners',
            'options' => [
                'label' => 'Organization Owners',
                'empty_option' => 'Select ...',
                'value_options' => $this->userService->getEmployeeList(),
            ],
            'attributes' => [
                'multiple' => 'multiple',
                'id' => 'owners',
            ],
        ]);

        $this->inputFilter->add([
            'name' => 'owners',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\Explode::class,
                    'options' => [
                        'validator' => new Validator\InArray([
                            'haystack' => array_keys($this->userService->getEmployeeList())
                        ]),
                    ],
                ],
            ],
        ]);

        return $this;
    }
}
