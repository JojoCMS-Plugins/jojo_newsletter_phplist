{if $message}
<div class="message">{$message}</div>
{/if}
{if $content}{$content}{/if}
<form name="contactform" method="post" action="{$posturl}" onsubmit="return checkmenewsletter()" class="contact-form">
    <p class="note">Required fields are marked *</p>
{foreach from=$fields key=k item=f }
    {assign var=x value=`$k-1`}
    {if $f.fieldset!='' && $f.fieldset!=$fields[$x].fieldset}<fieldset><legend>{$f.fieldset}</legend>{/if}
    <label for="form_{$f.field}">{if $f.display!=''}{$f.display}:{/if}</label>
    {if $f.type == 'textarea'}
    <textarea class="textarea" rows="{$f.rows|default:'10'}" cols="{$f.cols|default:'29'}" name="form_{$f.field}" id="form_{$f.field}">{$f.value}</textarea>
    {elseif $f.type == 'checkboxes'}
    <div class="form-field">
{foreach from=$f.options item=fo }
        <input type="checkbox" class="checkbox" name="form_{$f.field}[{$fo}]" id="form_{$f.field}_{$fo|replace:' ':'_'|replace:'$':''}" value="{$fo}" /><label for="form_{$f.field}_{$fo}"> {$fo}</label><br />
{/foreach}
    </div>
    {elseif $f.type=='select'}
    <select name="form_{$f.field}" id="form_{$f.field}">
          <option value="">Select</option>
{foreach from=$f.options key=k item=so}
          <option value="{$k}"{if $f.value == $so} selected="selected"{/if}>{$so}</option>
{/foreach}
    </select>
    {else}
    <input type="{$f.type}" class="{$f.type}" size="{$f.size}" name="form_{$f.field}" id="form_{$f.field}" value="{$f.value}" />
    {/if}
    {if $f.required && $f.type!='hidden'}&nbsp;*{/if}
    {if $f.description}<div class="form-field-description">{$f.description}</div>{/if}<br />
    {assign var=x value=`$k+1`}
    {if $f.fieldset!='' && $f.fieldset!=$fields[$x].fieldset}</fieldset>{/if}
{/foreach}
{if $OPTIONS.contactcaptcha == 'yes'}
    <div class="captcha">
        <label for="CAPTCHA">Spam prevention:</label>
        <input type="text" class="text" size="8" name="CAPTCHA" id="CAPTCHA" value="" />&nbsp;*<br />
        <p class="note">Please enter the 3 letter code below. This helps us prevent spam. <em>Code is not case-sensitive</em></p>
        <img src="external/php-captcha/visual-captcha.php" width="200" height="60" alt="Visual CAPTCHA" /><br />
    </div>
{/if}
    <label>&nbsp;</label><input type="submit" name="submit" value="Submit" class="button" onmouseover="this.className='button buttonrollover';" onmouseout="this.className='button'" />
<br class="clear" />
</form>