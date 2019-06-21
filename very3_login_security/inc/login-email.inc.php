<!DOCTYPE html>
<html lang="en">
<head prefix="dcterms: http://purl.org/dc/terms">
  <title>Admin Login at <?php echo $v3_lsec['conf']['sitename'];?></title>
</head>
<html>
<body>
  <b><?php echo $_state['auth'];?></b> logon for user <b><?php echo $_state['user'];?></b> to the admin interface at
  <b><a href="https://<?php echo $v3_lsec['conf']['sitename'];?>/admin"><?php echo $v3_lsec['conf']['sitename'];?></a></b> on <b><?php echo date(DATE_RFC2822);?></b>.<br/><br/>
  <b>Remote Address:</b> <a href="https://very3.net/tools/whois/?ip=<?php echo $_state['ripa'];?>"><?php echo $_state['ripa'];?></a><br/>
  <b>Location:</b> <?php echo $_state['city'].' '.$_state['region'].' '.$_state['country'].' '.$_state['postal'];?> (<a href="https://www.google.com/maps/search/?api=1&query=<?php echo $_state['location'];?>"><?php echo $_state['location'];?></a>)<br/>
  <b>Service Provider:</b> <?php echo $_state['org'];?><br/>
  <b>User Agent:</b> <?php echo $_state['uagent'];?><br/><br/>
</body>
</html>
