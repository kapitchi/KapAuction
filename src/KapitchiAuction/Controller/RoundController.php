<?php

namespace KapitchiAuction\Controller;

class RoundController extends \KapitchiEntity\Controller\AbstractEntityController
{
    public function getIndexUrl()
    {
        return $this->url()->fromRoute('auction/round', array(
            'action' => 'index'
        ));
    }

    public function getUpdateUrl($entity)
    {
        return $this->url()->fromRoute('auction/round', array(
            'action' => 'update', 'id' => $entity->getId()
        ));
    }
    
    protected function attachDefaultListeners()
    {
        parent::attachDefaultListeners();
        $em = $this->getEventManager();
        $em->attach('create.pre', function($e) {
            $ins = $e->getTarget();
            $form = $e->getParam('form');
            $itemId = $ins->getRequest()->getQuery()->get('itemId');
            $form->get('itemId')->setValue($itemId);
        });
    }
    
}
