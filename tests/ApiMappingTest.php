<?php

require_once('TestBoilerplate.php');

class ApiMappingTest extends TestBoilerplate
{

    /**
     *
     */
    public function testJsonData()
    {
        $mapping = $this->client->GetApiMapping('v3_getWalletBalance');
        $this->assertEquals('GET', $mapping['method']);
    }
}
