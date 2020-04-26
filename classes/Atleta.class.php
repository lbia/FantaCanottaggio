<?php

class Atleta {

  private $nome;
  private $cognome;

  public function __contruct($nome, $cognome){
    $this->nome = $nome;
    $this->$cognome = $cognome;
  }

  public function getNome(){
    return $this->nome;
  }
  public function getCognome(){
    return $this->$cognome;
  }
}
