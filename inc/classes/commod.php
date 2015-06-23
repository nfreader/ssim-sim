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

}