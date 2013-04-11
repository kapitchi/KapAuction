<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapAuction\Entity;

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