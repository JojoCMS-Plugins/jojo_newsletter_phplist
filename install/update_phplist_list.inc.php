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

$default_td['phplist_list'] = array(
        'td_name' => "phplist_list",
        'td_displayname' => "Newsletter Group",
        'td_primarykey' => "id",
        'td_displayfield' => "name",
        'td_deleteoption' => "yes",
        'td_menutype' => "list",
        'td_help' => "Newsletter Groups are managed from here.  The system will comfortably take many hundreds of newsletter groups.",
        'td_defaultpermissions' => "everyone.show=1 \n everyone.view=1 \n everyone.edit=1 \n everyone.add=1 \n everyone.delete=1 \n admin.show=1 \n admin.view=1 \n admin.edit=1 \n admin.add=1 \n admin.delete=1 \n registered.show=1 \n registered.view=1 \n registered.edit=1 \n registered.add=1 \n registered.delete=1 \n sysinstall.show=1 \n sysinstall.view=1 \n sysinstall.edit=1 \n sysinstall.add=1 \n sysinstall.delete=1",
    );

$default_fd['phplist_list']['id'] = array(
        'fd_name' => "ID",
        'fd_type' => "readonly",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_help' => "The Issue Number of the Newsletter",
    );

$default_fd['phplist_list']['name'] = array(
        'fd_name' => "Name",
        'fd_type' => "text",
        'fd_help' => "The Date the Newsletter Was Made",
    );

$default_fd['phplist_list']['description'] = array(
        'fd_name' => "Description",
        'fd_type' => "textarea",
        'fd_size' => "0",
        'fd_rows' => "4",
        'fd_cols' => "40",
    );

$default_fd['phplist_list']['entered'] = array(
        'fd_name' => "Entered",
        'fd_type' => "readonly",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
    );

$default_fd['phplist_list']['listorder'] = array(
        'fd_name' => "Listorder",
        'fd_type' => "hidden",
        'fd_showlabel' => "no",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
    );

$default_fd['phplist_list']['prefix'] = array(
        'fd_name' => "Prefix",
        'fd_type' => "hidden",
        'fd_showlabel' => "no",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
    );

$default_fd['phplist_list']['rssfeed'] = array(
        'fd_name' => "RSSfeed",
        'fd_type' => "hidden",
        'fd_showlabel' => "no",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
    );

$default_fd['phplist_list']['modified'] = array(
        'fd_name' => "Modified",
        'fd_type' => "readonly",
        'fd_default' => "CURRENT_TIMESTAMP",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
    );

$default_fd['phplist_list']['active'] = array(
        'fd_name' => "Active",
        'fd_type' => "radio",
        'fd_options' => "1:Yes \n 0:No",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
    );

$default_fd['phplist_list']['owner'] = array(
        'fd_name' => "Members",
        'fd_type' => "many2many",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_tabname' => "Members",
        'fd_m2m_linktable' => "phplist_listuser",
        'fd_m2m_linkitemid' => "listid",
        'fd_m2m_linkcatid' => "userid",
        'fd_m2m_cattable' => "newslettersuser",
    );