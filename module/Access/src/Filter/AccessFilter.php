<?php

namespace Access\Filter;

use DomainException;
use Zend\InputFilter\InputFilter;
use Zend\Filter;
use Zend\Validator;
use Resource\Service\ResourceService;
use User\Service\UserService;

class AccessFilter extends InputFilter
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
        ]);
    }

    public function getAccessFilter()
    {
        $this->inputFilter->get('user_user_id')->getValidatorChain()->addValidator(new Validator\InArray([
            'haystack' => array_keys($this->userService->getUserList())
        ]));

        return $this->inputFilter;
    }

    public function getAccessSearchFilter()
    {
        $this->inputFilter->get('username')->setAllowEmpty(true);
        $this->inputFilter->get('resource_resource_id')->setRequired(false);
        $this->inputFilter->get('user_user_id')->setRequired(false);

        return $this->inputFilter;
    }
}
