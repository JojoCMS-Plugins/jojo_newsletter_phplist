<?php
/**
 *                    Jojo CMS
 *                ================
 *
 * Copyright 2008 Michael Cochrane <mikec@joojcms.org>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Michael Cochrane <mikec@jojocms.org>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 */

$default_td['newslettersuser'] = array(
        'td_name' => "newslettersuser",
        'td_displayname' => "Newsletter Subscribers",
        'td_primarykey' => "id",
        'td_displayfield' => "email",
        'td_deleteoption' => "yes",
        'td_menutype' => "list",
        'td_help' => "Newsletter subscribers are managed from here.  The system will comfortably take many hundreds of subscribers.",
        'td_defaultpermissions' => "everyone.show=0\neveryone.view=0\neveryone.edit=0\neveryone.add=0\neveryone.delete=0\nadmin.show=1\nadmin.view=1\nadmin.edit=1\nadmin.add=1\nadmin.delete=1\nnotloggedin.show=0\nnotloggedin.view=0\nnotloggedin.edit=0\nnotloggedin.add=0\nnotloggedin.delete=0\nregistered.show=1\nregistered.view=1\nregistered.edit=1\nregistered.add=1\nregistered.delete=1\nsysinstall.show=0\nsysinstall.view=0\nsysinstall.edit=0\nsysinstall.add=0\nsysinstall.delete=0\n",
    );

$o=0;

$default_fd['newslettersuser']['id'] = array(
        'fd_name' => "ID",
        'fd_type' => "readonly",
        'fd_default' => "0",
        'fd_help' => "A unique ID, automatically assigned by the system",
        'fd_order' => $o++,
        'fd_mode' => "advanced",
        'fd_tabname' => "Details",
    );

// First Name Field
$default_fd['newslettersuser']['firstname'] = array(
        'fd_name' => "First Name",
        'fd_type' => "text",
        'fd_size' => "20",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

// Last Name Field
$default_fd['newslettersuser']['lastname'] = array(
        'fd_name' => "Last Name",
        'fd_type' => "text",
        'fd_size' => "20",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

// Organisation Field
$default_fd['newslettersuser']['organisation'] = array(
        'fd_name' => "Organisation",
        'fd_type' => "text",
        'fd_size' => "20",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

$default_fd['newslettersuser']['email'] = array(
        'fd_name' => "Email",
        'fd_type' => "email",
        'fd_help' => "Email of Subscriber.",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

$default_fd['newslettersuser']['confirmed'] = array(
        'fd_name' => "Confirmed",
        'fd_type' => "radio",
        'fd_options' => "1:Yes \n 0:No",
        'fd_default' => "1",
        'fd_help' => "",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

$default_fd['newslettersuser']['htmlemail'] = array(
        'fd_name' => "Html Email",
        'fd_type' => "radio",
        'fd_options' => "1:Yes \n 0:No",
        'fd_default' => "1",
        'fd_help' => "",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

$default_fd['newslettersuser']['blacklisted'] = array(
        'fd_name' => "Blacklisted",
        'fd_type' => "radio",
        'fd_options' => "1:Yes \n 0:No",
        'fd_default' => "0",
        'fd_help' => "",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

$default_fd['newslettersuser']['disabled'] = array(
        'fd_name' => "Disabled",
        'fd_type' => "radio",
        'fd_options' => "1:Yes \n 0:No",
        'fd_default' => "0",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

$default_fd['newslettersuser']['groups'] = array(
        'fd_name' => "Newsletters Groups",
        'fd_type' => "many2many",
        'fd_help' => "A unique ID, automatically assigned by the system",
        'fd_m2m_linktable' => "phplist_listuser",
        'fd_m2m_linkitemid' => "userid",
        'fd_m2m_linkcatid' => "listid",
        'fd_m2m_cattable' => "phplist_list",
        'fd_tabname' => "Details",
        'fd_order' => $o++,
    );