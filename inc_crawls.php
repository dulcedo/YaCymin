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

 echo "<h3><font color=grey>&nbsp;&nbsp;My YaCy-Crawls</font></h3>";
 
  // show crawl profiles ---------------------------------------
  
 include 'peerlist_inc.php';
 $maxpeers=count($this_YaCyPeer)+1; #local inst


for ($peerno=0;$peerno<$maxpeers;$peerno++)
{
  $peer=$this_YaCyPeer[$peerno][0];
  $port=$this_YaCyPeer[$peerno][1];
  $appid=$this_YaCyPeer[$peerno][2];
  $name=$this_YaCyPeer[$peerno][3];
     
   $res=$search->setProperties($peer.":".$port,$appid,$name);
   $info=$search->ping($peerno);
   
   
   if ($info['status']=="1")
   { 
   
     #$itm=$search->peerInfo($peerno);   #extended info 
     $itm=$search->getProperties();      
     $info['name']=$itm['name'];

     $status=$search->getStatus();  
     if (!$status)
     {
      $qlocal="-";
      $qglobal="-";
     } else {
      $qlocal= number_format($status['localcrawlerqueue']['size'], 0, ",", ".");
      $qglobal= number_format($status['limitcrawlerqueue']['size'], 0, ",", ".");
     }

     $items=$search->crawlInfo();

   
    echo '<div class="blogtoy"><h2 class="widgetheader" title="Show peer crawler queues and profiles or start new crawls">';
    echo '<table border=0 width=90%><tr>';
    echo '<td>';
    if ($info['name'])
     {
       echo " <i>".$info['name']."</i>";
     } else {
       echo " ".$info['host'].":".$info['port']." ";
     }
   echo '</td><td align=right width=20%>';
    
   echo "( ".$qlocal." / ".$qglobal.")";
   echo '</td><td align=right width=20%>'; 
    if ($items) 
    {
     echo "<font size=1>&nbsp;( <font color=grey>".count($items)."  profiles </font>)</font>";      
    }else
    {
     echo "<font size=1>&nbsp;( <font color=grey>locked </font>)</font>";      
    }
   echo '</td>';
   
   echo "</font>";
   echo '</tr></table>';
   echo '</h2>';
   
    
    if ($items) 
    {   

    echo '<div class="innerwidget">';
        
    #echo '<div>' ;  #menu left    
    #echo '</div>';  #end menu left
     # menu left
     
$leftmen="12"; #width% menu left
echo '<div style="float: left; width: '.$leftmen.'%;">';

#$pp='http://127.0.0.1:8080';
$pp="http://".$peer.":".$port;             # @,$appid
echo'
<div id="navi-left">

	<h1 class="screenreader">left navigation</h1>
	<ul>
<li class="page_item page-item-1"><a href="'.$pp.'/IndexCreateParserErrors_p.html" title="Crawl/Parser Errors">errors</a></li><br>
<li class="page_item page-item-2"><a href="'.$pp.'/CrawlResults.html?process=5" title="Local Crawl Results">local</a></li><br>
<li class="page_item page-item-3"><a href="'.$pp.'/CrawlResults.html?process=3" title="DHT Transfers">dht</a></li><br>
<li class="page_item page-item-3"><a href="'.$pp.'/CrawlResults.html?process=2" title="Search Crawl">search</a></li><br>
<li class="page_item page-item-4"><a href="'.$pp.'/CrawlResults.html?process=4" title="Proxy Crawl Results">proxy</a></li><br>
<li class="page_item page-item-5"><a href="'.$pp.'/CrawlResults.html?process=6" title="Global Crawl Results">global</a></li><br>
<li class="page_item page-item-6"><a href="'.$pp.'/CrawlResults.html?process=1" title="Reverse Global Crawl Results">reverse</a></li><br>

	</ul>
  
</div>';

echo "</div>";

# content right
echo '<div style="float: right; width: '.(100-$leftmen).'%;">';


        
    echo "<h4><a href=?action=newcrawl&peer=".$peerno.">Start new Crawl on #".$info['host'].":".$info['port']."</a></h4>";
     echo "<table cellspacing=2>";
     foreach ($items as $item)
     {
      if ( substr($item['name'],0,7) =="snippet"  || substr($item['name'],0,5) =="proxy"  || substr($item['name'],0,7) =="remote"|| substr($item['name'],0,10) =="surrogates")
      {  } else
       {      
       if ($tr=="ffffff") {$tr="aaaaaa";} else {$tr="ffffff";}
       echo "<tr bgcolor=#".$tr.">";
       #echo "<td>".$item['hash']."</td>";
       echo "<td>".$item['status']."</td>";
       echo "<td>".$item['name']."</td>";
       #echo "<td>".$item['starturl']."</td>";
       echo "<td>".$item['depth']."</td>";
       echo "<td>".$item['mustmatch']."</td>";
       #echo "<td>".$item['mustnotmatch']."</td>";
       echo "<td>".$item['crawlingIfOlder']."</td>";
       #echo "<td>".$item['crawlingDomFilterDepth']."</td>";
       #echo "<td>".$item['crawlingDomFilterContent']."</td>";
       #echo "<td>".$item['DomMaxPages']."</td>";
       #echo "<td>".$item['withQuery']."</td>";
       #echo "<td>".$item['storeCache']."</td>";
       #echo "<td>".$item['indexText']."</td>";
       #echo "<td>".$item['indexMedia']."</td>";
       echo "<td>".$item['remoteIndexing']."</td>";
       echo "</tr>"; 
     } 
     }
     echo "</table>";  


    echo "</div>"; #content right
 
     
     echo "</div>";  #innerwidget
   }
   else
   {
     #echo "locked.";
   }
    
    #echo "<br>X:";
  
 # ' print_r($items);
  
 echo "</div>";   #blogtoy
 
}


  
} #end for peerno

