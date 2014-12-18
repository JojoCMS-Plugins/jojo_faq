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

class JOJO_Plugin_Jojo_faq extends JOJO_Plugin
{

    function getPrefix()
    {
        return $this->page['pg_url'];
    }

    function _getContent()
    {

        $content = array();
        global $smarty;

        $baseurl = _SITEURL . '/' . self::getPrefix();
        $smarty->assign('prefix', $baseurl);

        $smarty->assign("faq_title", $this->page['pg_title']);
        
        $faq_detail = (boolean)(Jojo::getOption('faq_detail_pages', 'no') == 'yes');
        $smarty->assign("faq_detail", $faq_detail);

        $id  = Jojo::getFormData('id', '');
        $url = Jojo::getFormData('url', '');
        $content['content'] = '';

        if (!empty($id) || !empty($url)) {
            $faq = false;
            if (!empty($id)) {
                $faq = Jojo::selectRow("SELECT * FROM {faq} WHERE `faqid`=? AND `fq_pageid` = ? LIMIT 1", array($id, $this->id));
            } elseif (!empty($url)) {
                $faq = Jojo::selectRow("SELECT * FROM {faq} WHERE `fq_faqurl`=? AND `fq_pageid` = ? LIMIT 1", array($url, $this->id));
            }

            if (!$faq) {
                Jojo::redirect($baseurl . '/');
            }
            

            $smarty->assign('faq', $faq);
            $content['title']           = $faq['fq_question'];
            $content['seotitle']        = $faq['fq_question'];
            $content['metadescription'] = $faq['fq_metadesc'];

            /* Add breadcrumb */
            $breadcrumbs = $this->_getBreadCrumbs();
            $breadcrumb = array();
            $breadcrumb['name'] = $faq['fq_question'];
            $breadcrumb['url'] = !empty($faq['fq_faqurl']) ? $baseurl . '/' . $faq['fq_faqurl'] .'/' : $baseurl . $id . '/';
            $breadcrumbs[count($breadcrumbs)] = $breadcrumb;
            $content['breadcrumbs'] = $breadcrumbs;
        }

        $faqs = Jojo::selectQuery("SELECT * FROM {faq} WHERE `fq_pageid` = ?  ORDER BY fq_order, fq_question", array($this->id));
        $smarty->assign('faqs', $faqs);
        if ($faq_detail && (!empty($id) || !empty($url))) {
                $content['content'] = $smarty->fetch('jojo_faq_detail.tpl');
        } else {
            $content['content'] = $smarty->fetch('jojo_faq.tpl');
        }

        return $content;
    }

    /**
     * Work out if the provided uri is a uri for a FAQ
     */
    static function isUrl($uri) {
        foreach (Jojo::selectAssoc('SELECT pageid, pg_url FROM {page} WHERE pg_link = "jojo_plugin_jojo_faq"') as $pageid => $prefix) {
            if (preg_match("#^$prefix/([0-9]+)$#", $uri, $matches)) {
                /* faq/123/ */
                $_GET['id'] = $matches[1];
                return $pageid;
            } elseif (preg_match("#^$prefix/([a-z0-9-_]+)$#", $uri, $matches)) {
                /* faq/what-is-your-name/ */
                $_GET['uri'] = $matches[1];
                return $pageid;
            }
        }
        return false;
    }


    /**
     * XML Sitemap filter
     *
     * Receives existing sitemap and adds FAQ pages
     */
    static function xmlsitemap($sitemap)
    {
        if (Jojo::getOption('faq_detail_pages') == 'yes') {
            /* Get FAQ pages from database */
            $prefix = Jojo::selectAssoc("SELECT pageid, pg_url from {page} WHERE pg_link = 'jojo_plugin_jojo_faq'");
            $faqs = Jojo::selectQuery("SELECT * FROM {faq} ORDER BY fq_order, fq_question");

            /* Add FAQ pages to sitemap */
            foreach($faqs as $faq) {
                $url           = _SITEURL . '/' . $prefix[$faq['fq_pageid']] . '/'. Jojo::either($faq['fq_faqurl'], $faq['faqid']).'/';
                $lastmod       = $faq['fq_updated'];
                $changefreq    = '';
                $priority      = 0.4;
                $sitemap[$url] = array($url, $lastmod, $changefreq, $priority);
            }
        }
        /* Return sitemap */
        return $sitemap;
    }


     function getCorrectUrl()
    {
        $id  = Jojo::getFormData('id',  '');
        $url = Jojo::getFormData('url', '');
        $baseurl = _SITEURL.'/'. self::getPrefix().'/';

        if (!empty($url)) {
            $data = Jojo::selectQuery("SELECT faqid, fq_faqurl FROM {faq} WHERE fq_faqurl=?", $url);
            if (count($data)) return $baseurl . $url . '/';
        } elseif (!empty($id)) {
            $data = Jojo::selectQuery("SELECT faqid, fq_faqurl FROM {faq} WHERE faqid=?", $id);
            if (count($data)) {
                if (!empty($data[0]['fq_faqurl'])) return $baseurl . $data[0]['fq_faqurl'].'/';
                return $baseurl . $id . '/';
            }
        }

        return $baseurl;

    }

}
