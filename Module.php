<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapAuction;

use KapitchiBase\ModuleManager\AbstractModule,
    KapitchiEntity\Mapper\EntityDbAdapterMapper,
    KapitchiEntity\Mapper\EntityDbAdapterMapperOptions;

class Module extends AbstractModule implements
    \Zend\ModuleManager\Feature\ServiceProviderInterface,
    \Zend\ModuleManager\Feature\ControllerProviderInterface,
    \Zend\ModuleManager\Feature\ViewHelperProviderInterface
{
    
    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'KapAuction\Controller\Item' => function($sm) {
                    $cont = new Controller\ItemController();
                    $cont->setEntityService($sm->getServiceLocator()->get('KapAuction\Service\Item'));
                    $cont->setEntityForm($sm->getServiceLocator()->get('KapAuction\Form\Item'));
                    return $cont;
                },
                'KapAuction\Controller\Auction' => function($sm) {
                    $cont = new Controller\AuctionController();
                    $cont->setEntityService($sm->getServiceLocator()->get('KapAuction\Service\Auction'));
                    $cont->setEntityForm($sm->getServiceLocator()->get('KapAuction\Form\Auction'));
                    return $cont;
                },
                'KapAuction\Controller\Round' => function($sm) {
                    $cont = new Controller\RoundController();
                    $cont->setEntityService($sm->getServiceLocator()->get('KapAuction\Service\Round'));
                    $cont->setEntityForm($sm->getServiceLocator()->get('KapAuction\Form\Round'));
                    return $cont;
                }
            )
        );
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'auctionItem' => function($sm) {
                    $cont = new View\Helper\Item($sm->getServiceLocator()->get('KapAuction\Service\Item'));
                    return $cont;
                },
                'auction' => function($sm) {
                    $cont = new View\Helper\Auction($sm->getServiceLocator()->get('KapAuction\Service\Auction'));
                    return $cont;
                },
                'auctionState' => function($sm) {
                    $cont = new View\Helper\AuctionState($sm->getServiceLocator()->get('KapAuction\Service\AuctionState'));
                    return $cont;
                },
                'auctionRoundState' => function($sm) {
                    $cont = new View\Helper\RoundState($sm->getServiceLocator()->get('KapAuction\Service\RoundState'));
                    return $cont;
                },
                'auctionRound' => function($sm) {
                    $cont = new \KapitchiEntity\View\Helper\AbstractEntityHelper($sm->getServiceLocator()->get('KapAuction\Service\Round'));
                    return $cont;
                },
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'KapAuction\Mapper\Auction' => 'KapAuction\Mapper\AuctionDbAdapter',
                'KapAuction\Mapper\Item' => 'KapAuction\Mapper\ItemDbAdapter',
                'KapAuction\Mapper\Round' => 'KapAuction\Mapper\RoundDbAdapter',
            ),
            'invokables' => array(
                'KapAuction\Entity\Auction' => 'KapAuction\Entity\Auction',
                'KapAuction\Entity\AuctionState' => 'KapAuction\Entity\AuctionState',
                'KapAuction\Entity\AuctionInputFilter' => 'KapAuction\Entity\AuctionInputFilter',
                'KapAuction\Form\AuctionInputFilter' => 'KapAuction\Form\AuctionInputFilter',
                'KapAuction\Entity\Item' => 'KapAuction\Entity\Item',
                'KapAuction\Entity\ItemInputFilter' => 'KapAuction\Entity\ItemInputFilter',
                'KapAuction\Form\ItemInputFilter' => 'KapAuction\Form\ItemInputFilter',
                'KapAuction\Entity\Round' => 'KapAuction\Entity\Round',
                'KapAuction\Entity\RoundInputFilter' => 'KapAuction\Entity\RoundInputFilter',
                'KapAuction\Entity\RoundState' => 'KapAuction\Entity\RoundState',
                'KapAuction\Form\RoundInputFilter' => 'KapAuction\Form\RoundInputFilter',
                'KapAuction\Entity\RealPropertyItem' => 'KapAuction\Entity\RealPropertyItem',
            ),
            'factories' => array(
                'KapAuction\ModuleOptions' => function ($sm) {
                    $config = $sm->get('Config');
                    return new ModuleOptions(isset($config['KapAuction']) ? $config['KapAuction'] : array());
                },
                'KapAuction\Form\Auction' => function ($sm) {
                    $form = new Form\Auction();
                    $form->setInputFilter($sm->get('KapAuction\Form\AuctionInputFilter'));
                    return $form;
                },
                //Auction
                'KapAuction\Service\Auction' => function ($sm) {
                    $s = new Service\Auction(
                        $sm->get('KapAuction\Mapper\Auction'),
                        $sm->get('KapAuction\Entity\Auction'),
                        $sm->get('KapAuction\Entity\AuctionHydrator')
                    );
                    $s->setInputFilter($sm->get('KapAuction\Entity\AuctionInputFilter'));
                    return $s;
                },
                'KapAuction\Mapper\AuctionDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapAuction\Entity\AuctionHydrator'),
                            'entityPrototype' => $sm->get('KapAuction\Entity\Auction'),
                        ))
                    );
                },
                //AuctionRevision
                'KapAuction\Service\AuctionRevision' => function ($sm) {
                    $s = new Service\AuctionRevision(
                        $sm->get('KapAuction\Mapper\AuctionRevisionDbAdapterMapper'),
                        $sm->get('KapAuction\Service\Auction')
                    );
                    return $s;
                },
                'KapAuction\Mapper\AuctionRevisionDbAdapterMapper' => function ($sm) {
                    return new \KapitchiEntity\Mapper\RevisionDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction_revision',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiEntity\Entity\RevisionHydrator'),
                            'entityPrototype' => $sm->get('KapitchiEntity\Entity\Revision'),
                        )),
                        $sm->get('KapAuction\Entity\Auction'),
                        $sm->get('KapAuction\Entity\AuctionHydrator')
                    );
                },
                'KapAuction\Entity\AuctionHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \KapAuction\Entity\AuctionHydrator(false);
                },
                'KapAuction\Service\Round' => function ($sm) {
                    $ins = new Service\Round(
                        $sm->get('KapAuction\Mapper\Round'),
                        $sm->get('KapAuction\Entity\Round'),
                        $sm->get('KapAuction\Entity\RoundHydrator')
                    );
                    $ins->setInputFilter($sm->get('KapAuction\Entity\RoundInputFilter'));
                    $ins->setItemService($sm->get('KapAuction\Service\Item'));
                    return $ins;
                },
                'KapAuction\Mapper\RoundDbAdapterMapper' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction_round',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapAuction\Entity\RoundHydrator'),
                            'entityPrototype' => $sm->get('KapAuction\Entity\Round'),
                        ))
                    );
                },
                'KapAuction\Entity\RoundHydrator' => function ($sm) {
                    return new Entity\RoundHydrator(false);
                },
                'KapAuction\Form\Round' => function ($sm) {
                    $allOptions = $sm->get('KapAuction\Service\RoundState')->fetchAll(null, null, function($item) {
                        return $item->getLabel();
                    });
                    $ins = new Form\Round($allOptions);
                    $ins->setInputFilter($sm->get('KapAuction\Form\RoundInputFilter'));
                    return $ins;
                },
                //RoundRevision
                'KapAuction\Service\RoundRevision' => function ($sm) {
                    $s = new Service\AuctionRevision(
                        $sm->get('KapAuction\Mapper\RoundRevisionDbAdapterMapper'),
                        $sm->get('KapAuction\Service\Round')
                    );
                    return $s;
                },
                'KapAuction\Mapper\RoundRevisionDbAdapterMapper' => function ($sm) {
                    return new \KapitchiEntity\Mapper\RevisionDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction_round_revision',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiEntity\Entity\RevisionHydrator'),
                            'entityPrototype' => $sm->get('KapitchiEntity\Entity\Revision'),
                        )),
                        $sm->get('KapAuction\Entity\Round'),
                        $sm->get('KapAuction\Entity\RoundHydrator')
                    );
                },
                
                'KapAuction\Service\Item' => function ($sm) {
                    $ins = new Service\Item(
                        $sm->get('KapAuction\Mapper\Item'),
                        $sm->get('KapAuction\Entity\Item'),
                        $sm->get('KapAuction\Entity\ItemHydrator')
                    );
                    $ins->setInputFilter($sm->get('KapAuction\Entity\ItemInputFilter'));
                    $ins->setAuctionService($sm->get('KapAuction\Service\Auction'));
                    return $ins;
                },
                'KapAuction\Mapper\ItemDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction_item',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapAuction\Entity\ItemHydrator'),
                            'entityPrototype' => $sm->get('KapAuction\Entity\Item'),
                        ))
                    );
                },
                'KapAuction\Entity\ItemHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                'KapAuction\Form\Item' => function ($sm) {
                    $ins = new Form\Item();
                    $ins->setInputFilter($sm->get('KapAuction\Form\ItemInputFilter'));
                    return $ins;
                },
                        
                //RoundState
                'KapAuction\Service\RoundState' => function ($sm) {
                    return new Service\RoundState(
                        $sm->get('KapAuction\Mapper\RoundStateDbAdapter'),
                        $sm->get('KapAuction\Entity\RoundState'),
                        $sm->get('KapAuction\Entity\RoundStateHydrator')
                    );
                },
                'KapAuction\Mapper\RoundStateDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction_round_state',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapAuction\Entity\RoundStateHydrator'),
                            'entityPrototype' => $sm->get('KapAuction\Entity\RoundState'),
                        ))
                    );
                },
                'KapAuction\Entity\RoundStateHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },        
                
                //RoundState
                'KapAuction\Service\AuctionState' => function ($sm) {
                    return new Service\RoundState(
                        $sm->get('KapAuction\Mapper\AuctionStateDbAdapter'),
                        $sm->get('KapAuction\Entity\AuctionState'),
                        $sm->get('KapAuction\Entity\AuctionStateHydrator')
                    );
                },
                'KapAuction\Mapper\AuctionStateDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction_auction_state',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapAuction\Entity\AuctionStateHydrator'),
                            'entityPrototype' => $sm->get('KapAuction\Entity\AuctionState'),
                        ))
                    );
                },
                'KapAuction\Entity\AuctionStateHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                        
                //RealPropertyItem
                'KapAuction\Service\RealPropertyItem' => function ($sm) {
                    return new Service\RealPropertyItem(
                        $sm->get('KapAuction\Mapper\RealPropertyItemDbAdapter'),
                        $sm->get('KapAuction\Entity\RealPropertyItem'),
                        $sm->get('KapAuction\Entity\RealPropertyItemHydrator')
                    );
                },
                'KapAuction\Mapper\RealPropertyItemDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction_item_realproperty',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapAuction\Entity\RealPropertyItemHydrator'),
                            'entityPrototype' => $sm->get('KapAuction\Entity\RealPropertyItem'),
                        ))
                    );
                },
                'KapAuction\Entity\RealPropertyItemHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
            ),
        );
    }
    
	
    public function getDir() {
        return __DIR__;
    }

    public function getNamespace() {
        return __NAMESPACE__;
    }

}