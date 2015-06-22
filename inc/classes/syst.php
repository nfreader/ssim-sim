<?php

class syst {

  public function listSysts() {
    $db = new database();
    $db->query("SELECT
      tbl_syst.*,
      tbl_govt.name AS govtname,
      CONCAT('#',tbl_govt.color) AS hexcolor,
      CONCAT('#',tbl_govt.color2) AS hexcolor2,
      tbl_govt.color,
      tbl_govt.color2
      FROM tbl_syst
      LEFT JOIN tbl_govt ON tbl_syst.govt = tbl_govt.id
      ORDER BY ssim_syst.id");
    $db->execute();
    return $db->resultSet();
  }

}