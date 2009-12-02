Send email to selected groups now:<br/>

<input type="button" value="Send Newsletter Now" onclick="javascript:if(confirm('Really?')){ldelim}{if $newsletterid}if (confirm('Are you sure you want to send to selected users now?')) {literal}{{/literal}$('#sending-now').show(); $.post('{$SITEURL}/json/newsletter_send_now.php', {literal}{{/literal}id: {$newsletterid}{literal}});} $('#sending-now-error-id').hide();{/literal}{else}$('#sending-now-error-id').show();{/if}{rdelim}return false;" />
<span id="sending-now" style="display: none">Sending now... </span>
<span id="sending-now-error-id" style="display: none">You need to save this newsletter before sending</span>

