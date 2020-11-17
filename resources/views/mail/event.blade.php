@include('mail.partials.head')

<table width="600" cellpadding="0" cellspacing="0" style="margin:0 auto">
	<tr>
		<td style="width:25%"></td>
		<td style="width:50%" align="center">
			<span style="font-family:'Open Sans',Arial;font-style:normal;font-size:14px;line-height:19px;color:#000;">We know this is a bit out of order since the prize winners are posted already (go back to $4YT to check them out!), but...<br /><br />Thank you for attending $4YT!<br /></span><br />
		</td>
		<td style="width:25%"></td>
	</tr>
	<tr style="margin-top:50px;">
		<td style="width:25%"></td>
		<td style="width:50%" align="center">
			<span style="font-family:'Open Sans',Arial;font-style:normal;font-size:14px;line-height:19px;color:#000;"><span style="font-weight:bold;">Questions you've submitted your ideas on:</span>
		@foreach($answers as $answer)
			@if($question = $answer -> question)
			<br /><span>Q: {{ $question -> text }}</span>
			@endif
		@endforeach
			<br /><br />
		</span>
		</td>
		<td style="width:25%"></td>
	</tr>
	<tr style="margin-top:50px;">
		<td style="width:25%"></td>
		<td style="width:50%" align="center">
			<span style="font-family:'Open Sans',Arial;font-style:normal;font-size:14px;line-height:19px;color:#000;"><span style="font-weight:bold;">Treasure Items you've bid on:</span>
		@foreach($items as $itemId)
			@if($item = App\Item::find($itemId))
			<br />@if(Storage::disk('public') -> exists($item -> image)) <img src="{{ Storage::disk('public') -> url($item -> image) }}" alt="{{ $item -> name }}" style="max-width:100px;margin-top:15px;height:auto;" /> @endif<span style="display:block;width:100%;">{{ $item -> name }}</span>
			@endif
		@endforeach
		</span><br /><br />
		</td>
		<td style="width:25%"></td>
	</tr>
	<tr style="margin-top:50px;">
		<td style="width:25%"></td>
		<td style="width:50%" align="center">
			<span style="font-family:'Open Sans',Arial;font-style:normal;font-size:14px;line-height:19px;color:#000;"><span style="font-weight:bold;">Companies that you connected to:</span>
		@foreach($connects as $connect)
			@if($business = App\Business::find($connect -> business_id))
			<br /><span style="display:block;width:100%;">{{ $business -> name }} @if($user = $business -> user) <a href="mailto:{{ $user -> email }}">{{ $user -> email }}</a> @endif</span>
			@endif
		@endforeach
		</span>
		</td>
		<td style="width:25%"></td>
	</tr>
</table>

@include('mail.partials.footer')