<?php
namespace KapitchiAuction\Plugin;

use Zend\EventManager\EventInterface,
    KapitchiApp\PluginManager\AbstractPlugin;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class AuctionRevision extends AbstractPlugin
{
    
    public function getAuthor()
    {
        return 'Matus Zeman';
    }

    public function getDescription()
    {
        return 'This enables revision service for auctions';
    }

    public function getName()
    {
        return '[KapitchiAuction] Revision enabler for Auction';
    }

    public function getVersion()
    {
        return '0.1';
    }
    
    public function onBootstrap(EventInterface $e)
    {
        $em = $e->getApplication()->getEventManager();
        $sm = $e->getApplication()->getServiceManager();
        
        $em->getSharedManager()->attach('KapitchiAuction\Service\Auction', 'persist', function($e) use ($sm) {
            $revService = $sm->get('KapitchiAuction\Service\AuctionRevision');
            $revision = $revService->createEntityRevision($e->getParam('entity'));
            
            $data = $e->getParam('data', false);
            if($data && isset($data['revision']['revisionLog'])) {
                $revision->setRevisionLog($data['revision']['revisionLog']);
                $revService->persist($revision);
            }
        }, 0);
        $em->getSharedManager()->attach('KapitchiAuction\Form\Auction', 'init', function($e) use ($sm) {
            $form = $e->getTarget();
            $form->add($sm->get('KapitchiEntity\Form\Revision'));
        });
        $em->getSharedManager()->attach('KapitchiAuction\Form\AuctionInputFilter', 'init', function($e) use ($sm) {
            $if = $sm->get('KapitchiEntity\Entity\RevisionInputFilter');
            $e->getTarget()->add($if, 'revision');
        });
        $em->getSharedManager()->attach('KapitchiAuction\Controller\AuctionController', 'update.post', function($e) use ($sm) {
            $form = $e->getParam('form');
            $viewModel = $e->getParam('viewModel');
            
            //mz: we always reset revision log to empty string
            $log = $form->get('revision')->get('revisionLog');
            $log->setValue('');
        });
    }
    
    public function getAuctionRevisionPaginator($entityId)
    {
        $service = $this->getAuctionRevisionService();
        $paginator = $service->getPaginator(array(
            'revisionEntityId' => $entityId
        ), array(
            'revisionCreated DESC'
        ));
        return $paginator;
    }
    
    public function getAuctionRevisionService()
    {
        $sm = $this->getServiceLocator();
        return $sm->getServiceLocator()->get('KapitchiAuction\Service\AuctionRevision');
    }
}