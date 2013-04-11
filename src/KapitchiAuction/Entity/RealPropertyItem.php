<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapAuction\Entity;

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