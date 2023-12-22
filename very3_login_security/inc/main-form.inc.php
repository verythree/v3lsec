<!--
  Very3 Login Security Plugin for GetSimple CMS
  (c)2019-2023 Very3 Technology Consultants
  Author: Mark Page [mark@very3.net]
  Internal Version: 23.12.22.821
  Released: Fri Dec 22 08:18:17 2023 -0600
-->

<div id="v3-lsec-main">
  <h3><?php echo isset($v3_lsec['conf']['name']) ? $v3_lsec['conf']['name']: '';?></h3>
  <div id="v3-lsec-help-button"><a title="Quick Help" href="#">&#8853;</a></div>
  <div id="v3-lsec-notes-wrapper" style="display:none;">
    <h2>V3LSEC Help</h2>
    <p>
      <b>Main Settings</b><br/>
      By default, this plugin will block a remote IP address after 5 failed login attempts for 600 seconds (10 minutes) and does not send notifications. Set the "Max Auth Attempts" 
      value to the number of attempts you wish to allow before blocking the IP address. The user will not be able to submit the login form again until the "Time to Block" seconds 
      has elapsed. If you wish to show the V3LSEC tab and logs only to specific users (and hide from everyone else), add their usernames (comma seperated) to the "Plugin Admins" 
      field. The "Support URL" link will be shown on the blocked IP page if you wish to provide support for users who need assistance with blocked IP addresses. Checking the "Disable 
      Lookups to ipinfo.io" checkbox will disable location lookup queries to ipinfo.io and disable location logging as well.
    </p>
    <p>
      <b>Email Settings</b><br/>
      To receive email notifications you must add both to and from email addresses (they can be the same) and select at least one "Send Email on..." option. This function also 
      requires a local MTA and/or PHP configuration, see your operating system's documentation for more detail.
    </p>
    <p>
      <b>SMS (Twilio) Settings</b><br/>To receive SMS notifications you must have a <a href="https://www.twilio.com/" target="_blank">Twilio</a> account and select at least one 
      "Send SMS on..." option enabled. To find your SID and token information, please refer to the <a href="https://support.twilio.com/hc/en-us/articles/223136027-Auth-Tokens-and-How-to-Change-Them" 
      target="_blank">Where is my Auth Token?</a> section on the Twilio website.
    </p> 
    <p>
      <b>Need Help?</b><br/>
      If you have any questions, comments, suggestions or complaints, please visit the Very3 Login Security pages on the <a href="http://get-simple.info/forums/showthread.php?tid=10896" 
      target="_blank">GetSimple Community Forum</a>.
    </p>
    <div id="v3-lsec-version">(Version: <?php echo isset($v3_lsec['conf']['version']) ? $v3_lsec['conf']['version']: '';?> - Released: <?php echo isset($v3_lsec['conf']['name']) ? $v3_lsec['conf']['moddate']: '';?>)</div>
  </div>

  <div style="clear:both;"></div>

  <div id="v3-lsec-form-wrapper">
    <form id="v3-lsec-main-form" method="post" action="#">
      <input type="hidden" name="v3-lsec-save-settings" value="yep" />

      <fieldset>
        <legend>Main Settings</legend>
        <div class="v3-lsec-2-c">
          <div class="v3-lsec-1-c">
            <label>Max Auth Attempts</label>
            <input type="text" name="maxtries" value="<?php echo isset($_xml_data->maxtries) ? $_xml_data->maxtries : '5';?>" placeholder="Sane value: 3-5" />
          </div>
          <div class="v3-lsec-1-c">
            <label>Time to Block IP (seconds)</label>
            <input type="text" name="timeout" value="<?php echo isset($_xml_data->timeout) ? $_xml_data->timeout : '600';?>" placeholder="Sane value: 600-86400" />
          </div>
          <div class="v3-lsec-1-c">
            <label>Support URL</label>
            <input type="text" name="support" value="<?php echo isset($_xml_data->support) ? $_xml_data->support : '';?>" placeholder="https://www.support-site.tld" />
          </div>
          <div class="v3-lsec-1-c">
            <label>Plugin Admins</label>
            <input type="text" name="plugin_admins" value="<?php echo isset($_xml_data->plugin_admins) ? $_xml_data->plugin_admins : '';?>" placeholder="user1, user2, user3" />
          </div>
          <div class="v3-lsec-1-c">
            <input type="checkbox" id="disable-ipinfo-checkbox" name="disable_ipinfo" value="yes" <?php echo isset($_xml_data->disable_ipinfo) ? 'checked' : '';?>>
            <label for="disable-ipinfo-checkbox">Disable Lookups to ipinfo.io</label>
          </div>
        </div>
      </fieldset>

      <div class="v3-lsec-spacer"></div>

      <fieldset>
        <legend>Email Settings</legend>
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
      </fieldset>

      <div class="v3-lsec-spacer"></div>

      <fieldset>
        <legend>Twilio Settings</legend>
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
      </fieldset>

      <div class="v3-lsec-spacer"></div>

      <input type="submit" value="Save" />
      <div style="clear:both;"></div>
    </form>
  </div>
</div>

<script language="javascript">
  <?php echo isset($_form_feedback) ? $_form_feedback: '';?>
</script>

