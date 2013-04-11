<?php

namespace KapitchiAuction\Controller;

class ItemController extends \KapitchiEntity\Controller\AbstractEntityController
{
    public function getIndexUrl()
    {
        return $this->url()->fromRoute('auction/item', array(
            'action' => 'index'
        ));
    }

    public function getUpdateUrl($entity)
    {
        return $this->url()->fromRoute('auction/item', array(
            'action' => 'update', 'id' => $entity->getId()
        ));
    }
    
    public function attachDefaultListeners()
    {
        parent::attachDefaultListeners();
        $em = $this->getEventManager();
        $em->attach('create.pre', function($e) {
            $form = $e->getParam('form');
            $form->get('auctionId')->setValue($e->getTarget()->getRequest()->getQuery()->get('auctionId'));
        });
    }
    
}
