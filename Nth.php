<?php

class Nth {

    private $url;
    private $username;
    private $password;
    private $serviceCode;
    private $phone;

    public $callBackWapIdentifyUser;
    public $callBackWapAuthorize;
    public $callBackWebAuthorize;

    public function __construct() {
        $this->url = ''; //Server and port example:https://mp.mobile-gw.com:8080
        $this->username = ''; //Username from your account
        $this->password = ''; //Password from your account
        $this->serviceCode = ''; //Service code from your account
        
        $this->callBackWapIdentifyUser = ''; //Url to back from check valid phone
        $this->callBackWapAuthorize = ''; //Url Authenticate Wap
        $this->callBackWebAuthorize = ''; ////Url Authenticate Wep
    }

    public function wapIdentifyUser($userIp) {
        $data = array(
            'command' => 'wapIdentifyUser',
            'username' => $this->username,
            'password' => $this->password,
            'serviceCode' => $this->serviceCode,
            'userIp' => $userIp,
            'callbackUrl' => $this->callBackWapIdentifyUser
        ); 

        $curl = curl_init($this->url);                                                                            
        curl_setopt($curl, CURLOPT_POST, true);                                                             
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));                                    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                                   
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json', 'Accept: application/xml'));   
        $response = curl_exec($curl);                                                                       
        curl_close($curl);    

        $json = json_decode($response, true);
        $uid = $json['uid'];
        $redirectUrl = $json['redirectUrl'];    

        return array($uid,$redirectUrl);
    }

    public function getUser($uid) {
        $data = array(
            'command' => 'getUser',
            'username' => $this->username,
            'password' => $this->password,
            'serviceCode' => $this->serviceCode,
            'uid' => $uid
        ); 

        $curl = curl_init($this->url);                                                                            
        curl_setopt($curl, CURLOPT_POST, true);                                                             
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));                                    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                                   
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json', 'Accept: application/xml'));   
        $response = curl_exec($curl);                                                                       
        curl_close($curl);                                                                                 

        $json = json_decode($response, true);
        $status = $json['user']['status'];
        $msisdn = $json['user']['msisdn'];
        return array($status, $msisdn);
        //Unidentified
        //Identified
    }

    public function wapAuthorize($userIp, $price, $msisdn, $operatorCode, $uid) {
        $data = array(
            'command' => 'wapAuthorize',
            'username' => $this->username,
            'password' => $this->password,
            'serviceCode' => $this->serviceCode,
            'userIp' => $userIp,
            'price' => $price,
            'msisdn' => $msisdn,
            'operatorCode' => $operatorCode,
            'uid' => $uid,
            'callbackUrl' => $this->callBackWapAuthorize
        );          

        $curl = curl_init($this->url);                                                                            
        curl_setopt($curl, CURLOPT_POST, true);                                                             
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));                                    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                                   
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json', 'Accept: application/xml'));   
        $response = curl_exec($curl);                                                                       
        curl_close($curl);                                                                                  
    
        $json = json_decode($response, true);
        $sessionId = $json['sessionId'];
        $redirectUrl = $json['redirectUrl'];  
        return array($sessionId, $redirectUrl);
    }

    public function webAuthorize($userIp, $price, $msisdn, $operatorCode) {
        $data = array(
            'command' => 'webAuthorize',
            'username' => $this->username,
            'password' => $this->password,
            'serviceCode' => $this->serviceCode,
            'userIp' => $userIp,
            'price' => $price,
            'msisdn' => $msisdn,
            'operatorCode' => $operatorCode,
            'callbackUrl' => $this->callBackWebAuthorize
        );          

        $curl = curl_init($this->url);                                                                            
        curl_setopt($curl, CURLOPT_POST, true);                                                             
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));                                    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                                   
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json', 'Accept: application/xml'));   
        $response = curl_exec($curl);                                                                       
        curl_close($curl);                                                                                  
      
        $json = json_decode($response, true);
        $sessionId = $json['sessionId'];
        $redirectUrl = $json['redirectUrl'];  
        return array($sessionId, $redirectUrl);
    }

    public function getSubscription($sessionId) {
        $data = array(
            'command' => 'getSubscription',
            'username' => $this->username,
            'password' => $this->password,
            'serviceCode' => $this->serviceCode,
            'sessionId' => $sessionId
        );          

        $curl = curl_init($this->url);                                                                            
        curl_setopt($curl, CURLOPT_POST, true);                                                             
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));                                    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                                   
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json', 'Accept: application/xml'));   
        $response = curl_exec($curl);                                                                       
        curl_close($curl);                                                                                  
        //return $response;      
        return $response;
    }

    public function checkSubscription($msisdn) {
        $data = array(
            'command' => 'getSubscription',
            'username' => $this->username,
            'password' => $this->password,
            'serviceCode' => $this->serviceCode,
            'msisdn' => $msisdn
        );          

        $curl = curl_init($this->url);                                                                            
        curl_setopt($curl, CURLOPT_POST, true);                                                             
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));                                    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                                   
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json', 'Accept: application/xml'));   
        $response = curl_exec($curl);                                                                       
        curl_close($curl);                                                                                  
        
        $json = json_decode($response, true);
        $subscriptionId = $json['subscription']['subscriptionId'];
        $statusText = $json['subscription']['statusText'];
        $statusNumber = $json['subscription']['statusNumber'];

        return array($subscriptionId, $statusText, $statusNumber);
    }

    public function checkSubscription_($msisdn) {
        $data = array(
            'command' => 'getSubscription',
            'username' => $this->username,
            'password' => $this->password,
            'serviceCode' => $this->serviceCode,
            'msisdn' => $msisdn
        );          

        $curl = curl_init($this->url);                                                                            
        curl_setopt($curl, CURLOPT_POST, true);                                                             
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));                                    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                                   
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json', 'Accept: application/xml'));   
        $response = curl_exec($curl);                                                                       
        curl_close($curl);      
        
        $json = json_decode($response, true);
        $resultCode = $json['resultCode'];
        
        return $resultCode;
    }

    public function paymentAuthorize($uid, $price) {
        $data = array(
            'command' => 'paymentAuthorize',
            'username' => $this->username,
            'password' => $this->password,
            'serviceCode' => $this->serviceCode,
            'price' => $price,
            'uid' => $uid
        );          

        $curl = curl_init($this->url);                                                                            
        curl_setopt($curl, CURLOPT_POST, true);                                                             
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));                                    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                                   
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json', 'Accept: application/xml'));   
        $response = curl_exec($curl);                                                                       
        curl_close($curl);                                                                                  
        //return $response;      
        return $response;
    }

    public function redirectGetUser($action) {
        //list($uid, $redirectUrl) = $action;
        return $action;
    }
    public function redirectWap($action) {
        //list($uid, $redirectUrl) = $action;
        return $action;
    }
    public function redirectWep($action) {
        //list($uid, $redirectUrl) = $action;
        return $action;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getPhone() {
        return $this->phone;
    }

}
