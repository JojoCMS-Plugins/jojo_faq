{if $content}{$content}{/if}
{if $faqs}
<div class="faq-index">
  <a name="faq-top"></a>
  <h3>{$faq_title} Index</h3>
  <ul>
  {section name=f loop=$faqs}
    <li><a href="#faq{$faqs[f].faqid}">{$faqs[f].fq_question}</a></li>
  {/section}
  </ul>
</div>

{section name=f loop=$faqs}
<div class="faq">
  <a name="faq{$faqs[f].faqid}"></a>
  <h4>{$faqs[f].fq_question}</h4>
  <p>{$faqs[f].fq_answer}</p>
  <div><a href="#faq-top" title="Back to top"><img src="images/cms/uparrow.gif" alt="Top" /></a> <a href="#faq-top" title="Back to top">top</a></div>
</div>

{/section}
{else}
<p>There are currently no frequently asked questions on this site.</p>
{/if}