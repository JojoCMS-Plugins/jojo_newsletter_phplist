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

$default_td['newsletter'] = array(
        'td_name' => "newsletter",
        'td_displayname' => "Newsletter",
        'td_primarykey' => "id",
        'td_displayfield' => "name",
        'td_deleteoption' => "yes",
        'td_orderbyfields' => "id DESC",
        'td_menutype' => "list",
        'td_help' => "Newsletters are managed from here.  The system will comfortably take many hundreds of newsletters.",
        'td_defaultpermissions' => "everyone.show=1\neveryone.view=1\neveryone.edit=1\neveryone.add=1\neveryone.delete=1\nadmin.show=1\nadmin.view=1\nadmin.edit=1\nadmin.add=1\nadmin.delete=1\nnotloggedin.show=0\nnotloggedin.view=0\nnotloggedin.edit=0\nnotloggedin.add=0\nnotloggedin.delete=0\nregistered.show=1\nregistered.view=1\nregistered.edit=1\nregistered.add=1\nregistered.delete=1\nsysinstall.show=1\nsysinstall.view=1\nsysinstall.edit=1\nsysinstall.add=1\nsysinstall.delete=1\n",
    );

$o=0;

$default_fd['newsletter']['id'] = array(
        'fd_name' => "ID",
        'fd_type' => "readonly",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );

$defaulttemplate = Jojo::selectRow("SELECT id FROM {phplist_template}");
$defaulttemplate = isset($defaulttemplate['id']) ? $defaulttemplate['id'] : 1;
// Template
$default_fd['newsletter']['template'] = array(
        'fd_name' => "Template",
        'fd_type' => "dblist",
        'fd_options' => "phplist_template",
        'fd_default' => $defaulttemplate,
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );

$default_fd['newsletter']['name'] = array(
        'fd_name' => "Subject",
        'fd_type' => "text",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );

$default_fd['newsletter']['issue_number'] = array(
        'fd_name' => "Issue Number",
        'fd_type' => "integer",
        'fd_required' => "yes",
        'fd_help' => "The Issue Number of the Newsletter",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );

$default_fd['newsletter']['intro'] = array(
        'fd_name' => "Introduction",
        'fd_type' => "hidden",
        'fd_size' => "0",
        'fd_rows' => "6",
        'fd_cols' => "40",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );

$default_fd['newsletter']['outro'] = array(
        'fd_name' => "Outro",
        'fd_type' => "hidden",
        'fd_size' => "0",
        'fd_rows' => "6",
        'fd_cols' => "40",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );

// Intro Field
$default_fd['newsletter']['intro_code'] = array(
        'fd_name' => "Intro",
        'fd_type' => "texteditor",
        'fd_options' => "intro",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );

// Outro Field
$default_fd['newsletter']['outro_code'] = array(
        'fd_name' => "Outro",
        'fd_type' => "texteditor",
        'fd_options' => "outro",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );
    

$default_fd['newsletter']['date'] = array(
        'fd_name' => "Date",
        'fd_type' => "unixdate",
        'fd_help' => "The Date the Newsletter Was Made",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );

if (class_exists('JOJO_Plugin_Jojo_bannerimage')) {
$default_fd['newsletter']['header_image'] = array(
        'fd_name' => "Header Image",
        'fd_type' => "dblist",
        'fd_options' => "bannerimage",
        'fd_required' => "no",
        'fd_help' => "Image on the Newsletter Header.",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );
}
// Truncate and link articles
$default_fd['newsletter']['link'] = array(
        'fd_name' => "Link to full Article",
        'fd_type' => "checkbox",
        'fd_options' => "yes\nno",
        'fd_default' => "yes",
        'fd_help' => "Truncate the article in the email and provide a link to the full article on the site",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );

$default_fd['newsletter']['articles'] = array(
        'fd_name' => "Articles To Include",
        'fd_type' => "many2manyordered",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_showlabel' => "no",
        'fd_tabname' => "2. Articles",
        'fd_m2m_linktable' => "newsletter_article",
        'fd_m2m_linkitemid' => "newsletterid",
        'fd_m2m_linkcatid' => "articleid",
        'fd_m2m_cattable' => "article",
    );

$default_fd['newsletter']['groups'] = array(
        'fd_name' => "Groups",
        'fd_type' => "many2many",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_tabname' => "3. Groups",
        'fd_m2m_linktable' => "newsletter_list",
        'fd_m2m_linkitemid' => "newsletterid",
        'fd_m2m_linkcatid' => "listid",
        'fd_m2m_cattable' => "phplist_list",
    );

$default_fd['newsletter']['preview'] = array(
        'fd_name' => "Preview",
        'fd_type' => "newsletter_preview",
        'fd_showlabel' => "no",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_tabname' => "4. Send",
    );

$default_fd['newsletter']['sender'] = array(
        'fd_name' => "Sender email",
        'fd_type' => "text",
        'fd_size' => "30",
        'fd_tabname' => "4. Send",
    );

$default_fd['newsletter']['send'] = array(
        'fd_name' => "Newsletter Delivery",
        'fd_type' => "newsletter_send_now",
        'fd_showlabel' => "no",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_tabname' => "4. Send",
    );

$default_fd['newsletter']['sentdate'] = array(
        'fd_name' => "Date Sent",
        'fd_type' => "unixdate",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => "6",
        'fd_tabname' => "4. Send",
    );