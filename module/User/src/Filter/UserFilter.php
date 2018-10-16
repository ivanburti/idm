<?php

namespace User\Filter;

use DomainException;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Filter;
use Zend\Validator;
use Organization\Service\OrganizationService;

class UserFilter extends InputFilter implements InputFilterAwareInterface
{
    private $organizationService;
    private $inputFilter;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;

        $this->inputFilter = new InputFilter();

        return $this->inputFilter;
    }


    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf('%s does not allow injection of an alternate input filter',__CLASS__));
    }

    public function setFullNameFilter(){
        $this->inputFilter->add([
            'name' => 'full_name',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);
    }

    public function setBirthdayFilter()
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

    public function setOrganizationIdFilter($organizations)
    {
        $this->inputFilter->add([
            'name' => 'organizations_organization_id',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\InArray::class,
                    'options' => [
                        'haystack' => array_keys($organizations),
                    ],
                ],
            ],
        ]);
    }

    public function setPersonalIdFilter()
    {
        $this->inputFilter->add([
            'name' => 'personal_id',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);
    }

    public function setWorkIdFilter()
    {
        $this->inputFilter->add([
            'name' => 'work_id',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);
    }

    public function setHiringFilter()
    {
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
    }

    public function setResignationFilter()
    {
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
    }

    public function setPositionFilter()
    {
        $this->inputFilter->add([
            'name' => 'position',
            'required' => true,
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);
    }

    public function setSupervisorName()
    {
        $this->inputFilter->add([
            'name' => 'supervisor_name',
            'required' => true,
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

    public function getEmployeeFilter()
    {
        $this->setFullNameFilter();
        $this->setBirthdayFilter();
        $this->setPersonalIdFilter();
        $this->setWorkIdFilter();
        $this->setHiringFilter();
        $this->setResignationFilter();
        $this->setPositionFilter();
        $this->setSupervisorName();

        $internals = $this->organizationService->getInternalList();
        $this->setOrganizationIdFilter($internals);

        return $this->inputFilter;
    }

    public function getEmployeeUpdate()
    {
        $this->setFullNameFilter();
        $this->setResignationFilter();
        $this->setPositionFilter();
        $this->setSupervisorName();

        return $this->inputFilter;
    }

    public function getUserSearchFilter()
    {
        /*$this->inputFilter->get('email')->setRequired(false);
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
            */
    }

}
