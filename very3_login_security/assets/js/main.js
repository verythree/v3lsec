$(document).ready(function() {
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
