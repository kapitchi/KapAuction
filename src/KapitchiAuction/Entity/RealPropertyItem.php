<?php

namespace KapitchiAuction\Entity;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class RealPropertyItem
{
    protected $id;
    protected $itemId;
    protected $propertyId;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getItemId()
    {
        return $this->itemId;
    }

    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
    }

    public function getPropertyId()
    {
        return $this->propertyId;
    }

    public function setPropertyId($propertyId)
    {
        $this->propertyId = $propertyId;
    }

}