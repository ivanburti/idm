<?php

namespace Resource\Service;

use Resource\Model\ResourceTable;
use Resource\Model\Resource;

class ResourceService
{
    private $resourceTable;

    public function __construct(ResourceTable $resourceTable)
    {
        $this->resourceTable = $resourceTable;
    }

    public function getResources()
    {
        return $this->resourceTable->getResources();
    }

    public function getResourceList()
    {
        return array_column($this->getResources()->toArray(), 'name', 'resource_id');
    }

    public function getResourceById($resource_id)
    {
        $resource_id = (int) $resource_id;

        return $this->resourceTable->getResourceById($resource_id);
    }

    public function addResource(Resource $resource)
    {
        $resource_id = $this->resourceTable->saveResource($resource);

        $this->enableResource($resource_id);

        return $resource_id;
    }

    public function updateResource($resource)
    {
        return $this->resourceTable->saveResource($resource);
    }

    public function enableResource($resource_id)
    {
        $resource_id = (int) $resource_id;

        $resource = $this->getResourceById($resource_id);
        $resource->status = 1;

        return $this->resourceTable->saveResource($resource);
    }
}
