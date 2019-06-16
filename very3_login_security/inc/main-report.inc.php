
<div style="display:none;" id="v3-lsec-overlay">
  <div id="v3-lsec-overlay-header">
    <span id="v3-lsec-overlay-title">Log Detail</span>
    <a id="v3-lsec-overlay-closer" href="#">&#10005;</a>
  </div>
  <div id="v3-lsec-overlay-content"></div>
</div>

<div id="v3-lsec-main">
  <h3><?php echo isset($v3_lsec['conf']['name']) ? $v3_lsec['conf']['name']: '';?></h3>
  <?php echo join('',$_table);?>
  <div id="v3-lsec-report-buttons">
    <input type="button" id="v3-lsec-clear-logs" value="Clear Logs"/>
    <input type="button" id="v3-lsec-clear-blocked" value="Clear Blocks"/>
  </div>
</div>
<script>
  <?php echo $_action_feedback;?>
  $(document).ready(function() {
    $("a[href*='load.php?id=very3_login_security&report']").addClass('current');
  });
</script>


