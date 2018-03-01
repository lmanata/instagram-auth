<?php
namespace InstagramAuth;
require_once './util.php';

class Authenticator {
  public $code;
  public $config;
  public $user;
  public $codeEndpoint = "https://api.instagram.com/oauth/access_token";

  public function __construct ( $config = null ) {
    if ( !$config ) {
      throw new \Exception( "Expecting config variable!" );
    }

    try {
      $config = is_object( $config ) ? (array)$config : $config;
      $config = is_array( $config ) ? $config : json_decode( file_get_contents( $config ), true );
    }
    catch ( \Exception $e ) {
      throw $e;
    }

    $isValid = validateFields( $config, [ "client_id", "client_secret", "redirect_uri" ] );
    if ( !$isValid ) {
      throw new \Exception( "Fields client_id,client_secret and redirect_uri must be set in the config!" );
    }

    $this->config = $config;
  }

  public function validateCode ( $code = null ) {
    if ( !$code ) {
      throw new \Exception( "Missing code variable!" );
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
      throw new \DetailedException(
        "Unexpected api response, expected fields were not set!",
        $requestParams,
        $validationResponse
      );
    }

    return $validationResponse;
  }

}