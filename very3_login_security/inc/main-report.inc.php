<!--
  Very3 Login Security Plugin for GetSimple CMS
  (c)2019-2023 Very3 Technology Consultants
  Author: Mark Page [mark@very3.net]
  Internal Version: 23.12.22.821
  Released: Fri Dec 22 08:18:17 2023 -0600
-->

<div style="display:none;" id="v3-lsec-overlay">
  <div id="v3-lsec-overlay-header">
    <span id="v3-lsec-overlay-title"></span>
    <a id="v3-lsec-overlay-closer" href="#">&#10005;</a>
  </div>
  <div id="v3-lsec-overlay-content"></div>
</div>

<div id="v3-lsec-main">
  <h3><?php echo isset($v3_lsec['conf']['name']) ? $v3_lsec['conf']['name']: '';?></h3>
  <?php echo join('',$_table);?>
  <div id="v3-lsec-report-buttons">
    <button id="v3-lsec-clear-logs"><i class="far fa-trash-alt"></i>&nbsp;&nbsp;Delete Log</button>
    <button id="v3-lsec-clear-blocked"><i class="fas fa-ban"></i>&nbsp;&nbsp;Clear Blocks</button>
    <button id="v3-lsec-reload-logs"><i class="fas fa-sync-alt"></i>&nbsp;&nbsp;Reload Page</button>
  </div>
</div>

<script>
  <?php echo $_act_err;?>
  $(document).ready(function() {
    $("a[href*='load.php?id=very3_login_security&report']").addClass('current');
  });
</script>


