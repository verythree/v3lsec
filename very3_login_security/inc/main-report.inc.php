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
</script>


