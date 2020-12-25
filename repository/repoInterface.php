<?php
	
interface Repository {
  public function add(Array $data);
  public function delete(Array $keys);
  public function update(Array $data);
  public function getOne(Array $keys, Array $colums = []);
  public function getAll(Array $colums = []);
}