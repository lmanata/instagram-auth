<?php

function validateFields( $item = [], $fields = [] ) {
  foreach ( $fields as $field ) {
    if ( !isset( $item[ $field ] ) )  return false;
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