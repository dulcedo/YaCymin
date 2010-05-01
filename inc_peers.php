<?php
/**
* YaCymin - YaCy Admin and Search 
* for PHP5 with cURL
* 
* v0.4
*
* Copyright (c) 2010 yacy.net / dulcedo
* URL: http://yacymin.walamt.de

* Permission is hereby granted, free of charge, to any person
* obtaining a copy of this software and associated documentation
* files (the "Software"), to deal in the Software without
* restriction, including without limitation the rights to use,
* copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the
* Software is furnished to do so, subject to the following
* conditions:

* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.

  peer status overview

*/ 

// Include the API PHP Library
require 'YaCyAPI4.php';
#include 'JSON.php';

//-----------------------------------------------------
// start the class 
$search = new YaCyAPI();

//-----------------------------------------------------
// show overview
echo "<h3><font color=grey>&nbsp;".date('d-m H:i',time())."</font></h3>";
  
//-----------------------------------------------------
// 
include 'peerlist_inc.php';
 
if($_GET['first'])  #
{
  $peerno=0;
  $peer=$this_YaCyPeer[$peerno][0];
  $port=$this_YaCyPeer[$peerno][1];
  $appid=$this_YaCyPeer[$peerno][2];
  $name=$this_YaCyPeer[$peerno][3];
  
  
  
  $res=$search->setProperties($mypeer,$appid,$name);
    
  $info=$search->ping($peerno);
  #$ti1=round(($search->_dur1*1000),0);
  
  #if status!
  $mypeer="http://".$peer.":".$port."/";  
  $command="Network.xml?page=1&ip=";
  $results = $search->peerCommandDirect($mypeer,$command,$appid);   #direct access via peer-address

  //now we have xml, put it in a simple array
  $resultarray=xml2array($results);  #, $get_attributes = 1, $priority = 'tag');
  
  //get items only
  $items=$resultarray['peers']['peer'];
  if ($items)
  {
    echo count($items);

    while ($ccount<$_GET['first']) 
    {
     $ccount=$ccount+1;
     $peer=$items[$ccount]['address'];
     echo "<br>".$ccount."-".$peer;
    }
  }

}
else
{
 $maxpeers=count($this_YaCyPeer)+1; #local inst
 
 for ($peerno=0;$peerno<$maxpeers;$peerno++)
 {
 
  $peer=$this_YaCyPeer[$peerno][0];
  $port=$this_YaCyPeer[$peerno][1];
  $appid=$this_YaCyPeer[$peerno][2];
  $name=$this_YaCyPeer[$peerno][3];
  
  #-------------------------------------------------------------------------------
  $res=$search->setProperties($peer.":".$port,$appid,$name);
  $info=$search->ping();
  

  if ($info['host'])     #peer defined?
  {
    require('inc_onepeer.php');
    ###########
  } # end if peer defined  

 } #end for peerno

}#ind if param-first
?>