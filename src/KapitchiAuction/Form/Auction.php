<?php
namespace KapitchiAuction\Form;

use KapitchiBase\Form\EventManagerAwareForm;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Auction extends EventManagerAwareForm
{
    protected $auctionStateService;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
            'options' => array(
                'label' => 'ID',
            ),
        ));
        
        $this->add(array(
            'name' => 'refNumber',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Reference'),
            ),
            'attributes' => array(
                
            ),
        ));

        //$stateOptions = $this->getAuctionStateService()->getPaginator();
        $this->add(array(
            'name' => 'stateId',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => $this->translate('State'),
            ),
            'attributes' => array(
                'options' => array(
                    1 => 'Aktivna',
                    2 => 'Pozastavena',
                    3 => 'Ukoncena',
                    4 => 'Este nezacata',
                ),//empty - this should be set depending on an auction
            ),
        ));
    }
    
    public function getAuctionStateService()
    {
        return $this->auctionStateService;
    }

    public function setAuctionStateService($auctionStateService)
    {
        $this->auctionStateService = $auctionStateService;
    }


}