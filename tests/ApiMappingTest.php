<?php

require_once('TestBoilerplate.php');

class ApiMappingTest extends TestBoilerplate {

    /**
     * 
     */
    function testJsonData(){
      $mapping = $this->client->GetApiMapping('v3_getWalletBalance');
      $this->assertEquals('GET', $mapping['method']);        
    }

}