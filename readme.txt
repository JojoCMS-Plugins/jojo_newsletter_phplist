This plugin acts as a front end to phplist.

It assumes that you have phplist already setup, installed into the same database as
Jojo with a table prefix of 'phplist'. If you are running jojo with a table
prefix then add this on the front to eg jojoprefix_phplist...

It will remove the existing user_user table from phplist with a view based on
the jojo user table. It will also create a couple of other views. Because of
this, only run this on the latest version of MySQL.

The PHPlist Admin file location and the PHPlist Admin from address should also 
be supplied at the Site Options for this plugin to work properly.

The jojo_bannerimage plugin is required for jojo_newsletter_phplist to work. 
Please install jojo_bannerimage first. 