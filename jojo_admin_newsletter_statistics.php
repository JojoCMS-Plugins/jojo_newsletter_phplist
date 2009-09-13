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

class jojo_plugin_jojo_admin_newsletter_statistics extends Jojo_Plugin
{

	public function _getContent(){
		global $smarty, $_USERGROUPS;
		Jojo_Plugin_Admin::adminMenu();
		$id = Util::getFormData('id', 0);

		/* generic overview  */
		$content = jojo::selectQuery('SELECT subject, sendstart, processed, bouncecount, viewed FROM {phplist_message} where id = ?', $id);
		$message	=	'<h2>"'.$content[0]['subject'].'" Statistics Overview'."</h2><hr />";
		$message	.=	'<p><h3>Date Sent:</h3> '.$content[0]['sendstart'].'.</p>'."\n\n";
		$message	.=	'<p><h3>Sent:</h3> '.$content[0]['processed'].'.</p>'."\n\n";
		$message	.=	'<p><h3>Bounced: </h3>'.$content[0]['bouncecount'].'.</p>'."\n\n";
		$views		= jojo::selectQuery('SELECT count(distinct viewed) as total FROM {phplist_usermessage} where viewed IS NOT NULL AND messageid = ?', $id);
		$message	.=	'<p><h3>Views:</h3> '.$views[0]['total'].'.</p><br /><br /><hr/><hr/>'."\n\n";
		$message	.=	'<h2>"'.$content[0]['subject'].'" Statistics on Links'."</h2><hr />";

		/* Get URL's per message */
		$urls = jojo::selectQuery('SELECT distinct url  FROM {phplist_linktrack} where messageid = ?', $id);

		/* Get number of clicks per URL */
		foreach($urls as $k => $section) {
			$clicks = jojo::selectQuery('SELECT SUM(clicked) FROM {phplist_linktrack} where url = ? and messageid = ?', array($urls[$k]['url'], $id));
			$link = $urls[$k]['url'];
		/* Get all the articles for this newsletter */
			$articleid = preg_replace("/[^0-9]/", '', $link);
			$articled = Jojo::selectQuery('SELECT * FROM {article} WHERE articleid = ?', $articleid);
			$message	.= '<p><h3>Clicks to the link "';
			$message	.= $link.' | ';

			foreach($articled as $article) {
			$message	.=	$article['ar_title'].'": </h3>';
					}

			$message 	.= $clicks[0]['SUM(clicked)'].' click(s).<br/>'."\n";
			$message	.= '<h3>Subscribers who clicked this link:</h3>'."\n";

			/* Get email on who clicked on this URL */
			$clickers = jojo::selectQuery('SELECT userid FROM {phplist_linktrack} where url = ? AND clicked > 0', $urls[$k]['url']);

			foreach($clickers as $k => $section) {
				$clickersemail = jojo::selectQuery('SELECT distinct email FROM {newslettersuser} where id =?', $clickers[$k]['userid']);
				foreach($clickersemail as $k => $section) {
					$message	.= '- '.$clickersemail[$k]['email'].'<br />'."\n";
				}
			}
			$message	.= '</p><hr /><hr />'."\n\n";
		}

		$message	.= '<br /><br /><p>The statistics on the clicks per links are dependent on whether subscribers allowed tracking. The figures might be lower than actual.</p>';

		$smarty->assign('message', $message);

		$content['content'] = $smarty->fetch('admin/newsletter_morestats.tpl');

		return $content;
	}

	public static function _getPrefix($for = 'more-newsletter-stats') {
		static $_cache;
			if (!isset($_cache[$for])) {
				$query = 'SELECT pg_url FROM {page} WHERE pg_link = ?;';
				$values = false;
				if ($for == 'more-newsletter-stats') {
				$values = array('Jojo_Plugin_Jojo_Admin_Newsletter_Statistics');
				}
				if ($values) {
				$res = Jojo::selectQuery($query, $values);
					if (isset($res[0])) {
					$_cache[$for] = $res[0]['pg_url'];
					return $_cache[$for];
						}
				}
		$_cache[$for] = '';
		}

		return $_cache[$for];
	}

	function getCorrectUrl()
	{
		$id = Util::getFormData('id', 0);
		return parent::getCorrectUrl() . $id . '/';
	}
}