<?php
/**
 * (c) 2016. 11. 03..
 * Authors: nxu
 */

namespace LaravelHungary\Barion;

class Barion extends BarionClient
{
    /**
     * Initializes a payment by sending a payment start request.
     *
     * @param array $data
     * @return array|mixed
     */
    public function paymentStart($data)
    {
        return $this->post("/v2/Payment/Start", $data);
    }

    /**
     * Gets the status of the payment.
     *
     * @param string $paymentId
     * @return array|mixed
     */
    public function getPaymentState($paymentId)
    {
        return $this->get("/v2/Payment/GetPaymentState?PaymentId=$paymentId");
    }
}
