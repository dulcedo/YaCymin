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


* EXPERIMENTAL

*/ 
 
// Include the API PHP Library
require 'YaCyAPI4.php';
include 'JSON.php';

 
 
 # menu left
$leftmen="10"; #width% menu left
echo '<div style="float: left; width: '.$leftmen.'%;">';

echo'
<div id="navi-left">

	<h1 class="screenreader">left navigation</h1>
	<ul>
<li class="page_item page-item-1"><a href="#" title="Log">Log</a></li><br>
<li class="page_item page-item-2"><a href="#" title=""></a></li><br>
<li class="page_item page-item-3"><a href="#" title=""></a></li><br>

	</ul>
  
</div>';



echo "</div>";

# content right
echo '<div style="float: right; width: '.(100-$leftmen).'%;">';


 
 
//-----------------------------------------------------
// start the class 
$search = new YaCyAPI();

include 'peerlist_inc.php';


$peerno=$_GET['peer'];
$peer=$this_YaCyPeer[$peerno][0];
$port=$this_YaCyPeer[$peerno][1];
$appid=$this_YaCyPeer[$peerno][2];
$name=$this_YaCyPeer[$peerno][3];


echo "<h3><font color=grey>Log from ".$peer.":".$port."</font></h3>";

               $command="/ViewLog_p.json";
               $body = $search->peerCommanddirect($peer.":".$port,$command,$appid); 
                              
               $json = new Services_JSON();
               $json = $json->decode($body);
               
              # $jd = json_decode($json);
               #echo "json-last error".json_last_error();
               #var_dump ($json);
               #echo "J:".$json;
             $ll=$json->loglines;
             
             if ($ll) 
             {
             echo "<form><font face=arial><textarea rows=20 cols=120 readonly>";
                        
             foreach ($ll as $logline)
             {
              echo $logline->logline."\n";
              #echo $logline->loglevel." ";
          
             }
             echo "</textarea></font></form>";
             }

echo "</div>"; #content right