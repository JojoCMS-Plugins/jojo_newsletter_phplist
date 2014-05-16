{if $message}<div class="message">{$message}</div>
{/if}
{if $content}{$content}
{/if}
<form name="contactform" method="post" action="{$posturl}" class="contact-form no-ajax">
    {foreach from=$fields key=k item=f }{assign var=x value=`$k-1`}
    {if $f.fieldset!='' && $f.fieldset!=$fields[$x].fieldset}<fieldset>
        <legend>{$f.fieldset}</legend>
    {/if}
        <div class="form-fieldset form-group">
            {if $f.type!='hidden'}<label for="form_{$f.field}" class="control-label">{if $f.display!='' }##{$f.display}##:{/if}{if $f.required && $f.type!='hidden'}<span class="required">*</span>{/if}</label>{/if}
            {if $f.type == 'textarea'}<textarea class="textarea" rows="{$f.rows|default:'10'}" cols="{$f.cols|default:'29'}" name="form_{$f.field}" id="form_{$f.field}">{$f.value}</textarea>
            {elseif $f.type == 'checkboxes'}
                {foreach from=$f.options key=k item=fo }<label for="form_{$f.field}_{$fo}" class="checkbox"><input type="checkbox" name="form_{$f.field}[{$fo}]" id="form_{$f.field}_{$fo|replace:' ':'_'|replace:'$':''}" value="{$k}" />{$fo}</label><br />
                {/foreach}
            {elseif $f.type=='select'}<select name="form_{$f.field}" id="form_{$f.field}">
                <option value="">Select</option>
                {foreach from=$f.options key=k item=so}<option value="{$k}"{if $f.value == $so} selected="selected"{/if}>{$so}</option>
                {/foreach}
            </select>
            {else}<input type="{$f.type}" class="{$f.type} form-control" {if $f.size}size="{$f.size}"{/if} name="form_{$f.field}" id="form_{$f.field}" value="{if $f.value}{$f.value}{/if}" />
            {/if}
            {if $f.description}<div class="form-field-description">{$f.description}</div>{/if}
        </div>
    {assign var=x value=`$k+1`}
    {if $f.fieldset!='' && $f.fieldset!=$fields[$x].fieldset}</fieldset>{/if}
    {/foreach}

    {if $OPTIONS.contactcaptcha == 'yes'}<div class="captcha">
        <label for="CAPTCHA">Spam prevention:</label>
        <input type="text" class="text" size="8" name="CAPTCHA" id="CAPTCHA" value="" />&nbsp;*<br />
        <p class="note">Please enter the 3 letter code below. This helps us prevent spam. <em>Code is not case-sensitive</em></p>
        <img src="external/php-captcha/visual-captcha.php" width="200" height="60" alt="Visual CAPTCHA" /><br />
    </div>
    {/if}
    <button type="submit" name="submit" value="##Submit##" class="button btn btn-primary" >##Submit##</button>
</form>