<?php
require_once __DIR__."/../repository/superLayer.php";
require_once __DIR__."/Conexion.php";

class Customer extends Superlayer{
		
  protected String $table;
  protected Database $dbh;

  function __construct(){
    $this->table = "user";
    $this->dbh = new Database;
  }

}