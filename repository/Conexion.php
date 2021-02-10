<?php
	
//Clase to connect the Database
// using PDO
  
class Database {
  private $host = "localhost";
  private $usuario = "root";
  private $password = "";
  private $nombre_bd = "p_curso";
    
  private $dbh; // Database Handler
  private $stmt;  //Statement
  private $error;

  public const INT_TYPE = PDO::PARAM_INT;
  public const BOOL_TYPE = PDO::PARAM_BOOL;
  public const NULL_TYPE = PDO::PARAM_NULL;
  public const STR_TYPE = PDO::PARAM_STR;

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

  /**
   * Set query
   * @param String $sql 
  */
  public function query($sql){
    $this->stmt = $this->dbh->prepare($sql);
  }

  /**
   * Show the full query
  */
  public function showQuery(){
    return  $this->stmt->fullQuery;
  }

  /**
   * Include all the data into the query by binding them
   * @param Param | String | Param Name
   * @param Value | Any Type | Param Value
   * @param Type  | Param Type | opcional
  */
  public function bind($param, $value, $type=null){

    if (is_null($type)) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
        break;

        case is_bool($value):
          $type = PDO::PARAM_BOOL;
        break;

        case is_null($value):
          $type = PDO::PARAM_NULL;
        break;
        
        default:
            $type = PDO::PARAM_STR;
        break;
      }
    }

    $this->stmt->bindValue($param, $value , $type);

  }

  /**
   * Execute the estament
  */
  public function execute(){
    $this->stmt->execute();
  }

  /**
   * Return the id of the last inserted row
   * @return Number
  */
  public function lastId(){
    $this->execute();
    return   $this->dbh->lastInsertId(); 
  }

  /**
   * Return the multiples rows
   * @return Object-Array
  */
  public function fetchAll(){
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }	

  /**
   * Return One row
   * @return Object
  */
  public function fetchOne(){
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  /**
   * Return number of rows
   * @return Number
  */
  public function count(){
    $this->execute();
    return $this->stmt->rowCount();
  }

}
