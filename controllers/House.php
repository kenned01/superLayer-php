<?php
require_once __DIR__."/../repository/superLayer.php";
require_once __DIR__."/Conexion.php";

class House extends Superlayer{
		
  protected String $table;
  protected Database $dbh;

  function __construct(){
    $this->table = "house";
    $this->dbh = new Database;
  }

}