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
class ItemInputFilter extends EventManagerAwareInputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'       => 'id',
            'required'   => false,
        ));
        $this->add(array(
            'name'       => 'auctionId',
            'required'   => true,
        ));
        $this->add(array(
            'name'       => 'typeHandle',
            'required'   => true,
        ));
        $this->add(array(
            'name'       => 'title',
            'required'   => true,
        ));
        $this->add(array(
            'name'       => 'description',
            'required'   => true,
        ));
        $this->add(array(
            'name'       => 'winningBidderContactId',
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
    }
}