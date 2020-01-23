<?php

/**
 * This is the part of Povils open-source library.
 *
 * @author Povilas Susinskas
 */

namespace Omnipay\Paysera;

use Omnipay\Common\AbstractGateway;
use Omnipay\Paysera\Message\AcceptNotificationRequest;
use Omnipay\Paysera\Message\PurchaseRequest;
use Omnipay\Paysera\Message\CompletePurchaseRequest;

/**
 * Class Gateway
 *
 * @package Omnipay\Paysera
 */
class Gateway extends AbstractGateway
{
    const VERSION = '1.6';

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Paysera';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'testMode' => true,
            'version' => self::VERSION,
        );
    }

    /**
     * @return string
     */
    public function getProjectId()
    {
        return $this->getParameter('projectId');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setProjectId($value)
    {
        return $this->setParameter('projectId', $value);
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->getParameter('version');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setVersion($value)
    {
        return $this->setParameter('version', $value);
    }

    /**
     * @param array $parameters
     *
     * @return PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Paysera\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Paysera\Message\CompletePurchaseRequest', $parameters);
    }

    /**
     * @return AcceptNotificationRequest
     */
    public function acceptNotification()
    {
        return $this->createRequest('\Omnipay\Paysera\Message\AcceptNotificationRequest', array());
    }
}
