<?php

$table = 'newsletter';
$query = "CREATE TABLE {newsletter} (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `template` int(11) NOT NULL,
  `articles` text NOT NULL,
  `groups` text NOT NULL,
  `sentdate` bigint(20) NOT NULL,
  `intro` text NOT NULL,
  `outro` text NOT NULL,
  `link` enum('yes','no') NOT NULL default 'yes',
  `preview` tinyint(4) NOT NULL,
  `send` tinyint(4) NOT NULL,
  `issue_number` int(11) NOT NULL,
  `date` bigint(20) NOT NULL,
  ";
if (class_exists('JOJO_Plugin_Jojo_bannerimage')) {
    $query .= "`header_image` int(11) NOT NULL,
    ";
}
$query .= "PRIMARY KEY  (`id`) );";

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