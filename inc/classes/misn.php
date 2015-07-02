<?php

class misn {

  public function generatemissions($count) {
    $commod = new commod();
    $commods = $commod->listcommods();
    $spob = new spob();
    $spobs = $spob->listspobs();

    $db = new database();
    $db->query("INSERT INTO tbl_misn (commod, amount, pickup, dest, reward, status, uid, lastchange, created) VALUES(:commod,:amount,:pickup,:dest,:reward,'N',:uid,NOW(),NOW())");
    $i = 0;
    while ($i < $count) :
      $pickup = pick($spobs);
      $dest = pick($spobs);
      if($dest === $pickup) {
        $dest = pick($spobs);
      }

      $commod = pick($commods);

      $ship = new ship();
      $cargobounds = $ship->getcargobounds();

      $amount = floor(rand(1,$cargobounds->MAX));
      $reward = $amount * floor(rand($commod->avgcost*.95,$commod->avgcost*1.05));

      if ($dest->govttype == 'P') {
        $reward = $reward * 2;
        echo "Pirate port destination! Reward doubled! ";
      }

      if ($dest->techlevel < $commod->techlevel || $pickup->techlevel < $commod->techlevel) :
        echo "Aborting mission creation.<br>";
      else :
        echo "Take $amount tons of $commod->name from $pickup->name to $dest->name for $reward credits<br>";

        $db->bind(':commod',$commod->id,PDO::PARAM_INT);
        $db->bind(':amount',$amount,PDO::PARAM_INT);
        $db->bind(':pickup',$pickup->id,PDO::PARAM_INT);
        $db->bind(':dest',$dest->id,PDO::PARAM_INT);
        $db->bind(':reward',$reward,PDO::PARAM_INT);
        $db->bind(':uid',hexprint($commod->id.$dest->id.$pickup->id.$amount.$reward),PDO::PARAM_STR);
        $db->execute();
        $i++;
      endif;
    endwhile;
  }

  public function getmissions($offset=0,$limit=100) {
    $COMMOD_COST_MODIFIER = COMMOD_COST_MODIFIER;
    $db = new database();
    $db->query("SELECT tbl_misn.uid,
      tbl_misn.amount,
      tbl_misn.reward,
      tbl_misn.dest,
      tbl_misn.pickup,
      tbl_commod.type,
      floor((tbl_commod.basecost * (tbl_commod.techlevel/dest.techlevel)/tbl_commodspob.supply * $COMMOD_COST_MODIFIER)) AS unitprice,
      CASE WHEN tbl_commod.type = 'C' THEN 
      (SELECT unitprice) * tbl_misn.amount ELSE tbl_commod.basecost * tbl_misn.amount END AS actualvalue,
      (SELECT actualvalue) - tbl_misn.reward AS diff,
      tbl_commod.name AS commodname,
      pickup.name AS pickupname,
      dest.name AS destname
      FROM tbl_misn
      LEFT JOIN tbl_commod ON tbl_misn.commod = tbl_commod.id
      LEFT JOIN tbl_spob AS pickup ON tbl_misn.pickup = pickup.id
      LEFT JOIN tbl_spob AS dest ON tbl_misn.dest = dest.id
      LEFT JOIN tbl_commodspob ON tbl_misn.dest = tbl_commodspob.spob
      ORDER BY tbl_misn.amount
      AND tbl_misn.reward
      LIMIT $offset,$limit;");
    $db->execute();
    return $db->resultset();
  }

}