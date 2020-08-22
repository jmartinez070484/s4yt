@include('mail.partials.head')

<table width="600" cellpadding="0" cellspacing="0" style="margin:0 auto">
	<tr>
		<td style="width:25%"></td>
		<td style="width:50%" align="center">
			<span style="font-family:'Open Sans',Arial;font-weight:normal;font-style:normal;font-size:14px;line-height:19px;color:#000;">Congratulations {{ $name }}</span><br /><br />
			<span style="font-family:'Open Sans',Arial;font-weight:300;font-style:normal;font-size:14px;line-height:19px;color:#000;">You have been awarded a scholarship:<br /><br /><b style="font-weight:bold">"{{ $scholarship -> name }} ${{ $scholarship -> amount }}"</b> <br /><br />By {{ $business -> name }}</span><br /><br />
		</td>
		<td style="width:25%"></td>
	</tr>
</table>

@include('mail.partials.footer')