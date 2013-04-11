<?php

namespace KapitchiAuction\Entity;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Item
{
    protected $id;
    protected $auctionId;
    protected $typeHandle;
    protected $title;
    protected $description;
    protected $winningBidAmount;
    protected $winningBidderContactId;
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAuctionId()
    {
        return $this->auctionId;
    }

    public function setAuctionId($auctionId)
    {
        $this->auctionId = $auctionId;
    }

    public function getTypeHandle()
    {
        return $this->typeHandle;
    }

    public function setTypeHandle($typeHandle)
    {
        $this->typeHandle = $typeHandle;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getWinningBidderContactId()
    {
        return $this->winningBidderContactId;
    }

    public function setWinningBidderContactId($winningBidderContactId)
    {
        $this->winningBidderContactId = $winningBidderContactId;
    }
    
    public function getWinningBidAmount()
    {
        return $this->winningBidAmount;
    }

    public function setWinningBidAmount($winningBidAmount)
    {
        $this->winningBidAmount = $winningBidAmount;
    }

}