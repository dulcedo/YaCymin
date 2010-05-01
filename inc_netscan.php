<?php
/**
* YaCymin - YaCy Admin and Search 
* for PHP5 with cURL
* 
* v0.3
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

 Module: netscan
 
 
 INWORK

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


#echo "<h3>select</h3>";#
#echo "<p><a href=?action=peerlist>network</a></p>";
#echo "<a href=?action=netscan&verbose=true&peer=".$mypeer.">detailed scan</a>";

echo "</div>";

# content right
echo '<div style="float: right; width: '.(100-$leftmen).'%;">';



$mypeer=$_GET['peer'];
 
if (!$mypeer) 
{


######### TD se peer 0 ? ##########
  #echo "specify own peer plz";
  $mypeer="127.0.0.1:8080";
  #exit;
}
$timeout=$_GET['timeout'];
if (!$timeout) 
{
 $to=$timeout/1000;
}  else
{
 $to=0.5;
}

  $mypeer=$mypeer."/";
  
  $mycred=$_GET['id'];
  
  echo "<h3><font color=grey>Network status </font></h3>";
  #echo "<h4>from ".$mypeer."</h4>";
  
  $res=$search->setProperties($mypeer,$appid,$name,$to);
    
  $info=$search->ping($peerno);
  #$ti1=round(($search->_dur1*1000),0);
  
  #if status!
   
  $command="Network.xml?page=1&ip=";
  $results = $search->peerCommandDirect($mypeer,$command,$mycred);   #direct access via peer-address

  //now we have xml, put it in a simple array
  $resultarray=xml2array($results);  #, $get_attributes = 1, $priority = 'tag');
  
  //get items only
  $items=$resultarray['peers']['peer'];
  if ($items)
 {
 
  
 #counting
 foreach ($items as $item)
 {
   $scount++;
   $sppm= $sppm+$item['ppm'];
   $sqph= $sqph+$item['qph'];
   $slinks= $slinks+$item['links'];
   $swords= $swords+$item['words'];
      #echo "<td>".$item['uptime']."</td>";
  }
  if ($scount)
  {
   $dppm=round(($sppm/$scount),0);
   $dqph=round(($sqph/$scount),0);
   $dlinks=round(($slinks/1000000),0);
   $dwords=round(($swords/1000000),0);
 
   echo "<table border=0><tr><td>Counting ";
   echo $scount, " peers ";
   echo "from ".$mypeer." collecting and searching </td>";
   
   echo "<td>&nbsp;&nbsp;".$dlinks." murls</td>";
   echo "<td>&nbsp;".$dwords." mwords</td>";
   
   echo "<td>&nbsp; @ &nbsp;".$sppm." ppm</td>";
   echo "<td>&nbsp;".$sqph." qph</td>";
   
   echo "</tr></table>";
  }  
 
 
 foreach ($items as $item)
 {
   if ($_GET['verbose']=="true")
   {
    #$items=$search->ping();   #extended info    
    
    $peer=$item['address'];
    
    $res=$search->setProperties($peer,$appid,$name);
    
    $res=$search->ping($peerno);
    $ti1=round(($search->_dur1*1000),0);
  
    #echo $ti1;
    #exit;
    $extitems=$search->getProperties();      
    
    #echo "<br>".$search->_dur2;
    #print_r($extitems);
    #exit;
   }
  
   echo '<div class="blogtoy"><h2 class="widgetheader">';
  
   
   if ($tr=="ffffff") {$tr="aaaaaa";} else {$tr="ffffff";}
   echo "<table border=0 width=95%><tr>";
   
   #echo "<td>".$item['hash']."</td>";
   if ($item['direct']=="direct")
   {
    $di="<font color=orange>S</font>";
   } else
   {
    $di="<font color=green>S</font>";
   }

   
   $ti2=round(($search->_dur2*1000),0);
   switch ($ti1)
   {
      case ($ti1 > 300):
        $ti1="<font color=red>".$ti1."</font>";
      break;      

      case ($ti1 > 100):
        $ti1="<font color=orange>".$ti1."</font>";
      break;      
   }
       
   switch ($ti2)
   {
      case ($ti2 > 5000):
        $ti2="<font color=red>".$ti2."</font>";
      break;      

      case ($ti2 > 500):
        $ti2="<font color=orange>".$ti2."</font>";
      break;      
   }

 $links=round(($item['links']/1000000),1)."mio";

   echo "<td width=2%>".$di."</td>";
   echo "<td>".$item['fullname']."</td>";
   echo "<td width=18%><font size=1>&nbsp;(<font color=grey></font>".$ti1." <font color=grey> / </font>".$ti2." ms)</font></td>"; 
   echo "<td width=6% align=right><font color=grey>".$item['ppm']."&nbsp;</font></td>";
   echo "<td width=11%  align=right>".$links."</td>";
   echo "<td width=20% align=right>".$item['uptime']."</td>";
   
   echo "</font>";
   echo "</tr></table>";
   
   echo '</h2>';
   
   echo '<div class="innerwidget">';
   
   echo "<br><table border=1 width=100%><tr>";
      
   echo "<td>".$item['direct']."</td>";
   echo "<td>".$item['type']."</td>";
   echo "<td>".$item['version']."</td>";
   echo "<td>".$item['ppm']."</td>";
   echo "<td>".$item['qph']."</td>";
   echo "<td>".$item['uptime']."</td>";
   echo "<td>".$item['links']."</td>";
   echo "<td>".$item['words']."</td>";
   echo "<td>".$item['rurls']."</td>";
   echo "<td>".$item['lastseen']."</td>";
   echo "<td>".$item['sendWords']."</td>";
   echo "<td>".$item['receivedWords']."</td>";
   echo "<td>".$item['sendURLs']."</td>";
   echo "<td>".$item['receivedURLs']."</td>";
   
   echo "<td>".$item['acceptcrawl']."</td>";
   echo "<td>".$item['dhtreceive']."</td>";
   echo "<td>".$item['rankingreceive']."</td>";
#  # echo "<td>".$item['location']."</td>";
#  # echo "<td>".$item['seedurl']."</td>";
#   echo "<td>".$item['age']."</td>";
#   #echo "<td>".$item['seeds']."</td>";
#   #echo "<td>".$item['connects']."</td>";

   if ($ym_mode=="admin")
   {
    echo "<td><a href=# title='klick for details'>".$item['address']."</a></td>";
    echo "<td>".$item['useragent']."</td>";
   } 

   echo "</tr>"; 
   echo "</table>"; 
   echo "</div></div>";
   
  }
  
}

echo "</div>"; #div right