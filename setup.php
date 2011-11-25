<?php
/**
 *                    Jojo CMS
 *                ================
 *
 * Copyright 2007-2008 Harvey Kane <code@ragepank.com>
 * Copyright 2007-2008 Michael Holt <code@gardyneholt.co.nz>
 * Copyright 2007 Melanie Schulz <mel@gardyneholt.co.nz>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Harvey Kane <code@ragepank.com>
 * @author  Michael Cochrane <mikec@jojocms.org>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 */

/* add newsletter subscription page */
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_link='Jojo_Plugin_Jojo_Newsletter_Subscribe'");
if (!count($data)) {
    echo "Adding <b>Subscribe to a Newsletter</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Subscribe to a Newsletter', pg_link='Jojo_Plugin_Jojo_Newsletter_Subscribe', pg_url='subscribe'");
}

/* add newsletter unsubscribe page */
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_link='Jojo_Plugin_Jojo_Newsletter_Unsubscribe'");
if (!count($data)) {
    echo "Adding <b>Unsubscribe From Newsletter</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Unsubscribe From Newsletter', pg_link='Jojo_Plugin_Jojo_Newsletter_Unsubscribe', pg_url='unsubscribe'");
}

/* add newsletter viewing page */
$data = Jojo::selectRow("SELECT pageid FROM {page} WHERE pg_link='jojo_plugin_jojo_newsletter'");
if (!count($data)) {
    echo "Adding <b>Newsletter Online</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Newsletter', pg_link='jojo_plugin_jojo_newsletter', pg_url='newsletter', pg_status='hidden'");
}

/* Add Edit Newsletter Page */
$data = Jojo::selectRow("SELECT pageid FROM {page} WHERE pg_url='admin/newsletters'");
if (!$data) {
    echo "Adding <b>Newsletters</b> Page to Admin menu<br />";
    $_ADMIN_NEWSLETTER_ID = Jojo::insertQuery("INSERT INTO {page} SET pg_title='Edit Newsletters', pg_link='', pg_url='admin/newsletters', pg_parent = ?, pg_order = 2, pg_breadcrumbnav='no', pg_footernav='no', pg_sitemapnav='no', pg_xmlsitemapnav='no'", array($_ADMIN_ROOT_ID));
} else {
    $_ADMIN_NEWSLETTER_ID = $data['pageid'];
}

/* Add Edit Newsletter Page */
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_url='admin/edit/newsletter'");
if (!count($data)) {
    echo "Adding <b>Edit Newsletters</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Newsletters', pg_link='jojo_plugin_admin_edit', pg_url='admin/edit/newsletter', pg_parent = ?", $_ADMIN_NEWSLETTER_ID);
}

/* Add Edit Newsletter Page */
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_url='admin/edit/newslettersuser'");
if (!count($data)) {
    echo "Adding <b>Edit Newsletter Users</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Edit Newsletter Users', pg_link='jojo_plugin_admin_edit', pg_url='admin/edit/newslettersuser', pg_parent = ?", $_ADMIN_NEWSLETTER_ID);
}

/* Add Edit Newsletter Groups Page */
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_url='admin/edit/phplist_list'");
if (!count($data)) {
    echo "Adding <b>Edit Newsletter Groups</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Edit Newsletter Groups', pg_link='jojo_plugin_admin_edit', pg_url='admin/edit/phplist_list', pg_parent = ?", $_ADMIN_NEWSLETTER_ID);
}

/* add newsletter statistics page */
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_url='admin/newsletterstats'");
if (!count($data)) {
    echo "Adding <b>Newsletter Statistics</b> Page to Admin menu<br />";;
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Newsletter Statistics', pg_link='jojo_plugin_jojo_admin_newsletter_stats', pg_url='admin/newsletterstats', pg_parent=?, pg_status='active', pg_order='4', pg_breadcrumbnav='no', pg_footernav='no', pg_sitemapnav='no', pg_xmlsitemapnav='no'", $_ADMIN_NEWSLETTER_ID);
}

/* add more newsletter statistics page */
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_url='admin/more-newsletter-stats'");
if (!count($data)) {
    echo "Adding <b>More Newsletter Statistics</b> Page to Admin menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='More Newsletter Statistics', pg_link='jojo_plugin_jojo_admin_newsletter_statistics', pg_url='admin/more-newsletter-stats', pg_status='active', pg_order='4',pg_parent=?, pg_breadcrumbnav='no', pg_footernav='no', pg_sitemapnav='no', pg_xmlsitemapnav='no'", $_ADMIN_NEWSLETTER_ID);
}