<?php

class ship {

  public function getCargoBounds() {
    $db = new database();
    $db->query("SELECT max(tbl_ship.cargobay) AS MAX,
      min(tbl_ship.cargobay) AS MIN
      FROM tbl_ship");
    $db->execute();
    return $db->single();
  }

}