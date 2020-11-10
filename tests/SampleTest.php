<?php

require_once('TestBoilerplate.php');

class SampleTest extends TestBoilerplate {

    /**
     * 
     */
    function testJsonData(){
      $mapping = $this->client->GetApiMapping('v3_getWalletBalance');
      $this->assertEquals($mapping['method'], 'GET');        
    }

}