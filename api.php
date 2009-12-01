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

$_provides['fieldTypes'] = array(
        'many2manyordered' => 'Many 2 Many List with Ordering',
        'newsletter_preview' => 'Send preview newsletter',
        'newsletter_send_now' => 'Send newsletter'
);


$_provides['pluginClasses'] = array(
        'Jojo_Plugin_newsletter_subscription' => 'Newsletter Subscriber',
        'Jojo_Plugin_newsletter_unsubscriber' => 'Newsletter Unsubscriber'
        );

$_options[] = array(
    'id'        => 'phplist_admin',
    'category'  => 'Newsletter',
    'label'     => 'PHPlist Admin file location',
    'description' => 'Full path to php list\'s admin index.php eg /home/httpd/phplist/lists/admin/index.php',
    'type'      => 'text',
    'default'   => '',
    'options'   => '',
    'plugin'    => 'jojo_newsletter_phplist'
);


$_options[] = array(
    'id'        => 'phplist_fromaddress',
    'category'  => 'Newsletter',
    'label'     => 'Newsletter "from" address',
    'description' => 'Address newsletters will appear to come from and bounce to eg noreply@example.com',
    'type'      => 'text',
    'default'   => 'noreply@example.com',
    'options'   => '',
    'plugin'    => 'jojo_newsletter_phplist'
);

$_options[] = array(
    'id'        => 'phplist_notifications',
    'category'  => 'Newsletter',
    'label'     => 'Subscribe/Unsubscribe notifications',
    'description' => 'Address for notifications to be sent to',
    'type'      => 'text',
    'default'   => '',
    'options'   => '',
    'plugin'    => 'jojo_newsletter_phplist'

);

$_options[] = array(
    'id'        => 'phplist_notifications_name',
    'category'  => 'Newsletter',
    'label'     => 'Subscribe/Unsubscribe notifications - Name',
    'description' => 'Name of the person to whom notifications to be sent to',
    'type'      => 'text',
    'default'   => '',
    'options'   => '',
    'plugin'    => 'jojo_newsletter_phplist'

);

$_options[] = array(
  'id'        => 'phplist_notifications_webmaster',
  'category'  => 'Newsletter',
  'label'     => 'Send Subscribe/Unsubscribe notifications to the Webmaster?',
  'description' => '',
  'type'        => 'radio',
  'default'     => 'yes',
  'options'     => 'yes,no',
  'plugin'    => 'jojo_newsletter_phplist'
);

$_options[] = array(
  'id'        => 'phplist_unsubscribe_behaviour',
  'category'  => 'Newsletter',
  'label'     => 'On unsubscribe, delete',
  'description' => 'Any: delete unsubscribing user from the system regardless, Newsletter: delete user if they have no login (newletter only user) otherwise just remove mailing list entries, None: leave user, but remove from mailing lists',
  'type'        => 'radio',
  'default'     => 'newsletteruser',
  'options'     => 'any,newsletteruser,none',
  'plugin'    => 'jojo_newsletter_phplist'
);

$_options[] = array(
    'id'        => 'phplist_phplocation',
    'category'  => 'Newsletter',
    'label'     => 'PHP Location',
    'description' => 'This is the location where PHP is on your server. Use ssh "whereis php", to find path. This is needed so that the send buttons can work.',
    'type'      => 'text',
    'default'   => '/usr/bin/php',
    'options'   => '',
    'plugin'    => 'jojo_newsletter_phplist'
);

$_options[] = array(
    'id'          => 'phplist_includeimages',
    'category'    => 'Newsletter',
    'label'       => 'Article Images',
    'description' => 'Include article images (if they have them) alongside the text snippet in the email',
    'type'        => 'radio',
    'default'     => 'yes',
    'options'     => 'yes,no',
    'plugin'    => 'jojo_newsletter_phplist'
);

$_options[] = array(
    'id'        => 'phplist_imagesize',
    'category'  => 'Newsletter',
    'label'     => 'Article image size',
    'description' => 'Sizing for article images in snippets - eg v25000, s100, w200',
    'type'      => 'text',
    'default'   => 'v25000',
    'options'   => '',
    'plugin'    => 'jojo_newsletter_phplist'
);

$_options[] = array(
    'id'        => 'phplist_bannerimage',
    'category'  => 'Newsletter',
    'label'     => 'Banner Image',
    'description' => 'Use the Banner Image manager to pick images for the email header',
    'type'        => 'radio',
    'default'     => 'yes',
    'options'     => 'yes,no',
    'plugin'    => 'jojo_newsletter_phplist'
);

$_options[] = array(
  'id'        => 'phplist_subscription_success_message',
  'category'  => 'Newsletter',
  'label'     => 'Subscription Success Message',
  'description' => 'The text of the success message shown on the screen',
  'type'        => 'textarea',
  'default'     => '',
  'options'     => '',
  'plugin'    => 'jojo_newsletter_phplist'
);

$_options[] = array(
  'id'        => 'phplist_thankyou',
  'category'  => 'Newsletter',
  'label'     => 'Is a thankyou email sent?',
  'description' => 'Set whether to send, then set the text of the email',
  'type'        => 'radio',
  'default'     => 'no',
  'options'     => 'yes,no',
  'plugin'    => 'jojo_newsletter_phplist'
);

$_options[] = array(
  'id'        => 'phplist_thankyou_email_text',
  'category'  => 'Newsletter',
  'label'     => 'Text of subscription thankyou email',
  'description' => 'The text of the thankyou email.',
  'type'        => 'textarea',
  'default'     => 'Thank you for subscribing to our newsletter. We look forward to keeping in contact with you.',
  'options'     => '',
  'plugin'    => 'jojo_newsletter_phplist'
);


$prefix = JOJO_Plugin_Jojo_Admin_Newsletter_Statistics::_getPrefix();
Jojo::registerURI("$prefix/[id:integer]/[.*]", 'Jojo_Plugin_Jojo_admin_newsletter_statistics'); // "morenewsletterstatistics/123/name-of-quote/"
Jojo::registerURI("$prefix/[id:integer]", 'Jojo_Plugin_Jojo_admin_newsletter_statistics'); // "morenewsletterstatistics/123"
Jojo::registerURI("$prefix/[url:string]", 'Jojo_Plugin_Jojo_admin_newsletter_statistics'); // "morenewsletterstatistics/url"