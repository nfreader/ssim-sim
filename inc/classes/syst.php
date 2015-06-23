<?php

class syst {

  public function listSysts() {
    $db = new database();
    $db->query("SELECT
      tbl_syst.*,
      CASE WHEN tbl_syst.govt IS NULL THEN 'None' ELSE tbl_govt.name END AS govtname,
      CONCAT('#',tbl_govt.color) AS hexcolor,
      CONCAT('#',tbl_govt.color2) AS hexcolor2,
      tbl_govt.color,
      tbl_govt.color2,
      count(distinct tbl_spob.id) AS spobs
      FROM tbl_syst
      LEFT JOIN tbl_govt ON tbl_syst.govt = tbl_govt.id
      LEFT JOIN tbl_spob ON tbl_syst.id = tbl_spob.parent
      GROUP BY tbl_syst.id
      ORDER BY tbl_syst.id;");
    $db->execute();
    return $db->resultSet();
  }

}