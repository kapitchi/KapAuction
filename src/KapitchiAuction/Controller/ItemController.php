<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapAuction\Controller;

class ItemController extends \KapitchiEntity\Controller\EntityContoller
{
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
