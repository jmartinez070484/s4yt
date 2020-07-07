@include('mail.partials.head')

<table width="600" cellpadding="0" cellspacing="0" style="margin:0 auto">
	<tr>
		<td style="width:25%"></td>
		<td style="width:50%" align="center">
			<span style="font-family:'Open Sans',Arial;font-weight:normal;font-style:normal;font-size:14px;line-height:19px;color:#000;"><a href="{{ $url }}">Click Here to Reset Your Password</a></span>
		</td>
		<td style="width:25%"></td>
	</tr>
</table>

@include('mail.partials.footer')