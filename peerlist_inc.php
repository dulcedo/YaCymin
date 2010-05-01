<?php 
if (file_exists('peerlist_alt.php')) #alternate private peerlist
{
 INCLUDE 'peerlist_alt.php';
}
else
{
// ----------- edit here ----------
   
     // array of possipble peers  0:ip, 1:port, 2:user:pw, 3: opt.friendlyname
     // do NOT use localhost but (public) IP/hostname
     $i= 0; $this_YaCyPeer[$i][0]="127.0.0.1"; $this_YaCyPeer[$i][1]="8080"; $this_YaCyPeer[$i][2]="admin:password";$this_YaCyPeer[$i][3]="local peer"; 
     $i= 1; $this_YaCyPeer[$i][0]="other.ip"; $this_YaCyPeer[$i][1]="8081"; $this_YaCyPeer[$i][2]="";$this_YaCyPeer[$i][3]="other peer"; 
     


 // ----------- end edit ----------
 }
?> 