{include file="admin/header.tpl"}
<div id="event-log">

<table >
    <tr>
      <td><h3>Newsletter</h3></td>
      <td><h3>Date Sent</h3></td>
      <td><h3>Sent</h3></td>
	  <td><h3>Bounced</h3></td>
	  <td><h3>Views</h3></td>
	  <td><h3>Details</h3></td>
    </tr>

    {section name=e loop=$messageinfo}
    <tr>
      <td>{$messageinfo[e].subject}</td>
      <td>{$messageinfo[e].sendstart|date_format:"%e %B %Y"}</td>
      <td>{$messageinfo[e].processed}</td>
	  <td>{$messageinfo[e].bouncecount}</td>
	  <td>{$messageinfo[e].viewed}</td>
	  <td>
			<a href="admin/more-newsletter-stats/{$messageinfo[e].id}"> more... </a>
     </td>
    </tr>
    {/section}

</table>

</div>

{include file="admin/footer.tpl"}