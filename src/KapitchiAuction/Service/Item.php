<?php

namespace KapitchiAuction\Service;

use KapitchiEntity\Service\EntityService,
    KapitchiAuction\Entity\Item as ItemEntity;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Item extends EntityService
{
    protected $auctionService;
    
    public function findAuction(ItemEntity $item)
    {
        return $this->getAuctionService()->find($item->getAuctionId());
    }
    
    public function getAuctionService()
    {
        return $this->auctionService;
    }

    public function setAuctionService($auctionService)
    {
        $this->auctionService = $auctionService;
    }
}