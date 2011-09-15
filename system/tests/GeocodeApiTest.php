<?php

// Include test specific config
require_once( './config.php' );

// Include main config
require_once( '../config/config.php' );

// Include necessary files
require_once( '../core/Request.php' );
require_once( '../core/Response.php' );

class GeocodeApiTest extends PHPUnit_Framework_TestCase  
{  
	public function setUp(){ }  
	public function tearDown(){ }  
	public function testNoLocation() {
		$req = Request::factory( URL_ROOT_TEST . '/api/geocode' );
		$resp = $req->execute();
		$this->assertEquals( 405, $resp->status );
	}
	public function testLocations() {
		$req = Request::factory( URL_ROOT_TEST . '/api/geocode?city=New+York&state=NY' );
		$resp = $req->execute();
		$this->assertTrue( isset( $resp->data->lat ) );
	}

}  
