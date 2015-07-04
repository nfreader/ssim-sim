<?php

class pilot{

  private $full;

  public $id;
  public $name;
  public $govt;
  public $balance;
  public $vessel; 
  public $status; 
  public $vesselname;
  public $govtname;
  public $govtisoname;
  public $locationtype;

  public function __construct($id=NULL,$full=NULL) {
    $this->full = $full;
    if ($id) {
      $pilot = $this->getPilot($id);
      $this->id = $pilot->id;
      $this->name = $pilot->name;
      $this->govt = $pilot->govt;
      $this->balance = $pilot->balance;
      $this->vessel = $pilot->vessel; 
      $this->status = $pilot->status; 
      $this->vesselname = $pilot->vesselname;
      $this->govtname = $pilot->govtname;
      $this->govtisoname = $pilot->govtiso;
      $this->location = $pilot->location;
      $this->locationname = $pilot->locationname;
      $this->locationtype = $pilot->locationtype;
      $this->statuschange = $pilot->statuschange;
      $this->fingerprint = hexprint($pilot->name.$pilot->creationdate);
      if ($this->full) {

      }
    }
  }

  public function getPilot($id) {
    $db = new database();
    $query = 
    $db->query("SELECT ssim_pilot.*,
      ssim_vessel.name AS vesselname,
      ssim_vessel.fuel,
      ssim_govt.name AS govtname,
      ssim_govt.isoname AS govtiso,
      CASE
      WHEN ssim_pilot.status = 'O' THEN ssim_syst.name
      WHEN ssim_pilot.status = 'L' THEN ssim_spob.name
      WHEN ssim_pilot.status = 'N' THEN NULL
      WHEN ssim_pilot.status = 'B' THEN NULL
      END AS locationname,
      ssim_spob.type AS locationtype
      FROM ssim_pilot
      LEFT JOIN ssim_vessel ON ssim_pilot.vessel = ssim_vessel.id
      LEFT JOIN ssim_govt ON ssim_pilot.govt = ssim_govt.id
      LEFT JOIN ssim_spob ON ssim_pilot.location = ssim_spob.id
      LEFT JOIN ssim_syst ON ssim_pilot.location = ssim_syst.id
      WHERE ssim_pilot.id = :id");
    $db->bind(':id',$id,PDO::PARAM_INT);
    $db->execute();
    return $db->single();
  }

  public function listPilots() {
    $db = new database();
    $query = 
    $db->query("SELECT tbl_pilot.*,
      tbl_vessel.name AS vesselname,
      tbl_ship.name AS shipname,
      tbl_ship.shipwright,
      tbl_ship.class,
      tbl_vessel.integrity,
      tbl_ship.armor,
      tbl_ship.shields,
      tbl_ship.cargobay,
      tbl_ship.fueltank,
      tbl_vessel.fuel,
      tbl_govt.name AS govtname,
      tbl_govt.isoname AS govtiso,
      tbl_govt.color AS govtcolor,
      tbl_govt.color2 AS govtcolor2
      FROM tbl_pilot
      LEFT JOIN tbl_vessel ON tbl_pilot.vessel = tbl_vessel.id
      LEFT JOIN tbl_ship ON tbl_vessel.ship = tbl_ship.id
      LEFT JOIN tbl_govt ON tbl_pilot.govt = tbl_govt.id");
    $db->execute();
    return $db->resultSet();
  }

}
