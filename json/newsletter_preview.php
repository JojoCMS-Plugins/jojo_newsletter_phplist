<?php

/* Ensure users of this function have access to the admin page */
$page = Jojo_Plugin::getPage(Jojo::parsepage('admin'));
if (!$page->perms->hasPerm($_USERGROUPS, 'view')) {
    echo "Permission Denied";
    exit;
}

$id = Util::getFormData('id');
$email = Util::getFormData('email');
if (!$id || !$email) {
    exit;
}

$content = Jojo_Plugin_Jojo_Newsletter::assembleNewsletter($id);
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
                subject         = ?,
                fromfield       = ?,
                message         = ?,
                tofield         = ?,
                replyto         = '',
                footer          = '',
                entered         = ?,
                embargo         = ?,
                repeatuntil     = ?,
                status          = 'queued',
                sent            = ?,
                htmlformatted   = 1,
                sendformat      = 'HTML',
                ashtml          = 1,
                sendstart       = ?,
                template        = ?",
                array($content['subject'], $content['sender'], $content['content'], $email,
                      $test_date, $test_date, $test_date, $test_date,
                      $test_date, $templateid)
    );

/* Delete all existing newsletter previewer mailing lists*/
jojo::deleteQuery("DELETE FROM {phplist_list} WHERE name = 'newsletter previewer'");

/* Insert a preview mailing list group as a new mailing list group */
jojo::insertQuery("INSERT INTO {phplist_list} SET name = 'newsletter previewer'");
$listid =  jojo::selectQuery("SELECT id FROM {phplist_list} WHERE name = 'newsletter previewer'");
$listid = $listid[0]['id'];

/* Check if the email already exists in the database */
$user = jojo::selectQuery('SELECT id FROM {newslettersuser} WHERE email = ?', $email);
if(!isset($user[0])) {
    /* Insert the preview recipient as a new user*/
    jojo::insertQuery("INSERT INTO {newslettersuser} SET
                    email            = ?,
                    confirmed        = 1,
                    htmlemail        = 1",
                    array($email)
                    );
    $userid = jojo::selectQuery("SELECT MAX(id) as userid FROM {newslettersuser} WHERE email = ?", array($email));
    $userid = $userid[0]['userid'];
} else {
    $userid = $user[0]['id'];
}

/* Assign the preview recipient as a member of the created preview mailing list */
jojo::insertQuery("INSERT INTO {phplist_listuser} SET
        userid      = ?,
        listid      = ?,
        entered     = ?",
        array($userid, $listid, $test_date)
    );

/* Assign the newly made message to the desired mailing list  */
jojo::insertQuery("INSERT INTO {phplist_listmessage} SET
        messageid   = ?,
        listid      = ?,
        entered     = ?",
        array($messageid, $listid, $test_date)
    );

/* Send the message, which was queued, from phplist.  So that commandline executions are possible, "root" was added as commandline_users in the config/config.php file. */
putenv('USER=admin');
echo system(Jojo::getOption('phplist_phplocation') . ' ' . Jojo::getOption('phplist_admin') . ' -pprocessqueue');
echo system(Jojo::getOption('phplist_phplocation') . ' ' . Jojo::getOption('phplist_admin') . ' -pprocessqueue');

jojo::deleteQuery('DELETE FROM {phplist_message} WHERE tofield =?', $email);