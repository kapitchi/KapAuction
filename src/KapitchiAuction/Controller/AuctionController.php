<?php

namespace KapitchiAuction\Controller;

use KapitchiEntity\Controller\AbstractEntityController;

class AuctionController extends AbstractEntityController
{
    public function getIndexUrl()
    {
        return $this->url()->fromRoute('auction/auction', array(
            'action' => 'index'
        ));
    }

    public function getUpdateUrl($entity)
    {
        return $this->url()->fromRoute('auction/auction', array(
            'action' => 'update', 'id' => $entity->getId()
        ));
    }
    
}
