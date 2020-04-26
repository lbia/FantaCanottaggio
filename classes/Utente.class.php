<?php

class Utente {

  private $username;

  public $regNomi = array();
  public $regCognomi = array();
  public $nazNomi = array();
  public $nazCognomi = array();

  public function __construct($username){
    $this->username = $username;
  }

  public function getUsername(){
    return $this->username;
  }
}
