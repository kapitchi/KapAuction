<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapAuction\Service;

use KapitchiEntity\Service\EntityService,
    KapAuction\Entity\Item as ItemEntity;

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