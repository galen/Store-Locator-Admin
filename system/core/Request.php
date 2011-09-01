<?php

class Request {

	private $url;
	public $method, $post, $get;
	
	static function factory( $url ) {
		return new self( isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://' . $_SERVER['HTTP_HOST'] . $url );
	}

	function __construct( $url ) {
		$this->url = $url;
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