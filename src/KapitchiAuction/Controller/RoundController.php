<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapAuction\Controller;

class RoundController extends \KapitchiEntity\Controller\EntityContoller
{
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
