<?php

class Response {

	public $data, $status, $status_text, $url;

	function __construct( $data ) {
		$this->data = json_decode( $data );
	}

}