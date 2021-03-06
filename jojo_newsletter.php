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

class Jojo_Plugin_Jojo_Newsletter extends Jojo_Plugin
{
    /**
     * Get all the bits of the news letter and put them all together
     */
    public static function assembleNewsletter($id, $online=false, $inline=false)
    {
        global $smarty;
        $result = array();

        /* Get the newsletter from the database */
        $newsletter = Jojo::selectRow('SELECT * FROM {newsletter} WHERE id = ?', $id);
        if (!isset($newsletter)) {
            return false;
        }
        $css = Jojo::getOption('css-email', '');
        $tablelists = (boolean)(Jojo::getOption('newslettercss_lists', 'no') == 'yes');
        $newscss = array();
        if ($css) {
            $styles = Jojo::ta2array($css);
            foreach ($styles as $k => $s) {
                $style = explode('{', $s);
                $newscss[$k]['tag'] = $style[0];
                $newscss[$k]['style'] = trim($style[1], '}');
                $smarty->assign(str_replace(array(' ','=','"'), '', $newscss[$k]['tag']) .'css', $newscss[$k]['style']);
            }
        }
        $smarty->assign('htmlintro', true);

        $smarty->assign('newsletter', $newsletter);
        $smarty->assign('online', $online);
        $smarty->assign('inline', $inline);

        /* Get the templateid */
        $templateid = $newsletter['template'];

        if (Jojo::tableExists('bannerimage') && $newsletter['header_image']) {
            /* Get the image */
            $newsletter_header_image = Jojo::selectRow('SELECT bi_image FROM {bannerimage} WHERE bannerimageid = ?', $newsletter['header_image']);
            $bannerimage = rawurlencode($newsletter_header_image['bi_image']);
            $imagelocation = _SITEURL . '/images/394x213/bannerimages/' . $bannerimage;
            $filename = self::addTemplateImage($templateid, $imagelocation);
            $smarty->assign('bannerimage', $filename);
            $smarty->assign('bannerimagefile', $bannerimage);
        }

        $contentarray = array();
        /* Get results from plugins */
        $contentarray = Jojo::applyFilter('jojo_newslettercontent', $contentarray, $id);
        $smarty->assign('contentarray', $contentarray);
        
       /* Allow plugins to add anything else they need to */
        Jojo::runHook('assembleNewsletter', array('templateid' => $templateid, 'newsletter' => $newsletter));


        /* Add all the images to the database */
        $result['subject']  = $newsletter['name'];
        $result['date']  = $newsletter['date'];
        $result['template'] = $templateid;
        $content = $smarty->fetch('jojo_newsletter_content.tpl');
        // add inline styling to tags based on option css settings
        // convert lists into table-based layout with manual bullets and p tags for Outlook if option is enabled
        $result['content']  =  $css ? Jojo::inlineStyle($content, $css, $tablelists) : $content;
        // convert any relative urls to absolute
        $result['content'] = Jojo::relative2absolute($result['content'], _SITEURL);
         // re-encode htmlentites as utf-8
        $result['content'] = mb_convert_encoding($result['content'], 'HTML-ENTITIES', 'UTF-8');
        $result['sender'] = ($newsletter['sender']) ? $newsletter['sender'] : Jojo::getOption('phplist_fromaddress');

        /* Get the list id's this is going to */
        $lists = Jojo::selectQuery('SELECT listid FROM {newsletter_list} WHERE newsletterid = ?', $id);
        $result['lists'] = array();
        foreach($lists as $list) {
            $result['lists'][] = $list['listid'];
        }

        return $result;
    }

    function _getContent()
    {
        global $smarty;
        $content = array();

        /* Do we have an id? */
        $id = Jojo::getFormData('id', 0);
        if ($id) {
            $inline = (boolean)(Jojo::getOption('onlinenews_display', 'inline')=='inline');
            $newsletter = self::assembleNewsletter($id, $online=true, $inline);
            $content['content'] = $newsletter['content'];
            $content['title'] = $content['seotitle'] = $newsletter['subject'];
            if (!$inline) {
                header('Content-Type: text/html');
                header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
                header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
                echo $newsletter['content'];
                exit;
            }

        } else {
            if ($newsletters = Jojo::selectQuery('SELECT * FROM {newsletter} WHERE sentdate > 0 ORDER BY sentdate DESC')) {
                foreach ($newsletters as &$i) {
                    $i['title']   = htmlspecialchars($i['name'], ENT_COMPAT, 'UTF-8', false);
                    $i['datefriendly'] = Jojo::formatTimestamp($i['sentdate'], "medium");
                }
            }
            $smarty->assign('newsletters', $newsletters);
            $content['content'] = $smarty->fetch('jojo_newsletter_index.tpl');
        }
        
        return $content;
    }

    function getCorrectUrl()
    {
        $id = Jojo::getFormData('id', 0);
        $correcturl = self::_getPrefix() . '/' . $id . '/';

        if ($id && $correcturl) {
            return _SITEURL . '/' . $correcturl;
        }

        /* default */
        return parent::getCorrectUrl();
    }

    static public function isUrl($uri)
    {
        $prefix = false;
        $getvars = array();
        /* Check for standard plugin url format matches */
        if ($uribits = parent::isPluginUrl($uri)) {
            $prefix = $uribits['prefix'];
            $getvars = $uribits['getvars'];
        } else {
            return false;
        }
        /* Check the prefix matches */
        if ($res = self::checkPrefix($prefix)) {
            /* If full uri matches a prefix it's an index page so ignore it and let the page plugin handle it */
            if (self::checkPrefix(trim($uri, '/'))) {
                return false;
            }

            /* The prefix is good, pass through uri parts */
            foreach($getvars as $k => $v) {
                $_GET[$k] = $v;
            }
            return true;
        }
        return false;
    }

    /**
     * Check if a prefix is a prefix for this plugin
     */
    static public function checkPrefix($prefix)
    {
        static $_prefixes;
        if (!isset($_prefixes)) {
            /* Initialise cache */
            $_prefixes = array();
        }
        /* Check if it's in the cache */
        if (isset($_prefixes[$prefix])) {
            return $_prefixes[$prefix];
        }
        /* Check everything */
        $testPrefix = self::_getPrefix();
        $_prefixes[$testPrefix] = true;
        if ($testPrefix == $prefix) {
            /* The prefix is good */
            return true;
        }
        /* Didn't match */
        $_prefixes[$testPrefix] = false;
        return false;
    }

    static function _getPrefix()
    {
        $cacheKey = 'newsletterview';

        /* Have we got a cached result? */
        static $_cache;
        if (isset($_cache[$cacheKey])) {
            return $_cache[$cacheKey];
        }

        /* Cache some stuff */
        $res = Jojo::selectRow("SELECT p.pageid, pg_title, pg_url FROM {page} p WHERE `pg_link` = 'jojo_plugin_jojo_newsletter'");
        if ($res) {
            $_cache[$cacheKey] = !empty($res['pg_url']) ? $res['pg_url'] : $res['pageid'] . '/' . Jojo::clean($res['pg_title']);
        } else {
            $_cache[$cacheKey] = '';
        }
        return $_cache[$cacheKey];
    }

   /**
     * Add an image file to the template images table and return the filename
     * for the image
     */
    public static function addTemplateImage($templateid, $filename)
    {
        $data = base64_encode(file_get_contents($filename));

        /* See if the image is already in the database */
        $existing = Jojo::selectQuery('SELECT * FROM {phplist_templateimage} WHERE template= ? AND data = ?', array($templateid, $data));
        if ($existing) {
            /* Yes it's there - return the existing filename */
            return $existing[0]['filename'];
        }

        /* No - Add it to the database */
        list($width, $height, $imagetype)  = getimagesize($filename);
        if (strpos($filename, 'http://') === 0) {
            /* Remote file */
            $parts = parse_url($filename);
            $filename = basename($parts['path']);
        } else {
            /* Local file */
            $filename = basename($filename);
        }

        /* Make sure we have a unique filename */
        $uniqueID = null;
        while(Jojo::selectQuery('SELECT * FROM {phplist_templateimage} WHERE filename = ?', $uniqueID . $filename)) {
            $uniqueID++;
        }
        $filename = $uniqueID . $filename;

        $mimetype = image_type_to_mime_type($imagetype);
        jojo::insertQuery("INSERT INTO {phplist_templateimage} SET
                            template = ?,
                            mimetype = ?,
                            filename = ?,
                            data     = ?,
                            width    = ?,
                            height   = ?",
                            array($templateid, $mimetype, $filename, $data, $width, $height)
                         );
        return $filename;
    }

}