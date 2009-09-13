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

        $prefix = self::getPrefix();
        $smarty->assign('prefix', $prefix);

        $smarty->assign("faq_title", $this->page['pg_title']);

        $id  = Util::getFormData('id', '');
        $url = Util::getFormData('url', '');
        $content['content'] = '';

        if (!empty($id) || !empty($url)) {
            $faqs = array();
            if (!empty($id)) {
                $faqs = Jojo::selectQuery("SELECT * FROM {faq} WHERE `faqid`=? LIMIT 1", $id);
            } elseif (!empty($url)) {
                $faqs = Jojo::selectQuery("SELECT * FROM {faq} WHERE `fq_faqurl`=? LIMIT 1", $url);
            }

            if (!count($faqs)) {
                Jojo::redirect(_SITEURL.'/'.self::getPrefix().'/');
            }

            $smarty->assign('faq', $faqs[0]);
            $content['title']           = $faqs[0]['fq_question'];
            $content['seotitle']        = $faqs[0]['fq_question'];
            $content['metadescription'] = $faqs[0]['fq_metadesc'];

            /* Add breadcrumb */
            $breadcrumbs = $this->_getBreadCrumbs();
            $breadcrumb = array();
            $breadcrumb['name'] = $faqs[0]['fq_question'];
            $breadcrumb['url'] = !empty($faqs[0]['fq_faqurl']) ? _SITEURL.'/'.$prefix.'/'.$faqs[0]['fq_faqurl'].'/' : _SITEURL.'/'.$prefix.'/'.$id.'/';
            $breadcrumbs[count($breadcrumbs)] = $breadcrumb;
            $content['breadcrumbs'] = $breadcrumbs;
        }

        $faqs = Jojo::selectQuery("SELECT * FROM {faq} WHERE 1 ORDER BY fq_order, fq_question");
        $smarty->assign('faqs', $faqs);
        if (Jojo::getOption('faq_detail_pages') == 'yes') {
            if (!empty($id) || !empty($url)) {
                $content['content'] = $smarty->fetch('jojo_faq_detail.tpl');
            } else {
                $content['content'] = $this->page['pg_body']."<br />\n".$smarty->fetch('jojo_faq_index.tpl');
            }
        } else {
            $content['content'] = $smarty->fetch('jojo_faq.tpl');
        }

        return $content;
    }


    /**
     * XML Sitemap filter
     *
     * Receives existing sitemap and adds FAQ pages
     */
    function xmlsitemap($sitemap)
    {
        if (Jojo::getOption('faq_detail_pages') == 'yes') {
            /* Get FAQ pages from database */
            $prefix = Jojo::selectQuery("SELECT pg_url from {page} WHERE pg_link =	'jojo_plugin_jojo_faq'");
            $faqs = Jojo::selectQuery("SELECT * FROM {faq} WHERE 1 ORDER BY fq_order, fq_question");

            /* Add FAQ pages to sitemap */
            foreach($faqs as $faq) {
                $url           = _SITEURL . '/'.$prefix[0]['pg_url'].'/'. Jojo::either($faq['fq_faqurl'], $faq['faqid']).'/';
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
        $id  = Util::getFormData('id',  '');
        $url = Util::getFormData('url', '');

        if (!empty($url)) {
            $data = Jojo::selectQuery("SELECT faqid, fq_faqurl FROM {faq} WHERE fq_faqurl=?", $url);
            if (count($data)) return _SITEURL.'/'.JOJO_Plugin_Jojo_faq::getPrefix().'/'.$url.'/';
        }
        if (!empty($id)) {
            $data = Jojo::selectQuery("SELECT faqid, fq_faqurl FROM {faq} WHERE faqid=?", $id);
            if (count($data)) {
                if (!empty($data[0]['fq_faqurl'])) return _SITEURL.'/'.JOJO_Plugin_Jojo_faq::getPrefix().'/'.$data[0]['fq_faqurl'].'/';
                return _SITEURL.'/'.JOJO_Plugin_Jojo_faq::getPrefix().'/'.$id.'/';
            }
        }

        return _SITEURL.'/'.JOJO_Plugin_Jojo_faq::getPrefix().'/';

    }

}