{include file="admin/header.tpl"}
<div id="event-log">

<table class="table">
    <tr>
      <td><h3>Newsletter</h3></td>
      <td><h3>Date Sent</h3></td>
      <td><h3>Sent</h3></td>
	  <td><h3>Bounced</h3></td>
	  <td><h3>Views</h3></td>
	  <td><h3>Details</h3></td>
    </tr>

    {foreach from=$messageinfo item=e }
    <tr>
      <td>{$e.subject}</td>
      <td>{$e.sendstart|date_format:"%e %B %Y"}</td>
      <td>{$e.processed}</td>
	  <td>{$e.bouncecount}</td>
	  <td>{$e.viewed}</td>
	  <td>
			<a href="admin/more-newsletter-stats/{$e.id}"> more... </a>
     </td>
    </tr>
    {/foreach}

</table>

</div>

{include file="admin/footer.tpl"}