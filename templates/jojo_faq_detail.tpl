<p>{$faq.fq_answer}</p>

{if $faqs}
<div class="faq-index">
  <h3>{$faq_title} Index</h3>
  <ul>
{foreach from=$faqs item=f}
    <li><a href="{$prefix}/{if $f.fq_faqurl}{$f.fq_faqurl}{else}{$f.faqid}{/if}/">{$f.fq_question}</a></li>
  {/foreach}
  </ul>
</div>
{/if}
