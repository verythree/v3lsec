# v3lsec: Very3 Login Security Plugin for GetSimple CMS

### A word of caution...
If you're looking to use this with your GetSimple website, we suggest grabbing the packaged version in the GetSimple Extend 
Repository at [http://get-simple.info/extend/plugin/v3lsec-very3-login-security/1211/](http://get-simple.info/extend/plugin/v3lsec-very3-login-security/1211/).
The Github version (the one you're looking at now) is automatically updated from the development source and may have a bug 
or two or thirteen. ;-)

### About
The Very3 Login Security Plugin for GetSimple CMS utilizes the GS [*successful-login-start*](http://get-simple.info/wiki/plugins:hooks_filters)
hook and attempts to verify the user name and password hash before completing the authentication flow. If the user does not exist 
or the login credentials appear to be bogus, a counter is incremented based on the user's IP address (REMOTE_ADDR). Once the 
count reaches the desired threshold the plugin disallows any form authentication flow until the set timeout occurs.

Additionally the plugin provides granular notifications via email and SMS, and logs location data based on the remote IP by 
utilizing the [IPinfo API](http://ipinfo.io) (the free version limited to 1000 requests per day). The main report page links 
the IP addresses to the [ARIN Whois/RDAP](https://search.arin.net/rdap/) search and the latitude/longitude coordinates to the 
[OpenStreetMap](https://www.openstreetmap.org) search.

This plugin **does not** prevent or mitigate IP-based network attacks on your GetSimple host server, it simply prevents 
the login page form from being submitted for a given IP address for a configured duration. That said, this plugin **does** 
create syslog entries that can be leveraged by services such as [Fail2ban](https://www.fail2ban.org) and [OSSEC](https://www.ossec.net/).

### Installation & Configuration
To install this plugin, download the zip file and extract to your GetSimple plugins folder. Once installed and activated, see 
the settings page under the "V3LSEC" tab for configuration options. For support, please visit the GetSimple Community Forum at
[http://get-simple.info/forums/showthread.php?tid=10896](http://get-simple.info/forums/showthread.php?tid=10896).

Out of the box, this plugin will block a remote IP address after 5 bad login attempts for 600 seconds (10 minutes) and send no 
notification. You must configure email addresses (they can be the same) and select at least one "Send Email on..." option to 
receive email notifications.  The SMS function requires that you have a [Twilio](https://www.twilio.com/) account and select 
at least one "Send SMS on..." option to receive SMS notifications.

### Well crap, I've locked myself out of my GS site
Then it sucks to be you right now. If you have access to another computer on another network (from a different IP address, duh) or 
maybe via a cellular link, you can simply login and click the "Clear Blocks" button from the V3LSEC tab. If you have ssh access to
your GetSimple host, login and dig down to your GS data folder (usually in the base install dir) then go to */other/very3_login_security/db/*
and delete the *ip.db* folder.

Or you can just wait. =)

