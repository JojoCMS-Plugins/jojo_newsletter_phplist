<?php

$table = 'newsletter_article';
$query = "CREATE TABLE {newsletter_article} (
  `newsletterid` int(11) NOT NULL,
  `articleid` int(11) NOT NULL,
  `order` int(11) NOT NULL
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