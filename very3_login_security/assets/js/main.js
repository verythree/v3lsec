/*
** Very3 Login Security Plugin for GetSimple CMS
** (c)2019-2023 Very3 Technology Consultants
** Author: Mark Page [mark@very3.net]
** Internal Version: 23.12.22.823
** Released: Fri Dec 22 08:18:17 2023 -0600
*/

$(document).ready(function() {
  $('#nav_very3_login_security a i').removeClass('fa-puzzle-piece');
  $('#nav_very3_login_security a i').addClass('fa-unlock-alt');

  $('#v3-lsec-main-form').validate({
    rules: {
      maxtries: {
        required: true,
        number: true,
        min: 2
      },
      timeout: {
        required: true,
        number: true,
        min: 5
      },
      support: {
        required: false,
        url: true
      },
      from: {
        required: false,
        email: true
      },
      to: {
        required: false,
        email: true
      },
      tw_sid: {
        required: false,
        minlength: 34,
        maxlength: 34
      },
      tw_token: {
        required: false,
        minlength: 32,
        maxlength: 32
      }
    }
  });

  $('#v3-lsec-help-button a').on('click', function() {
    if ($('#v3-lsec-notes-wrapper').is(':visible')) {
      $('#v3-lsec-notes-wrapper').hide();
      $('#v3-lsec-help-button a').html('&#8853;');
    }
    else {
      $('#v3-lsec-notes-wrapper').show();
      $('#v3-lsec-help-button a').html('&#8854;');
    }
  });

  $('.v3-lsec-show-full').on('click', function() {
    $('#v3-lsec-overlay-title').html("Log Detail"); 
    $('#v3-lsec-overlay-content').html($(this).data('full')); 
    $('#v3-lsec-overlay').show();
  });

  $('#v3-lsec-overlay-closer').on('click', function() {
    $('#v3-lsec-overlay-content').html(); 
    $('#v3-lsec-overlay').hide();
  });

  $('.v3-lsec-arin-lookup').on('click', function() {
    window.open("https://search.arin.net/rdap/?query="+$(this).data('ripa'));
  });

  $('.v3-lsec-openstreetmap-lookup').on('click', function() {
    window.open('https://www.openstreetmap.org/#map=15/'+$(this).data('lon')+'/'+$(this).data('lat'));
  });

  $('#v3-lsec-clear-logs').on('click', function() {
    if (confirm("Clear access logs?\nAre you sure?")) {
      location.href="?id=very3_login_security&v3_lsec_router&report-action=clear-logs";
    }
  });

  $('#v3-lsec-reload-logs').on('click', function() {
    location.href="/admin/load.php?id=very3_login_security&report";
  });

  $('#v3-lsec-clear-blocked').on('click', function() {
    if (confirm("Clear blocked IP addresses?\nAre you sure?")) {
      location.href="?id=very3_login_security&v3_lsec_router&report-action=clear-blocked";
    }
  });

  $('#v3-lsec-report').DataTable({
    "order": [[0,"desc"]],
    "paging": true
  });

});
