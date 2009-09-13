<?php

/* Include user table update first so we can create a view against it */
include('install_user.inc.php');

$table = 'phplist_user_user';
$query = "CREATE VIEW {phplist_user_user} AS select
    `userid` AS `id`,
    `us_email` AS `email`,
    `confirmed` AS `confirmed`,
    `blacklisted` AS `blacklisted`,
    `bouncecount` AS `bouncecount`,
    `entered` AS `entered`,
    `modified` AS `modified`,
    md5(`userid`) AS `uniqid`,
    `htmlemail` AS `htmlemail`,
    `subscribepage` AS `subscribepage`,
    `rssfrequency` AS `rssfrequency`,
    `us_password` AS `password`,
    `passwordchanged` AS `passwordchanged`,
    `disabled` AS `disabled`,
    `extradata` AS `extradata`,
    `foreignkey` AS `foreignkey` from {user};";

/* Remove table if it exists */
if (Jojo::tableExists($table)) {
    Jojo::structureQuery('DROP TABLE ' . $table);
}

/* Check view exists */
if (!Jojo::tableExists($table, 'VIEWS')) {
    Jojo::structureQuery($query);

    echo sprintf("jojo_newsletter_phplist: View <b>%s</b> Does not exist - created view.<br />", $table);
}