<?php 

$ships = array(
  array(
    'Name'=>'Shuttlecraft',
    'shields'=>25,
    'armor'=>100,
    'Outfits'=>array(
      array(
        'Name'=>'Basic Laser Cannon',
        'Type'=>'WPN',
        'Projectile'=>'E', //Energy particle projectile
        'Damage'=>4,
        'Reload'=>1, //Can fire every tick
      ),
      array(
        'Name'=>'Illegal Hacked Laser Cannon',
        'Type'=>'WPN',
        'Projectile'=>'E',
        'Damage'=>10,
        'Reload'=>2 //Can fire every other tick
      ),
      array(
        'Name'=>'Flare launcher',
        'Type'=>'BCM', //Ballistic countermeasures
        'Projectile'=>'M', //Missile-type projectile
        'Ammo'=>10,
        'Reload'=>1,
        'Evasion'=>.25,
      ),
      array(
        'Name'=>'Radar Jammer',
        'Type'=>'ECM', //Electronic countermeasures
        'Evasion'=>.5,
        'Reload'=>2,
      ),
      array(
        'Name'=>'Greeble',
        'Type'=>'DEC', //Decoration
      )    
    ),
    'accel'=>5,
    'turn'=>2,
    'mass'=>150,
    'Flee'=>100, //armor percentage at which they will attempt to flee (user defined)
  ),
  array(
    'Name'=>'Shuttlecraft (Modified blockade runner)',
    'shields'=>25,
    'armor'=>100,
    'Outfits'=>array(
      array(
        'Name'=>'Flare launcher',
        'Type'=>'BCM', //Ballistic countermeasures
        'Projectile'=>'M', //Missile-type projectile
        'Ammo'=>10,
        'Evasion'=>.25,
      ),
      array(
        'Name'=>'Radar Jammer',
        'Type'=>'ECM', //Electronic countermeasures
        'Evasion'=>.5,
      ),
      array(
        'Name'=>'Radar Jammer',
        'Type'=>'ECM', //Electronic countermeasures
        'Evasion'=>.5,
      ),
      array(
        'Name'=>'Radar Jammer',
        'Type'=>'ECM', //Electronic countermeasures
        'Evasion'=>.5,
      ),
      array(
        'Name'=>'Afterburner',
        'Type'=>'PPE',
        'accel'=>.5,
      ),
      array(
        'Name'=>'Greeble',
        'Type'=>'DEC', //Decoration
      )    
    ),
    'accel'=>7.5,
    'turn'=>2,
    'mass'=>150,
    'Flee'=>40, //armor percentage at which they will attempt to flee (user   defined)
  ),
  array(
    'Name'=>'Cargo Drone',
    'shields'=>10,
    'armor'=>10,
    'Outfits'=>array(),
    'accel'=>3.5,
    'turn'=>1,
    'mass'=>45,
    'Flee'=>40, //armor percentage at which they will attempt to flee (user   defined)
  ),
    array(
    'Name'=>'Brixton-Class Frigate',
    'shields'=>250,
    'armor'=>400,
    'Outfits'=>array(
      array(
        'Name'=>'Flare launcher',
        'Type'=>'BCM', //Ballistic countermeasures
        'Projectile'=>'M', //Missile-type projectile
        'Ammo'=>10,
        'Evasion'=>.25,
      ),
      array(
        'Name'=>'Enhanced Shield Projector',
        'Type'=>'SEM', //Shield Enhancement
        'shields'=>.3,
      ),
      array(
        'Name'=>'Railgun',
        'Type'=>'WPN', //Ballistic countermeasures
        'Projectile'=>'E', //Missile-type projectile
        'Damage'=>40,
        'Reload'=>2
      ),  
    ),
    'accel'=>10,
    'turn'=>7,
    'mass'=>1500,
    'Flee'=>40, //armor percentage at which they will attempt to flee (user   defined)
  ),
);