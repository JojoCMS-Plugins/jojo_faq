<?php
/**
 *                    Jojo CMS
 *                ================
 *
 * Copyright 2007 Harvey Kane <code@ragepank.com>
 * Copyright 2007 Michael Holt <code@gardyneholt.co.nz>
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

$_provides['pluginClasses'] = array(
        'Jojo_Plugin_Jojo_faq' => 'FAQ page'
        );

$_options[] = array(
    'id'          => 'faq_detail_pages',
    'category'    => 'FAQ',
    'label'       => 'Show FAQ detail pages',
    'description' => 'Include a separate page for every FAQ item. This adds additional pages to the site which may be useful for SEO',
    'type'        => 'radio',
    'default'     => 'no',
    'options'     => 'yes,no',
    'plugin'      => 'jojo_faq'
);

if (Jojo::getOption('faq_detail_pages') == 'yes') {
    /* URI Handler */
    Jojo::registerURI(null, 'Jojo_Plugin_Jojo_faq', 'isUrl');

    /* XML Sitemap filter */
    Jojo::addFilter('jojo_xml_sitemap', 'xmlsitemap', 'jojo_faq');
}