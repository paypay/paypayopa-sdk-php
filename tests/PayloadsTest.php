<?php
require_once('TestBoilerplate.php');

use PayPay\OpenPaymentAPI\Models\CreateQrCodePayload;
use PayPay\OpenPaymentAPI\Models\OrderItem;

class PayloadsTest extends TestBoilerplate
{
    /**
     * Checking payloads method chaining
     *
     * @return void
     */
    public function testCreateQrCode()
    {
        $test = new CreateQrCodePayload();
        $OrderItems = [];
        $OrderItems[] = (new OrderItem())->setName('Cake')->setQuantity(1)->setUnitPrice(['amount' => 20, 'currency' => 'JPY']);
        $test->setMerchantPaymentId('Test123')->setAmount(['amount' => 20, 'currency' => 'JPY'])->setCodeType()->setOrderItems($OrderItems);
        $array = $test->serialize();
        $this->assertIsArray($array);
    }
}
