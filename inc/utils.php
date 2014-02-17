<?php

// Utility classes
require_once('class.database.php');
require_once('application.php');

// result codes returned from password validation
define('PW_OK', 0);
define('PW_USER_NOT_FOUND', -1);
define('PW_INVALID_PASSWORD', -2);

date_default_timezone_set('America/Los_Angeles');


// **
// ** Passwords
// **
class Passwords
{

  // get a new salt - 8 hexadecimal characters long
  private function getPasswordSalt() {
    return substr( str_pad( dechex( mt_rand() ), 8, '0', STR_PAD_LEFT ), -8 );
  }

  // calculate the hash from a salt and a password
  private function getPasswordHash($salt, $password) {
      return $salt . hash('sha1', $salt . $password);
  }

// compare a password to a hash
  public function comparePassword($password, $hash) {
      $salt = substr( $hash, 0, 8 );
      return $hash == $this->getPasswordHash($salt, $password);
  }

  public function hashFor($password) {
    $salt = $this->getPasswordSalt();
    return $this->getPasswordHash($salt, $password);
  }

  public function getRandomPassword() {

    $words = array('butter', 'dust', 'freeze', 'bunny', 'over', 'under', 'step', 'base', 'fruit',
    'sam', 'wet', 'water', 'apple', 'slip', 'frog', 'brat', 'pick', 'fly', 'zip', 'try', 'back');
    
    $pass1 = $words[ rand(0, count($words) - 1) ];
    $pass2 = $words[ rand(0, count($words) - 1) ];
    
    while ( $pass2 == $pass1 )
    {
      $pass2 = $words[ rand(0, count($words) - 1) ];  
    }
    $pass3 = rand(1, 999);
    
    return $pass1 . $pass3 . $pass2;
  }
}


// **
// ** Owner
// **
class Owner
{

  private $_name = "";
  private $_id = 0;

  public function __construct($avatarName) {

    $this->_name = $avatarName;

  }

  /* returns:
       0 = match
       1 = avatar not found
       2 = mismatch
  */
  public function validatePassword($password) {

    // get the user's password salt from the database 
    $db = new Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $row = $db->select('id,password')->from('owners')->where('avname', $this->_name)->fetch_first();

    if (count($row) == 0) {
      return PW_USER_NOT_FOUND;
    }

    // grab the user id
    $this->_id = (int)$row['id'];

    // check the password
    $pw = new Passwords();
    if ($pw->comparePassword($password, $row['password']) == FALSE) {
      return PW_INVALID_PASSWORD;
    }

    // otherwise
    return PW_OK;
  }

  public function userID() {
    return $this->_id;
  }

}


// **
// ** Tokens
// **
class Token
{

  private $_userID = 0;

  public function __construct($userID) {
    $this->_userID = (int)$userID;
  }

  public function createToken() {
    $tokenValue = 'abcdefghi';

    // update the tokens table
    $db = new Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $db->where('userid', $this->_userID);
    $data = array(
      'token' => $tokenValue,
      'created' => 'NOW()'
      );
    $db->update('tokens', $data);

    return $tokenValue;
  }

  public function getToken() {
    
    // use a manual query. get the token only if it was created within the last
    // hour. otherwise there's no valid token
    $sql = "SELECT token FROM tokens WHERE (userid=" . $this->_userID . ")";
    $sql .= " AND (TIMESTAMPDIFF(MINUTE, created, NOW()) < 60);";

    // grab the database token as long as it's valid
    $db = new Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $db->query($sql);
    $row = $db->fetch_first();

    return isset($row['token']) ? $row['token'] : "";
  }

  public function validateToken($token) {
    return FALSE;
  }

}

