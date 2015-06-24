<?php 

class govt {
  public function getGovtStats() {
    $db = new database();
    $db->query("SELECT tbl_govt.*,
      sum(distinct tbl_pilot.balance) AS totalmemberbalance,
      count(distinct tbl_pilot.id) AS totalpilots,
      count(distinct tbl_syst.id) AS systems,
      count(distinct tbl_spob.id) AS spobs
      FROM tbl_govt
      LEFT JOIN tbl_pilot ON tbl_govt.id = tbl_pilot.govt
      LEFT JOIN tbl_syst ON tbl_govt.id = tbl_syst.govt
      LEFT JOIN tbl_spob ON tbl_syst.id = tbl_spob.parent
      GROUP BY tbl_govt.id;");
    $db->execute();
    return $db->resultSet();
  }

  public function listRelations() {
    $db = new database();
    $db->query("SELECT tbl_relations.*,
      target.name AS targetname,
      target.color AS targetcolor,
      target.color2 AS targetcolor2,
      subject.name AS subjectname,
      subject.color AS subjectcolor,
      subject.color2 AS subjectcolor2
      FROM tbl_relations
      LEFT JOIN tbl_govt AS target ON tbl_relations.target = target.id
      LEFT JOIN tbl_govt AS subject ON tbl_relations.subject = subject.id
      ORDER BY tbl_relations.subject");
    $db->execute();
    return $db->resultset();
  }

  public function addNewGovt() {
    //Last step
    $this->generateCSS();
  }

  public function generateCSS() {
    $db = new database();
    $db->query("SELECT tbl_govt.id,
      tbl_govt.isoname,
      tbl_govt.color,
      tbl_govt.color2
      FROM tbl_govt");
    $db->execute();
    $colors = $db->resultset();
    $css = '';
    foreach($colors as $gov) {
      $css.=".gov.$gov->isoname {";
      $css.="  color: #$gov->color;";
      $css.="  background: #$gov->color2;";
      $css.="}";
      $css.=".gov.$gov->isoname.inverse {";
      $css.="  color: #$gov->color2;";
      $css.="  background: #$gov->color;";
      $css.="}";
    }
    $handle = fopen("assets/css/govt.css","a+");
    ftruncate($handle,0);
    fwrite($handle,$css);
    fclose($handle);
  }

}