<?php

$table = 'user';
$query = "CREATE TABLE {user} (
  `userid` int(11) NOT NULL auto_increment,
  `us_login` varchar(100) NOT NULL default '',
  `us_password` varchar(40) NOT NULL default '',
  `us_lastsuccess` datetime NOT NULL default '0000-00-00 00:00:00',
  `us_lastfailure` datetime NOT NULL default '0000-00-00 00:00:00',
  `us_failures` int(11) NOT NULL default '0',
  `us_locked` int(11) NOT NULL default '0',
  `us_firstname` varchar(100) NOT NULL default '',
  `us_lastname` varchar(100) NOT NULL default '',
  `us_email` varchar(100) NOT NULL default '',
  `us_signature` varchar(255) NOT NULL default '',
  `us_status` enum('active','inactive') NOT NULL default 'active',
  `us_reminder` varchar(255) NOT NULL default '',
  `us_reset` varchar(255) NOT NULL default '',
  `us_permissions` text,
  `us_website` varchar(255) NOT NULL default '',
  `us_organisation` varchar(255) NOT NULL default '',
  `us_avatar` varchar(255) NOT NULL default '',
  `us_tagline` varchar(255) NOT NULL default '',
  `us_location` varchar(255) NOT NULL default '',
  `us_timezone` int(11) NOT NULL default '12',
  `us_approvecode` varchar(40) NOT NULL default '',
  `us_deletecode` varchar(40) NOT NULL default '',
  `us_groups` varchar(255) NOT NULL default '',
  `confirmed` tinyint(4) default '0',
  `blacklisted` tinyint(4) default '0',
  `bouncecount` int(11) default '0',
  `entered` datetime default NULL,
  `modified` timestamp NOT NULL,
  `htmlemail` tinyint(4) NOT NULL,
  `subscribepage` int(11) default NULL,
  `rssfrequency` varchar(100) default NULL,
  `password` varchar(255) default NULL,
  `passwordchanged` date default NULL,
  `disabled` tinyint(4) NOT NULL,
  `extradata` text,
  `foreignkey` varchar(100) default NULL,
  PRIMARY KEY  (`userid`)
);";

/* Check table structure */
$result = Jojo::checkTable($table, $query);

/* Output result */
if (isset($result['created'])) {
    echo sprintf("jojo_newsletter_phplist: Table <b>%s</b> Does not exist - created empty table.<br />", $table);
}

if (isset($result['added'])) {
    foreach ($result['added'] as $col => $v) {
        echo sprintf("jojo_newsletter_phplist: Table <b>%s</b> column <b>%s</b> Does not exist - added.<br />", $table, $col);
    }
}

if (isset($result['different'])) Jojo::printTableDifference($table,$result['different']);