<?php

namespace Access\Filter;

use DomainException;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Filter;
use Zend\Validator;
use Resource\Service\ResourceService;
use User\Service\UserService;

class AccessFilter extends InputFilter implements InputFilterAwareInterface
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
            'name' => 'username',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);

        $this->inputFilter->add([
            'name' => 'resource_resource_id',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\InArray::class,
                    'options' => [
                        'haystack' => array_keys($this->resourceService->getResourceList()),
                    ],
                ],
            ],
        ]);

        $this->inputFilter->add([
            'name' => 'user_user_id',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\InArray::class,
                    'options' => [
                        'haystack' => array_keys($userService->getUserList()),
                    ],
                ],
            ],
        ]);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf('%s does not allow injection of an alternate input filter', __CLASS__));
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}
