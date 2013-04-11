<?php

namespace KapitchiAuction\Service;

use KapitchiEntity\Service\EntityService,
    KapitchiAuction\Entity\Round as RoundEntity;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Round extends EntityService
{
    protected $itemService;
    
    public function findAuction(RoundEntity $round)
    {
        $item = $this->findItem($round);
        return $this->getItemService()->findAuction($item);
    }
    
    public function findItem($round)
    {
        $itemService = $this->getItemService();
        $itemId = $round->getItemId();
        return $itemService->find($itemId);
    }
    
    public function getItemService()
    {
        return $this->itemService;
    }

    public function setItemService($itemService)
    {
        $this->itemService = $itemService;
    }

}