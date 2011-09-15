<?php

require_once( './config.php' );
require_once( '../core/Request.php' );
require_once( '../core/Response.php' );

class SearchApiTest extends PHPUnit_Framework_TestCase  
{  
	public function setUp(){ }  
	public function tearDown(){ }  
	public function testNoResults() {
		$req = Request::factory( URL_ROOT . '/api/search/?geocode_status=1' );
		$resp = $req->execute();
		$this->assertEquals( 0, $resp->data->num_results );
	}
	public function testInvalidId() {
		$req = Request::factory( URL_ROOT . '/api/search?id[compare]=%3D&id[value]=asdf' );
		$resp = $req->execute();
		$this->assertEquals( 0, $resp->data->num_results );
	}
	public function testNoQuery() {
		$req = Request::factory( URL_ROOT . '/api/search' );
		$resp = $req->execute();
		$this->assertGreaterThan( 0, $resp->data->num_results );
	}
}  
