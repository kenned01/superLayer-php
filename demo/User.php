<?php
require_once __DIR__."/../repository/superLayer.php";
require_once __DIR__."/../repository/Conexion.php";

class User extends Superlayer{
		

  function __construct(){
    $this->table = "user";
    $this->db = new Database;
  }

}