<?php

class vessel {

  private $full;
  private $json;

  public $id;
  public $pilot;
  public $pilotname;
  public $name;
  public $registration;
  public $status;
  public $ship;
  public $shipname;
  public $shipclass;
  public $class;
  public $shipwright;
  public $cargo;
  public $outfits;
  public $image;
  public $turn;
  public $accel;
  public $mass;

  public function __construct($id=NULL,$full=false,$json=FALSE) {
    $this->json = $json;
    $this->full = $full;
    if ($id) :
      $vessel = $this->getVessel($id);
      $this->id = $vessel->id;
      $this->pilot = $vessel->pilot;
      $this->name = $vessel->name;
      $this->registration = $vessel->registration;
      $this->status = $vessel->status;
      $this->ship = $vessel->ship;
      $this->shipname = $vessel->shipname;
      $this->shipclass = $vessel->shipclass;
      $this->class = shipclass($vessel->shipclass)['class'];
      $this->shipwright = $vessel->shipwright;
      $this->pilotname = $vessel->pilotname;
      $this->image = $vessel->image;
      $this->turn = $vessel->turn;
      $this->accel = $vessel->accel;
      $this->mass = $vessel->mass;
      $this->armor = $vessel->armor;
      $this->shields = $vessel->shields;
        if ($this->full) {
          $this->cargo = $this->getVesselCargo($id);
          $this->outfits = $this->getVesselOutfits($id);
        }
    endif;
  }

  public function getVessel($id) {
    $db = new database();
    $db->query("SELECT tbl_vessel.*,
      tbl_ship.name AS shipname,
      tbl_ship.shipwright,
      tbl_ship.class AS shipclass,
      tbl_ship.image,
      tbl_ship.accel,
      tbl_ship.turn,
      tbl_ship.mass,
      tbl_ship.armor,
      tbl_ship.shields,
      tbl_pilot.name AS pilotname
      FROM tbl_vessel
      LEFT JOIN tbl_ship ON tbl_vessel.ship = tbl_ship.id
      LEFT JOIN tbl_pilot ON tbl_vessel.pilot = tbl_pilot.id
      WHERE tbl_vessel.id = :id");
    $db->bind(':id',$id,PDO::PARAM_INT);
    $db->execute();
    return $db->single();
  }

  public function getVesselCargo($id) {
    $db = new database();
    $db->query("SELECT tbl_vesselcargo.*,
      tbl_commod.*
      FROM tbl_vesselcargo
      LEFT JOIN tbl_commod ON tbl_vesselcargo.commod = tbl_commod.id
      WHERE tbl_vesselcargo.vessel = :id");
    $db->bind(':id',$id,PDO::PARAM_INT);
    $db->execute();
    return $db->resultset();
  }

  public function getVesselOutfits($id) {
    $db = new database();
    $db->query("SELECT ssim_vesseloutfit.*,
      ssim_outfit.*
      FROM ssim_vesseloutfit
      LEFT JOIN ssim_outfit ON ssim_vesseloutfit.outfit = ssim_outfit.id
      WHERE ssim_vesseloutfit.vessel = :id");
    $db->bind(':id',$id,PDO::PARAM_INT);
    $db->execute();
    return $db->resultset();
  }


}
