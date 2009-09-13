<img src="{$bannerimage}" width="394px" height="213px"/></td></tr>
  <tr bgcolor="#fbfbfb" height="40px">
    <td style="padding-left:20px;border-bottom:1px solid #dddddd;text-align:left;">
      <p style="font-family:verdana; font-size:10px;color:#9B8C6F;">{$newsletter.issue_number|string_format:"Issue: %03d"}&nbsp;&nbsp;&nbsp;{$newsletter.date|date_format:"%d %b %Y"}</p>
    </td>
  </tr>
</table>
<table bgcolor="#f7f7f7"cellspacing="10" align="center" width="585">
  <tr>
    <td valign="top" style="text-align:left; padding:10px;" width="395" >
      <p style="font-family:verdana; font-size:11px;color:#636363;">{$newsletter.intro}</p>
      <hr color="#dddddd" size="1"/>

{foreach from=$articles item=a}
      <div style="clear: both;">
      <h2 style="font-weight:normal;font-family:verdana; font-size:12px;color:#77b1cb;margin-top:10px;">{$a.ar_title}</h2>
      <p style="font-family:verdana; font-size:11px;color:#636363;">
{if $a.ar_image}
        <img src="{$a.ar_image}" style="float:right;margin-left:8px;margin-bottom:8px;" align="right"/><br />
{/if}

{if $newsletter.link != 'no'}
    {if $a.ar_language =='ru'}
         {$a.ar_body|truncate:2000}</p>
    {else}
         {$a.ar_body|truncate:450}</p>
    {/if}

      <p><a href="{$a.ar_url}" style="text-decoration:none;" title="Read more"><img style="border:0;float:right;" src="button.png" width="100" height="27" alt="Read more" align="right"/></a></p>
{else}
    {$a.ar_body}</p>
{/if}
      <br />
      <hr color="#dddddd" size="1" style="clear:both;" />
      </div>
{/foreach}

{if $newsletter.outro}
      <p style="font-family:verdana; font-size:11px;color:#77b1cb;">{$newsletter.outro}</p>
{/if}