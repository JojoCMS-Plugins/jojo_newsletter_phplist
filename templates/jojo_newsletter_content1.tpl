{if !$online && !$inline}<html>
<head>
        <meta content="text/html;charset=UTF-8" http-equiv="Content-Type">
        <title>{$newsletter.name}</title>
</head>
<body>
{/if}
<div style="text-align:center; padding:2px;padding-top:10px;padding-bottom:10px;width:100%">
{if !$online}<!-- view online -->
    <p style="{if $pcss}{$pcss}{else}font-family:verdana; font-size:10px;color:black;{/if}">Can't see this email? <a href="{$SITEURL}/newsletter/{$newsletter.id}/" style="{if $acss}{$acss}{else}font-family:Verdana;font-size:10px;color:orange;{/if}">View it online</a>
{/if}
<table width="600">
{if $bannerimage}<tr>
<td>
<img src="{$SITEURL}/images/600x200/bannerimages/{$bannerimagefile}"/>
</td>
</tr>
{/if}
  <tr bgcolor="#fbfbfb" height="40">
    <td style="padding-left:20px;border-bottom:1px solid #dddddd;text-align:left;">
      <h1 style="font-family:verdana; font-size:13px;color:#9B8C6F;">{$newsletter.name}</h1>
      <p style="font-family:verdana; font-size:10px;color:#9B8C6F;">{$newsletter.issue_number|string_format:"Issue: %03d"}&nbsp;&nbsp;&nbsp;{$newsletter.date|date_format:"%d %b %Y"}</p>
    </td>
  </tr>
  <tr>
    <td valign="top" style="text-align:left; padding:10px;" >
{if $newsletter.intro}{$newsletter.intro}
      <hr color="#dddddd" size="1"/>{/if}

{if $contentarray}{foreach from=$contentarray item=contentitems}

{foreach from=$contentitems item=a}<div style="clear: both;">
<h2 font="Verdana" style="font-family:'verdana';font-size:13px;">{$a.title}</h2>
{if $a.image}<img src="{$SITEURL}/images/s180/{$a.image}" alt="{$a.title}" align="right" style="margin-right:10px;float:right;" width="140" height="94">{/if}
{if $newsletter.link != 'no'}<p style="font-weight:normal;font-family:verdana; font-size:12px;color:#77b1cb;margin-top:10px;">{$a.bodyplain|truncate:275} <a href="{$SITEURL}/{$a.url}">Read more on our website</a></p>
{else}{$a.body}{/if}
<hr color="#dddddd" size="1" style="clear:both;" />
</div>{/foreach}

{/foreach}{/if}

{if $newsletter.outro}{$newsletter.outro}{/if}
<p style="{if $pcss}{$pcss}{else}font-family:verdana; font-size:10px;color:#636363;{/if}">The Unsolicited Electronic Messages Act 2007 came into effect on 5 September 2007 and I need your permission to send you emails. If you no longer wish to receive these emails, please click on this <a href="[UNSUBSCRIBEURL]"style="text-decoration:none;">unsubscribe link</a>.</p>
<p style="{if $pcss}{$pcss}{else}font-family:verdana; font-size:10px;color:#636363;{/if}">All future correspondence will have the option to unsubscribe should you wish to do so. Thanks for allowing this newsletter to be emailed.</p>
</tr>
</table>
</div>{if !$online && !$inline}
[USERTRACK] 
<body></html>
{/if}