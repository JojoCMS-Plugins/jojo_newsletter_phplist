<?php

/* Include user table update first so we can create a view against it */
include('install_user.inc.php');

$table = 'newslettersuser';
$query = "CREATE VIEW {newslettersuser} AS select
                `userid` AS `id`,
                `us_email` AS `email`,
                `confirmed` AS `confirmed`,
                `blacklisted` AS `blacklisted`,
                `htmlemail` AS `htmlemail`,
                `disabled` AS `disabled`,
                `us_firstname` AS `firstname`,
                `us_lastname` AS `lastname`,
                `us_organisation` AS `organisation`,
                `us_groups` AS `groups` from {user};";

/* Check table structure */
if (!Jojo::tableExists($table, 'VIEWS')) {
    Jojo::structureQuery($query);

    echo sprintf("jojo_newsletter_phplist: View <b>%s</b> Does not exist - created view.<br />", $table);
} else {
  $exists = jojo::selectQuery("SHOW COLUMNS FROM {newslettersuser}");
  $n = count($exists);
  $firstname=false;
  for ($i=0; $i<$n; $i++) {
    if($exists[$i]['Field']=='firstname') $firstname=true;
  };
  if(!$firstname) {
    $query_delete='DROP VIEW {newslettersuser}';
    Jojo::structureQuery($query_delete);
    Jojo::structureQuery($query);
    echo sprintf("jojo_newsletter_phplist: View <b>%s</b> Existed - deleted and recreated.<br />", $table);
  }
}

$query = "INSERT IGNORE INTO {usergroups} (
`groupid` ,
`gr_name`
)
VALUES (
'newsletter', 'Newsletter'
);";

 jojo::insertQuery($query);

