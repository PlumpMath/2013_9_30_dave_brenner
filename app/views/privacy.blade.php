@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Privacy Policy', 'icon' => 'eye-open', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Privacy Policy'])
<div class="box bg-1">
	<div class="box measure bg-0 border-left border-bottom-0">
		@include('modules.section_divide', ['name' => 'Welcome'])
		<div class="box box-pad-0 bg-0">This site is owned by My After School Programs, Inc. (Corp.”)</div>
		@include('modules.section_divide', ['name' => 'Consent'])
		<div class="box box-pad-0 bg-0">By using this site, you hereby represent to the Corp., among other things, that you are an individual of at least twenty one years of age and that you expressly consent to each of the provisions contained in this Privacy Policy and related <a href="{{ URL::to('/legal/terms_of_agreement') }}">Terms and Conditions.</a> Whenever you submit information to this Site, you consent to the collection, use and disclosure of that information in accordance with this Privacy Policy, as well as that of the <a href="{{ URL::to('/legal/terms_of_agreement') }}">Terms and Conditions</a>.
</div>
		@include('modules.section_divide', ['name' => 'Information Collection'])
		<div class="box box-pad-0 bg-0 border-bottom-0">This site collects personal information for the purpose of (a) fulfilling class program schedules, (b) providing necessary information to the associated sponsors for required record maintenance, and (c) enabling us to contact you via email, phone or mail to your street address, for the purpose of providing informational or advisory program communications.<br/><br/>As some programs on this site are sponsored by 3rd party non-profit organizations, your personal information is submitted to these organizations after you register, comparable to registering in person for similar programs where physical registration forms are filled out.<br/><br/>Notwithstanding anything to the contrary contained herein, in no event shall the liability of the Corp, exceed the dollar amount of enrollment hereunder.<br/><br/>Further, similar to many websites, IP addresses and cookies are used to maximize your security, analogous to special passes that allow you access to a restricted area. We do not give, share, sell, rent, trade or allow any additional third party access to your personal information. Only legal requests by court order, subpoena or request by law enforcement agency can result in disclosure of personal information beyond the above mentioned.<br/><br/>This site does monitor page activity to understand customer patterns and trends for the purpose of improving this site and customer experience/service.</div>
		@include('modules.section_divide', ['name' => 'Security'])
		<div class="box box-pad-0 bg-0 border-bottom-0">The security of your personal information is important to us. We take all commercially reasonable measures to protect the confidentiality of your personal information. This website utilizes secure hypertext transfer protocol (https) through a secure sockets layer (SSL) to encrypt and protect your information.<br/><br/>While we take commercially reasonable measures to maintain a secure site, electronic communications and databases cannot be 100% safeguarded from errors, destruction, tampering and unauthorized access, and we cannot guarantee or warrant that such events will not take place.  Visitors or Authorized Customers acknowledge and agree that Corp., shall have no liability whatsoever for any of the aforementioned occurrences.<br/><br/>As no internet transmission is ever 100% secure or error-free, and as such it’s the sole responsibility of Visitor or Authorized Customers to safeguard its use of passwords, usernames, ID numbers or other special access features on this Site. Visitors or Authorized Customers expressly acknowledge and agree that they will indemnify, defend and hold Corp., harmless from any and all actions which may arise as a result of any action or claim arising, directly or indirectly, from said Visitors or Authorized Customersuse of passwords, usernames, ID numbers or other special access features on this Site.</div>
		@include('modules.section_divide', ['name' => 'Policy Updates'])
		<div class="box box-pad-0 bg-0">You expressly acknowledge and agree that the Corp., shall have the right to update and/or revise any policy contained herein, and that such revisions or updates shall be self-operative and automatically applicable to you. Please check this Policy and the <a href="{{ URL::to('/legal/terms_of_agreement') }}">Terms and Conditions</a> for any such periodical updates or revisions.</div>
		@include('modules.section_divide', ['name' => 'How to Contact Us'])
		<div class="box box-pad-0 bg-0 border-bottom-0">If you have any questions, comments or concerns about this Privacy Policy, Terms and Conditions, or the information practices of this Site, please contact us at:<br/><br/>
		My After School Programs, Inc.<br/>
		PO Box 444<br/>
		Huntington Station, NY, 11746<br/><br/>
		Or call 631-776-8242</div>
	</div>
	<div class="box box-pad-0 bg-0"></div>
</div>
@stop
