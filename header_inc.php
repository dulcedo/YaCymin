  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <meta http-equiv="refresh" content="<?php
    if ($_GET['refresh']<>0)
    {
    echo $_GET['refresh']; 
    }else{
    echo "300";
    }
    ?>; URL=">
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="expires" content="1" />
    <meta http-equiv="content-language" content="de" />
    <meta name="author" content="dulcedo / yacy.net"/>
 
    <meta content="INDEX,FOLLOW" name="robots" />

  <link rel="stylesheet" media="screen" href=style.css type="text/css" />
  	<!--[if lte IE 7]>
		<link rel="stylesheet" media="screen" href="style_ie7.css" type="text/css" />
	<![endif]-->
	<!--[if lte IE 6]>
		<link rel="stylesheet" media="screen" href="style_ie.css" type="text/css" />
	<![endif]-->

  <script type="text/javascript">
	<!--
	document.write('<style type="text/css">.innerwidget{display:none;}</style>');
	-->
	</script>
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="domscripts.js"></script>
  <script type="text/javascript" src="jquery_iframe.js"></script> 
  <script type="text/javascript"> 
    $(function(){
        $('a.iframe').iframe();
    });
</script> 

  <title>YaCymin o4</title>
  </head>
  <body>
  <p class="screenreader"><a href="#inhalt">goto content</a></p>
 
<div id="navi-main">
	<h1 class="screenreader">main navigation</h1>
	<ul>
<li class="page_item page-item-2"><a href="?refresh=<?php if(!$_GET['refresh']){echo '120';}else{echo $_GET['refresh'];} ?>&action=peers" title="Peers">Status</a></li>
<li class="page_item page-item-12"><a href="?action=peerlist" title="Crawls">Network</a></li>
<li class="page_item page-item-12"><a href="?action=crawls" title="Crawls">Crawls</a></li>
<li class="page_item page-item-22"><a href="?action=tools" title="Tools">Tools</a></li>
<li class="page_item page-item-32"><a href="?action=search" title="Search">Search</a></li>
	</ul>
</div>
 
 
<h1 class="screenreader">information</h1>
 
 
<!-- ++++++++++++++++++++++++++++++++++++++ -->
 
<div class="blogtoy">
	<h2 class="widgetheader"><font color=grey>YaCymin <?php echo$modedisplay; ?></font></h2>
	<div class="innerwidget">
		<p>Search and admin multiple YaCy-peers.
     <hr><p align=right><form action=?action= method=get>Refresh pages every  <input size=5 type=text name=refresh id=refresh value=
<?php 
 echo $_GET['refresh'];
?>
     > seconds.<input type=submit value=set></form></p>
     </p>
	</div>
</div>

<?php
