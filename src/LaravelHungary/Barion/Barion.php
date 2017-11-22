<?php

namespace LaravelHungary\Barion;

class Barion extends BarionClient
{
    /**
     * Initializes a payment by sending a payment start request.
     *
     * @param array $data
     *
     * @return array|mixed
     */
    public function paymentStart($data)
    {
        return $this->post('/v2/Payment/Start', $data);
    }

    /**
     * Gets the status of the payment.
     *
     * @param string $paymentId
     *
     * @return array|mixed
     */
    public function getPaymentState($paymentId)
    {
        return $this->get("/v2/Payment/GetPaymentState?PaymentId=$paymentId");
    }

    /**
     * Make call with different POS key.
     *
     * @param $key
     *
     * @return static
     */
    public function withPOSKey($key)
    {
        return $this->setPosKey($key);
    }
}
