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

/*
    Many-to-many relationships are commonly handled when an item belongs to one or more categories.
    A product may belong to several categories
    An invoice might have several lines
    etc.

    */

//////////////////////MANY2MANYFIELD//////////////////////
class Jojo_Field_many2manyordered extends Jojo_Field
{
    var $rows;
    var $options;

    function __construct($fielddata = array())
    {
        parent::__construct($fielddata);
        $this->rows = 1; //TODO: make this optional in Fielddata
        $this->options = array();
    }

    function checkvalue()
    {
        if (($this->fd_required == 'yes') && $this->isblank()) {
            $this->error = 'Required field';
        }
        return empty($this->error) ? true : false;
    }

    function displayedit()
    {
        $itemid = $this->table->getRecordID();

        /* get all current selections */
        $categories = Jojo::selectQuery("SELECT * FROM {" .  $this->linktable . "} WHERE `" . $this->linkitemid . "` = ?", $itemid);
        $selections = array(); //simple array holding all the categories the item is assigned to
        foreach ($categories as $c) {
            $selections[$c[$this->linkcatid]] = $c['order'];
        }

        $tablename = $this->cattable;
        $rows = Jojo::selectQuery("SELECT * FROM {tabledata} WHERE td_name = ? LIMIT 1", $tablename);
        $tableoptions = $rows[0];

        $idfield        = $tableoptions['td_primarykey'];
        $displayfield   = Jojo::either($tableoptions['td_displayfield'], $tableoptions['td_primarykey']);
        $parentfield    = Jojo::either($tableoptions['td_parentfield'], $tableoptions['td_group1'], "'0'");
        $categorytable  = $tableoptions['td_categorytable'];
        $categoryfield  = Jojo::either($tableoptions['td_categoryfield'], $tableoptions['td_group1'], "'0'");
        $orderbyfield   = $tableoptions['td_orderbyfields'];
        $group1field    = $tableoptions['td_group1'];

        /* TODO - Add group2 logic */
        $datafilter =  Jojo::either($tableoptions['td_filterby'],'1'); //filter results
        $rolloverfield =  Jojo::either($tableoptions['td_rolloverfield'],"''");
        $html = ''; //this will be used for output

        //Layer1 represents table structure where the first level is the grouping, then individual records underneath
        if ($tableoptions['td_group1'] != "") { // - this is used to pull down the main groupings - takes an extra query
            $layer1 = Jojo::selectQuery("SELECT ".$tableoptions['td_group1']." FROM {".$tableoptions['td_name']."} GROUP BY ".$tableoptions['td_group1']." ORDER BY ".$tableoptions['td_group1']."");
        }
        /* Main query */
        $query = "SELECT $idfield AS id, $displayfield AS display, $parentfield AS parent, $categoryfield AS categoryfield, $rolloverfield AS rollover ". Jojo::onlyIf($group1field,",".$group1field." AS group1").
                    ' FROM {'.$tableoptions['td_name']."}
                    WHERE $datafilter ".
                    ' ORDER BY '. Jojo::onlyIf($group1field,' '.$group1field.', ').
                     Jojo::onlyIf($orderbyfield,' '.$orderbyfield.', ').
                     Jojo::onlyIf($displayfield,' '.$displayfield.', ').
                    ' display';
        $records = Jojo::selectQuery($query);

        $i = 1;
        foreach ($records as $record) {
            $options[$i]['name']        = $record['display'];
            $options[$i]['value']       = $record['id'];
            $options[$i]['parent']      = $record['parent'];
            $this->options[$i]['group'] = isset($record['group1']) ? $record['group1'] : '';
            $i++;
        }

        $tree = new hktree('tree');

        /* loop through each option and display */
        $n = count($options);
        foreach ($options as $o) {
            $isselected = isset($selections[$o['value']]) ? ' checked="checked"' : '';
            $position   = isset($selections[$o['value']]) ? $selections[$o['value']] : '';
            $item = '<input type="text" name="fm_' . $this->fd_field . '_' . $o['value'] . '_order" value="' . $position . '" size="3" style="width:35px;" />&nbsp;<label><input type="checkbox" name="fm_' . $this->fd_field . "_" . $o['value']."\" id=\"fm_".$this->fd_field."_".$o['value']."\" value=\"".$o['value']."\" onchange=\"fullsave = true;\"".$isselected."> ".$o['name']."</label><br />\n";
            $tree->addNode($o['value'], $o['parent'], $item);
        }
        $output = '<strong>Articles to include:</strong><br/><br/><ul style="list-style-type: circle;"><li><span style="width:35px;">Position</span></li></ul>';
        $output .= $tree->printout_plain();

        return $output;
    }



    function setvalue($newvalue)
    {

    }

    function afterSave($table)
    {
        $selected = array();
        if (!$this->table->getRecordID()) {
            /* Don't save many-many records where ID is empty */
            return true;
        }

        foreach ($_POST as $k => $v) {
            if (substr($k, -6, 6) == '_order') {
                continue;
            }
            if (strpos($k, 'fm_' . $this->fd_field) === 0) {
                $selected[$v] = Jojo::getFormData('fm_' . $this->fd_field . '_' . $v . '_order');
            }
        }

        Jojo::deleteQuery("DELETE FROM {" . $this->linktable . "} WHERE `" . $this->linkitemid . "` = ?", array($this->table->getRecordID()));
        foreach ($selected as $k => $v) {
            $q = "REPLACE INTO {" . $this->linktable . "} SET `" . $this->linkitemid . "` = ?, `" . $this->linkcatid ."` = ?, `order` = ?";
            Jojo::insertQuery($q, array($this->table->getRecordID(), $k, $v));
        }
        return true;

    }
}