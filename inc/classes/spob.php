<?php 

class spob {

  public function listSpobs() {
    $db = new database();
    $db->query("SELECT * FROM tbl_spob");
    $db->execute();
    return $db->resultset();
  }

}