<div id="v3-lsec-main">
  <h3><?php echo isset($v3_lsec['conf']['name']) ? $v3_lsec['conf']['name']: '';?></h3>

  <div id="v3-lsec-notes-wrapper">
      Out of the box, this plugin will block a remote IP address after 5 bad login attempts for 600 seconds (10 minutes) and send no notification.
      You must add both email addresses (they can be the same) and select at least one "Send Email on..." option to recieve email notifications. 
      The SMS function requires that you have a <a href="https://www.twilio.com/" target="_blank">Twilio</a> account and select at least one 
      "Send SMS on..." option to receive SMS notifications. This plugin also creates syslog entries that can be leveraged by services such as
      <a href="https://www.fail2ban.org" target="_blank">Fail2ban</a> and <a href="https://www.ossec.net/" target="_blank">OSSEC</a>.
  </div>

  <div style="clear:both;"></div>

  <div id="v3-lsec-form-wrapper">
    <form id="v3-lsec-main-form" method="post" action="#">
      <input type="hidden" name="v3-lsec-save-settings" value="yep" />

      <div class="v3-lsec-2-c">
        <div class="v3-lsec-1-c">
          <label>Max Auth Attempts</label>
          <input type="text" name="maxtries" value="<?php echo isset($_xml_data->maxtries) ? $_xml_data->maxtries : '';?>" placeholder="Sane value: 3-5" />
        </div>
        <div class="v3-lsec-1-c">
          <label>Time to Block IP (seconds)</label>
          <input type="text" name="timeout" value="<?php echo isset($_xml_data->timeout) ? $_xml_data->timeout : '';?>" placeholder="Sane value: 3600-86400" />
        </div>
        <div class="v3-lsec-1-c">
          <label>Support URL</label>
          <input type="text" name="support" value="<?php echo isset($_xml_data->support) ? $_xml_data->support : '';?>" title="Adds a support link to the blocked notification page" placeholder="https://www.support-site.tld" />
        </div>
        <div class="v3-lsec-1-c" style="padding-top:20px;">
          <input type="checkbox" id="disable-ipinfo-checkbox" title="Disables lookups to ipinfo.io and turns off the location logging. If your server is on a slow connection and logins are taking a long time, you may want to disable this." name="disable_ipinfo" value="yes" <?php echo isset($_xml_data->disable_ipinfo) ? 'checked' : '';?>>
          <label for="disable-ipinfo-checkbox">Disable Lookups to ipinfo.io</label>
        </div>
      </div>

      <div class="v3-lsec-spacer"></div>

      <div class="v3-lsec-2-c">
        <div class="v3-lsec-1-c">
          <label>Email Notification FROM Address</label>
          <input type="text" name="from" value="<?php echo isset($_xml_data->from) ? $_xml_data->from : '';?>" placeholder="user@somewhere.tld" />
        </div>
        <div class="v3-lsec-1-c">
          <label>Email Notification TO Address</label>
          <input type="text" name="to" value="<?php echo isset($_xml_data->to) ? $_xml_data->to : '';?>" placeholder="user@somewhereelse.tld" />
        </div>
        <div class="v3-lsec-1-c">
          <input type="checkbox" id="email-on-failed-checkbox" name="email_send_failed" value="yes" <?php echo isset($_xml_data->email_send_failed) ? 'checked' : '';?>>
          <label for="email-on-failed-checkbox">Send Email on Failed Logins</label>
        </div>
        <div class="v3-lsec-1-c">
          <input type="checkbox" id="email-on-blocked-checkbox" name="email_send_blocked" value="yes" <?php echo isset($_xml_data->email_send_blocked) ? 'checked' : '';?>>
          <label for="email-on-blocked-checkbox">Send Email on Blocked IP addresses</label>
        </div>
        <div class="v3-lsec-1-c">
          <input type="checkbox" id="email-on-success-checkbox" name="email_send_success" value="yes" <?php echo isset($_xml_data->email_send_success) ? 'checked' : '';?>>
          <label for="email-on-success-checkbox">Send Email on Successful Logins</label>
        </div>
      </div>

      <div class="v3-lsec-spacer"></div>

      <div class="v3-lsec-2-c">
        <div class="v3-lsec-1-c">
          <label>Twilio Account SID</label>
          <input type="text" name="tw_sid" value="<?php echo isset($_xml_data->tw_sid) ? $_xml_data->tw_sid : '';?>" placeholder="ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" />
        </div>
        <div class="v3-lsec-1-c">
          <label>Twilio Auth Token</label>
          <input type="text" name="tw_token" value="<?php echo isset($_xml_data->tw_token) ? $_xml_data->tw_token : '';?>" placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" />
        </div>
        <div class="v3-lsec-1-c">
          <label>Twilio Sending Number</label>
          <input type="text" name="tw_from" value="<?php echo isset($_xml_data->tw_from) ? $_xml_data->tw_from : '';?>" placeholder="01234567890" />
        </div>
        <div class="v3-lsec-1-c">
          <label>Twilio Recipient Number</label>
          <input type="text" name="tw_to" value="<?php echo isset($_xml_data->tw_to) ? $_xml_data->tw_to : '';?>" placeholder="01234567890" />
        </div>
        <div class="v3-lsec-1-c">
          <input type="checkbox" id="sms-on-failed-checkbox" name="sms_send_failed" value="yes" <?php echo isset($_xml_data->sms_send_failed) ? 'checked' : '';?>>
          <label for="sms-on-failed-checkbox">Send SMS on Failed Logins</label>
        </div>
        <div class="v3-lsec-1-c">
          <input type="checkbox" id="sms-on-blocked-checkbox" name="sms_send_blocked" value="yes" <?php echo isset($_xml_data->sms_send_blocked) ? 'checked' : '';?>>
          <label for="sms-on-blocked-checkbox">Send SMS on Blocked IP addresses</label>
        </div>
        <div class="v3-lsec-1-c">
          <input type="checkbox" id="sms-on-success-checkbox" name="sms_send_success" value="yes" <?php echo isset($_xml_data->sms_send_success) ? 'checked' : '';?>>
          <label for="sms-on-success-checkbox">Send SMS on Successful Logins</label>
        </div>
      </div>

      <div class="v3-lsec-spacer"></div>

      <input type="submit" value="Save" />
      <div style="clear:both;"></div>
    </form>
  </div>
</div>

<script language="javascript">
  <?php echo isset($_form_feedback) ? $_form_feedback: '';?>
</script>

