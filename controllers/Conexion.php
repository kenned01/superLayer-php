<?php
	
//Clase para conectarse a la base de datos y ejecutar consultas PDO
  
class Database {
  private $host = "localhost";
  private $usuario = "root";
  private $password = "";
  private $nombre_bd = "test";
    
  private $dbh; // Database Handler
  private $stmt;  //Statement
  private $error;


  function __construct()  {
      // Primero configuramos la conecion
      $dsn = "mysql:host=$this->host;dbname=$this->nombre_bd";

      $opciones = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      );

      try {
        $this->dbh = new PDO ($dsn, $this->usuario, $this->password, $opciones);
        $this->dbh->exec('set names utf8');

      } catch (PDOException $e){
        $this->error = $e->getMessage();
        echo $this->error;
      }

  }



  // Preparamos la consulta
  public function query($sql){
    $this->stmt = $this->dbh->prepare($sql);
  }

  public function showQuery(){
    return  $this->stmt->fullQuery;
  }

  // Vinculamos la consulta con bind
  public function bind($parametro, $valor, $tipo=null){

    if (is_null($tipo)) {
      switch (true) {
        case is_int($valor):
          $tipo = PDO::PARAM_INT;
        break;

        case is_bool($valor):
          $tipo = PDO::PARAM_BOOL;
        break;

        case is_null($valor):
          $tipo = PDO::PARAM_NULL;
        break;
        
        default:
            $tipo = PDO::PARAM_STR;
        break;
      }
    }

    $this->stmt->bindValue($parametro, $valor , $tipo);

  }

  // Ejecutamos la consulta
  public function execute(){
  
    return $this->stmt->execute();
  }

  // Ultimo_ID_insertado
  public function lastId(){
    $this->execute();
    return   $this->dbh->lastInsertId(); 
  }

  // Devuelve varios registros
  public function registros(){
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }	

  // Devuelve un solo Registro
  public function registro(){
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  // Devuelve total de registros 
  public function contar(){
    $this->execute();
    return $this->stmt->rowCount();
  }

}
