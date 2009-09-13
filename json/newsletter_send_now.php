<?php

/* Ensure users of this function have access to the admin page */
$page = Jojo_Plugin::getPage(Jojo::parsepage('admin'));
if (!$page->perms->hasPerm($_USERGROUPS, 'view')) {
    echo "Permission Denied";
    exit;
}

$id = Util::getPost('id', 1);
$email = Util::getPost('email');

$content = Jojo_PLugin_Jojo_Newsletter::assembleNewsletter($id);
if (!$content) {
    exit;
}

/* Get the templateid */
$templateid = $content['template'];

/* Variables required to compose and send a message to a mailing list */
$offset = date('Z') - (Jojo::getOption('servertimezone') * 60 *60);
$test_date = date("Y-m-d H:i:s", (time() - $offset - 1));

/* Insert the message into the database and prepare it for dispatch */
$messageid = jojo::insertQuery("INSERT INTO {phplist_message} SET
                subject            = ?,
                fromfield          = ?,
                message            = ?,
                tofield            = '',
                replyto            = '',
                footer             = '',
                entered            = ?,
                embargo            = ?,
                repeatuntil        = ?,
                status             = 'queued',
                sent               = ?,
                htmlformatted      = 1,
                sendformat         = 'HTML',
                ashtml             = 1,
                sendstart          = ?,
                template           = ?",
                array($content['subject'], $content['sender'], $content['content'],
                      $test_date, $test_date, $test_date, $test_date,
                      $test_date, $content['template'])
    );

/* Assigns the newly made message to the desired mailing list */
foreach ($content['lists'] as $listid) {
    jojo::insertQuery("INSERT INTO {phplist_listmessage} SET
        messageid        = ?,
        listid            = ?,
        entered            = ?",
        array($messageid, $listid,  $test_date)
    );
}

/* Send the message, which was queued, from phplist.  So that commandline executions are possible, "root" was added as commandline_users in the config/config.php file. */
putenv('USER=admin');
echo system(Jojo::getOption('phplist_phplocation') . ' ' . Jojo::getOption('phplist_admin') . ' -pprocessqueue');
echo system(Jojo::getOption('phplist_phplocation') . ' ' . Jojo::getOption('phplist_admin') . ' -pprocessqueue');

/* Assign sent date to newsletter */
jojo::updateQuery("UPDATE {newsletter} SET sentdate = ? WHERE id = ?", array(time(), $id));
