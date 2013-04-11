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
class Auction implements AuctionInterface
{
    protected $id;
    protected $refNumber;
    protected $stateId;
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getRefNumber()
    {
        return $this->refNumber;
    }

    public function setRefNumber($refNumber)
    {
        $this->refNumber = $refNumber;
    }

    public function getStateId()
    {
        return $this->stateId;
    }

    public function setStateId($stateId)
    {
        $this->stateId = $stateId;
    }


}