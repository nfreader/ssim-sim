<?php 

$ships = array(
  array(
    'Name'=>'Shuttlecraft',
    'Shields'=>25,
    'Armor'=>100,
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
    'Accel'=>5,
    'Turn'=>2,
    'Mass'=>150,
    'Flee'=>100, //Armor percentage at which they will attempt to flee (user defined)
  ),
  array(
    'Name'=>'Shuttlecraft (Modified blockade runner)',
    'Shields'=>25,
    'Armor'=>100,
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
        'Accel'=>.5,
      ),
      array(
        'Name'=>'Greeble',
        'Type'=>'DEC', //Decoration
      )    
    ),
    'Accel'=>7.5,
    'Turn'=>2,
    'Mass'=>150,
    'Flee'=>40, //Armor percentage at which they will attempt to flee (user   defined)
  ),
  array(
    'Name'=>'Cargo Drone',
    'Shields'=>10,
    'Armor'=>10,
    'Outfits'=>array(),
    'Accel'=>3.5,
    'Turn'=>1,
    'Mass'=>45,
    'Flee'=>40, //Armor percentage at which they will attempt to flee (user   defined)
  ),
    array(
    'Name'=>'Brixton-Class Frigate',
    'Shields'=>250,
    'Armor'=>400,
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
        'Shields'=>.3,
      ),
      array(
        'Name'=>'Railgun',
        'Type'=>'WPN', //Ballistic countermeasures
        'Projectile'=>'E', //Missile-type projectile
        'Damage'=>40,
        'Reload'=>2
      ),  
    ),
    'Accel'=>10,
    'Turn'=>7,
    'Mass'=>1500,
    'Flee'=>40, //Armor percentage at which they will attempt to flee (user   defined)
  ),
);