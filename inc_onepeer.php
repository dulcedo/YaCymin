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
  INCLUDED

*/ 

   $t="Showing peer-name / address and time for a ping / time for executing commands / peer uptime. Click for more infos.";
   echo '<div class="blogtoy"><h2 title=" '.$t.' "class="widgetheader">';
   
   
   if ($info['status'])                                             #peer online
   {
      echo "<table border=0 width=100%><tr><td width=35%>";   
      $items=$search->getProperties();
      $info['name']=$items['name'];
      $x="?action=peer&peer=".$peerno;
      echo "<a href='".$x."'>";
      if ($info['name'])
      {
        echo "<font color=black><i>".$info['name']."</i> is </font>";
      } else {
        echo $info['host'].":".$info['port']." is ";     
      } 
      echo "</a>";          
      echo "<font color=green>on</font>";
        
      echo "</td><td>";
      $ti1=round(($search->_dur1*1000),0);
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
      
      
     #staus now  / measurement
     #$status=$search->getStatus();     

     # Array ( [ppm] => 36 [wordCacheSize] => 19192 [wordCacheMaxSize] => 100000 [loaderqueue] => Array ( [size] => 2 [max] => 50 ) [localcrawlerqueue] => Array ( [size] => 147040 ) [limitcrawlerqueue] => Array ( [size] => 0 ) [remotecrawlerqueue] => Array ( [size] => 0 ) [memory] => Array ( [free] => 882057936 [total] => 6534856704 [max] => 6632243200 ) [processors] => 4 [traffic] => Array ( [in] => 0 [proxy] => 0 [crawler] => 0 ) )
     #print_r($status);
     #exit;
     
      
      echo "<font size=1>&nbsp;(<font color=grey>ping:</font>".$ti1." <font color=grey>cmd:</font>".$ti2." ms)</font></td>"; 
      echo "<td align = right>";      
      echo " ".$items['uptime']."&nbsp;&nbsp;&nbsp;";     
      echo "</td></tr></table>";
      
     } 
     else               #peer offline
     { 
        echo "<table border=0 width=100%><tr><td width=35%>";   
        if ($info['name'])
        {
          echo "<i>".$info['name']."</i> is ";
        } else {
           echo $info['host'].":".$info['port']." is ";     
        } 

        echo "<font color=red>off";
        echo "</font>"; 
        echo '&nbsp;<a href=?action=SSH&host='.$info['host'].' title="SSH"><img src=images/cats.png></a>';
        echo "</td></tr></table>";
        
     } #end if peer
     
     

     
     echo '</h2>';
     echo '<div class="innerwidget">';

     if ($info['status']) {
       echo "<div align=center><h4>Peer Details:</h4>";       
       echo $items['type']." ".$items['name']." (".$info['host'].":".$info['port'].")";
       echo "&nbsp;subversion:" .$items['version'];
       echo "<br>links/words: ".$items['links']."/".$items['words']."&nbsp;-&nbsp;";
       if ($items['acceptindex']) echo "accepts DHT-in ";
       if ($items['acceptcrawl']) echo "is remote crawling";
 
       echo "<br><a href=http://".$info['host'].":".$info['port']."/Status.html>Admin</a>";
       echo "&nbsp;- <a href=?action=stats&peer=".$peerno.">Stats</a>"; 
       echo "&nbsp;- <a href=?action=log&peer=".$peerno.">Log</a>";
       echo "&nbsp;- <a href=?action=SSH&host=".$info['host'].">SSH</a>";
 
       if ($ym_mode=="admin"){
        echo "&nbsp;- <a href=?action=tools&update=".$peerno."><font color=orange>Update</font></a>"; 
        echo "&nbsp;- <a href=http://".$info['host'].":".$info['port']."/Steering.html?restart=><font color=orange>Restart</font></a>"; 
        echo "&nbsp;- <a href=http://".$info['host'].":".$info['port']."/Steering.html?shutdown=1><font color=red>Shutdown</font></a>"; 
        echo "&nbsp;- <a href=http://".$info['host'].":".$info['port']."/Status.html?pauseCrawlJob=&jobType=localCrawl><font color=orange>Pause</font></a>"; 
        echo "&nbsp;- <a href=http://".$info['host'].":".$info['port']."/Status.html?continueCrawlJob=&jobType=localCrawl><font color=green>Continue</font></a>"; 
        
       }  #http://localhost:8092/Status.html?pauseCrawlJob=&jobType=localCrawl
 
       echo "<br><img src=http://".$info['host'].":".$info['port']."/Banner.png?textcolor=000000&bgcolor=ddeeee&bordercolor=aaaaaa>";   
       
       #$qlocal= number_format($status['localcrawlerqueue']['size'], 0, ",", ".");
       #$qglobal= number_format($status['limitcrawlerqueue']['size'], 0, ",", ".");
       #$qremote= number_format($status['remotecrawlerqueue']['size'], 0, ",", ".");
       #echo "<br>&nbsp;Crawler local:".$qlocal." - global:".$qglobal." - remote:".$qremote;
  
       
       echo "</div>"; 
 
      # to fold it in:
      
     #  echo '<div class="blogtoy">';
	   #  echo '<h2 class="widgetheader"><font>Performance...</font></h2>';
	   #  echo '<div class="innerwidget">';
 
       echo '<center><iframe src="http://'.$info['host'].":".$info['port'].'/rssTerminal.html?set=PEERNEWS,REMOTESEARCH,LOCALSEARCH,REMOTEINDEXING,LOCALINDEXING,INDEXRECEIVE&amp;width=600px&amp;height=180px&amp;maxlines=20&amp;maxwidth=120"
              style="width:600px;height:180px;margin:0px;border:1px solid black;" scrolling="no" name="newsframe"></iframe><br />';
              
       echo "<p><img src=http://".$info['host'].":".$info['port']."/PerformanceGraph.png></p>";  
       echo "</center><hr>";
      
      # echo '</div></div>';  #unfold
   }
   else
   {
      echo "Offline";
   }
   echo "</div></div>";   #blogtoy
   
