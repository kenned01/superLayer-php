<?php

require_once __DIR__."/repoInterface.php";

class Superlayer implements Repository  {
  #
  # inherited class needs the property table defined
  #

  /**
   * Parameter must be an Array (key -> value);
  */
  public function add(Array $data){

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
    $this->dbh->query( $query );
    for($i = 0; $i < count ( $keys ) ; $i++ ){
      $this->dbh->bind(":$keys[$i]", $data[ $keys[$i] ] );
    }
    $this->dbh->execute();
  }

  /**
   * Deletes one rows of the table
  */
  public function delete(int $data, String $identifier){
    try {
      $this->dbh->query("DELETE FROM `$this->table` WHERE `$identifier` = :data ;");
      $this->dbh->bind(":data", $data);
      
      $this->dbh->execute();
    } catch (PDOException $th) {
      echo $th->getMessage();
    }
  }

  /**
   * Parameter must be an Array (key -> value)
   * the first position/value must the the id of the 
   * row that is intented to be updated
   * [
   *  "id" => 999,
   * "other" => "other"
   * ]
  */
  public function update(Array $data){
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
    $this->dbh->query( $query );
    for($i = 0; $i < count ( $keys ) ; $i++ ){
      $this->dbh->bind(":$keys[$i]", $data[ $keys[$i] ] );
    }
    $this->dbh->execute();
  }

  /**
   * Returns one row of the table
  */
  public function getOne(int $data, String $identifier){
    try {
      $this->dbh->query("SELECT * FROM `$this->table` WHERE `$identifier` = :data ;");
      $this->dbh->bind(":data", $data);
      
      return $this->dbh->registro();
    } catch (PDOException $th) {
      echo $th->getMessage();
      return null;
    }
  }
  
  /**
   * Returns every row of the table
  */
  public function getAll(){
    try {
      $this->dbh->query("SELECT * FROM `$this->table`;");
      return $this->dbh->registros();
    } catch (PDOException $th) {
      echo $th->getMessage();
      return array();
    }
  }
}