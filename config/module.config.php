<?php
return array(
    'KapAuction' => array(
        'auction_options' => array(
            //'active' => 
        )
    ),
    'plugin_manager' => array(
        'invokables' => array(
            'Auction/AuctionRevision' => 'KapAuction\Plugin\AuctionRevision',
            'Auction/RoundRevision' => 'KapAuction\Plugin\RoundRevision',
            'Auction/KapitchiLog/AuctionLog' => 'KapAuction\Plugin\KapitchiLog\AuctionLog',
            'Auction/KapRealProperty' => 'KapAuction\Plugin\KapRealProperty',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'KapAuction\Controller\Index' => 'KapAuction\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            //'auction/index/index'   => __DIR__ . '/../view/auction/index/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'auction' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/auction',
                    'defaults' => array(
                        '__NAMESPACE__' => 'KapAuction\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'auction' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/auction[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Auction',
                            ),
                        ),
                    ),
                    'item' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/item[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Item',
                            ),
                        ),
                    ),
                    'round' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/round[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Round',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
