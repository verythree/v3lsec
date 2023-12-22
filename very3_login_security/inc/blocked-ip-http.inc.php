<!DOCTYPE html>
<html lang="en">
<head>
  <!--
    Very3 Login Security Plugin for GetSimple CMS
    (c)2019-2023 Very3 Technology Consultants
    Author: Mark Page [mark@very3.net]
    Internal Version: 23.12.22.821
    Released: Fri Dec 22 08:18:17 2023 -0600
  -->
  <title>Blocked IP Address: <?php echo $_state['ripa'];?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"  />
  <meta name="robots" content="noindex, nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/plugins/<?php echo $v3_lsec['conf']['plugin'];?>/assets/css/main.css?v=1.0" rel="stylesheet" media="screen">
</head>
<body id="v3-lsec-blocked">
  <div class="outer">
    <div class="inner">
      <h3>Blocked IP Address: <?php echo $_state['ripa'];?></h3>
      <div class="content">
        <p>
          The IP address of your computer (<?php echo $_state['ripa'];?>) has been blocked by this server due to failed logon attempts.
          You will not be able to access the <b><?php echo $v3_lsec['conf']['sitename'];?></b> admin panel for <b><?php echo round(($v3_lsec['conf']['settings']['timeout'] - $_tleft)/60,2);?>
          minute(s)</b>. Once this time has elapsed, the block will be lifted and you may try again.
        </p>
        <?php if (!empty($v3_lsec['conf']['settings']['support'])) {?>
        <p>
          If you feel you have reached this page in error or need assistance with account credentials, please visit
          <a target="_blank" href="<?php echo $v3_lsec['conf']['settings']['support'];?>"><?php echo $v3_lsec['conf']['settings']['support'];?></a>.
        </p>
        <?php }?>
      </div>
      <div class="footer">
        IP: <?php echo $_state['ripa'];?>,
        ORG: <?php echo $_state['org'];?>,
        CITY: <?php echo $_state['city'];?>,
        REGION: <?php echo $_state['region'];?>,
        COUNTRY: <?php echo $_state['country'];?>,
        POSTAL: <?php echo $_state['postal'];?>,
        LOC: <?php echo $_state['location'];?>
      </div>
    </div>
  </div>
</body>
</html>
