<?php
namespace KapitchiAuction\Form;

use KapitchiBase\Form\EventManagerAwareForm;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Round extends EventManagerAwareForm
{
    public function __construct(array $stateValueOptions)
    {
        parent::__construct('round');

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
            'options' => array(
                'label' => $this->translate('ID'),
            ),
            'attributes' => array(
                
            ),
        ));
        $this->add(array(
            'name' => 'itemId',
            'type' => 'Zend\Form\Element\Hidden',
            'options' => array(
                'label' => $this->translate('Item'),
            ),
            'attributes' => array(
                
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
            'name' => 'stateId',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => $this->translate('State'),
                'value_options' => $stateValueOptions
            ),
            'attributes' => array(
            ),
        ));
        $this->add(array(
            'name' => 'fromTime',
            'type' => 'Zend\Form\Element\DateTime',
            'options' => array(
                'label' => $this->translate('From'),
            ),
            'attributes' => array(
                
            ),
        ));
        $this->add(array(
            'name' => 'untilTime',
            'type' => 'Zend\Form\Element\DateTime',
            'options' => array(
                'label' => $this->translate('Since'),
            ),
            'attributes' => array(
                
            ),
        ));
        $this->add(array(
            'name' => 'minimumBidAmount',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Minimum bid amount'),
            ),
            'attributes' => array(
                
            ),
        ));
        $this->add(array(
            'name' => 'reservePrice',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Reserve price'),
            ),
            'attributes' => array(
                
            ),
        ));
        $this->add(array(
            'name' => 'incrementAmount',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Increment amount'),
            ),
            'attributes' => array(
                
            ),
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
        $this->add(array(
            'name' => 'registrationDeposit',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Registration deposit'),
            ),
            'attributes' => array(
                
            ),
        ));
        $this->add(array(
            'name' => 'venueAddressId',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => $this->translate('Venue address'),
            ),
            'attributes' => array(
                'data-kap-ui' => 'address-lookup-input'
            ),
        ));
        $this->add(array(
            'name' => 'note',
            'type' => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => $this->translate('Note'),
            ),
            'attributes' => array(
                
            ),
        ));
    }
    
}