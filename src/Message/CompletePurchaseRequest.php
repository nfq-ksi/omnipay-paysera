<?php

/**
 * This is the part of Povils open-source library.
 *
 * @author Povilas Susinskas
 */

namespace Omnipay\Paysera\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Paysera\Common\Encoder;
use Omnipay\Paysera\Common\PurchaseDataGenerator;
use Omnipay\Paysera\Common\SignatureGenerator;
use Omnipay\Paysera\Common\SignatureValidator;

/**
 * Class PurchaseRequest
 *
 * @package Omnipay\Paysera\Message
 */
class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        if ($this->httpRequest->get('ss1') && $this->httpRequest->get('ss2')) {
            return array(
                'data' => $this->httpRequest->get('data'),
                'ss1' => $this->httpRequest->get('ss1'),
                'ss2' => $this->httpRequest->get('ss2'),
            );
        }

        $this->validate('projectId', 'password');
        $data = PurchaseDataGenerator::generate($this);

        return array(
            'data' => $data,
            'sign' => SignatureGenerator::generate($data, $this->getPassword()),
        );
    }

    /**
     * @param array $data
     *
     * @return AcceptNotificationResponse
     * @throws InvalidRequestException
     */
    public function sendData($data)
    {
        if (isset($data['sign'])) {
            return $this->response = new PurchaseResponse($this, $data);
        }
        
        if (false === SignatureValidator::isValid($data, $this->getPassword(), $this->httpClient)) {
            throw new InvalidRequestException('Invalid signature');
        }

        return $this->response = new AcceptNotificationResponse($this, $this->parseData($data['data']));
    }

    /**
     * @param string $data
     *
     * @return array
     */
    protected function parseData($data)
    {
        $parameters = array();
        parse_str(Encoder::decode($data), $parameters);

        return null !== $parameters ? $parameters : array();
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
     * @return string
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }
}
