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
  public $fuelgraph;
  public $fuel;
  public $fueltank;
  public $shieldgraph;

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
      $this->fuel = $vessel->fuel;
      $this->fueltank = $vessel->fueltank;
      $this->fuelgraph = $vessel->fuelgraph;
      $this->shieldgraph = $vessel->shieldgraph;
      $this->armorgraph = $vessel->armorgraph;
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
      tbl_ship.fueltank,
      (tbl_vessel.fuel/tbl_ship.fueltank) * 100 AS fuelgraph,
      ((tbl_ship.shields - tbl_vessel.shielddam) / tbl_ship.shields) * 100 AS shieldgraph,
      ((tbl_ship.armor - tbl_vessel.armordam) / tbl_ship.armor) * 100 AS armorgraph,
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
    $db->query("SELECT tbl_vesseloutfit.*,
      tbl_outfit.*
      FROM tbl_vesseloutfit
      LEFT JOIN tbl_outfit ON tbl_vesseloutfit.outfit = tbl_outfit.id
      WHERE tbl_vesseloutfit.vessel = :id");
    $db->bind(':id',$id,PDO::PARAM_INT);
    $db->execute();
    return $db->resultset();
  }

  function parseOutfits($id){
    $vessel = $this->getVessel($id);
    $vessel->outfits = $this->getVesselOutfits($id);
    //Calculate base evasion
    //((accel*turn)/mass) * 5
    $vessel->baseEvasion = round((($vessel->accel*$vessel->turn)/$vessel->mass) * 5,2);
    $vessel->evasionModifier = 0;
    $vessel->firepower = 0;
    foreach($vessel->outfits AS $outf) {
      if ($outf->type == 'ECM') {
        if ($outf->data1) {
        $vessel->evasionModifier = $vessel->evasionModifier + ($vessel->baseEvasion + ($outf->data1 / 100));
        $outf->reload = $outf->data2;
        }
      }
      if ($outf->type == 'WPN') {
        if($outf->data1) {
          $vessel->firepower = $vessel->firepower + $outf->data1;
        }
        if ($outf->data2 == 1) {
          $outf->reload = NULL;
        } 
      }
    }
    $vessel->Evasion = $vessel->baseEvasion*$vessel->evasionModifier;
    return $vessel;
  }

}
