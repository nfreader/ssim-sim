<?php 

class spob {

  public function listSpobs() {
    $db = new database();
    $db->query("SELECT tbl_spob.*,
    CASE WHEN tbl_spob.can_be_homeworld IS TRUE THEN 'Yes' ELSE '' END AS homeworld FROM tbl_spob");
    $db->execute();
    return $db->resultset();
  }

}