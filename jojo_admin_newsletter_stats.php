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
 * @author  Melanie Schulz <mel@gardyneholt.co.nz>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 */

class jojo_plugin_jojo_admin_newsletter_stats extends Jojo_Plugin
{
    function _getContent()
    {
		global $smarty, $_USERGROUPS;
        Jojo_Plugin_Admin::adminMenu();

		/* Process bounces before getting bounce count */
		putenv('USER=admin');
		exec('/usr/bin/php ' . Jojo::getOption('phplist_admin') . ' -pprocessbounces');

        /* Get message's subject, date, processed, viewed and bounce count */
		$messageinfo = Jojo::selectQuery("SELECT * FROM {phplist_message} ORDER BY sendstart desc");
		foreach ($messageinfo as $k => $message) {
			$res = Jojo::selectQuery('SELECT count(distinct viewed) as total FROM {phplist_usermessage} where viewed IS NOT NULL AND messageid = ?', $message['id']);
			$messageinfo[$k]['viewed'] = $res[0]['total'];
		}

        $smarty->assign('messageinfo', $messageinfo);

        $content['content'] = $smarty->fetch('admin/newsletter_stats.tpl');

        return $content;
    }
}