<?php

require_once __DIR__."/repoInterface.php";

class Superlayer implements Repository  {
  #
  # inherited class needs the property table defined
  #

  /**
   * @var db must be an instance of Conexion
  */
  protected $db = null;

  /**
   * @var table must be the table name of your database
  */
  protected $table = "";

  /**
   * if set to false, it will hide all errors
   * 
   * @var showError default true
   * 
  */
  protected $showError = true;

  /**
   * @param $data must be an Array (key -> value);
  */
  public function add(Array $data){

    try {
      $keys = array_keys( $data );
      $insert = "(";
      $values = "(";

      for ($i=0; $i< count( $keys ) ; $i++ ){
        $insert .= " `$keys[$i]`";
        $values .= " :$keys[$i]";
        if($i != count( $keys ) -1 ){
          $insert .= ", ";
          $values .= ", ";
        }
      }

      $insert .= ")";
      $values .= ")";

      $query = "INSERT INTO `$this->table` $insert VALUES $values";

      //now we have our query we gotta bind the data to be inserted
      $this->db->query( $query );
      for($i = 0; $i < count ( $keys ) ; $i++ ){
        $this->db->bind(":$keys[$i]", $data[ $keys[$i] ] );
      }
      $this->db->execute();

      return true;
    } catch (PDOException $th) {
      if($this->showError){
        echo $th->getMessage();
      }

      return false;
    }
  }

  /**
   * Deletes one rows of the table
   * @param Array $keys (key/value) to be used for the delete sentence
   * @example "" [ "identifier_column" => "column content" ]
  */
  public function delete(Array $keys){
    try {

      $keys2 = array_keys($keys);
      $this->db->query("DELETE FROM `$this->table` WHERE `$keys2[0]` = :data ;");
      $this->db->bind(":data",  $keys[ $keys2[0] ] );
      
      $this->db->execute();
      return true;
    } catch (PDOException $th) {
      if($this->showError){
        echo $th->getMessage();
      }
      return false;
    }
  }

  /**
   * @param Array $data be an Array (key -> value)
   * the first position/value must the the id of the 
   * row that is intented to be updated
   * @example ""
   * [
   *  "id" => 999,
   *  "other" => "other"
   * ]
  */
  public function update(Array $data){

    try {
      $keys = array_keys( $data );
      $update = "";

      for ($i=1; $i< count( $keys ) ; $i++ ){
        $update .= " `$keys[$i]` = :$keys[$i] ";

        if($i != count( $keys ) -1 ){
          $update .= ", ";
        }
      }


      $query = "UPDATE `$this->table` SET $update WHERE `$keys[0]` = :$keys[0];";

      //now we have our query we gotta bind the data to be inserted
      $this->db->query( $query );
      for($i = 0; $i < count ( $keys ) ; $i++ ){
        $this->db->bind(":$keys[$i]", $data[ $keys[$i] ] );
      }
      $this->db->execute();

      return true;
    } catch (PDOException $th) {
      if($this->showError){
        echo $th->getMessage();
      }
      return false;
    }
  }

  /**
   * Returns one row of the table
   * 
   * @param Array $keys (key/value) list of the desire filter
   * @example "" [ "identifier_column" => "column content" ]
   * 
   * @param Array $columns *optional List of the columns to be fetched
   * @example "" ["id", "name", "creaton_date"]
  */
  public function getOne(Array $keys, Array $columns = []){
    try {

      $keys2 = array_keys($keys);
      $columnsSQl = $this->columnsQuery($columns);

      $this->db->query("SELECT $columnsSQl FROM `$this->table` WHERE `$keys2[0]` = :data ;");
      $this->db->bind(":data", $keys[ $keys2[0] ]);
      
      return $this->db->registro();
    } catch (PDOException $th) {
      
      if($this->showError){
        echo $th->getMessage();
      }

      return null;
    }
  }
  
  /**
   * Returns every row of the table
   * @param Array $columns *optional List of the columns to be fetched
   * @example "" ["id", "name", "creaton_date"]
  */
  public function getAll(Array $columns = []){
    try {

      $columnsSQl = $this->columnsQuery($columns);
      
      $this->db->query("SELECT $columnsSQl FROM `$this->table`;");
      return $this->db->registros();
    } catch (PDOException $th) {
      
      if($this->showError){
        echo $th->getMessage();
      }

      return array();
    }
  }

  private function columnsQuery(Array $columns = [] ){
    
    $columnsSQl = "";

    // construct columns query 
    // so that it can be fetched
    if( count($columns) > 0 ){
      for($i = 0; $i < count($columns); $i++){
        $columnsSQl .= $columns[$i];

        if( $i != (count($columns) - 1) ){
          $columnsSQl .= ",";
        }
      }


    }else{
      $columnsSQl =  "*";
    }

    return $columnsSQl;
  }

}