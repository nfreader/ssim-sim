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
  public $shipname;
  public $shipwright;
  public $class;
  public $integrity;
  public $armor;
  public $shields;
  public $cargobay;
  public $fueltank;
  public $fuel;
  public $govtname;
  public $govtisoname;
  public $govtcolor;

  public function __construct($id=NULL,$full=NULL) {
    $this->full = $full;
    if ($id) {
      if ($this->full) {

      }
    }
  }

  public function getPilot($id) {

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
