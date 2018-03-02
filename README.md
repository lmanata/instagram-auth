##A simple PHP class to handle the instagram user authentication (OAUTH2)

##Installation
Simply require the 'authenticator.php' file.

(Not yet available as a composer lib)


##Usage
You can either initialize the Authenticator class by passing an array/object or by passing a json file directory.

###Examples

####Initializing
Passing a config variable
```
if ( isset( $_REQUEST[ "code" ] ) ) {
      $config = [
        "client_secret" => "secret",
        "client_id" => "id",
        "redirect_uri" => "uri",
      ];
      $authenticator = new \InstagramAuth\Authenticator( $config );
      $codeData = $authenticator->validateCode( $data[ "code" ] );
}
```

Passing a file directory
```
if ( isset( $_REQUEST[ "code" ] ) ) {
    $configFile = "config.json";
    $authenticator = new \InstagramAuth\Authenticator( $configFile );
    $codeData = $authenticator->validateCode( $data[ "code" ] );
}
```
####Error Handling
Errors like missing config fields will throw a simple Exception.

Api response related errors will throw a custom 'DetailedException' which can be used to grab both request/response data

```
catch(\DetailedException $exception) {
    $requestData = $exception->getRequest();
    $responseData = $exception->getResponse();
}
```