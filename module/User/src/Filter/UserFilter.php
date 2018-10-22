<?php

namespace User\Filter;

//use DomainException;
use Zend\InputFilter\InputFilter;
//use Zend\InputFilter\InputFilterAwareInterface;
//use Zend\InputFilter\InputFilterInterface;
use Zend\Filter;
use Zend\Validator;
use Organization\Service\OrganizationService;

class UserFilter extends InputFilter //implements InputFilterAwareInterface
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

        return $this->inputFilter;
    }
}
