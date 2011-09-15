<?php

class Request {

	public $url;
	public $controller;
	public $method, $post, $get, $params;
	
	static function factory( $url ) {
		return new self( $url );
	}

	function __construct( $url ) {
		$this->url = $url;
		$this->params = new StdClass;
	}

	function setParam( $param, $value ) {
		$this->params->$param = $value;
	}

	function getParam( $param ) {
		return isset( $this->params->$param ) ? $this->params->$param : null;
	}

	function execute() {
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $this->url );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		if ( $this->method == 'post' ) {
			curl_setopt( $curl, CURLOPT_POST, true );
			curl_setopt( $curl, CURLOPT_POSTFIELDS, $this->post );
		}
		$response = new Response( curl_exec( $curl ) );
		$response->url = $this->url;
		$response->status = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
		return $response;
	}

}