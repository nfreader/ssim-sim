<?php

class commod {

  public function listCommods(){
    $COMMOD_COST_MODIFIER = COMMOD_COST_MODIFIER;
    $db = new database();
    $db->query("SELECT tbl_commod.*,
      CASE WHEN tbl_commod.type = 'C' THEN 
      count(distinct tbl_commodspob.spob) END AS spobs,
      CASE WHEN tbl_commod.type = 'C' THEN
      sum(distinct tbl_commodspob.supply) END AS totalsupply,
      CASE WHEN tbl_commod.type = 'C' THEN
      floor(avg(tbl_commod.basecost * (tbl_commod.techlevel/tbl_spob.techlevel)/tbl_commodspob.supply * $COMMOD_COST_MODIFIER)) END AS avgcost
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

}