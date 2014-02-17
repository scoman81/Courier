<?php

// require_once('inc/Pest.php');
require_once('inc/Pest.php');
require_once('inc/utils.php');

// clean up the POST data
$inputs = array();
foreach ($_POST as $key => $value) {
  $inputs[$key] = trim(strip_tags($value));
}

// we should be getting an avname and password
$avname = isset($inputs['avname']) ? $inputs['avname'] : "";
$password = isset($inputs['password']) ? $inputs['password'] : "";

// put together the REST api call
$params = array('avname' => $avname, 'password' => $password);

// construct the endpoint url
$url = array();
$url[] = 'http://';
$url[] = $_SERVER['SERVER_ADDR'];

$port = $_SERVER['SERVER_PORT'];
if ($port != 80 ) {
  $url[] = ':' . $port;
}

$url[] = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
$url[] = '/api/v1';

$pest = new Pest(implode('', $url));

try {
  $result = $pest->post('/login', $params);
  $result = json_decode($result);

  // create the access token
  $token = new Token($result->uid);
  $token->createToken();

  // create a session for this user, httponly
  session_set_cookie_params(NULL, NULL, NULL, NULL, TRUE);
  session_start();

  $_SESSION['uid'] = $result->uid;

  // redirect to the main SPA
  header('Location: ./');
  exit;

} catch (Pest_BadRequest $e) {

  // we were missing some data?
  header('Location: login.php?e=1');
  exit;

} catch (Pest_Unauthorized $e) {

  // invalid password
  header('Location: login.php?e=3');
  exit;

} catch (Pest_NotFound $e) {

  // username not recognized
  header('Location: login.php?e=2');
  exit;

} catch (Pest_ClientError $e) {

  // we're unsure what this error is.
  header('Location: login.php');
  exit;
}
