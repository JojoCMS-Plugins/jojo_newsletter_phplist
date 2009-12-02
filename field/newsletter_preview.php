<?php
/**
 *                    Jojo CMS
 *                ================
 *
 * Copyright 2008 Michael Cochrane <code@gardyneholt.co.nz>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Michael Cochrane <mikec@jojocms.org>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 */

//////////////////////MANY2MANYFIELD//////////////////////
class Jojo_Field_newsletter_preview extends Jojo_Field
{
    var $rows;
    var $options;

    function checkvalue()
    {
        return true;
    }

    function displayedit()
    {
        global $smarty;
        $smarty->assign('fd_field',$this->fd_field);
        $smarty->assign('newsletterid', $this->table->getRecordID());
        $smarty->assign('value', htmlentities($this->value, ENT_COMPAT, 'UTF-8'));
        return  $smarty->fetch('admin/fields/newsletter_preview.tpl');
    }

    function setvalue($newvalue)
    {
    }

}
