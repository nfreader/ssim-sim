<?php

class commod {

  public function getCommods() {
    $db = new database();
    $db->query("SELECT * FROM tbl_commod");
    $db->execute();
    return $db->resultset();
  }

  public function listCommods(){
    $COMMOD_COST_MODIFIER = COMMOD_COST_MODIFIER;
    $db = new database();
    $db->query("SELECT tbl_commod.*,
      CASE WHEN tbl_commod.type = 'C' THEN 
      count(distinct tbl_commodspob.spob) ELSE 1 END AS spobs,
      CASE WHEN tbl_commod.type = 'C' THEN
      sum(distinct tbl_commodspob.supply) ELSE tbl_commod.basesupply END AS totalsupply,
      CASE WHEN tbl_commod.type = 'C' THEN
      floor(avg(distinct tbl_commodspob.supply)) ELSE tbl_commod.basesupply END AS avgsupply,
      CASE WHEN tbl_commod.type = 'C' THEN
      floor(avg(tbl_commod.basecost * (tbl_commod.techlevel/tbl_spob.techlevel)/tbl_commodspob.supply * $COMMOD_COST_MODIFIER)) ELSE tbl_commod.basecost END AS avgcost
      FROM tbl_commod
      LEFT JOIN tbl_commodspob ON tbl_commod.id = tbl_commodspob.commod
      LEFT JOIN tbl_spob ON tbl_commodspob.spob = tbl_spob.id
      GROUP BY tbl_commod.id;");
    $db->execute();
    return $db->resultset();
  }

  public function getSpobCommods($spob) {
    $COMMOD_COST_MODIFIER = COMMOD_COST_MODIFIER;
    $db = new database();
    $db->query("SELECT
      tbl_commod.name,
      tbl_commod.type,
      tbl_commodspob.supply,
      tbl_commod.id,
      floor(tbl_commod.basecost * (tbl_commod.techlevel/tbl_spob.techlevel)/tbl_commodspob.supply * $COMMOD_COST_MODIFIER) as cost
      FROM tbl_commodspob
      LEFT JOIN tbl_commod ON tbl_commodspob.commod = tbl_commod.id
      LEFT JOIN tbl_spob ON tbl_commodspob.spob = tbl_spob.id
      WHERE tbl_commodspob.spob = :spob
      GROUP BY tbl_commodspob.commod");
    $db->bind(':spob',$spob,PDO::PARAM_INT);
    $db->execute();
    return $db->resultset();
  }

  public function spawnCommods($spob) {
    $spob = new spob($spob);
    $commods = $this->getcommods();
    $count = 0;
    $db = new database();
    $db->query("INSERT INTO tbl_commodspob (spob, commod, supply, lastchange) VALUES
      (:spob,:commod,:supply,NOW())");
    foreach ($commods as $commod) :
      if ($commod->techlevel <= $spob->techlevel && $commod->type == 'C') :
        $supplyLowerBound = $commod->basesupply-($commod->basesupply*COMMOD_DISTRIBUTION);
        $supplyUpperBound = $commod->basesupply+($commod->basesupply*COMMOD_DISTRIBUTION);
        $supply = floor(rand($supplyLowerBound,$supplyUpperBound));
        $db->bind(':spob',$spob->id,PDO::PARAM_INT);
        $db->bind(':commod',$commod->id,PDO::PARAM_INT);
        $db->bind(':supply',$supply,PDO::PARAM_INT);
        try {
          $db->execute();
          $count++;
        } catch (Exception $e) {
          return alert("Error: ".$e->getMessage(),2);
        }
      endif;
    endforeach;
    return alert("Added $count commods to $spob->name",1);
  }

  public function viewcommod($commod) {
    $COMMOD_COST_MODIFIER = COMMOD_COST_MODIFIER;
    $db = new database();
    $db->query("SELECT tbl_commod.*,
      CASE WHEN tbl_commod.type = 'C' THEN 
      count(distinct tbl_commodspob.spob) ELSE 1 END AS spobs,
      CASE WHEN tbl_commod.type = 'C' THEN
      sum(distinct tbl_commodspob.supply) ELSE tbl_commod.basesupply END AS totalsupply,
      CASE WHEN tbl_commod.type = 'C' THEN
      floor(avg(distinct tbl_commodspob.supply)) ELSE tbl_commod.basesupply END AS avgsupply,
      CASE WHEN tbl_commod.type = 'C' THEN
      floor(avg(tbl_commod.basecost * (tbl_commod.techlevel/tbl_spob.techlevel)/tbl_commodspob.supply * $COMMOD_COST_MODIFIER)) ELSE tbl_commod.basecost END AS avgcost,
      COUNT(distinct ssim_misn.id) AS missions
      FROM tbl_commod
      LEFT JOIN tbl_commodspob ON tbl_commod.id = tbl_commodspob.commod
      LEFT JOIN tbl_spob ON tbl_commodspob.spob = tbl_spob.id
      LEFT JOIN tbl_misn ON tbl_commod.id = tbl_misn.commod
      WHERE tbl_commod.id = :commod
      GROUP BY tbl_commod.id;");
    $db->bind('commod',$commod,PDO::PARAM_INT);
    $db->execute();
    $result = $db->single();
    $db->query("SELECT ssim_commodspob.*,
      ssim_spob.name,
      ssim_spob.id,
      CASE WHEN ssim_commod.type = 'C' THEN 
      floor((ssim_commod.basecost * (ssim_commod.techlevel/ssim_spob.techlevel  )/ssim_commodspob.supply * $COMMOD_COST_MODIFIER)) END AS cost
      FROM ssim_commodspob
      LEFT JOIN ssim_spob ON ssim_commodspob.spob = ssim_spob.id
      LEFT JOIN ssim_commod ON ssim_commodspob.commod = ssim_commod.id
      WHERE ssim_commod.id = :commod");
    $db->bind('commod',$commod,PDO::PARAM_INT);
    $db->execute();
    $result->spobs = $db->resultset();
    $db->query("SELECT ssim_commodtransact.*,
      (CASE ssim_commodtransact.onspob
      WHEN FALSE
      THEN ssim_syst.name
      ELSE ssim_spob.name
      END) AS locationname,
      ssim_pilot.name AS pilotname
      FROM ssim_commodtransact
      LEFT JOIN ssim_commod ON ssim_commodtransact.commod = ssim_commod.id
      LEFT JOIN ssim_spob ON ssim_commodtransact.location = ssim_spob.id
      LEFT JOIN ssim_syst ON ssim_commodtransact.location = ssim_syst.id
      LEFT JOIN ssim_pilot ON ssim_commodtransact.pilot = ssim_pilot.id
      WHERE ssim_commod.id = :commod
      ORDER BY ssim_commodtransact.timestamp DESC
      LIMIT 0,5;");
    $db->bind('commod',$commod,PDO::PARAM_INT);
    $db->execute();
    $result->transactions = $db->resultset();
    return $result;
  }

  public function generateCommodStats(){
    $db = new database();
    $db->query("INSERT INTO tbl_commodstats 
      (stats, timestamp) VALUES (:stats, NOW())");
    foreach($this->listcommods() as $commod) :
      $stat['commodname'] = $commod->name;
      $stat['commod'] = $commod->id;
      $stat['avgcost'] = $commod->avgcost;
      $stat['supply'] = $commod->totalsupply;
      $stat['avgsupply'] = $commod->avgsupply;
      $stats[] = $stat;
    endforeach;
    $db->bind(':stats',json_encode($stats,JSON_NUMERIC_CHECK));
    $db->execute();
  }

  public function getCommodStatData(){
    $db = new database();
    $db->query("SELECT * FROM tbl_commodstats LIMIT 0,5");
    $db->execute();
    return $db->resultset();
  }

}