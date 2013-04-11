<?php

namespace KapitchiAuction\Entity;

class Round
{
    protected $id;
    protected $itemId;
    protected $stateId;
    protected $title;
    protected $fromTime;
    protected $untilTime;
    protected $minimumBidAmount;
    protected $reservePrice;
    protected $incrementAmount;
    protected $winningBidAmount;
    protected $registrationDeposit;
    protected $note;
    protected $venueAddressId;
    
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

    public function getStateId()
    {
        return $this->stateId;
    }

    public function setStateId($stateId)
    {
        $this->stateId = $stateId;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getFromTime()
    {
        return $this->fromTime;
    }

    public function setFromTime($fromTime)
    {
        $this->fromTime = $fromTime;
    }

    public function getUntilTime()
    {
        return $this->untilTime;
    }

    public function setUntilTime($untilTime)
    {
        $this->untilTime = $untilTime;
    }

    public function getMinimumBidAmount()
    {
        return $this->minimumBidAmount;
    }

    public function setMinimumBidAmount($minimumBidAmount)
    {
        $this->minimumBidAmount = $minimumBidAmount;
    }

    public function getReservePrice()
    {
        return $this->reservePrice;
    }

    public function setReservePrice($reservePrice)
    {
        $this->reservePrice = $reservePrice;
    }

    public function getIncrementAmount()
    {
        return $this->incrementAmount;
    }

    public function setIncrementAmount($incrementAmount)
    {
        $this->incrementAmount = $incrementAmount;
    }

    public function getWinningBidAmount()
    {
        return $this->winningBidAmount;
    }

    public function setWinningBidAmount($winningBidAmount)
    {
        $this->winningBidAmount = $winningBidAmount;
    }

    public function getRegistrationDeposit()
    {
        return $this->registrationDeposit;
    }

    public function setRegistrationDeposit($registrationDeposit)
    {
        $this->registrationDeposit = $registrationDeposit;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setNote($note)
    {
        $this->note = $note;
    }

    public function getVenueAddressId()
    {
        return $this->venueAddressId;
    }

    public function setVenueAddressId($venueAddressId)
    {
        $this->venueAddressId = $venueAddressId;
    }
    
}