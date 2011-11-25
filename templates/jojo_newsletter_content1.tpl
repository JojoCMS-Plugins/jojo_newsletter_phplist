<html>
<body>
<div style="text-align:center; padding:2px;padding-top:10px;padding-bottom:10px;">
<table width="600px">
{if $bannerimage}
<tr>
<td>
<img src="{$bannerimage}"/>
</td>
</tr>
{/if}
  <tr bgcolor="#fbfbfb" height="40px">
    <td style="padding-left:20px;border-bottom:1px solid #dddddd;text-align:left;">
      <h1 style="font-family:verdana; font-size:13px;color:#9B8C6F;">{$newsletter.name}</h1>
      <p style="font-family:verdana; font-size:10px;color:#9B8C6F;">{$newsletter.issue_number|string_format:"Issue: %03d"}&nbsp;&nbsp;&nbsp;{$newsletter.date|date_format:"%d %b %Y"}</p>
    </td>
  </tr>
  <tr>
    <td valign="top" style="text-align:left; padding:10px;" >
{if $htmlintro && $newsletter.intro}{str_replace('<p>', '<p style="font-family:verdana; font-size:11px;color:#636363;">', $newsletter.intro)}
{elseif $newsletter.intro}<p style="font-family:verdana; font-size:11px;color:#636363;">{$newsletter.intro}</p>
{/if}
      <hr color="#dddddd" size="1"/>

{if $contentarray}{foreach from=$contentarray item=contentitems}

{foreach from=$contentitems item=a}<div style="clear: both;">
<h2 font="Verdana" style="font-family:'verdana';font-size:13px;">{$a.title}</h2>
{if $a.image}<img src="{$SITEURL}/images/s180/{$a.image}" alt="{$a.title}" align="right" style="margin-right:10px;float:right;" width="140px" height="94px">{/if}
{if $newsletter.link != 'no'}<p style="font-weight:normal;font-family:verdana; font-size:12px;color:#77b1cb;margin-top:10px;">{$a.bodyplain|truncate:275} <a href="{$SITEURL}/{$a.url}">Read more on our website</a></p>
{else}{$a.body}{/if}
<hr color="#dddddd" size="1" style="clear:both;" />
</div>{/foreach}

{/foreach}{/if}

{if $htmlintro && $newsletter.outro}{str_replace('<p>', '<p style="font-family:verdana; font-size:11px;color:#636363;">', $newsletter.outro)}
{elseif $newsletter.outro}<p style="font-family:verdana; font-size:11px;color:#636363;">{$newsletter.outro}</p>
{/if}
<p style="font-family:verdana; font-size:10px;color:#636363;">The Unsolicited Electronic Messages Act 2007 came into effect on 5 September 2007 and I need your permission to send you emails. If you no longer wish to receive these emails, please click on this <a href="[UNSUBSCRIBEURL]"style="text-decoration:none;">unsubscribe link</a>.</p>
<p style="font-family:verdana; font-size:10px;color:#636363;">All future correspondence will have the option to unsubscribe should you wish to do so. Thanks for allowing this newsletter to be emailed.</p>
</tr>
</table>
</div>[USERTRACK] 

<body></html>