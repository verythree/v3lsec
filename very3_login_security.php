<?php
//
// Very3 Login Security Plugin for GetSimple CMS
// (c)2019-2023 Very3 Technology Consultants
// Author: Mark Page [mark@very3.net]
// Internal Version: 23.12.22.837
// Released: Fri Dec 22 08:18:17 2023 -0600
//---------------------------------------------------
// See:
//    https://github.com/verythree/v3lsec
//    http://get-simple.info/forums/showthread.php?tid=10896
//    http://get-simple.info/extend/plugin/v3lsec-very3-login-security/1211/
//
$v3_lsec['conf'] = [
  'plugin'   => basename(__FILE__, ".php"),
  'plugpath' => __DIR__.'/'.basename(__FILE__, ".php"),
  'datapath' => GSDATAOTHERPATH.'/very3_login_security',
  'version'  => '23.12.22.837',
  'debug'    => false,
  'moddate'  => 'Fri Dec 22 08:18:51 2023 -0600',
  'author'   => 'Very3 Technology Consultants [mark@very3.net]',
  'url'      => 'https://very3.net',
  'type'     => 'very3_login_security',
  'tabname'  => 'V3LSEC',
  'setup'    => 'v3_lsec_setup',
  'login'    => 'v3_lsec_login',
  'report'   => 'v3_lsec_report',
  'router'   => 'v3_lsec_router',
  'name'     => 'Very3 Login Security',
  'desc'     => 'Mitigate brute-force login attempts by blocking IP addresses with failed logins for a configured time span. Optionally provides notifications via email and/or SMS (with Twilio account) for admin panel login activity. See <a href="https://github.com/verythree/v3lsec">https://github.com/verythree/v3lsec</a> for more info.',
  'is_admin' => true,
  'sitename' => $SITENAME,
  'siteurl'  => $SITEURL,
  'settings' => [
    'maxtries'           => 5,
    'timeout'            => 600,
    'email_send_failed'  => 'no',
    'email_send_blocked' => 'no',
    'email_send_success' => 'no',
    'sms_send_failed'    => 'no',
    'sms_send_blocked'   => 'no',
    'sms_send_success'   => 'no',
    'disable_ipinfo'     => 'no',
    'plugin_admins'      => '',
  ],
];

if (file_exists($v3_lsec['conf']['datapath'].'/config.xml')) {
  $v3_lsec['conf']['settings'] = array_merge($v3_lsec['conf']['settings'],(array) getXml($v3_lsec['conf']['datapath'].'/config.xml'));
}

if (!file_exists(GSDATAOTHERPATH.'/'.$v3_lsec['conf']['plugin'].'/db/ip.db')) {
  mkdir(GSDATAOTHERPATH.'/'.$v3_lsec['conf']['plugin'].'/db/ip.db', 0700, true);
}

if (!file_exists(GSDATAOTHERPATH.'/'.$v3_lsec['conf']['plugin'].'/logs')) {
  mkdir(GSDATAOTHERPATH.'/'.$v3_lsec['conf']['plugin'].'/logs', 0700, true);
}

if ($v3_lsec['conf']['debug']) {
  defined('GSDEBUG') or define('GSDEBUG', true);
  defined('GSERRORLOGENABLE') or define('GSERRORLOGENABLE', true);
  $_dump = get_defined_vars();
  ob_start(); print_r($_dump);
  $_output = date("c")."\n".ob_get_clean();
  file_put_contents($v3_lsec['conf']['datapath'].'/.debug',$_output);
}
else {
  if (file_exists($v3_lsec['conf']['datapath'].'/.debug')) {
    unlink($v3_lsec['conf']['datapath'].'/.debug');
  }
}

if (!empty($v3_lsec['conf']['settings']['plugin_admins'])) {
  $v3_lsec['conf']['is_admin'] = false;
  $_admins = str_getcsv($v3_lsec['conf']['settings']['plugin_admins']);
  $_admins = str_replace(' ', '', $_admins);
  foreach ($_admins as $_a) {
    if (strtolower($USR) == strtolower($_a)) {
      $v3_lsec['conf']['is_admin'] = true;
    }
  }
}

register_plugin(
  $v3_lsec['conf']['plugin'],   // Plugin id
  $v3_lsec['conf']['name'],     // Plugin name
  $v3_lsec['conf']['version'],  // Plugin version
  $v3_lsec['conf']['author'],   // Plugin author
  $v3_lsec['conf']['url'],      // Author website
  $v3_lsec['conf']['desc'],     // Plugin description
  $v3_lsec['conf']['type'],     // Page type
  $v3_lsec['conf']['router']    // Main function
);

add_action(
  'successful-login-start',
  $v3_lsec['conf']['login']
);

if ($v3_lsec['conf']['is_admin']) {
  add_action(
    'nav-tab',
    'createNavTab',
    array(
      $v3_lsec['conf']['plugin'],
      $v3_lsec['conf']['plugin'],
      $v3_lsec['conf']['tabname'],
      $v3_lsec['conf']['router']
    )
  );

  add_action(
    'very3_login_security-sidebar',
    'createSideMenu',
    array(
      $v3_lsec['conf']['plugin'],
      'Access Log',
      'report'
    )
  );

  add_action(
    'very3_login_security-sidebar',
    'createSideMenu',
    array(
      $v3_lsec['conf']['plugin'],
      'Settings',
      'setup'
    )
  );
}

register_style ('v3_lsec_dt_css', '//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/css/jquery.dataTables.min.css', '1.10.19', 'all');
queue_style ('v3_lsec_dt_css', GSBACK);

register_style ('v3_lsec_css', $SITEURL.'/plugins/'.$v3_lsec['conf']['plugin'].'/assets/css/main.css', '1.0', 'all');
queue_style ('v3_lsec_css', GSBACK);

register_style ('v3_lsec_fontawesome','//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css', '5.8.2', 'all');
queue_style ('v3_lsec_fontawesome', GSBACK );

register_script('v3_lsec_dt_js', '//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js', '1.10.19', FALSE);
queue_script('v3_lsec_dt_js', GSBACK);

register_script('v3_lsec_jv_js', '//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js', '1.19.1', FALSE);
queue_script('v3_lsec_jv_js', GSBACK);

register_script('v3_lsec_js', $SITEURL.'/plugins/'.$v3_lsec['conf']['plugin'].'/assets/js/main.js', '1.0', FALSE);
queue_script('v3_lsec_js', GSBACK);


#--------------------------------------------------------------------------------------------------
function v3_lsec_router() {
  if (isset($_GET['setup'])) {
    v3_lsec_setup();
  }
  else {
    v3_lsec_report();
  }
}
#--------------------------------------------------------------------------------------------------


#--------------------------------------------------------------------------------------------------
function v3_lsec_login() {
  global $user_xml, $userid, $password, $v3_lsec;

  $_state           = array();
  $_state['date']   = date("c");
  $_state['auth']   = 'Failed';
  $_state['email']  = 'none';
  $_state['user']   = $userid;
  $_state['pass']   = $password;
  $_state['ripa']   = $_SERVER['REMOTE_ADDR'];
  $_state['site']   = $v3_lsec['conf']['sitename'];
  $_state['url']    = $v3_lsec['conf']['siteurl'];
  $_state['uagent'] = $_SERVER['HTTP_USER_AGENT'];

  $_state  = array_merge($_state,v3_lsec_ipinfo());
  $_state  = array_merge($_state,v3_lsec_check_user());
  $_ipfile = $v3_lsec['conf']['datapath'].'/db/ip.db/'.$_state['ripa'];

  if (file_exists($_ipfile)) {
    $_stat  = stat($_ipfile);
    $_tleft = (time() - $_stat[9]);
    $_lines = count(file($_ipfile));

    if ((($_lines % $v3_lsec['conf']['settings']['maxtries']) == 0) and ($_tleft < $v3_lsec['conf']['settings']['timeout'])) {
      $_state['auth'] = 'Blocked';
      v3_lsec_log_state($_state,'access',$v3_lsec);

      ob_start(); require($v3_lsec['conf']['plugpath'].'/inc/blocked-ip-email.inc.php');
      $_state['msg'] = ob_get_clean();
      $_state['sub'] = '[Blocked] IP Address '.$_state['ripa'].' at '.$_state['site'].' ('.$_state['url'].')';

      syslog(LOG_WARNING|LOG_LOCAL0, 'V3SEC:'.$_state['sub']);
      v3_lsec_send_email($_state['sub'],$_state['msg'],$v3_lsec);
      v3_lsec_send_sms($_state['sub'],$_state['msg'],$v3_lsec);

      require($v3_lsec['conf']['plugpath'].'/inc/blocked-ip-http.inc.php');
      exit;
    }
  }

  if ($_state['auth'] == 'Failed') {
    if (!stat($v3_lsec['conf']['datapath'].'/db/ip.db')) {
      mkdir($v3_lsec['conf']['datapath'].'/db/ip.db', 0700, true);
    }
    $_db  = fopen($_ipfile,"a+");
    fwrite($_db, '"'.date("c").'","'.$_state['user'].'","'.$_state['pass']."\"\n");
    fclose($_db);
  }

  v3_lsec_log_state($_state,'access',$v3_lsec);

  ob_start(); require($v3_lsec['conf']['plugpath'].'/inc/login-email.inc.php');
  $_state['msg'] = ob_get_clean();
  $_state['sub'] = '['.$_state['auth'].'] user login by '.$userid.' ('.$_state['email'].') at '.$v3_lsec['conf']['sitename'].' ('.$v3_lsec['conf']['siteurl'].')';

  syslog(LOG_WARNING|LOG_LOCAL0,'V3SEC:'.$_state['sub']);
  v3_lsec_send_email($_state['sub'],$_state['msg'],$v3_lsec);
  v3_lsec_send_sms($_state['sub'],$_state['msg'],$v3_lsec);
}

#--------------------------------------------------------------------------------------------------


#--------------------------------------------------------------------------------------------------
function v3_lsec_check_user() {
  global $user_xml, $userid, $password, $v3_lsec;
  $_return = array();

  if (file_exists($user_xml)){
    $_data = getXML($user_xml);
    if (passhash($password) == $_data->PWD and strtolower($userid) == strtolower($_data->USR)) {
      $_return['auth']  = 'Successful';
      $_return['email'] = $_data->EMAIL;
      $_return['pass']  = '[valid]';
    }
    if (passhash($password) != $_data->PWD and strtolower($userid) == strtolower($_data->USR)) {
      $_return['auth']  = 'Failed';
      $_return['email'] = $_data->EMAIL;
      $_return['pass']  = '[invalid]';
    }
  }
  else {
    $_return['auth']  = 'Failed';
    $_return['email'] = '[invalid user]';
    $_return['pass']  = '[invalid user]';
  }

  return $_return;
}
#--------------------------------------------------------------------------------------------------


#--------------------------------------------------------------------------------------------------
function v3_lsec_report() {
  global $v3_lsec;

  $_act_err  = '';
  $_table    = array();
  $_counter  = 0;
  $_log_file = $v3_lsec['conf']['datapath'].'/logs/access.log';

  if (isset($_GET['report-action'])) {
    if ($_GET['report-action'] == 'clear-logs') {
      if (file_exists($_log_file)) {
        if (!unlink($_log_file)) {
          $_act_err = 'alert("There was a problem clearing the log.\nCheck your file permissions.");';
        }
      }
    }

    if ($_GET['report-action'] == 'clear-blocked') {
      $_sem_path = $v3_lsec['conf']['datapath'].'/db/ip.db';
      $_it       = new RecursiveDirectoryIterator($_sem_path, RecursiveDirectoryIterator::SKIP_DOTS);
      $_sems     = new RecursiveIteratorIterator($_it,RecursiveIteratorIterator::CHILD_FIRST);

      foreach($_sems as $_s) {
        if ($_s->isDir()){
          if (!rmdir($_s->getRealPath())) {
            $_act_err = 'alert("There was a problem clearing the blocks.\nCheck your file permissions.");';
          }
        } 
        else {
          if (!unlink($_s->getRealPath())) {
            $_act_err = 'alert("There was a problem clearing the blocks.\nCheck your file permissions.");';
          }
        }
      }
    }
  }

  array_push($_table,'
    <table id="v3-lsec-report">
      <thead>
        <tr>
          <th>Date</th>
          <th>Auth</th>
          <th>User</th>
          <th>IP</th>
          <th>Country</th>
          <th>Lat / Long</th>
        </tr>
      </thead>
      <tbody>
  ');

  if (file_exists($_log_file)) {
    $_csv = array_map('str_getcsv', file($_log_file));
    $_names = $_csv[0];

    foreach ($_csv as $_cl) {
      if ($_counter > 0) {
        $_d = array();
        $_c = array_combine($_names,$_cl);
        $_coord = explode(',',$_c['location']);

        foreach ($_c as $_cn => $_cv) {
          array_push($_d,'<tr><th>'.$_cn.'</th><td>'.$_cv.'</td></tr>');
        }

        array_push($_table,'<tr class="'.$_c['auth'].'">');
        array_push($_table,'<td><a href="#" class="v3-lsec-show-full" data-full="<table>'.join('',$_d).'"</table>'.$_c['date'].'</a></td>');
        array_push($_table,'<td>'.$_c['auth'].'</td>');
        array_push($_table,'<td>'.$_c['user'].'</td>');
 
        if ($_c['org'] != '-') {
          array_push($_table,'<td><a href="#" title="'.$_c['org'].'" class="v3-lsec-arin-lookup" data-ripa="'.$_c['ripa'].'">'.$_c['ripa'].'</a></td>');
        }
        else {
          array_push($_table,'<td><a href="#" class="v3-lsec-arin-lookup" data-ripa='.$_c['ripa'].'">'.$_c['ripa'].'</a></td>');
        }

        array_push($_table,'<td>'.$_c['country'].'</td>');
        
        if ($_c['location'] != '-,-') {
          array_push($_table,'<td><a href="#" class="v3-lsec-openstreetmap-lookup" title="'.$_c['city'].' '.$_c['region'].' '.$_c['country'].' '.$_c['postal'].'" data-lon="'.$_coord[0].'" data-lat="'.$_coord[1].'">'.$_c['location'].'</a></td>');
        }
        else {
          array_push($_table,'<td>-</td>');
        }

        array_push($_table,'</tr>');
      }

      $_counter++;
    }
  }
  else {
    array_push($_table,'<tr><td></td><td></td><td></td><td style="padding-left:100px;">Such empty...</td><td></td><td></td></tr>');
  }

  array_push($_table,'</tbody></table>');
  require($v3_lsec['conf']['plugpath'].'/inc/main-report.inc.php');
}
#--------------------------------------------------------------------------------------------------


#--------------------------------------------------------------------------------------------------
function v3_lsec_log_state($_state,$_log,$v3_lsec) {
  $_log_path   = $v3_lsec['conf']['datapath'].'/logs/'.$_log.'.log';
  $_log_header = '"'.join('","',array_keys($_state))."\"\n";
  $_log_entry  = '"'.join('","',array_values($_state))."\"\n";

  if (!stat($v3_lsec['conf']['datapath'].'/logs')) {
    mkdir($v3_lsec['conf']['datapath'].'/logs', 0700, true);
  }

  if (!file_exists($_log_path)) {
    $_log_file  = fopen($_log_path,"a+");
    fwrite($_log_file, $_log_header);
    fclose($_log_file);
  }

  $_log_file  = fopen($_log_path,"a+");
  fwrite($_log_file, $_log_entry);
  fclose($_log_file);
}
#--------------------------------------------------------------------------------------------------


#--------------------------------------------------------------------------------------------------
function v3_lsec_send_email($_sub,$_msg,$v3_lsec) {
  $_send_flag = true;

  if (empty($v3_lsec['conf']['settings']['to']) or empty($v3_lsec['conf']['settings']['from'])) {
    $_send_flag = false;
  }

  if (preg_match('/Successful/',$_sub) and $v3_lsec['conf']['settings']['email_send_success'] != 'yes') {
    $_send_flag = false;
  }

  if (preg_match('/Blocked/',$_sub) and $v3_lsec['conf']['settings']['email_send_blocked'] != 'yes') {
    $_send_flag = false;
  }

  if (preg_match('/Failed/',$_sub) and $v3_lsec['conf']['settings']['email_send_failed'] != 'yes') {
    $_send_flag = false;
  }

  if ($_send_flag) {
    $_smfrm = ' -f '.$v3_lsec['conf']['settings']['from'];
    $_to    = $v3_lsec['conf']['settings']['to'];
    $_hdr   = "From: ".$v3_lsec['conf']['settings']['from']."\r\n";
    $_hdr  .= 'Reply-To: '.$v3_lsec['conf']['settings']['from']."\r\n";
    $_hdr  .= "X-Mailer: Very3 Inline Mailer\r\n";
    $_hdr  .= "MIME-Version: 1.0" . "\r\n";
    $_hdr  .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $_err   = mail($_to,$_sub,$_msg,$_hdr,$_smfrm);
  }
}
#--------------------------------------------------------------------------------------------------


#--------------------------------------------------------------------------------------------------
function v3_lsec_send_sms($_sub,$_msg,$v3_lsec) {
  $_send_flag = true;

  if (empty($v3_lsec['conf']['settings']['tw_to']) or empty($v3_lsec['conf']['settings']['tw_from'])) {
    $_send_flag = false;
  }

  if (preg_match('/Successful/',$_sub) and $v3_lsec['conf']['settings']['sms_send_success'] != 'yes') {
    $_send_flag = false;
  }

  if (preg_match('/Blocked/',$_sub) and $v3_lsec['conf']['settings']['sms_send_blocked'] != 'yes') {
    $_send_flag = false;
  }

  if (preg_match('/Failed/',$_sub) and $v3_lsec['conf']['settings']['sms_send_failed'] != 'yes') {
    $_send_flag = false;
  }

  if ($_send_flag) {
    $_tw_url  = "https://api.twilio.com/2010-04-01/Accounts/".$v3_lsec['conf']['settings']['tw_sid']."/SMS/Messages";
    $_tw_from = $v3_lsec['conf']['settings']['tw_from'];
    $_tw_to   = $v3_lsec['conf']['settings']['tw_to'];
    $_tw_auth = $v3_lsec['conf']['settings']['tw_sid'].':'.$v3_lsec['conf']['settings']['tw_token'];
    $_tw_data = array('From' => $_tw_from,'To' => $_tw_to,'Body' => $_sub);

    $_tw_post = http_build_query($_tw_data);
    $_tw_curl = curl_init($_tw_url);

    curl_setopt($_tw_curl, CURLOPT_POST, true);
    curl_setopt($_tw_curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($_tw_curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($_tw_curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($_tw_curl, CURLOPT_USERPWD, "$_tw_auth");
    curl_setopt($_tw_curl, CURLOPT_POSTFIELDS, $_tw_post);

    $_tw_response = curl_exec($_tw_curl);
    curl_close($_tw_curl);
  }
}
#--------------------------------------------------------------------------------------------------


#--------------------------------------------------------------------------------------------------
function v3_lsec_setup() {
  global $v3_lsec;

  $_xml_data      = array();
  $_form_feedback = '';
  $_xml_save_resp = array(
    'There was an error writing the configuration, please check your folder and file permissions.',
    'Configuration Saved.',
  );

  if (isset($_POST['v3-lsec-save-settings'])) {
    $_xml_out = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><item></item>');
    foreach ($_POST as $_n => $_d) {
      $_node = $_xml_out->addChild($_n);
      $_node->addCData($_d);
    }
    $_xml_save_resp_index = XMLsave($_xml_out, $v3_lsec['conf']['datapath'].'/config.xml');
    $_form_feedback = 'alert("'.$_xml_save_resp[$_xml_save_resp_index].'")';
  }

  if (file_exists($v3_lsec['conf']['datapath'].'/config.xml')) {
    $_xml_data = getXml($v3_lsec['conf']['datapath'].'/config.xml');
  }

  require($v3_lsec['conf']['plugpath'].'/inc/main-form.inc.php');
}
#--------------------------------------------------------------------------------------------------


#--------------------------------------------------------------------------------------------------
function v3_lsec_ipinfo() {
  global $v3_lsec;

  $_return = array();
  $_ripa   = $_SERVER['REMOTE_ADDR'];

  if ($v3_lsec['conf']['settings']['disable_ipinfo'] != 'yes') {
    $_json = json_decode(file_get_contents("http://ipinfo.io/{$_ripa}/json"));
  }

  if (isset($_json->city)) { 
    $_return['city']     = $_json->city;
    $_return['region']   = $_json->region;
    $_return['country']  = $_json->country;
    $_return['postal']   = $_json->postal;
    $_return['location'] = $_json->loc;
    $_return['org']      = $_json->org;
  }
  else {
    $_return['city']     = '-';
    $_return['region']   = '-';
    $_return['country']  = '-';
    $_return['postal']   = '-';
    $_return['location'] = '-,-';
    $_return['org']      = '-';
  }

  return $_return;
}
#--------------------------------------------------------------------------------------------------

