<?php

namespace Omnipay\GlobalAlipay\Message;

use Omnipay\Common\Message\AbstractResponse;

class TradeRefundResponse extends AbstractResponse
{
    protected $key;

    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->isRefunded();
    }

    public function isRefunded()
    {
        $data = $this->getData();

        return $data['refunded'];
    }

    public function getAlipayResponse($key = null)
    {
        if ($key) {
            return array_get($this->data, "{$this->key}.{$key}");
        } else {
            return array_get($this->data, $this->key);
        }
    }
}
