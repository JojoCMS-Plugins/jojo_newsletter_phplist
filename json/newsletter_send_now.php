<?php

/* Ensure users of this function have access to the admin page */
$page = Jojo_Plugin::getPage(Jojo::parsepage('admin'));
if (!$page->perms->hasPerm($_USERGROUPS, 'view')) {
    echo "Permission Denied";
    exit;
}

$id = Jojo::getPost('id', 1);
$email = Jojo::getPost('email');

$content = Jojo_Plugin_Jojo_Newsletter::assembleNewsletter($id);
if (!$content) {
    exit;
}

/* Get the templateid */
$templateid = $content['template'];

/* Insert the message into the database and prepare it for dispatch */
$messageid = jojo::insertQuery("INSERT INTO {phplist_message} SET
                subject            = ?,
                fromfield          = ?,
                message            = ?,
                tofield            = '',
                replyto            = '',
                footer             = '',
                entered            = now(),
                embargo            = '0000-00-00 00:00:00',
                repeatuntil        = '0000-00-00 00:00:00',
                status             = 'queued',
                htmlformatted      = 1,
                sendformat         = 'HTML',
                ashtml             = 1,
                sendstart          = now(),
                template           = ?",
                array($content['subject'], $content['sender'], $content['content'], $content['template'])
    );

/* Assigns the newly made message to the desired mailing list */
foreach ($content['lists'] as $listid) {
    Jojo::insertQuery("INSERT INTO {phplist_listmessage} SET
        messageid        = ?,
        listid            = ?,
        entered            = now()",
        array($messageid, $listid)
    );
}

/* Send the message, which was queued, from phplist.  So that commandline executions are possible, "root" was added as commandline_users in the config/config.php file. */
putenv('USER=admin');
echo system(Jojo::getOption('phplist_phplocation') . ' ' . Jojo::getOption('phplist_admin') . ' -pprocessqueue' . (Jojo::getOption('phplist_config', '') ? ' -c ' . Jojo::getOption('phplist_config') : ''));

/* Assign sent date to newsletter using local time, not server time */
Jojo::updateQuery("UPDATE {newsletter} SET sentdate = ? WHERE id = ?", array(time(), $id));
