<p>{$faq.fq_answer}</p>

{if $faqs}
<div class="faq-index">
  <h3>{$faq_title} Index</h3>
  <ul>
  {section name=f loop=$faqs}
    <li><a href="{$prefix}/{if $faqs[f].fq_faqurl}{$faqs[f].fq_faqurl}{else}{$faqs[f].faqid}{/if}/">{$faqs[f].fq_question}</a></li>
  {/section}
  </ul>
</div>
{/if}