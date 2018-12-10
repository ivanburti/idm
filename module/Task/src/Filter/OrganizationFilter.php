<?php

namespace Organization\Filter;

use DomainException;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Filter;
use Zend\Validator;
use Organization\Service\OrganizationService;
use User\Service\UserService;

class OrganizationFilter extends InputFilter implements InputFilterAwareInterface
{
    private $organizationService;
    private $userService;
    private $inputFilter;

    public function __construct(OrganizationService $organizationService, UserService $userService)
    {
        $this->userService = $userService;
        $this->organizationService = $organizationService;

        $this->inputFilter = new InputFilter();

        $this->inputFilter->add([
            'name' => 'alias',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
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

        $this->inputFilter->add([
            'name' => 'type',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\InArray::class,
                    'options' => [
                        'haystack' => array_keys($this->organizationService->getOrganizationTypeList()),
                    ],
                ],
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

        $this->inputFilter->add([
            'name' => 'expires_on',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);

        $this->inputFilter->add([
            'name' => 'status',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\InArray::class,
                    'options' => [
                        'haystack' => array_keys($this->organizationService->getOrganizationStatusList()),
                    ],
                ],
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

        /*
        $this->inputFilter->add([
            'name' => 'owner',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\InArray::class,
                    'options' => [
                        'haystack' => array_keys($this->userService->getEmployeesList()),
                        'strict'   => Validator\InArray::COMPARE_NOT_STRICT
                    ],
                ],
            ],
        ]);
        */
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf('%s does not allow injection of an alternate input filter',__CLASS__));
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

    public function getInternalFilter()
    {
        return $this->inputFilter;
    }

    public function getExternalFilter()
    {
        $this->inputFilter->get('type')->setRequired(false);
        $this->inputFilter->get('status')->setRequired(false);

        return $this->inputFilter;
    }

    public function getOrganizationSearchFilter()
    {
        $this->inputFilter->get('alias')->setRequired(false);
        $this->inputFilter->get('name')->setRequired(false);
        $this->inputFilter->get('type')->setRequired(false);
        $this->inputFilter->get('employer_number')->setRequired(false);
        $this->inputFilter->get('expires_on')->setRequired(false);
        $this->inputFilter->get('status')->setRequired(false);
        $this->inputFilter->get('owners')->setRequired(false);

        return $this->inputFilter;
    }
}
