<?php

class syst {

  public function listSysts() {
    $db = new database();
    $db->query("SELECT
      tbl_syst.*,
      tbl_govt.name AS govtname,
      CONCAT('#',tbl_govt.color) AS color,
      CONCAT('#',tbl_govt.color2) AS color2
      FROM tbl_syst
      LEFT JOIN tbl_govt ON tbl_syst.govt = tbl_govt.id;");
    $db->execute();
    return $db->resultSet();
  }

}