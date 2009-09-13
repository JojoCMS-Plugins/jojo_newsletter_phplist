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

class Jojo_Plugin_Jojo_Newsletter_Unsubscribe extends JOJO_Plugin
{

    function sendEnquiry()
    {
        global $smarty;

        /* Check for form injection attempts */
        Jojo::noFormInjection();
        $from_email = trim($_POST['form_replyemail']);

        /* check if unsubscriber is a current user or not */
        $user = Jojo::selectRow('SELECT userid, us_firstname, us_lastname, us_login FROM {user} WHERE us_email = ?', array($from_email) );
        if(!$user) {
           $smarty->assign('message', 'You are not currently subscribed to a ' . Jojo::getOption('sitetitle') . ' Newsletter.');
            return;
        }
        $userid = $user['userid'];

        $fields = array();
        /* First preference is fields from customised jojo_newsletter_subscription_fields.php in any plugin or theme */
        foreach (Jojo::listPlugins('newsletter_unsubscribe_fields.php') as $pluginfile) {
          include($pluginfile);
          break;
        }

        $errors = array();
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
                $field['value'] = Util::getFormData('form_' . $field['field'], '');
            }

            /* check value is set on required fields */
            if (($field['required']) && (empty($field['value']))) {
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

        $to_name  =  Jojo::either(Jojo::getOption('phplist_notifications_name'), _CONTACTNAME, _FROMNAME, _WEBMASTERNAME);
        $to_email =  Jojo::either(Jojo::getOption('phplist_notifications'), _CONTACTADDRESS, _FROMADDRESS, _WEBMASTERADDRESS);


        $subject  = 'Unsubscribing from ' . Jojo::getOption('sitetitle') . ' Newsletter';
        $message  = '';

        $from_name = $user['us_firstname'] . ' ' . $user['us_lastname'];
        $from_name = empty($from_name) ? Jojo::getOption('sitetitle') : $from_name;

        foreach ($fields as $field) {
            $message .= $field['display'] . ': ' . $field['value'] . "\r\n";
        }

        $delete = Jojo::getOption('phplist_unsubscribe_behaviour', 'newsletteruser');
       if ( $delete == 'all' || ($delete =='newsletteruser' && empty($user['us_login']))) {
            Jojo::deleteQuery('DELETE FROM {user} WHERE userid = ?', $userid);
            Jojo::deleteQuery('DELETE FROM {phplist_listuser} WHERE userid = ?', $userid);
            Jojo::deleteQuery('DELETE FROM {phplist_user_user} WHERE id = ?', $userid);
            Jojo::deleteQuery('DELETE FROM {phplist_user_user_attribute} WHERE userid = ?', $userid);
       } else {
            Jojo::deleteQuery('DELETE FROM {phplist_listuser} WHERE userid = ?', $userid);
       }

        $message .= Jojo::emailFooter();

        if (!count($errors)) {
            if (Jojo::simpleMail($to_name, $to_email, $subject, $message, $from_name, $from_email)) {
                $smarty->assign('message', 'You are now unsubscribed from the ' . Jojo::getOption('sitetitle') . ' Newsletter.');

              /* send a copy to the webmaster */
                if (Jojo::getOption('phplist_notifications_webmaster', 'yes') == 'yes' AND $to_email <> _WEBMASTERADDRESS) {
                    Jojo::simpleMail(_WEBMASTERNAME, _WEBMASTERADDRESS, $subject, $message, $from_name, $from_email);
                }
                return true;
            }

        } else {
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
        foreach (Jojo::listPlugins('newsletter_unsubscribe_fields.php') as $pluginfile) {
          include($pluginfile);
          break;
        }

        $smarty->assign('posturl', $this->getCorrectUrl());
        $smarty->assign('fields',$fields);
        $sent = false;
        if (isset($_POST['submit'])) {
            $sent = $this->sendEnquiry();
        }
        $smarty->assign('sent', $sent);

        $content['content'] = $this->page['pg_body'].'<br />'.$smarty->fetch('jojo_newsletter_unsubscribe.tpl');
        $content['javascript'] = $smarty->fetch('jojo_newsletter_unsubscribe_js.tpl');

        return $content;
    }

}