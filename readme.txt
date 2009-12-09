This plugin acts as a front end to phplist.

It assumes that you have phplist already setup, installed into the same database as
Jojo with a table prefix of 'phplist'. If you are running jojo with a table
prefix then add this on the front to eg jojoprefix_phplist...

It will remove the existing user_user table from phplist with a view based on
the jojo user table. It will also create a couple of other views. Because of
this, only run this on the latest version of MySQL.

The jojo_bannerimage plugin is required for jojo_newsletter_phplist to work.
Please install jojo_bannerimage first.

Pointers:
- Download the latest phplist from http://sourceforge.net/projects/phplist/files/
- Because of the database "views" created with jojo, the import functions of
  phplist do not work. Therefore check this plugin for 2 files. Copy the two
  updated files from lists into their respective directories (phplist-2.10.10)
  - if you use a table prefix, change 'user' to 'jojoprefix_user'
  - /lists/admin/import1.php
  - /lists/admin/commonlib/importcsv.php
- bounce management - see the config.php file for the following, and change to
  equal an email address. Otherwise the Return-path is set to the server default
  and you won't necessarily be advised of bounces.
  $message_envelope = 'bouncelist@domain.com';
- remove the test status, otherwise emails can't be sent
  change to: define ("TEST",0);
- and update the database and other config options

jojo admin options - newsletter
- set the phplist admin file location - this allows the newsletter to be sent via JOJO
  - ie for directadmin or cpanel /home/clientaccount/public_html/lists/admin/index.php
- set the PHP Location - Use ssh "whereis php", to find path
  ie DirectAdmin /usr/local/bin/php
  or cpanel /usr/bin/php

To send a newsletter, you may need to first use the send, followed by preview to
get it sent.

Newsletter formatting:
You in general need to use tables, and formating inside the code rather than
css files or css in the head.
http://msdn.microsoft.com/en-us/library/aa338201.aspx#Word2007MailHTMLandCSS_Word2007CSSSpecification

- Background images are not supported
- use style="display: block;" on images so margins are not added on images as seen
  in hotmail
- remember that emails as seen in hotmail/yahoo/gmail etc have their that pages
  specific head and body tags. So better to have nothing specific in <body> or
  the head section.
- the a element is meant to have full support including margin. But margin not
  supported fully on all email clients. Better to use &nbsp;
