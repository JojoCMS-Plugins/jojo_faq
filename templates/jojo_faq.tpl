{if $content}{$content}{/if}
{if $faqs}
<div class="faq-index">
  <a name="faq-top"></a>
  <h3>{$faq_title}</h3>
  <ul id="faq-questions">
  {foreach from=$faqs item=f}
    <li>{if $faq_detail}<a href="{$prefix}/{if $f.fq_faqurl}{$f.fq_faqurl}{else}{$f.faqid}{/if}/">{else}<a href="#faq{$f.faqid}">{/if}{$f.fq_question}</a></li>
  {/foreach}
  </ul>
</div>

{if !$faq_detail}
{foreach from=$faqs item=f}
<div class="faq">
  <a name="faq{$f.faqid}"></a>
  <h4>{$f.fq_question}</h4>
  <p>{$f.fq_answer}</p>
  <div><a href="#faq-top" title="Back to top"><img src="{$SITEURL}/images/cms/uparrow.gif" alt="Top" /></a> <a href="#faq-top" title="Back to top">top</a></div>
</div>
{/foreach}
{/if}

{else}
<p>There are currently no frequently asked questions on this site.</p>
{/if}
