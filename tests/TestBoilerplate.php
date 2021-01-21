<?php

declare(strict_types=1);
require_once(__DIR__ . '/../src/Client.php');

use PHPUnit\Framework\TestCase;
use PayPay\OpenPaymentAPI\Client;

class BoilerplateTest extends TestCase
{
    /**
     * Open API Client
     *
     * @var Client
     */
    protected $client;
    /**
     * Buffer array to communicate data between tests
     *
     * @var Array
     */
    protected $data;
    /**
     * Test configuration
     *
     * @var Array
     */
    protected $config;
    public function __construct()
    {
        parent::__construct();
        require('config.php');
        $this->client = new Client([
            /** @phpstan-ignore-next-line */
            'API_KEY' => $config['key'],
            /** @phpstan-ignore-next-line */
            'API_SECRET' => $config['secret'],
            /** @phpstan-ignore-next-line */
            'MERCHANT_ID' => $config['mid']
        ], 'test');
        /** @phpstan-ignore-next-line */
        $this->config = $config;
    }
    /**
     * Initialization check
     *
     * @return void
     */
    public function InitCheck()
    {
        $this->assertInstanceOf(Client::class, $this->client, 'Client initialized incorrectly.');
    }
}