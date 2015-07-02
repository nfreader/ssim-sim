<?php 

class spob {

  private $json;

  public $id;
  public $name;
  public $parent;
  public $parentname;
  public $type;
  public $fulltype;
  public $govtid;
  public $govtname;
  public $govtiso;
  public $color;
  public $color2;
  public $commods;
  public $techlevel;
  public $govtseat;

  public function __construct($id=null,$full=false,$json=false) {
    if ($id) :
      $spob = $this->getSpob($id);
      $this->id = $spob->id;
      $this->name = $spob->name;
      $this->parent = $spob->parent;
      $this->parentname = $spob->syst;
      $this->type = $spob->type;
      $this->fulltype = spobtype($spob->type);
      $this->govtid = $spob->govtid;
      $this->govtiso = $spob->govtiso;
      $this->color = $spob->govtcolor;
      $this->color2 = $spob->govtcolor2;
      $this->govtseat = $spob->govtseat;
      $this->techlevel = $spob->techlevel;
      $this->govtname = $spob->govt;
      if ($full === true) :
        $commod = new commod();
        $this->commods = $commod->getSpobCommods($id);
      endif;
    endif;
    if ($json === TRUE) :
      $this->json = TRUE;
    endif;
  }

  public function createSpob($name,$parent,$techlevel) {
    $commod = new commod();
    $comod->spawnCommods($id);
  }

  public function listSpobs() {
    $db = new database();
    $db->query("SELECT
      tbl_spob.*,
      tbl_syst.name AS syst,
      tbl_govt.name AS govt,
      tbl_govt.id AS govtid,
      tbl_govt.isoname AS govtiso,
      tbl_govt.color AS govtcolor,
      tbl_govt.color2 AS govtcolor2,
      tbl_govt.type AS govttype,
      IF (tbl_govt.govtseat = tbl_spob.id,TRUE,FALSE) AS govtseat,
      CASE WHEN tbl_spob.can_be_homeworld IS TRUE THEN 'Yes' ELSE ''
      END AS homeworld
      FROM tbl_spob
      LEFT JOIN tbl_syst ON tbl_spob.parent = tbl_syst.id
      LEFT JOIN tbl_govt ON tbl_syst.govt = tbl_govt.id");
    $db->execute();
    return $db->resultset();
  }

  public function getSpob($id) {
    $db = new database();
    $db->query("SELECT
      tbl_spob.*,
      tbl_syst.name AS syst,
      tbl_govt.name AS govt,
      tbl_govt.id AS govtid,
      tbl_govt.isoname AS govtiso,
      tbl_govt.color AS govtcolor,
      tbl_govt.color2 AS govtcolor2,
      IF (tbl_govt.govtseat = tbl_spob.id,TRUE,FALSE) AS govtseat
      FROM tbl_spob
      LEFT JOIN tbl_syst ON tbl_spob.parent = tbl_syst.id
      LEFT JOIN tbl_govt ON tbl_syst.govt = tbl_govt.id
      WHERE tbl_spob.id = :id");
    $db->bind(':id',$id,PDO::PARAM_INT);
    $db->execute();
    if ($this->json === TRUE) :
      return json_encode($db->single(),JSON_NUMERIC_CHECK);
    else :
      return $db->single();
    endif;
  }
}