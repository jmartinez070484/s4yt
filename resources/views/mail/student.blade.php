@include('mail.partials.head')

<table width="600" cellpadding="0" cellspacing="0" style="margin:0 auto">
	<tr>
		<td style="width:25%"></td>
		<td style="width:50%" align="center">
			<span style="font-family:'Open Sans',Arial;font-style:normal;font-size:14px;line-height:19px;color:#000;"><span style="font-weight:bold">Your personal and official<br />S4YT EMAIL ADDRESS: {{ $email }}<br /><br /><a href="{{ $link }}">Click Here to Set Your Password</a></span>
		</td>
		<td style="width:25%"></td>
	</tr>
	<tr style="margin-top:50px;">
		<td style="width:25%"></td>
		<td style="width:50%" align="center">
			<span style="font-family:'Open Sans',Arial;font-style:normal;font-size:14px;line-height:19px;color:#000;">Between now and then, check out <br />our free database of Resources -- <br />You may be rewarded with a great find even before S4YT.<br /><br />+10 raffle tix have been + to your ID #!!<br />Tag us on Instagram, fb , and Snapchat to + even more!<br /><br />Mark S4YT in your calendar! <br />But don’t worry, we’ll remind you :) <br /><br />See you there!</span>
		</td>
		<td style="width:25%"></td>
	</tr>
</table>

@include('mail.partials.footer')