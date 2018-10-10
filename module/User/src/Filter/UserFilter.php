<?php

namespace User\Filter;

use DomainException;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Filter;
use Zend\Validator;
use Organization\Service\OrganizationService;

class UserFilter extends InputFilter
{
    private $organizationService;
    private $inputFilter;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;

        $this->inputFilter = new InputFilter();

        $this->inputFilter->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
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

        $this->inputFilter->add([
            'name' => 'personal_id',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);

        $this->inputFilter->add([
            'name' => 'work_id',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);

        $this->inputFilter->add([
            'name' => 'hiring_date',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
            'validators' => [
                ['name' => Validator\Date::class],
            ],
        ]);

        $this->inputFilter->add([
            'name' => 'resignation_date',
            'required' => true,
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
            'validators' => [
                ['name' => Validator\Date::class],
            ],
        ]);

        $this->inputFilter->add([
            'name' => 'position',
            'required' => true,
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);

        $this->inputFilter->add([
            'name' => 'supervisor_name',
            'required' => true,
        ]);

        //$internals = $this->organizationService->getInternalsList();
        $this->inputFilter->add([
            'name' => 'organizations_organization_id',
            'required' => true,
        ]);

        //$internals = $this->organizationService->getInternalsListByEmployerNumber();
        $this->inputFilter->add([
            'name' => 'employer_number',
            'required' => true,
            'validators' => [

                [
                    'name' => Validator\InArray::class,
                    'options' => [
                        //'haystack' => array_keys($internals),
                    ],
                ],
            ],

        ]);
    }


    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf('%s does not allow injection of an alternate input filter',__CLASS__));
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

/*
    public function getNewUserFilter()
    {
        $this->inputFilter->remove('organizations_organization_id');
        $this->inputFilter->remove('email');

        return $this->inputFilter;
    }

    public function getUpdateUserFilter()
    {

        $this->inputFilter->remove('email');
        $this->inputFilter->remove('birthday_date');
        $this->inputFilter->remove('personal_id');
        $this->inputFilter->remove('work_id');
        $this->inputFilter->remove('hiring_date');
        $this->inputFilter->remove('employer_number');

        return $this->inputFilter;
    }*/

    public function getUserSearchFilter()
    {
        $this->inputFilter->get('email')->setRequired(false);
        $this->inputFilter->get('supervisor_name')->setRequired(false);
        $this->inputFilter->get('organizations_organization_id')->setRequired(false);
        $this->inputFilter->get('birthday_date')->setRequired(false);
        $this->inputFilter->get('personal_id')->setRequired(false);
        $this->inputFilter->get('work_id')->setRequired(false);
        $this->inputFilter->get('hiring_date')->setRequired(false);
        $this->inputFilter->get('resignation_date')->setRequired(false);
        $this->inputFilter->get('position')->setRequired(false);
        $this->inputFilter->get('supervisor_name')->setRequired(false);
        $this->inputFilter->get('employer_number')->setRequired(false);

        return $this->inputFilter;
    }
}
