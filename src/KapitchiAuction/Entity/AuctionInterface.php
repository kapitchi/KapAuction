<?php
namespace KapitchiAuction\Entity;
/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
interface AuctionInterface
{
    public function getId();
    public function getRefNumber();
    public function getStateId();
}