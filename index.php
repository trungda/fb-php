<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Skip these two lines if you're using Composer
define('FACEBOOK_SDK_V4_SRC_DIR', 
  'facebook-php-sdk-v4-4.0/src/Facebook/');
require __DIR__ . '/facebook-php-sdk-v4-4.0/autoload.php';

use Facebook\FacebookRequest;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequestException;
use Facebook\FacebookSession;
use Facebook\GraphUser;

$app_id = '517456311725790';
$app_secret = '24383dee2940cf79497f2ebaaee0cce1';
$redirect_url = 'http://localhost/fb-connect/';
$permissions = 'manage_pages, publish_actions';

FacebookSession::setDefaultApplication($app_id, $app_secret);
$helper = new FacebookRedirectLoginHelper($redirect_url);

try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}

// see if we have a session
if (isset($session)) {

  $response = (new FacebookRequest(
    $session, 'POST', '/me/feed', array(
      'link' => 'google.com',
	'message' => 'google'
    )
  ))->execute()->getGraphObject();

  echo "Posted with id:" . $response->getProperty('id');

} else {
  // show login url
  echo '<a href="' . $helper->getLoginUrl(array('scope'=>$permissions)) . 
    '">Login</a>';
}

?>
