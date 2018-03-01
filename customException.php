<?php

class DetailedException extends Exception {
  private $result;
  private $request;

  public function __construct ( $message, $request = [], $result = [] ) {
    $this->request = $request;
    $this->result = $result;

    parent::__construct( $message );
  }

  public function getVar ( $key ) {
    return $this->{$key};
  }
}