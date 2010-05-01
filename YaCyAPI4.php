<?php
/**
* YAPP - YaCy PHP API class and xml/json Proxy 
* Version 4
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

  

class YaCyAPI {
    
    private $_queryTerms; # The input to search
    private $_appID; # Application ID
    # Optional queries
    public $_version = "0.4a";
    public $_market = "en-us";
    public $_sources; # The SourceType of the query / yet obsolete 
    public $_options; # An array containing optional parameters
    public $_format;  # What document will it be output into? XML, jSON
    public $_debugQuery;
    private $_holder;
    protected $_curlArray;


//############# public API functions ismael ##########################  
//
public function addJob() {
}
public function errstr() {
}
public function getProperties() {
       $peername="http://".$this->PeerURL.":".$this->PeerPort."/";
       $command="Network.xml";
       $appid=$this->PeerAppid;
       
       $this->_dur0=microtime(true);                       #for measuerement
       $xml = $this->peerCommandDirect($peername,$command,$appid); #credentials...
      $this->_dur2=microtime(true)-$this->_dur0;     #time for command
      
      //parse xml...
      $resultarray=$this->xml2array2($xml);  #, $get_attributes = 1, $priority = 'tag');
      $items=$resultarray['peers']['your'];
      return $items;
}
public function getPropertie() {
}



# php reserved
#public function new() {
#}
public function setProperties($url,$appid,$name,$timout=2000){
   $u=explode(":",$url);   
   $this->PeerURL=$u[0];
   $this->PeerPort=$u[1];
   $this->PeerName=$name;
   $this->PeerAppid=$appid;  
   $this->PeerTimeout=$timout;  
   
   $this->format= "rss";
   $this->startRecord= "0";
   $this->maximumRecords= "20";
   $this->verify= "true";
   $this->contentdom= "text";
   $this->prefermaskfilter= "";
   $this->urlmaskfilter= ".*";
   $this->resource= "global";
   $this->Lr= "";
}
public function ping() {
    $to=0.5;    
    
    ini_set("default_socket_timeout",$to);     #for web / local  timeout in fsockopen
    
     $peerinfo['host']=$this->PeerURL;   
     $peerinfo['port']=$this->PeerPort;   
     $peerinfo['appid']=$this->PeerAppid;
     $peerinfo['name']=$this->PeerName;   

      $this->_dur0=microtime(true);                       #for measuerement
      $fp = @fsockopen($this->PeerURL, $this->PeerPort, $errno, $errstr, $to);  
      $this->_dur1=microtime(true)-$this->_dur0;     #time for select
      $peerinfo['ping']=$this->_dur1; 
      if (!$fp) 
      {    
        #echo $YaCyURL." offline! (".$errno."-".$errstr.")";
        $peerinfo['status']="0";   
      }
      else
      {
        $peerinfo['status']="1";
      }
    return $peerinfo;

}


public function pauseCrawling() {
       $peername="http://".$this->PeerURL.":".$this->PeerPort."/";
       $command="Status.html?pauseCrawlJob=&jobType=localCrawl";
       $appid=$this->PeerAppid;
       
       $this->_dur0=microtime(true);                       #for measuerement
       $xml = $this->peerCommandDirect($peername,$command,$appid); 
      $this->_dur2=microtime(true)-$this->_dur0;     #time for command
}
public function resumeCrawling() {
       $peername="http://".$this->PeerURL.":".$this->PeerPort."/";
       $command="Status.html?resumeCrawlJob=&jobType=localCrawl";
       $appid=$this->PeerAppid;
       
       $this->_dur0=microtime(true);                       #for measuerement
       $xml = $this->peerCommandDirect($peername,$command,$appid); 
      $this->_dur2=microtime(true)-$this->_dur0;     #time for command
}

public function setTransferProperties() {
 #indexDistribute=>on/off, indexDistributeWhileCrawling=>on/off, indexReceive=>on/off, indexReceiveBlockBlacklist=>on/off
}

### search specific 
#########################################

public function setFormat($format) {
      $this->format= "rss";
      if ($format=="HTML" || $format=="html") {$this->format="html";}     
      if ($format=="JSON" || $format=="json") {$this->format="json";}     
}
public function setStartRecord($n) 
{     
      if ($n<0 || !$n) {$n="0";}     
      $this->startRecord= $n;
}
public function setMaximumRecords($n) 
{     
      if ($n<0 || !$n) {$n="0";}     
      $this->maximumRecords= $n;
}
public function setVerify($n) 
{        
      $this->verify= $n;
}
public function setSources($n) 
{        
      $this->contentDom= $n;
}
public function setContentDom($n) 
{        
      $this->contentDom= $n;
}
public function setResource($n) 
{        
      $this->resource= $n;
}
public function setPrefermaskfilter($n)
{
      $this->prefermaskfilter= $n;
}
public function setURLmaskfilter($n)
{
      $this->urlmaskfilter= $n;
}
public function setLr($n) 
{        
      $this->Lr= $n;
}


public function stop() {
       $peername="http://".$this->PeerURL.":".$this->PeerPort."/";
       $command="Steering.html?shutdown=";
       $appid=$this->PeerAppid;
       
       $this->_dur0=microtime(true);                       #for measuerement
       $xml = $this->peerCommandDirect($peername,$command,$appid); 
      $this->_dur2=microtime(true)-$this->_dur0;     #time for command
}


#########################################
#### ---- extended ---------------------------------------------------------

public function findFirstPeer($frompeer) 
{        
      
}


 public function crawlInfo(){
      $peername="http://".$this->PeerURL.":".$this->PeerPort."/";
      $command="CrawlProfileEditor_p.xml";
      $appid=$this->PeerAppid;

      $this->_dur0=microtime(true);                       #for measuerement
      $xml = $this->peerCommandDirect($peername,$command,$appid); #credentials...
      $this->_dur3=microtime(true)-$this->_dur0;     #time for command

      //parse xml...
      $resultarray=xml2array($xml);  #, $get_attributes = 1, $priority = 'tag');
      $items=$resultarray['crawlProfiles']['crawlProfile'];
      return $items;
}

public function getStats($n) {
       $peername="http://".$this->PeerURL.":".$this->PeerPort."/";
       $command="AccessTracker_p.xml?page=".$n;
       $appid=$this->PeerAppid;
 #echo $command;      
       $this->_dur0=microtime(true);                       #for measuerement
       $xml = $this->peerCommandDirect($peername,$command,$appid); #credentials...
      $this->_dur2=microtime(true)-$this->_dur0;     #time for command
      //parse xml...
      $resultarray=$this->xml2array2($xml);  #, $get_attributes = 1, $priority = 'tag');
      $items=$resultarray['AccessTracker']; #['serverAccessDetails']['entry'];
      
    
      return $items;
}


public function getStatus() {
       $peername="http://".$this->PeerURL.":".$this->PeerPort."/";
       $command="api/status_p.xml";
       $appid=$this->PeerAppid;
       
       $this->_dur0=microtime(true);                       #for measuerement
       $xml = $this->peerCommandDirect($peername,$command,$appid); #credentials...
      $this->_dur2=microtime(true)-$this->_dur0;     #time for command
    

 #print_r($xml);
   #  exit;
       if($xml)   
      {
    

      //parse xml...
      $resultarray=$this->xml2array2($xml);  #, $get_attributes = 1, $priority = 'tag');
      $items=$resultarray['status'];
      return $items;
      }
      else
      {
       #not impl.
      }
}


public function getYconf($key) {
       $peername="http://".$this->PeerURL.":".$this->PeerPort."/";
       $command="api/config_p.xml";
       $appid=$this->PeerAppid;
       
       $this->_dur0=microtime(true);                       #for measuerement
       $xml = $this->peerCommandDirect($peername,$command,$appid); #credentials...
      $this->_dur2=microtime(true)-$this->_dur0;     #time for command
      
      //parse xml...
      $resultarray=$this->xml2array2($xml);  #, $get_attributes = 1, $priority = 'tag');
           
      $itemarray=$resultarray['settings']['option'];
            
      foreach ($itemarray as $item)
     {
      if ($item['key']==$key)
      {
        $value=$item['value'];
      }
     }
      
     return $value;
}












#------------------------------
# returns search in simple array
public function search($s)
{
$xml=$this->getResults($s); 
$resultarray=xml2array($xml);  #, $get_attributes = 1, $priority = 'tag'); 
$items=$resultarray['rss']['channel']['item'];
#print_r($xml);
#exit;
if ($items)
{
#print_r($items);
#echo "###";
   #  map and store unique result-set
   foreach ($items as $item)
  {
  $l=$item['link'];
    #$exists=array_search($l,$links);
    #if (!$exists) 
    {
      $lfd++;
      #$links[$lfd]=$item['link'];  # for dupes
      $allres[$lfd]['link']=$item['link'];
      $allres[$lfd]['title']=$item['title'];
      $allres[$lfd]['description']=$item['description'];
      $allres[$lfd]['date']=$item['pubDate'];
      $allres[$lfd]['host']=$item['yacy:host'];
      $allres[$lfd]['file']=$item['yacy:file'];
      $allres[$lfd]['size']=$item['yacy:size'].$item['yacy:sizename'];
      $allres[$lfd]['favicon']="http://".$item['yacy:host']."/favicon.ico";
      
      $cp = curl_init( $allres[$lfd]['favicon'] );
        
      curl_setopt($cp,CURLOPT_TIMEOUT,10);        
      curl_setopt($cp,CURLOPT_FAILONERROR,1);        
      curl_setopt($cp,CURLOPT_RETURNTRANSFER,1);        
      curl_exec($cp);        
      if (curl_errno($cp) != 0)  
     { 
       $allres[$lfd]['favicon']="images/doc.png";
     } 
     else  
    { 
       $webserver[$key]['status'] = true;
    } 
   curl_close($cp);
 
   
   }
  }
  
} else 
{
  #echo "no results";
}

  
  
  return $allres;
}





#------------------------------
// returns xml or json results from search query
//
public function getResults($this_queryTerms) 
{
   
       $peername="http://".$this->PeerURL.":".$this->PeerPort."/";
       $command="Network.xml";
       $appid=$this->PeerAppid;

        try {
            if(empty($this->PeerURL)) { throw new Exception('Please select at least one peer'); }#
        } catch(Exception $e) {
            echo "An error has been detected: ".$e->getMessage();
            die(); # Stop the execution
        }

$this_queryTerms="?query=".$this_queryTerms;
$this_queryTerms=$this_queryTerms."&verify=".$this->verify; #true
$this_queryTerms=$this_queryTerms."&contentdom=".$this->contentdom; #text
$this_queryTerms=$this_queryTerms."&maximumRecords=".$this->maximumRecords; #25
$this_queryTerms=$this_queryTerms."&startRecord=".$this->startRecord; #0
$this_queryTerms=$this_queryTerms."&resource=".$this->resource;  #global";
$this_queryTerms=$this_queryTerms."&nav=all"; # .$this->nav;
$this_queryTerms=$this_queryTerms."&urlmaskfilter=".$this->urlmaskfilter; #.*";
$this_queryTerms=$this_queryTerms."&prefermaskfilter=".$this->prefermaskfilter;
$this_queryTerms=$this_queryTerms."&indexof=off";
$this_queryTerms=$this_queryTerms."&meanCount=5";

   #$qs=$_SERVER["QUERY_STRING"];   
   #$yquery="query=".$_GET['query'];
   #i#f ($yquery=="query=") $yquery= "query=".$_GET['s'];
   #if ($yquery=="query=") $yquery= "query=".$_GET['search'];
   #if ($yquery=="query=" ||$yquery=="")   # no ?query=
   #{
   #  $this_queryTerms=$_GET['search']; # use original arg-line for proxy-mode
   #  $this_queryTerms=$this_queryTerms."&verify=true&contentdom=text&maximumRecords=25&startRecord=0&resource=global&nav=all&urlmaskfilter=.*&prefermaskfilter=&indexof=off&meanCount=5 ";
  #  } else {
  #   $this_queryTerms=$yquery."&verify=true&contentdom=text&maximumRecords=25&startRecord=0&resource=global&nav=all&urlmaskfilter=.*&prefermaskfilter=&indexof=off&meanCount=5 ";
 #  }   
    
    
    
    $this->_dur0=microtime(true);
    # Start curl
    $cu=$this->PeerURL.":".$this->PeerPort."/yacysearch.".$this->format.$this_queryTerms; 
#
#echo "<br>CU:".$cu;
#exit;

    $queryServer = curl_init($cu);
    $this->_debugQuery = $cu;
    $to=2000;  
    curl_setopt($queryServer, CURLOPT_HEADER, 0);
    curl_setopt($queryServer, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($queryServer, CURLOPT_USERPWD,$tappid);
    curl_setopt($queryServer, CURLOPT_CONNECTTIMEOUT_MS, $to);
    
    if(is_array($this->_curlArray)) {
    curl_setopt_array($queryServer, $this->_curlArray);
    }
     
    # Deliver
    $holder = curl_exec($queryServer);
   
    
    # done
    curl_close($queryServer);
    $this->_dur3=microtime(true)-$this->_dur0;     #time for select
    
    return $holder;
    
}
 





// BASIC: ------------------------------------------------
// for execution of server commands or query xml/json
// send html to peer selected by name-------------------
public function peerCommandDirect($peername,$command,$credentials) #="admin:yacy") 
{
        
      $YaCyURL=$peername;
      $cu=$YaCyURL.$command;
#echo "<br>CU:".$cu;
      $to=2000;
       
      $ti=microtime(true); 
      
      $queryServer = curl_init($cu);
      $this->_debugQuery = $cu;
      curl_setopt($queryServer, CURLOPT_HEADER, 0);
      curl_setopt($queryServer, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($queryServer, CURLOPT_USERPWD,$credentials);
      curl_setopt($queryServer, CURLOPT_CONNECTTIMEOUT_MS, $to);

      
     $holder = curl_exec($queryServer);
     $this->_status = curl_getinfo($queryServer, CURLINFO_HTTP_CODE);     
         
     
     # done
     curl_close($queryServer);
      
     #$this->_dur2=microtime(true)-$ti;     #time for select
     if($this->_status>=200 && $this->_status<300)
     {
      return $holder;
     }
     else
     {
      #echo "<br>".$this->_status;
      return false;
     }
     
      
}


################ helpers #########################

// <root>
//  <child1>
//   <child1child1/>
//  </child1>
// </root>
//
// funtion creates an array like 
// array[root][child1][child1child1]

function xml2array2($contents, $get_attributes = 1, $priority = 'tag')
{
   
    if (!function_exists('xml_parser_create'))
    {
        return array ();
    }
    $parser = xml_parser_create('');
    
#    if (!($fp = @ fopen($url, 'rb')))
 #   {
  #      return array ();
  #  }
  #  while (!feof($fp))
  #  {
   #     $contents .= fread($fp, 8192);
  #  }
   # fclose($fp);
   
   
   
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);
    if (!$xml_values)
        return; //Hmm...
    $xml_array = array ();
    $parents = array ();
    $opened_tags = array ();
    $arr = array ();
    $current = & $xml_array;
    $repeated_tag_index = array (); 
    foreach ($xml_values as $data)
    {
        unset ($attributes, $value);
        extract($data);
        $result = array ();
        $attributes_data = array ();
        if (isset ($value))
        {
            if ($priority == 'tag')
                $result = $value;
            else
                $result['value'] = $value;
        }
        if (isset ($attributes) and $get_attributes)
        {
            foreach ($attributes as $attr => $val)
            {
                if ($priority == 'tag')
                    $attributes_data[$attr] = $val;
                else
                    $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
            }
        }
        if ($type == "open")
        { 
            $parent[$level -1] = & $current;
            if (!is_array($current) or (!in_array($tag, array_keys($current))))
            {
                $current[$tag] = $result;
                if ($attributes_data)
                    $current[$tag . '_attr'] = $attributes_data;
                $repeated_tag_index[$tag . '_' . $level] = 1;
                $current = & $current[$tag];
            }
            else
            {
                if (isset ($current[$tag][0]))
                {
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    $repeated_tag_index[$tag . '_' . $level]++;
                }
                else
                { 
                    $current[$tag] = array (
                        $current[$tag],
                        $result
                    ); 
                    $repeated_tag_index[$tag . '_' . $level] = 2;
                    if (isset ($current[$tag . '_attr']))
                    {
                        $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                        unset ($current[$tag . '_attr']);
                    }
                }
                $last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
                $current = & $current[$tag][$last_item_index];
            }
        }
        elseif ($type == "complete")
        {
            if (!isset ($current[$tag]))
            {
                $current[$tag] = $result;
                $repeated_tag_index[$tag . '_' . $level] = 1;
                if ($priority == 'tag' and $attributes_data)
                    $current[$tag . '_attr'] = $attributes_data;
            }
            else
            {
                if (isset ($current[$tag][0]) and is_array($current[$tag]))
                {
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    if ($priority == 'tag' and $get_attributes and $attributes_data)
                    {
                        $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag . '_' . $level]++;
                }
                else
                {
                    $current[$tag] = array (
                        $current[$tag],
                        $result
                    ); 
                    $repeated_tag_index[$tag . '_' . $level] = 1;
                    if ($priority == 'tag' and $get_attributes)
                    {
                        if (isset ($current[$tag . '_attr']))
                        { 
                            $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                            unset ($current[$tag . '_attr']);
                        }
                        if ($attributes_data)
                        {
                            $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag . '_' . $level]++; //0 and 1 index is already taken
                }
            }
        }
        elseif ($type == 'close')
        {
            $current = & $parent[$level -1];
        }
    }
    return ($xml_array);
}


 
}
// END API CLASS

?>