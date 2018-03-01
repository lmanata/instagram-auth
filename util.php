<?php

function getAuthLink () {
  $config = json_decode( file_get_contents( "config.json" ), true );
  $id = $config[ "client_id" ];
  $uri = $config[ "redirect_uri" ];
  $link = "https://api.instagram.com/oauth/authorize/?client_id=$id&redirect_uri=$uri&response_type=code";

  echo $link;
}

function validateFields ( $item = [], $fields = [] ) {
  foreach ( $fields as $field ) {
    if ( !isset( $item[ $field ] ) ) return false;
  }

  return true;
}

function simpleJsonPost ( $url, $data ) {
  $ch = curl_init();

  curl_setopt( $ch, CURLOPT_URL, $url );
  curl_setopt( $ch, CURLOPT_POST, true );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

  $result = curl_exec( $ch );
  curl_close( $ch );

  return $result;
}

class DetailedException extends Exception {
  private $result;
  private $request;

  public function __construct ( $message, $request = [], $result = [] ) {
    $this->request = $request;
    $this->result = $result;

    parent::__construct( $message );
  }

  public function getResult () {
    return $this->result;
  }

  public function getRequest () {
    return $this->request;
  }
}