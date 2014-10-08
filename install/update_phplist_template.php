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

$default_td['phplist_template'] = array(
        'td_name' => "phplist_template",
        'td_primarykey' => "id",
        'td_displayfield' => "title",
        'td_orderbyfields' => "title",
        'td_menutype' => "list",
        'td_defaultpermissions' => "everyone.show=0\neveryone.view=0\neveryone.edit=0\neveryone.add=0\neveryone.delete=0\nadmin.show=0\nadmin.view=0\nadmin.edit=0\nadmin.add=0\nadmin.delete=0\nnotloggedin.show=0\nnotloggedin.view=0\nnotloggedin.edit=0\nnotloggedin.add=0\nnotloggedin.delete=0\nregistered.show=0\nregistered.view=0\nregistered.edit=0\nregistered.add=0\nregistered.delete=0\nsysinstall.show=0\nsysinstall.view=0\nsysinstall.edit=0\nsysinstall.add=0\nsysinstall.delete=0\n",
    );

$default_fd['phplist_template']['id'] = array(
        'fd_name' => "ID",
        'fd_type' => "readonly",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
    );

$default_fd['phplist_template']['title'] = array(
        'fd_name' => "Title",
        'fd_type' => "text",
        'fd_help' => "",
    );

$default_fd['phplist_template']['template'] = array(
        'fd_name' => "Template",
        'fd_type' => "textarea",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
    );

$default_fd['phplist_template']['listorder'] = array(
        'fd_name' => "Listorder",
        'fd_type' => "integer",
        'fd_help' => "",
    );