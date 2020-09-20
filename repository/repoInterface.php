<?php
	
interface Repository {
  public function add(Array $data);
  public function delete(int $data, String $identifier);
  public function update(Array $data);
  public function getOne(int $data, String $identifier);
  public function getAll();
}