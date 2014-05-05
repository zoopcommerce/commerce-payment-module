<?php

namespace Zoop\Payment\Gateway\Anz;

use \Exception;
use Zoop\Payment\Gateway\AbstractGateway;
use Zoop\Payment\Gateway\GatewayInterface;
use Zoop\Payment\Gateway\OnServerGatewayInterface;
use Zoop\Order\DataModel\OrderInterface;
use Zoop\Payment\Gateway\GatewayResponseInterface;
use Zoop\Payment\Gateway\GatewayResponse;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
class Gateway extends AbstractGateway implements
    GatewayInterface, 
    OnServerGatewayInterface
{

    protected $server;

    /**
     * 
     * @param type $amount
     * @param type $currency
     * @param OrderInterface $order
     * @return GatewayResponseInterface $response
     */
    public function charge($amount, $currency, OrderInterface $order)
    {
        
    }

    /**
     * 
     * @param type $amount
     * @param OrderInterface $order
     * @return GatewayResponseInterface $response
     */
    public function refund($amount, OrderInterface $order)
    {
        
    }

    public function getServer()
    {
        return $this->server;
    }

    public function setServer($server)
    {
        $this->server = $server;
    }
}
