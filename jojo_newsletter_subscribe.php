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

class Jojo_Plugin_Jojo_Newsletter_Subscribe extends JOJO_Plugin
{

    function sendEnquiry()
    {
        global $smarty;
        $date_today = date("Y-m-d H:i:s");

        /* Check for form injection attempts */
        Jojo::noFormInjection();

        $fields = array();
        /* First preference is fields from customised jojo_newsletter_subscription_fields.php in any plugin or theme */
        foreach (Jojo::listPlugins('newsletter_subscription_fields.php') as $pluginfile) {
          include($pluginfile);
          break;
        }
        $errors = array();
        $listids = (array)$_POST['form_list'];

        foreach ($fields as &$field) {
            /* set field value from POST */
            if (is_array($_POST['form_' . $field['field']])) {
                /* convert array to string */
                $field['value'] = implode(', ', $_POST['form_' . $field['field']]);
                /* create an assoc array for resetting the value of checkboxes when server-side checking fails */
                $field['valuearr'] = array();
                foreach($_POST['form_' . $field['field']] as $f) {
                    $field['valuearr'][$f] = $f;
                }
            } else {
                $field['value'] = Jojo::getFormData('form_' . $field['field'], '');
            }

            /* check value is set on required fields */
            if ($field['required'] && empty($field['value'])) {
                $errors[] = $field['display'] . ' is a required field';
            }
            if (!empty($field['value'])) {
                switch ($field['validation']) {
                case 'email':
                   if (!Jojo::checkEmailFormat($field['value'])) {$errors[] = $field['display'] . ' is not a valid email format';}
                   break;
                case 'url':
                   $field['value'] = addHttp($field['value']);
                   if (!Jojo::checkUrlFormat($field['value'])) {$errors[] = $field['display'] . ' is not a valid URL format';}
                   break;
                case 'text':
                   //do we need to check anything?
                   break;
                case 'integer':
                   if (!is_numeric($field['value'])) {$errors[] = $field['display'] . ' is not an integer value';}
                   break;
                case 'numeric':
                   if (!is_numeric($field['value'])) {$errors[] = $field['display'] . ' is not an integer value';}
                   break;
                }
            }
        }
        unset($field);

        if (Jojo::getOption('contactcaptcha') == 'yes') {
          $captchacode = Jojo::getFormData('CAPTCHA','');
          if (!PhpCaptcha::Validate($captchacode)) {
            $errors[] = 'Incorrect Spam Prevention Code entered';
          }
        }

        if (count($errors)) {
          $smarty->assign('message', implode("<br />\n", $errors));
          $smarty->assign('fields', $fields);
          return false;
        }

        /* Check if the email already exists in the database */
        $user = Jojo::selectRow('SELECT id FROM {newslettersuser} WHERE email = ?', $_POST['form_replyemail']);
        if(!count($user)) {
           /* Insert the new subscriber to the mailing list*/
            $userid = jojo::insertQuery("INSERT INTO {newslettersuser} SET
                            email			= ?,
                            firstname = ?,
                            lastname  = ?,
                            confirmed		= 1,
                            htmlemail		= 1",
                            array($_POST['form_replyemail'],$_POST['form_firstname'],$_POST['form_lastname'])
                );
               /* insert usergroup 'newsletter' against user */
              jojo::insertQuery("INSERT INTO {usergroup_membership} SET
                                    userid = ?,
                                    groupid= ?",
                                array($userid, "newsletter"));
        } else {
            $userid = $user['id'];
        }

        /* Check if the subscriber is an existing user */
        $existing_user_lists = Jojo::selectAssoc('SELECT listid as lid, listid FROM {phplist_listuser} WHERE userid = ?', $userid);
        foreach ($listids as $listid) {
            if(!count($existing_user_lists) || !isset($existing_user_lists[$listid])) {
                jojo::insertQuery("INSERT INTO {phplist_listuser} SET
                        userid			= ?,
                        listid			= ?,
                        entered 	= '" . $date_today . "'",
                        array($userid, $listid) /* Place the id of your list here  */
                    );
            } else { /* check if the subscriber was blacklisted and remove from blacklist if blacklisted.*/
                $blacklisted_user = Jojo::selectRow('SELECT blacklisted FROM {newslettersuser} WHERE id = ?', $userid);
                if($blacklisted_user['blacklisted'] == 1) {
                    Jojo::updateQuery('UPDATE {newslettersuser} SET blacklisted = 0 WHERE id = ?', $userid);
                    $smarty->assign('message', 'You are now subscribed to the ' . Jojo::getOption('sitetitle') . ' Newsletter.');
                }else{
                    $smarty->assign('message', 'You were already subscribed to the ' . Jojo::getOption('sitetitle') . ' Newsletter.');
                }
            }
        }

        /* add attributes */
        foreach ($fields as $field) {
            if($field['field'] != 'replyemail' && $field['field'] != 'list') {
                $attribute_exists = Jojo::selectRow('SELECT id FROM {phplist_user_attribute} WHERE name = ?', $field['field']);
                $attributeid = count($attribute_exists) ? $attribute_exists['id'] : 0;
                if ($attributeid && !count(Jojo::selectRow('SELECT * FROM {phplist_user_user_attribute} WHERE userid = ? AND attributeid = ?', array($userid, $attributeid)))) {
                    Jojo::insertQuery("INSERT INTO {phplist_user_user_attribute} SET
                        attributeid = ?,
                        userid			= ?,
                        value       = ?",
                        array($attributeid, $userid, $field['value'])
                      );
                } else {
                    $id = Jojo::insertQuery("INSERT INTO {phplist_user_attribute} SET
                        name			= ?,
                        type      = 'textline',
                        required  = ?",
                        array($field['field'], ($field['required'] ? 1 : 0))
                    );
                    Jojo::insertQuery("INSERT INTO {phplist_user_user_attribute} SET
                        attributeid = ?,
                        userid			= ?,
                        value       = ?",
                        array($id, $userid, $field['value'])
                    );
                }
                $userfield = 'us_' . $field['field'];
                if (Jojo::fieldExists('{user}', $userfield)) {
                    Jojo::updateQuery("UPDATE {user} SET $userfield = ? WHERE userid = ?", array($field['value'], $userid) );
                }
            }
        }
        $listname = '';
        /* Convert array of ids to a string */
        $ids = "'" . implode($listids, "', '") . "'";
        $mailinglistnames = Jojo::selectQuery("SELECT name FROM {phplist_list} WHERE id IN ($ids)");
        if (count($mailinglistnames)) {
            foreach ($mailinglistnames as $k => $ln) {
                $listname .= ($k!=0 ? ', ' : '') . $ln['name'];
            }
        }
        $newlettername = !empty($listname) ? $listname . ' from ' . Jojo::getOption('sitetitle') :  Jojo::getOption('sitetitle') . ' Newsletter';

        $to_name  = Jojo::either(Jojo::getOption('phplist_notifications_name'), _CONTACTNAME, _FROMNAME, _WEBMASTERNAME);
        $to_email = Jojo::either(Jojo::getOption('phplist_notifications'), _CONTACTADDRESS, _FROMADDRESS, _WEBMASTERADDRESS);

        $subject  = 'A New Subscriber To ' . $newlettername;
        $message  = '';

        $from_name = '';
        foreach ($from_name_fields as $fromfieldname) {
            foreach ($fields as $field) {
                if ($fromfieldname == $field['field']) {
                    $from_name .= $field['value'];
                    continue 2;
                }
            }
           $from_name .= $fromfieldname;
        }

        $from_name = empty($from_name) ? Jojo::getOption('sitetitle') : $from_name;
        $from_email = trim($_POST['form_replyemail']);

        foreach ($fields as $field) {
            $message .= ($field['field'] != 'list') ? $field['display'] . ': ' . $field['value'] . "\r\n" : '';
        }
        $message .= 'Mailing List Name: ' . $newlettername;

        $messagesubscriber = Jojo::getOption('phplist_thankyou_email_text') . "\r\n\r\n" . $message;
        $unsubscribeurl = Jojo::selectRow('SELECT pg_url FROM {page} WHERE pg_link = ?', array('jojo_plugin_jojo_newsletter_unsubscribe'));
        $messagesubscriber .= !empty($unsubscribeurl['pg_url']) ? "\r\n\r\nUnsubscription link: " . _SITEURL . '/' . $unsubscribeurl['pg_url'] : '';

        $message .= Jojo::emailFooter();

        if (!count($errors)) {
            if (Jojo::simpleMail($to_name, $to_email, $subject, $message, $from_name, $from_email)) {
                /* mail send success */
                $successMessage = Jojo::getOption('phplist_subscription_success_message');
                $smarty->assign('message', Jojo::either($successMessage, 'You are now subscribed to ' . $newlettername ));

                /* send a copy to the webmaster */
                if (Jojo::getOption('phplist_notifications_webmaster', 'yes') == 'yes' AND $to_email  !=  _WEBMASTERADDRESS) {
                    Jojo::simpleMail(_WEBMASTERNAME, _WEBMASTERADDRESS, $subject, $message, $from_name, $from_email);
                }

                /* send a copy to the subscriber */
                if (Jojo::getOption('phplist_thankyou', 'yes') == 'yes') {
                  $subject  = 'Subscription to ' . $newlettername;
                  Jojo::simpleMail($from_name, $from_email, $subject, $messagesubscriber, $from_name, $from_email);
                }
                return true;

            } else {
                /* mail send failure */
                $smarty->assign('message', 'There was an error sending your message. This error has been logged, so we will attend to this problem as soon as we can.');
            }
        } else {
            $smarty->assign('message', implode("<br />\n", $errors));
            $smarty->assign('fields', $fields);
        }
        return false;
    }


    function _getContent()
    {
        global $smarty, $ajaxid;
        $content = array();
        $fields = array();
        /* First preference is fields from customised jojo_newsletter_subscription_fields.php in any plugin or theme */
        foreach (Jojo::listPlugins('newsletter_subscription_fields.php') as $pluginfile) {
          include($pluginfile);
          break;
        }

        $smarty->assign('posturl', $this->getCorrectUrl());
        $smarty->assign('fields', $fields);

        $sent = false;
        if (isset($_POST['submit'])) {
            $sent = $this->sendEnquiry();
        }
        $smarty->assign('sent', $sent);
        $content['content'] = $this->page['pg_body'] . '<br />' . $smarty->fetch('jojo_newsletter_subscribe.tpl');
        $content['javascript'] = $smarty->fetch('jojo_newsletter_subscribe_js.tpl');

        return $content;
    }

}