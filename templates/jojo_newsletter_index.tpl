{if $pg_body}{$pg_body}
{/if}
{if $newsletters}<ul>
    {foreach from=$newsletters item=n}<li><a href="{$SITEURL}/{$pg_url}/{$n.id}/" title="{$n.name}">{$n.name}</a> <span class="note">({$n.datefriendly})</span></li>
    {/foreach}
    </ul>
{/if} 