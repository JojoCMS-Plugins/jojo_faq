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
 * @author  Michael Cochrane <code@gardyneholt.co.nz>
 * @author  Melanie Schulz <mel@gardyneholt.co.nz>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 */


/* convert any old faq pages to the new plugin */
$data = Jojo::selectQuery("SELECT * FROM {page} WHERE pg_link='faq.php'");
foreach ($data as $page) {
    Jojo::selectQuery("UPDATE {page} SET pg_link='jojo_plugin_jojo_faq' WHERE pageid=? LIMIT 1", $page['pageid']);
}

/* add FAQ page if it does not exist */
$data = Jojo::selectQuery("SELECT * FROM {page} WHERE pg_link='jojo_plugin_jojo_faq'");
if (!count($data)) {
    echo "Adding <b>FAQ</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='FAQ', pg_link='jojo_plugin_jojo_faq', pg_url='faq'");
} else {
    if (empty($data[0]['pg_url'])) {//Set pg_url to "faq" if empty
        echo "Set discovery level URL for <b>FAQ</b><br />";
        Jojo::selectQuery("UPDATE {page} SET pg_url='faq' WHERE pageid=? LIMIT 1", $data[0]['pageid']);
    }
}

/* convert any old edit faq tables to the new structure */
if (Jojo::tableExists('faq') && Jojo::fieldExists('faq', 'fq_pageid')) {
  Jojo::structureQuery("ALTER TABLE  {faq} CHANGE  `fq_pageid`  `pageid` int(11) NOT NULL DEFAULT  '0'");
}

/* edit FAQ page */
$data = Jojo::selectQuery("SELECT * FROM {page} WHERE pg_url='admin/edit/faq'");
if (!count($data)) {
    echo "Adding <b>Edit FAQ</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Edit FAQ', pg_link='Jojo_Plugin_Admin_Edit', pg_url='admin/edit/faq', pg_parent=?, pg_order=5, pg_mainnav='yes', pg_breadcrumbnav='yes', pg_sitemapnav='no', pg_xmlsitemapnav='no', pg_footernav='no', pg_index='no'", $_ADMIN_CONTENT_ID);
}

/* Assign any orphaned faqs to a page */
$faqpageid = current(Jojo::selectRow("SELECT pageid FROM {page} WHERE pg_link='jojo_plugin_jojo_faq'"));
Jojo::updateQuery('UPDATE {faq} SET pageid = ? WHERE pageid = 0', $faqpageid);