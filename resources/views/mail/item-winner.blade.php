@include('mail.partials.head')

<table width="600" cellpadding="0" cellspacing="0" style="margin:0 auto">
	<tr>
		<td style="width:25%"></td>
		<td style="width:50%" align="center">
			<span style="font-family:'Open Sans',Arial;font-weight:normal;font-style:normal;font-size:14px;line-height:19px;color:#000;">Congratulations {{ $name }}</span><br /><br />
			<span style="font-family:'Open Sans',Arial;font-weight:300;font-style:normal;font-size:14px;line-height:19px;color:#000;">You have won {{ $item -> name }}</span><br /><br />
			@if(Storage::disk('public') -> exists($item -> image))
        	<img src="{{ Storage::disk('public') -> url($item -> image) }}" style="max-width:200px;height:auto" alt="{{ $item -> name }}" /><br /><br />
        	@endif
		</td>
		<td style="width:25%"></td>
	</tr>
</table>

@include('mail.partials.footer')