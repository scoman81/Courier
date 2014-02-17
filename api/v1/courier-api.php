<?php

require_once('api-class.php');
require_once('../../inc/utils.php');

class CourierAPI extends API
{

    public function __construct($request, $origin) {
        parent::__construct($request);
    }

/*
     protected function example() {
        if ($this->method == 'GET') {
            $r = array();
            $r['foo'] = 'You did good.';
            $r['bar'] = 12;
            return array('content'=>'foo')
        } else {
            return "Only accepts GET requests";
        }
     }

     protected function contacts($args) {
        if ($this->method == 'GET') {
            $result = Array();
            $result['token'] = $this->token;
            $result['req'] = $this->request;

            return $result;

        }
     }
*/

     protected function login() {
        if ($this->method == 'POST') {

            // prepare the response object
            $content = array();
            $status = 200;

            // grab the posted content. both are required
            $avname = isset($this->request['avname']) ? $this->request['avname'] : '';
            $password = isset($this->request['password']) ? $this->request['password'] : '';

            if (strlen($avname) == 0 || strlen($password) == 0) {
                $content['error'] = 'Invalid parameters';
                $content['a'] = $avname;
                $status = 400;
            } else {

                // automatically add Resident if needed ...
                $parts = explode(' ', $avname);
                if (count( $parts ) == 1) {
                  $parts[] = 'Resident';
                  $avname = implode( ' ', $parts );
                }

                // try logging in this user
                $owner = new Owner($avname);
                $pwStatus = $owner->validatePassword($password);

                switch ($pwStatus) {
                    case PW_OK:
                        // handle continued login process
                        $content['uid'] = $owner->UserID();
                        $content['token'] = 'a1b2c3d4';

                        break;

                    case PW_USER_NOT_FOUND:
                        $content['error'] = "Username not found";
                        $status = 404;
                        break;

                    case PW_INVALID_PASSWORD:
                        $content['error'] = "Invalid password";
                        $status = 401;
                        break;

                    default:
                        $status = 500;
                        $content['error'] = 'Unknown error';
                        break;
                }

            }

            return array('content'=>$content, 'status'=>$status);

        } else {
            return array('content'=>'Only accepts POST', 'status'=>405);
        }
     }

 }