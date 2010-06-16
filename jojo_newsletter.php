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

class Jojo_Plugin_Jojo_Newsletter
{
    /**
     * Get all the bits of the news letter and put them all together
     */
    public static function assembleNewsletter($id)
    {
        global $smarty;
        $result = array();

        /* Get the newsletter from the database */
        $newsletter = Jojo::selectRow('SELECT * FROM {newsletter} WHERE id = ?', $id);
        if (!isset($newsletter)) {
            return false;
        }
        if ($newsletter['template'] != 3 ) {
            $newsletter['intro'] = mb_convert_encoding($newsletter['intro'], 'HTML-ENTITIES', 'UTF-8');
        }
        
        $newsletter['outro'] = mb_convert_encoding($newsletter['outro'], 'HTML-ENTITIES', 'UTF-8');
        if ($newsletter['intro_code']) {  
            $smarty->assign('htmlintro', true);
        }
        $smarty->assign('newsletter', $newsletter);

        /* Get the templateid */
        $templateid = $newsletter['template'];

        if (Jojo::tableExists('bannerimage') && $newsletter['header_image']) {
            /* Get the image */
            $newsletter_header_image = Jojo::selectRow('SELECT bi_image FROM {bannerimage} WHERE bannerimageid = ?', $newsletter['header_image']);
            $imagelocation = _SITEURL . '/images/394x213/bannerimages/' . rawurlencode($newsletter_header_image['bi_image']);
            $filename = Jojo_Plugin_Jojo_Newsletter::addTemplateImage($templateid, $imagelocation);
            $smarty->assign('bannerimage', $filename);
        }

        /* Get all the articles for this newsletter */
        $articles = Jojo::selectQuery('SELECT a.* FROM {article} a, {newsletter_article} n WHERE a.articleid = n.articleid AND n.newsletterid = ? ORDER BY n.order', $id);

        /* Add the content of the articles to the email content */
        foreach($articles as $k => $article) {
            if ( Jojo::getOption('phplist_includeimages', 'yes') == 'yes' && $article['ar_image']) {
                /* Add the image */
                $articles[$k]['ar_image'] = Jojo_Plugin_Jojo_Newsletter::addTemplateImage($templateid, _SITEURL . '/images/' . Jojo::getOption('phplist_imagesize', 'v25000') . '/articles/' . rawurlencode($article['ar_image']));
            }
            $articles[$k]['ar_title'] = mb_convert_encoding($articles[$k]['ar_title'], 'HTML-ENTITIES', 'UTF-8');
            $articles[$k]['ar_url'] = _SITEURL .'/'. Jojo_Plugin_Jojo_article::getArticleUrl($article['articleid']);
            $articles[$k]['ar_body'] = mb_convert_encoding(strip_tags($articles[$k]['ar_body']), 'HTML-ENTITIES', 'UTF-8');


        }
        $smarty->assign('articles', $articles);


        /* Add all the images to the database */
        $result['subject']  = $newsletter['name'];
        $result['date']  = $newsletter['date'];
        $result['template'] = $templateid;
        $result['content']  = $smarty->fetch('jojo_newsletter_content.tpl');
        $result['sender'] = ($newsletter['sender']) ? $newsletter['sender'] : Jojo::getOption('phplist_fromaddress');

        /* Get the list id's this is going to */
        $lists = Jojo::selectQuery('SELECT listid FROM {newsletter_list} WHERE newsletterid = ?', $id);
        $result['lists'] = array();
        foreach($lists as $list) {
            $result['lists'][] = $list['listid'];
        }

        return $result;
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