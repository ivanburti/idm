<?php

namespace Resource\Filter;

use DomainException;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Filter;
use Zend\Validator;
use Resource\Service\ResourceService;
use User\Service\UserService;

class ResourceFilter extends InputFilter implements InputFilterAwareInterface
{
    private $resourceService;
    private $userService;
    private $inputFilter;

    public function __construct(ResourceService $resourceService, UserService $userService)
    {
        $this->resourceService = $resourceService;
        $this->userService = $userService;

        $this->inputFilter = new InputFilter();

        $this->inputFilter->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);

        $this->inputFilter->add([
            'name' => 'description',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
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

        $this->inputFilter->add([
            'name' => 'approvers',
            'required' => false,
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

        $this->inputFilter->add([
            'name' => 'resource_auth',
            'required' => false,
            'filters' => [
                ['name' => Filter\ToInt::class],
            ],
        ]);

        $this->inputFilter->add([
            'name' => 'resource_email',
            'required' => false,
            'filters' => [
                ['name' => Filter\ToInt::class],
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

    public function getResourceAddInputFilter()
    {
        return $this->inputFilter;
    }

    public function getResourceUpdateInputFilter()
    {
        return $this->inputFilter;
    }
}
