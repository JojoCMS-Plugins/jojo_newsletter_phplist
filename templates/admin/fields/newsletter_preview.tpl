Send a preview email to:<br/>
<input type="text" name="fm_{$fd_field}" id="fm_{$fd_field}" size="40" value="" />
<input type="button" value="Send Preview Now" onclick="{if $newsletterid}if ($('#fm_{$fd_field}').val()!=''){literal}{{/literal} $('#sending-preview').show(); $.post('{$SITEURL}/json/newsletter_preview.php', {literal}{{/literal} id:{$newsletterid}, email:$('#fm_{$fd_field}').val(){literal}}, function(){$('#sending-preview').fadeOut();}); $('#sending-error-id').hide(); $('#sending-error-email').hide(); return false; } else { $('#sending-error-email').show();$('#sending-error-id').hide(); return false; }{/literal}{else}$('#sending-error-id').show(); $('#sending-error-email').hide(); return false;{/if}" />
<span id="sending-preview" style="display: none">Sending Preview now...</span>
<span id="sending-error-id" style="display: none">You need to save this newsletter before sending</span>
<span id="sending-error-email" style="display: none">Enter an address to send to</span>