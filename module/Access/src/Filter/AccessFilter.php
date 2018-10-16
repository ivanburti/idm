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
use Access\Model\Access;

class AccessFilter extends InputFilter implements InputFilterAwareInterface
{
    private $resourceService;
    private $userService;
    private $access;
    private $inputFilter;

    public function __construct(ResourceService $resourceService, UserService $userService)
    {
        $this->resourceService = $resourceService;
        $this->userService = $userService;
        $this->access = new Access();

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
            'name' => 'resources_resource_id',
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
            'name' => 'users_user_id',
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

        $this->inputFilter->add([
            'name' => 'status',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\InArray::class,
                    'options' => [
                        'haystack' => array_keys($this->access->getStatusList()),
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

    public function getAccessLinkFilter()
    {
        $this->inputFilter->remove('username');
        $this->inputFilter->get('resources_resource_id')->setRequired(false);
        $this->inputFilter->get('users_user_id')->setRequired(false);
        $this->inputFilter->get('status')->setRequired(false);

        return $this->inputFilter;
    }

    public function getAccessSearchFilter()
    {
        $this->inputFilter->get('username')->setRequired(false);
        $this->inputFilter->get('resources_resource_id')->setRequired(false);
        $this->inputFilter->get('users_user_id')->setRequired(false);
        $this->inputFilter->get('status')->setRequired(false);

        return $this->inputFilter;
    }
}
