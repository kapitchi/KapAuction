<?php
namespace KapitchiAuction\Entity;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class AuctionInputFilter extends \KapitchiBase\InputFilter\EventManagerAwareInputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'       => 'refNumber',
            'required'   => true,
            'validators' => array(
                /*array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),*/
            ),
            'filters'   => array(
                array('name' => 'StringTrim'),
            ),
        ));
        $this->add(array(
            'name'       => 'stateId',
            'required'   => true,
            'validators' => array(
                /*array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),*/
            ),
            'filters'   => array(
                //array('name' => 'StringTrim'),
            ),
        ));
    }
}