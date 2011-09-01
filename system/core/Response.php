<?php

class Response {

	public $data, $status, $url;

	function __construct( $data ) {
		$this->data = json_decode( $data );
	}

}