<?php
/**
 *                    Jojo CMS
 *                ================
 *
 * Copyright 2008 Jojo CMS
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Michael Cochrane <mikec@jojocms.org>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 */

$default_td['faq'] = array(
        'td_name' => "faq",
        'td_primarykey' => "faqid",
        'td_displayfield' => "fq_question",
        'td_orderbyfields' => "fq_order, fq_question",
        'td_deleteoption' => "yes",
        'td_menutype' => "list",
    );

// Faqid Field
$default_fd['faq']['faqid'] = array(
        'fd_name' => "Faqid",
        'fd_type' => "hidden",
        'fd_help' => "A unique ID, automatically assigned by the system",
        'fd_order' => "1",
    );

// Question Field
$default_fd['faq']['fq_question'] = array(
        'fd_name' => "Question",
        'fd_type' => "text",
        'fd_required' => "yes",
        'fd_size' => "50",
        'fd_help' => "The question",
        'fd_order' => "2",
    );

// Answer Field
$default_fd['faq']['fq_bbanswer'] = array(
        'fd_name' => "Answer",
        'fd_type' => "texteditor",
        'fd_options' => "fq_answer",
        'fd_required' => "yes",
        'fd_order' => "3",
    );

// Answer Field
$default_fd['faq']['fq_answer'] = array(
        'fd_name' => "Answer",
        'fd_type' => "hidden",
        'fd_order' => "4",
    );

// Faqurl Field
$default_fd['faq']['fq_faqurl'] = array(
        'fd_name' => "Faqurl",
        'fd_type' => "internalurl",
        'fd_options' => "faq",
        'fd_size' => "30",
        'fd_order' => "5",
    );

// Order Field
$default_fd['faq']['fq_order'] = array(
        'fd_name' => "Order",
        'fd_type' => "order",
        'fd_default' => "0",
        'fd_help' => "Order in which the question appears on the page",
        'fd_order' => "6",
    );

// Meta Description Field
$default_fd['faq']['fq_metadesc'] = array(
        'fd_name' => "Meta Description",
        'fd_type' => "textarea",
        'fd_options' => "metadescription",
        'fd_rows' => "3",
        'fd_cols' => "60",
        'fd_help' => "A good sales oriented description of the page for the Search Engine snippet. Try to keep this within 155 characters, as anything larger will be chopped from the snippet.",
        'fd_order' => "7",
    );

// Updated Field
$default_fd['faq']['fq_updated'] = array(
        'fd_name' => "Updated",
        'fd_type' => "timestamp",
        'fd_order' => "8",
    );
