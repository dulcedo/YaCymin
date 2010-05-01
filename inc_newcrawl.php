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
#include 'JSON.php';



 # menu left
$leftmen="10"; #width% menu left
echo '<div style="float: left; width: '.$leftmen.'%;">';

echo'
<div id="navi-left">

	<h1 class="screenreader">left navigation</h1>
	<ul>
<li class="page_item page-item-1"><a href="?action=newcrawl&peer='.$_GET['peer'].'" title="Crawls">New</a></li><br>
<li class="page_item page-item-2"><a href="?action=crawls&auto=" title="Auto">Auto</a></li><br>
<li class="page_item page-item-3"><a href="#" title=""></a></li><br>

	</ul>
  
</div>';


#echo "<h3>select</h3>";#
#echo "<p><a href=?action=peerlist>network</a></p>";
#echo "<a href=?action=netscan&verbose=true&peer=".$mypeer.">detailed scan</a>";

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
     
$res=$search->setProperties($peer.":".$port,$appid,$name);
$info=$search->ping($peerno); 
   
if ($info['status']=="1")
{ 
 
 $items=$search->crawlInfo($peerno);
   
  echo '<h3><font color=grey>&nbsp;Start new crawl on '.$info['host'].':'.$info['port'].'</font></h3><br>';
 
 echo '<form name="Crawler" action="http://'.$info['appid']."@".$info['host'].':'.$info['port'].'/Crawler_p.html" method="post" enctype="multipart/form-data">';

 echo '<div class="blogtoy">';
 
 echo '<h2 class="widgetheader">From URL: <input id="crawlingURL" name="crawlingURL" type="text" size="40" maxlength="256" value="http://" />';
 echo '&nbsp;&nbsp;Depth: <input name="crawlingDepth" id="crawlingDepth" type="text" size="2" maxlength="2" value="1" />';
 echo '&nbsp;&nbsp;Remote: <input type="checkbox" name="crawlOrder" id="crawlOrder"  />';
 
 echo '&nbsp;&nbsp;<input type="submit" name="crawlingstart" value="Start" />';
 echo '</h2>';
 echo '<div class="innerwidget">';
 
 #  search form CrawlStart_p.html
 #----------------------------------------------------------------------------------------
 ?>    
    <table border=0 width=100% cellspacing="0">            
   <tr bgcolor=#cccccc><td colspan=3>&nbsp;</td></tr>           
   <tr bgcolor=#cccccc>
       <td width=1%></td>
       <td width=40%>
              
       <input type="radio" name="range" value="wide" checked="checked" />&nbsp;Must match:&nbsp;
      <input name="mustmatch" id="mustmatch" type="text" size="20" maxlength="100" value=".*" />
       </td>
       
      <td >
			 <input type="radio" name="range" value="domain" />&nbsp;or match start domain&nbsp;&nbsp;
			 <input type="radio" name="range" value="subpath" />&nbsp;or match sub path
      </td>
       
</tr><tr bgcolor=#cccccc>
        <td></td>
        <td colspan=2>Must not match:&nbsp;<input name="mustnotmatch" id="mustnotmatch" type="text" size="20" maxlength="100" value="" />
        </td>
</tr><tr bgcolor=#cccccc>
     <td></td>
<td><input type="checkbox" name="crawlingQ" id="crawlingQ" checked="checked" />&nbsp;Accept dynamic URLs (?=)</td>
         
          <td>
            <label for="indexText">Index Text</label>:
            <input type="checkbox" name="indexText" id="indexText" checked="checked" />&nbsp;&nbsp;&nbsp;
            <label for="indexMedia">Index Media</label>:
            <input type="checkbox" name="indexMedia" id="indexMedia" checked="checked" />
          
          </td>
          

</tr><tr> <td colspan=2>&nbsp;    


</td>     

</tr>
</table>

<div class="blogtoy">
	<h4 class="widgetheader"><font>Advanced crawling options...</font></h4>
	<div class="innerwidget">
  

<table>
<tr>   
  <td>
           
            <input type="checkbox" name="crawlingDomFilterCheck" id="crawlingDomFilterCheck"  />&nbsp;&nbsp;AutoDom Filter
            </td><td>
            <label for="crawlingDomFilterDepth">Depth</label>:
            <input name="crawlingDomFilterDepth" id="crawlingDomFilterDepth" type="text" size="2" maxlength="2" value="1" />

            <input type="checkbox" name="crawlingDomMaxCheck" id="crawlingDomMaxCheck"  />&nbsp;&nbsp;
            max.pages:
            <input name="crawlingDomMaxPages" id="crawlingDomMaxPages" type="text" size="6" maxlength="6" value="10000" />
            </td>
</td>

</tr><tr>
<td><input type="checkbox" name="crawlingIfOlderCheck" id="crawlingIfOlderChecked"  />&nbsp;Re-crawl known URLs:</td>
          <td>
        If older than: <input name="crawlingIfOlderNumber" id="crawlingIfOlderNumber" type="text" size="7" maxlength="7" value="3" />
			<select name="crawlingIfOlderUnit">
              <option value="year"   >Year(s)</option>
              <option value="month"  selected="selected">Month(s)</option>
              <option value="day"    >Day(w)</option>
              <option value="hour"   >Hour(s)</option>
			</select>
          </td>
          
</tr><tr>
          <td><input type="checkbox" name="storeHTCache" id="storeHTCache"  />&nbsp;Store in web-cache</td>
          

        <td>
          
			<input type="radio" name="cachePolicy" value="nocache" />no&nbsp;cache&nbsp;&nbsp;&nbsp;
			<input type="radio" name="cachePolicy" value="iffresh" checked="checked" />if&nbsp;fresh&nbsp;&nbsp;&nbsp;
			<input type="radio" name="cachePolicy" value="ifexist" />if&nbsp;exist&nbsp;&nbsp;&nbsp;
			<input type="radio" name="cachePolicy" value="cacheonly" />cache&nbsp;only
		  </td>
  
  </tr><tr>
  
           
 
 </tr><tr>          
          
          <td colspan=2>
          <input type="checkbox" name="xsstopw" id="xsstopw" checked="checked" />&nbsp;Exclude static stop-words

          </td>
          
</tr><tr>          
          
           
           
  </tr>

</table>

</div>
</div>


 


<?php         

 
 
 echo "</div></div>"; #end blogtoy
 
 echo '</form>';

#echo '<h2>Crawl start preview</h2> 

echo '<center><div class="iframe"><iframe id="content_iframe" marginWidth=0 marginHeight=0 src="" frameBorder=0 width=1024 height=480></iframe></div></center>';



 }else {
  echo "peer offline";
 } #endif peer online

//------
echo '
<div class="blogtoy">
	<h2 class="widgetheader"><font color=grey>Help</font></h2>
	<div class="innerwidget">
  <p>Start new crawls using a simplified CrawlStart form.
  <br>Enter URL, crawling-depth and enable remote-crawling if desired.
  <br>Expand display for advandced crawling options.
  </p>
  
	</div>
</div>
';
echo "</div>"; #content right

?>
<script>
$('#crawlingURL').keyup(function() {
var Wert= $('#crawlingURL').val();
$('#content_iframe').attr({
   'src' : Wert
});
});
</script>