<?php
require_once './util.php';

class Authenticator {
  public $code;
  public $config;
  public $user;
  public $codeEndpoint = "https://api.instagram.com/oauth/access_token";
  public static $authEndpoint = "https://api.instagram.com/oauth/authorize";

  public function __construct () {
    if ( !file_exists( "config.json" ) ) {
      throw new Exception( "Could not find config file (expecting ./config.json)!" );
    }

    $config = json_decode( file_get_contents( "config.json" ), true );
    $valid = validateFields( $config, [ "client_id", "client_secret" ] );

    if ( !$valid ) {
      throw new Exception( "Both client_id and client_secret need to be set in the config file!" );
    }

    $this->config = $config;
  }

  public function validateCode ( $code = null ) {
    if ( !$code ) {
      throw new Exception( "Missing code variable!" );
    }

    $this->code = $code;

    $requestParams = array_merge( $this->config, [
      "grant_type" => "authorization_code",
      "code" => $code,
    ] );

    $validationResponse = simpleJsonPost( $this->codeEndpoint, $requestParams );
    $validationResponse = json_decode( $validationResponse, true );

    $valid = validateFields( $validationResponse, [ "access_token", "user" ] );

    if ( !$valid ) {
      throw new DetailedException(
        "Did not get expected api response, access_token/user fields were not set!",
        $requestParams,
        $validationResponse
      );
    }

    return $validationResponse;
  }

}