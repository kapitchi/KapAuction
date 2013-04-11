<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapAuction\Entity;

use KapitchiBase\InputFilter\EventManagerAwareInputFilter;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class RoundInputFilter extends EventManagerAwareInputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'       => 'id',
            'required'   => false,
        ));
        $this->add(array(
            'name'       => 'title',
            'required'   => true,
            'filters'   => array(
                array('name' => 'StringTrim'),
            ),
        ));
        $this->add(array(
            'name'       => 'itemId',
            'required'   => true,
        ));
        $this->add(array(
            'name'       => 'stateId',
            'required'   => true,
        ));
        $this->add(array(
            'name'       => 'fromTime',
            'required'   => true,
        ));
        $this->add(array(
            'name'       => 'untilTime',
            'required'   => false,
            'filters'   => array(
                array('name' => 'Null'),
            ),
        ));
        $this->add(array(
            'name'       => 'minimumBidAmount',
            'required'   => false,
            'filters'   => array(
                array('name' => 'Null'),
            ),
        ));
        $this->add(array(
            'name'       => 'reservePrice',
            'required'   => false,
            'filters'   => array(
                array('name' => 'Null'),
            ),
        ));
        $this->add(array(
            'name'       => 'incrementAmount',
            'required'   => false,
            'filters'   => array(
                array('name' => 'Null'),
            ),
        ));
        $this->add(array(
            'name'       => 'winningBidAmount',
            'required'   => false,
            'filters'   => array(
                array('name' => 'Null'),
            ),
        ));
        $this->add(array(
            'name'       => 'registrationDeposit',
            'required'   => false,
            'filters'   => array(
                array('name' => 'Null'),
            ),
        ));
        $this->add(array(
            'name'       => 'venueAddressId',
            'required'   => false,
            'filters'   => array(
                array('name' => 'Null'),
            ),
        ));
        $this->add(array(
            'name'       => 'note',
            'required'   => false,
            'filters'   => array(
                array('name' => 'Null'),
            ),
        ));
    }
}