<?php
/**
 *                    Jojo CMS
 *                ================
 *
 * Copyright 2008 Jojo CMS
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Michael Cochrane <mikec@jojocms.org>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 */

/* Details Tab */


$default_fd['user']['confirmed'] = array(
        'fd_name' => "Confirmed",
        'fd_type' => "radio",
        'fd_options' => "1:Yes \n 0:No",
        'fd_default' => "1",
        'fd_help' => "",
        'fd_order' => "3",
        'fd_tabname' => "Newsletter",
    );

$default_fd['user']['htmlemail'] = array(
        'fd_name' => "Html Email",
        'fd_type' => "radio",
        'fd_options' => "1:Yes \n 0:No",
        'fd_default' => "1",
        'fd_help' => "",
        'fd_order' => "4",
        'fd_tabname' => "Newsletter",
    );

$default_fd['user']['blacklisted'] = array(
        'fd_name' => "Blacklisted",
        'fd_type' => "radio",
        'fd_options' => "1:Yes \n 0:No",
        'fd_default' => "0",
        'fd_help' => "",
        'fd_order' => "5",
        'fd_tabname' => "Newsletter",
    );

$default_fd['user']['disabled'] = array(
        'fd_name' => "Disabled",
        'fd_type' => "radio",
        'fd_options' => "1:Yes \n 0:No",
        'fd_default' => "0",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => "6",
        'fd_tabname' => "Newsletter",
    );

$default_fd['user']['bouncecount'] = array(
        'fd_name' => "Bounced",
        'fd_type' => "readonly",
        'fd_default' => "0",
        'fd_order' => "7",
        'fd_tabname' => "Newsletter",
    );

$default_fd['user']['entered'] = array(
        'fd_name' => "Entered",
        'fd_type' => "readonly",
        'fd_default' => "0",
        'fd_order' => "8",
        'fd_tabname' => "Newsletter",
    );

$default_fd['user']['modified'] = array(
        'fd_type' => "hidden",
        'fd_tabname' => "Newsletter",
    );

$default_fd['user']['us_organisation'] = array(
        'fd_type' => "text",
        'fd_tabname' => "Details",
        'fd_order' => 7,
    );



$default_fd['user']['subscribepage'] = array(
        'fd_type' => "hidden",
        'fd_tabname' => "Newsletter",
    );
$default_fd['user']['rssfrequency'] = array(
        'fd_type' => "hidden",
        'fd_tabname' => "Newsletter",
    );
$default_fd['user']['password'] = array(
        'fd_type' => "hidden",
        'fd_tabname' => "Newsletter",
    );
$default_fd['user']['passwordchanged'] = array(
        'fd_type' => "hidden",
        'fd_tabname' => "Newsletter",
    );
$default_fd['user']['extradata'] = array(
        'fd_type' => "hidden",
        'fd_tabname' => "Newsletter",
    );
$default_fd['user']['foreignkey'] = array(
        'fd_type' => "hidden",
        'fd_tabname' => "Newsletter",
    );
