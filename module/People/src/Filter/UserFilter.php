<?php

namespace People\Filter;

use Zend\InputFilter\InputFilter;
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
            'name' => 'organization_organization_id',
            'required' => true,
        ]);
    }

    private function setEmailFilter()
    {
        $this->inputFilter->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
            'validators' => [
                ['name' => Validator\EmailAddress::class],
            ],
        ]);
    }

    private function setResignationDateFilter($maxDate = null)
    {
        $this->inputFilter->add([
            'name' => 'resignation_date',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
            'validators' => [
                ['name' => Validator\Date::class],
            ],
        ]);

        ($maxDate) ? $this->inputFilter->get('resignation_date')->getValidatorChain()->addValidator(new Validator\LessThan(['max' => $maxDate])) : null;
    }

    private function setBirthdayDateFilter()
    {
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
    }

    public function getUserSearchFilter()
    {
        $this->inputFilter->get('full_name')->setAllowEmpty(true);
        $this->inputFilter->get('birthday_date')->setRequired(false);
        $this->inputFilter->get('personal_id')->setRequired(false);
        $this->inputFilter->get('work_id')->setRequired(false);
        $this->inputFilter->get('organization_organization_id')->setRequired(false);

        return $this->inputFilter;
    }

    public function getEmployeeFilter()
    {
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
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);

        $this->inputFilter->get('organization_organization_id')->getValidatorChain()->addValidator(new Validator\InArray([
            'haystack' => array_keys($this->organizationService->getInternalList())
        ]));

        return $this->inputFilter;
    }

    public function getServiceProviderFilter()
    {
        $this->setEmailFilter();
        $this->setResignationDateFilter(date('Y-m-d', strtotime(date('Y-m-d'). ' + 90 days')));
        $this->setBirthdayDateFilter();

        $this->inputFilter->get('organization_organization_id')->getValidatorChain()->addValidator(new Validator\InArray([
            'haystack' => array_keys($this->organizationService->getExternalList())
        ]));

        return $this->inputFilter;
    }
}
