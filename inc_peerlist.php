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

*/ 
// Include the API PHP Library
require 'YaCyAPI4.php';
#include 'JSON.php';

//-----------------------------------------------------
// start the class 
$search = new YaCyAPI();

# menu left

$leftmen="10"; #width% menu left
echo '<div style="float: left; width: '.$leftmen.'%;">';

echo'
<div id="navi-left">

	<h1 class="screenreader">left navigation</h1>
	<ul>
<li class="page_item page-item-1"><a href="?action=peerlist" title="Overwiew">Overview</a></li><br>
<li class="page_item page-item-2"><a href="?action=netscan&verbose=true&peer=" title="Detailed">Detailed</a></li><br>
<li class="page_item page-item-3"><a href="#" title=""></a></li><br>

	</ul>
  
</div>';

#echo "<h3>select</h3>";
#echo "<p><a href=?action=peerlist>network</a></p>";
#echo "<p><a href=?action=netscan&verbose=true&peer=".$mypeer.">detailed scan</a></p>";

echo "</div>";

# content right
echo '<div style="float: right; width: '.(100-$leftmen).'%;">';

echo "<h3><table width=100%><tr><td><font color=grey>Active peers in network </font></td>";
#echo "<td align=right><a href=?action=netscan&verbose=true&peer=".$mypeer.">detailed scan</a>&nbsp;</td></tr></table></h3>";
echo "</tr></table></h3>";

include 'peerlist_inc.php';

$command="Network.xml?page=1&ip=";
$peerno="0";
$peer=$this_YaCyPeer[$peerno][0];
$port=$this_YaCyPeer[$peerno][1];
$appid=$this_YaCyPeer[$peerno][2];
$name=$this_YaCyPeer[$peerno][3];
$peername="http://".$peer.":".$port."/";

$res=$search->setProperties($peer.":".$port,$appid,$name);
$info=$search->ping();
  
if ($info['host'])     #peer defined?
{

$results = $search->peerCommandDirect($peername,$command,$appid); 

//now we have xml, put it in a simple array
$resultarray=xml2array($results);  #, $get_attributes = 1, $priority = 'tag');
  
 //get items only
$items=$resultarray['peers']['peer'];
if ($items)
{
  echo "<table>";
  foreach ($items as $item)
  {
   if ($tr=="ffffff") {$tr="aaaaaa";} else {$tr="ffffff";}
   
   echo "<tr bgcolor=#".$tr.">";
   #echo "<td>".$item['hash']."</td>";
   echo "<td>".$item['fullname']."</td>";
   echo "<td>".$item['type']."</td>";
   echo "<td>".$item['version']."</td>";
   echo "<td>".$item['ppm']."</td>";
   echo "<td>".$item['qph']."</td>";
   echo "<td>".$item['uptime']."</td>";
   echo "<td>".$item['links']."</td>";
   echo "<td>".$item['words']."</td>";
   #echo "<td>".$item['rurls']."</td>";
   #echo "<td>".$item['lastseen']."</td>";
   #echo "<td>".$item['sendWords']."</td>";
   #echo "<td>".$item['receivedWords']."</td>";
   #echo "<td>".$item['sendURLs']."</td>";
   #echo "<td>".$item['receivedURLs']."</td>";
   
   echo "<td>".$item['direct']."</td>";
   echo "<td>".$item['acceptcrawl']."</td>";
   echo "<td>".$item['dhtreceive']."</td>";
   echo "<td>".$item['rankingreceive']."</td>";
   # echo "<td>".$item['location']."</td>";
   # echo "<td>".$item['seedurl']."</td>";
   echo "<td>".$item['age']."</td>";
   #echo "<td>".$item['seeds']."</td>";
   #echo "<td>".$item['connects']."</td>";
   if ($ym_mode=="admin")
   {
    echo "<td><a href=# title='klick for details'>".$item['address']."</a></td>";
    echo "<td>".$item['useragent']."</td>";
   } 
   echo "</tr>"; 
  }
  echo "</table>";
  
} #end for

} #end if peer online

echo "</div>"; #div right
