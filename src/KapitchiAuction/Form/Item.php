<?php
namespace KapitchiAuction\Form;

use KapitchiBase\Form\EventManagerAwareForm;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Item extends EventManagerAwareForm
{
    public function __construct()
    {
        parent::__construct('item');

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
            'options' => array(
                'label' => $this->translate('ID'),
            ),
        ));
        
        $this->add(array(
            'name' => 'auctionId',
            'type' => 'Zend\Form\Element\Hidden',
            'options' => array(
                'label' => $this->translate('Auction'),
            ),
        ));
        
        $this->add(array(
            'name' => 'typeHandle',
            'type' => 'Zend\Form\Element\Radio',
            'options' => array(
                'label' => $this->translate('Type'),
                'value_options' => array(
                    array(
                        'label' => 'Personal property',
                        'value' => 'personalproperty'
                    ),
                )
            ),
        ));
        
        $this->add(array(
            'name' => 'title',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Title'),
            ),
            'attributes' => array(
                
            ),
        ));
        $this->add(array(
            'name' => 'description',
            'type' => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => $this->translate('Description'),
            ),
        ));
        
        $this->add(array(
            'name' => 'winningBidderContactId',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Winning bidder'),
            ),
            'attributes' => array(
                'data-kap-ui' => 'contact-lookup-input',
            )
        ));
        $this->add(array(
            'name' => 'winningBidAmount',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Winning bid amount'),
            ),
            'attributes' => array(
                
            ),
        ));
    }

}