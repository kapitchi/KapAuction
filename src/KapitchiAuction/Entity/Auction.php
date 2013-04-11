<?php
namespace KapitchiAuction\Entity;
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