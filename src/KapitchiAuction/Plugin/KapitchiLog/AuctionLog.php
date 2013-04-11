<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapAuction\Plugin\KapitchiLog;

use Zend\EventManager\EventInterface,
    KapitchiApp\PluginManager\PluginInterface;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class AuctionLog implements PluginInterface
{
    
    public function getAuthor()
    {
        return 'Matus Zeman';
    }

    public function getDescription()
    {
        return 'TODO';
    }

    public function getName()
    {
        return '[KapAuction] Log log for auctions';
    }

    public function getVersion()
    {
        return '0.1';
    }
    
    public function onBootstrap(EventInterface $e)
    {
        $em = $e->getApplication()->getEventManager();
        $sm = $e->getApplication()->getServiceManager();
        $instance = $this;
        
        $em->getSharedManager()->attach('KapAuction\Service\Auction', 'persist', function($e) use ($sm, $instance) {
            $service = $e->getTarget();
            $activityIndexService = $sm->get('KapitchiLog\Service\LogIndex');
            
            $entity = $e->getParam('entity');
            $origEntity = $e->getParam('origEntity');
            if($origEntity) {
                if($origEntity->getRefNumber() != $entity->getRefNumber()) {
                    $activity = $activityIndexService->persistLog('auction-update-refnumber', array(
                        'auctionId' => $origEntity->getId(),
                        'origValue' => $origEntity->getStateId(),
                        'updatedValue' => $entity->getStateId(),
                    ));
                }
                if($origEntity->getStateId() != $entity->getStateId()) {
                    $activity = $activityIndexService->persistLog('auction-update-stateid', array(
                        'auctionId' => $origEntity->getId(),
                        'origValue' => $origEntity->getStateId(),
                        'updatedValue' => $entity->getStateId(),
                    ));
                }
                
            }
            else {
                //just created
            }
        }, -100);
    }
    
}