{if $content}{$content}{/if}
{if $faqs}
<div class="faq-index">
  <h3>{$faq_title} Index</h3>
  <ul{if $OPTIONS.faq_detail_pages} id="faq-questions"{/if}>
  {section name=f loop=$faqs}
    <li><a href="{$prefix}/{if $faqs[f].fq_faqurl}{$faqs[f].fq_faqurl}{else}{$faqs[f].faqid}{/if}/">{$faqs[f].fq_question}</a>{if $OPTIONS.faq_detail_pages}<div class="hidden">{$faqs[f].fq_answer}</div>{/if}</li>
  {/section}
  </ul>
</div>

{else}
<p>There are currently no frequently asked questions on this site.</p>
{/if}