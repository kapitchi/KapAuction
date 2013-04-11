<?php

namespace KapitchiAuction;

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
                'KapitchiAuction\Controller\Item' => function($sm) {
                    $cont = new Controller\ItemController();
                    $cont->setEntityService($sm->getServiceLocator()->get('KapitchiAuction\Service\Item'));
                    $cont->setEntityForm($sm->getServiceLocator()->get('KapitchiAuction\Form\Item'));
                    return $cont;
                },
                'KapitchiAuction\Controller\Auction' => function($sm) {
                    $cont = new Controller\AuctionController();
                    $cont->setEntityService($sm->getServiceLocator()->get('KapitchiAuction\Service\Auction'));
                    $cont->setEntityForm($sm->getServiceLocator()->get('KapitchiAuction\Form\Auction'));
                    return $cont;
                },
                'KapitchiAuction\Controller\Round' => function($sm) {
                    $cont = new Controller\RoundController();
                    $cont->setEntityService($sm->getServiceLocator()->get('KapitchiAuction\Service\Round'));
                    $cont->setEntityForm($sm->getServiceLocator()->get('KapitchiAuction\Form\Round'));
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
                    $cont = new View\Helper\Item($sm->getServiceLocator()->get('KapitchiAuction\Service\Item'));
                    return $cont;
                },
                'auction' => function($sm) {
                    $cont = new View\Helper\Auction($sm->getServiceLocator()->get('KapitchiAuction\Service\Auction'));
                    return $cont;
                },
                'auctionState' => function($sm) {
                    $cont = new View\Helper\AuctionState($sm->getServiceLocator()->get('KapitchiAuction\Service\AuctionState'));
                    return $cont;
                },
                'auctionRoundState' => function($sm) {
                    $cont = new View\Helper\RoundState($sm->getServiceLocator()->get('KapitchiAuction\Service\RoundState'));
                    return $cont;
                },
                'auctionRound' => function($sm) {
                    $cont = new \KapitchiEntity\View\Helper\AbstractEntityHelper($sm->getServiceLocator()->get('KapitchiAuction\Service\Round'));
                    return $cont;
                },
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'KapitchiAuction\Mapper\Auction' => 'KapitchiAuction\Mapper\AuctionDbAdapter',
                'KapitchiAuction\Mapper\Item' => 'KapitchiAuction\Mapper\ItemDbAdapter',
                'KapitchiAuction\Mapper\Round' => 'KapitchiAuction\Mapper\RoundDbAdapter',
            ),
            'invokables' => array(
                'KapitchiAuction\Entity\Auction' => 'KapitchiAuction\Entity\Auction',
                'KapitchiAuction\Entity\AuctionState' => 'KapitchiAuction\Entity\AuctionState',
                'KapitchiAuction\Entity\AuctionInputFilter' => 'KapitchiAuction\Entity\AuctionInputFilter',
                'KapitchiAuction\Form\AuctionInputFilter' => 'KapitchiAuction\Form\AuctionInputFilter',
                'KapitchiAuction\Entity\Item' => 'KapitchiAuction\Entity\Item',
                'KapitchiAuction\Entity\ItemInputFilter' => 'KapitchiAuction\Entity\ItemInputFilter',
                'KapitchiAuction\Form\ItemInputFilter' => 'KapitchiAuction\Form\ItemInputFilter',
                'KapitchiAuction\Entity\Round' => 'KapitchiAuction\Entity\Round',
                'KapitchiAuction\Entity\RoundInputFilter' => 'KapitchiAuction\Entity\RoundInputFilter',
                'KapitchiAuction\Entity\RoundState' => 'KapitchiAuction\Entity\RoundState',
                'KapitchiAuction\Form\RoundInputFilter' => 'KapitchiAuction\Form\RoundInputFilter',
                'KapitchiAuction\Entity\RealPropertyItem' => 'KapitchiAuction\Entity\RealPropertyItem',
            ),
            'factories' => array(
                'KapitchiAuction\ModuleOptions' => function ($sm) {
                    $config = $sm->get('Config');
                    return new ModuleOptions(isset($config['KapitchiAuction']) ? $config['KapitchiAuction'] : array());
                },
                'KapitchiAuction\Form\Auction' => function ($sm) {
                    $form = new Form\Auction();
                    $form->setInputFilter($sm->get('KapitchiAuction\Form\AuctionInputFilter'));
                    return $form;
                },
                //Auction
                'KapitchiAuction\Service\Auction' => function ($sm) {
                    $s = new Service\Auction(
                        $sm->get('KapitchiAuction\Mapper\Auction'),
                        $sm->get('KapitchiAuction\Entity\Auction'),
                        $sm->get('KapitchiAuction\Entity\AuctionHydrator')
                    );
                    $s->setInputFilter($sm->get('KapitchiAuction\Entity\AuctionInputFilter'));
                    return $s;
                },
                'KapitchiAuction\Mapper\AuctionDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiAuction\Entity\AuctionHydrator'),
                            'entityPrototype' => $sm->get('KapitchiAuction\Entity\Auction'),
                        ))
                    );
                },
                //AuctionRevision
                'KapitchiAuction\Service\AuctionRevision' => function ($sm) {
                    $s = new Service\AuctionRevision(
                        $sm->get('KapitchiAuction\Mapper\AuctionRevisionDbAdapterMapper'),
                        $sm->get('KapitchiAuction\Service\Auction')
                    );
                    return $s;
                },
                'KapitchiAuction\Mapper\AuctionRevisionDbAdapterMapper' => function ($sm) {
                    return new \KapitchiEntity\Mapper\RevisionDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction_revision',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiEntity\Entity\RevisionHydrator'),
                            'entityPrototype' => $sm->get('KapitchiEntity\Entity\Revision'),
                        )),
                        $sm->get('KapitchiAuction\Entity\Auction'),
                        $sm->get('KapitchiAuction\Entity\AuctionHydrator')
                    );
                },
                'KapitchiAuction\Entity\AuctionHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \KapitchiAuction\Entity\AuctionHydrator(false);
                },
                'KapitchiAuction\Service\Round' => function ($sm) {
                    $ins = new Service\Round(
                        $sm->get('KapitchiAuction\Mapper\Round'),
                        $sm->get('KapitchiAuction\Entity\Round'),
                        $sm->get('KapitchiAuction\Entity\RoundHydrator')
                    );
                    $ins->setInputFilter($sm->get('KapitchiAuction\Entity\RoundInputFilter'));
                    $ins->setItemService($sm->get('KapitchiAuction\Service\Item'));
                    return $ins;
                },
                'KapitchiAuction\Mapper\RoundDbAdapterMapper' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction_round',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiAuction\Entity\RoundHydrator'),
                            'entityPrototype' => $sm->get('KapitchiAuction\Entity\Round'),
                        ))
                    );
                },
                'KapitchiAuction\Entity\RoundHydrator' => function ($sm) {
                    return new Entity\RoundHydrator(false);
                },
                'KapitchiAuction\Form\Round' => function ($sm) {
                    $allOptions = $sm->get('KapitchiAuction\Service\RoundState')->fetchAll(null, null, function($item) {
                        return $item->getLabel();
                    });
                    $ins = new Form\Round($allOptions);
                    $ins->setInputFilter($sm->get('KapitchiAuction\Form\RoundInputFilter'));
                    return $ins;
                },
                //RoundRevision
                'KapitchiAuction\Service\RoundRevision' => function ($sm) {
                    $s = new Service\AuctionRevision(
                        $sm->get('KapitchiAuction\Mapper\RoundRevisionDbAdapterMapper'),
                        $sm->get('KapitchiAuction\Service\Round')
                    );
                    return $s;
                },
                'KapitchiAuction\Mapper\RoundRevisionDbAdapterMapper' => function ($sm) {
                    return new \KapitchiEntity\Mapper\RevisionDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction_round_revision',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiEntity\Entity\RevisionHydrator'),
                            'entityPrototype' => $sm->get('KapitchiEntity\Entity\Revision'),
                        )),
                        $sm->get('KapitchiAuction\Entity\Round'),
                        $sm->get('KapitchiAuction\Entity\RoundHydrator')
                    );
                },
                
                'KapitchiAuction\Service\Item' => function ($sm) {
                    $ins = new Service\Item(
                        $sm->get('KapitchiAuction\Mapper\Item'),
                        $sm->get('KapitchiAuction\Entity\Item'),
                        $sm->get('KapitchiAuction\Entity\ItemHydrator')
                    );
                    $ins->setInputFilter($sm->get('KapitchiAuction\Entity\ItemInputFilter'));
                    $ins->setAuctionService($sm->get('KapitchiAuction\Service\Auction'));
                    return $ins;
                },
                'KapitchiAuction\Mapper\ItemDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction_item',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiAuction\Entity\ItemHydrator'),
                            'entityPrototype' => $sm->get('KapitchiAuction\Entity\Item'),
                        ))
                    );
                },
                'KapitchiAuction\Entity\ItemHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                'KapitchiAuction\Form\Item' => function ($sm) {
                    $ins = new Form\Item();
                    $ins->setInputFilter($sm->get('KapitchiAuction\Form\ItemInputFilter'));
                    return $ins;
                },
                        
                //RoundState
                'KapitchiAuction\Service\RoundState' => function ($sm) {
                    return new Service\RoundState(
                        $sm->get('KapitchiAuction\Mapper\RoundStateDbAdapter'),
                        $sm->get('KapitchiAuction\Entity\RoundState'),
                        $sm->get('KapitchiAuction\Entity\RoundStateHydrator')
                    );
                },
                'KapitchiAuction\Mapper\RoundStateDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction_round_state',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiAuction\Entity\RoundStateHydrator'),
                            'entityPrototype' => $sm->get('KapitchiAuction\Entity\RoundState'),
                        ))
                    );
                },
                'KapitchiAuction\Entity\RoundStateHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },        
                
                //RoundState
                'KapitchiAuction\Service\AuctionState' => function ($sm) {
                    return new Service\RoundState(
                        $sm->get('KapitchiAuction\Mapper\AuctionStateDbAdapter'),
                        $sm->get('KapitchiAuction\Entity\AuctionState'),
                        $sm->get('KapitchiAuction\Entity\AuctionStateHydrator')
                    );
                },
                'KapitchiAuction\Mapper\AuctionStateDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction_auction_state',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiAuction\Entity\AuctionStateHydrator'),
                            'entityPrototype' => $sm->get('KapitchiAuction\Entity\AuctionState'),
                        ))
                    );
                },
                'KapitchiAuction\Entity\AuctionStateHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                        
                //RealPropertyItem
                'KapitchiAuction\Service\RealPropertyItem' => function ($sm) {
                    return new Service\RealPropertyItem(
                        $sm->get('KapitchiAuction\Mapper\RealPropertyItemDbAdapter'),
                        $sm->get('KapitchiAuction\Entity\RealPropertyItem'),
                        $sm->get('KapitchiAuction\Entity\RealPropertyItemHydrator')
                    );
                },
                'KapitchiAuction\Mapper\RealPropertyItemDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'auction_item_realproperty',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiAuction\Entity\RealPropertyItemHydrator'),
                            'entityPrototype' => $sm->get('KapitchiAuction\Entity\RealPropertyItem'),
                        ))
                    );
                },
                'KapitchiAuction\Entity\RealPropertyItemHydrator' => function ($sm) {
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