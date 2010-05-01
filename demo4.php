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

 $ym_version="0.4a";

 #$ym_mode="demo";   #readonly, no crawls
 #$ym_mode="basic";   #no restart, shutdown or crawls
 $ym_mode="admin";  #su
 
 
 switch ($ym_mode)  {
 case "demo": $modedisplay="Demo"; break;
 case "basic": $modedisplay=$ym_version; break;
 case "admin": $modedisplay=$ym_version." Admin"; break;
 default:  
 }
 
/**
also required:
IMAGES/
peerlist_inc.php
header_inc.php
footer_inc.php
domscripts.js
jqery.js
style.css
style_ie7.css
style_ie.css
style_print.css

optional:
mindterm.jar

*/



 //html headers
 require 'header_inc.php'; 
 
 #echo '<hr id="endfirst" class="bottomspace" /><div id="inhalt"><div class="article">';
 $action=$_GET['action'];
 switch ($action)
 {

  // ---------------------------- ssh -------------------------------
  case "SSH":
  
     echo '<br><h2><font color=grey>&nbsp;Opening SSH with '.$_GET["host"].'</font></h2>';
     echo "";
     echo "<div class=article>";
     echo '<APPLET CODE="com.mindbright.application.MindTerm.class"
          ARCHIVE="mindterm.jar" WIDTH=540 HEIGHT=480>
    <PARAM NAME="cabinets" VALUE="mindterm.cab">
    <PARAM NAME="sepframe" value="false">
    <PARAM NAME="debug" value="true">
    <PARAM NAME="server" value="'.$_GET["host"].'">
    </APPLET>';
    echo "</div>";
  break;

  // -- access ----------------------------------------------------
  // 
  case "access":
  require 'inc_access.php';
  break;

// -- tools ----------------------------------------------------
  // 
  case "tools":
  require 'inc_tools.php';
  break;

  // -- blacklist ----------------------------------------------------
  // 
  case "blacklists":
  require 'inc_blacklist.php';
  break;

  // -- xml-proxy ----------------------------------------------------
  // using list of peers for search
  case "proxy":
  require 'inc_proxy.php';
  break;
 
  // --network- autoSCAN ----------------------------------------------------
  // using given peer-address for status of all connected peers
  case "netscan":
  require 'inc_netscan.php';
  break;
 
 // --network-info ----------------------------------------------------
  case "peerlist":
  require 'inc_peerlist.php';
  break;
  
  // --SEARCH ----------------------------------------------------
  case "search":
  require 'inc_search.php';
  break;

  //   newCRAWL ######
  case "newcrawl":
  require 'inc_newcrawl.php'; 
  break;
 

  //  CRAWLs ###############
  case "crawls":
  require 'inc_crawls.php';
  break;

 
 // PEERS ################
 case "peers":
 default:
 require 'inc_peers.php';
 break;
 
 // onePEER ################
 case "peer":
 default:
 require 'inc_peer.php';
 break;
 
 
 ## simple funcs ##########################
 
  // ---------------------------- LOG -------------------------------
  case "log":
  require 'inc_log.php';
  break;
  

 
 
 
 
 #######################################
 ## EXPERIMENTAL ##########################
  //-------------------------------------------------------------- 
  case "mem":
  
    $peerno="0";
    $info=$search->peerStatus($peerno);
   
    if ($info['status']=="1")
    { 
   
      $itm=$search->memInfo($peerno);   #extended info     
      echo "<br>Avail: ".$itm['memoryAvailAfterStartup']."/".$itm['memoryAvailAfterInitAGC']."/".$itm['memoryAvailNow'];
      echo "<br>Used: ".$itm['memoryUsedAfterStartup']."/".$itm['memoryUsedAfterInitAGC']."/".$itm['memoryUsedNow'];
      #print_r($itm);

    }
  
  
 break;
  
 

#########################################################
}           #endswitch

#-------------------------------------------- HELP ---------------------------------------------------
#<p>Small piece of software looking for documentation. Sexy screens available on icq or mailto mjs a t frakt d o t de.<br>asl and own screens plz.</p>

require 'footer_inc.php';
echo "</body></html>";


 


exit;
 
 
 // <root>
//  <child1>
//   <child1child1/>
//  </child1>
// </root>
//
// funtion creates an array like 
// array[root][child1][child1child1]

function xml2array($contents, $get_attributes = 1, $priority = 'tag')
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

#dont forget me  ?> 

