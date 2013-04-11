<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapAuction\Service;

use KapitchiEntity\Service\EntityService,
    KapAuction\Entity\Round as RoundEntity;

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