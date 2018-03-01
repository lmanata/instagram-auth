<?php

function validateFields( $item = [], $fields = [] ) {
  foreach ( $fields as $field ) {
    if ( !isset( $item[ $field ] ) )  return false;
  }

  return true;
}

function simpleJsonPost ( $url, $data ) {
  $json = json_encode( $data );
  $ch = curl_init();

  curl_setopt( $ch, CURLOPT_URL, $url );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, [ "Content-Type: application/json", "Content-Length: " . strlen( $json ) ] );
  curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $data ) );

  $result = curl_exec( $ch );
  curl_close( $ch );

  return $result;
}