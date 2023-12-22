<!DOCTYPE html>
<html lang="en">
<head prefix="dcterms: http://purl.org/dc/terms">
  <!--
    Very3 Login Security Plugin for GetSimple CMS
    (c)2019-2023 Very3 Technology Consultants
    Author: Mark Page [mark@very3.net]
    Internal Version: 23.12.22.820
    Released: Fri Dec 22 08:18:17 2023 -0600
  -->
  <title>Blocked IP Address (<?php echo $_state['ripa'];?> at <?php echo $v3_lsec['conf']['sitename'];?></title>
</head>
<html>
<body>
  IP Address <b><?php echo $_state['ripa'];?></b>  
  was blocked at <b><a href="https://<?php echo $v3_lsec['conf']['sitename'];?>/admin"><?php echo $v3_lsec['conf']['sitename'];?></a></b> 
  on <b><?php echo date(DATE_RFC2822);?></b> for the next <?php echo round(($v3_lsec['conf']['settings']['timeout'] - $_tleft)/60,2);?> minutes.
  <br/><br/>
  <b>User:</b> <?php echo $_state['user'];?><br/>
  <b>Remote Address:</b> <a href="https://very3.net/tools/whois/?ip=<?php echo $_state['ripa'];?>"><?php echo $_state['ripa'];?></a><br/>
  <b>Location:</b> <?php echo $_state['city'].' '.$_state['region'].' '.$_state['country'].' '.$_state['postal'];?> (<a href="https://www.google.com/maps/search/?api=1&query=<?php echo $_state['location'];?>"><?php echo $_state['location'];?></a>)<br/>
  <b>Service Provider:</b> <?php echo $_state['org'];?><br/>
  <b>User Agent:</b> <?php echo $_state['uagent'];?><br/><br/>
</body>
</html>
