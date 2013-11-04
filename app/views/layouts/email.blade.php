<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>{{ $subject }}</title>
        <style type="text/css">
			/* /\/\/\/\/\/\/\/\/ MOBILE STYLES /\/\/\/\/\/\/\/\/ */

            @media only screen and (max-width: 480px){
				/* /\/\/\/\/\/\/ CLIENT-SPECIFIC MOBILE STYLES /\/\/\/\/\/\/ */
				body, table, td, p, a, li, blockquote{-webkit-text-size-adjust:none !important;} /* Prevent Webkit platforms from changing default text sizes */
                body{width:100% !important; min-width:100% !important;} /* Prevent iOS Mail from adding padding to the body */

				/* /\/\/\/\/\/\/ MOBILE RESET STYLES /\/\/\/\/\/\/ */
				#bodyCell{padding:10px !important;}

				/* /\/\/\/\/\/\/ MOBILE TEMPLATE STYLES /\/\/\/\/\/\/ */

				/* ======== Page Styles ======== */

				/**
				* @tab Mobile Styles
				* @section template width
				* @tip Make the template fluid for portrait or landscape view adaptability. If a fluid layout doesn't work for you, set the width to 300px instead.
				*/
				#templateContainer{
					max-width:600px !important;
					/*@editable*/ width:100% !important;
				}

				/**
				* @tab Mobile Styles
				* @section heading 1
				* @tip Make the first-level headings larger in size for better readability on small screens.
				*/
				h1{
					/*@editable*/ font-size:24px !important;
					/*@editable*/ line-height:100% !important;
				}

				/**
				* @tab Mobile Styles
				* @section heading 2
				* @tip Make the second-level headings larger in size for better readability on small screens.
				*/
				h2{
					/*@editable*/ font-size:20px !important;
					/*@editable*/ line-height:100% !important;
				}

				/**
				* @tab Mobile Styles
				* @section heading 3
				* @tip Make the third-level headings larger in size for better readability on small screens.
				*/
				h3{
					/*@editable*/ font-size:18px !important;
					/*@editable*/ line-height:100% !important;
				}

				/**
				* @tab Mobile Styles
				* @section heading 4
				* @tip Make the fourth-level headings larger in size for better readability on small screens.
				*/
				h4{
					/*@editable*/ font-size:16px !important;
					/*@editable*/ line-height:100% !important;
				}

				/* ======== Header Styles ======== */

				#templatePreheader{display:none !important;} /* Hide the template preheader to save space */

				/**
				* @tab Mobile Styles
				* @section header image
				* @tip Make the main header image fluid for portrait or landscape view adaptability, and set the image's original width as the max-width. If a fluid setting doesn't work, set the image width to half its original size instead.
				*/
				#headerImage{
					height:auto !important;
					/*@editable*/ max-width:600px !important;
					/*@editable*/ width:100% !important;
				}

				/**
				* @tab Mobile Styles
				* @section header text
				* @tip Make the header content text larger in size for better readability on small screens. We recommend a font size of at least 16px.
				*/
				.headerContent{
					/*@editable*/ font-size:14px !important;
					/*@editable*/ line-height:125% !important;
				}

				/* ======== Body Styles ======== */

				/**
				* @tab Mobile Styles
				* @section body text
				* @tip Make the body content text larger in size for better readability on small screens. We recommend a font size of at least 16px.
				*/
				.bodyContent{
					/*@editable*/ font-size:18px !important;
					/*@editable*/ line-height:125% !important;
				}

				/* ======== Footer Styles ======== */

				/**
				* @tab Mobile Styles
				* @section footer text
				* @tip Make the body content text larger in size for better readability on small screens.
				*/
				.footerContent{
					/*@editable*/ font-size:14px !important;
					/*@editable*/ line-height:115% !important;
				}

				.footerContent a{display:block !important;} /* Place footer social and utility links on their own lines, for easier access */
			}
		</style>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script></head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="margin: 0px; padding: 0px; height: 100%; width: 100%; background-color: rgb(255, 255, 255);">
    	<center>
        	<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="border-collapse: collapse; margin: 0px; padding: 0px; height: 100%; width: 100%; background-color: rgb(255, 255, 255);">
            	<tbody><tr>
                	<td align="center" valign="top" id="bodyCell" style="margin: 0px; padding: 20px; height: 100%; width: 100%;">
                    	<!-- BEGIN TEMPLATE // -->
                    	<table border="0" cellpadding="0" cellspacing="0" id="templateContainer" style="border-collapse: collapse; width: 600px; border: 1px solid rgb(208, 208, 208);">
                        	<tbody><tr>
                            	<td align="center" valign="top">
                                	<!-- BEGIN PREHEADER // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templatePreheader" style="border-collapse: collapse; background-color: rgb(238, 238, 238);">
                                        <tbody><tr>
                                            <td valign="top" class="preheaderContent" style="padding: 10px 20px; color: rgb(149, 149, 149); font-family: 'Open Sans'; font-size: 10px; line-height: 125%; text-align: left;" mc:edit="preheader_content00">
                                                {{ $summary }}
                                            </td>
                                            <!-- *|IFNOT:ARCHIVE_PAGE|* -->
                                            <td valign="top" width="180" class="preheaderContent" style="padding: 10px 20px 10px 0px; color: rgb(149, 149, 149); font-family: 'Open Sans'; font-size: 10px; line-height: 125%; text-align: left;" mc:edit="preheader_content01">
                                                Email not displaying correctly?<br><a href="{{ $in_browser_link }}" target="_blank" style="color: rgb(96, 96, 96); font-weight: normal; text-decoration: underline;">View it in your browser</a>.
                                            </td>
                                            <!-- *|END:IF|* -->
                                        </tr>
                                    </tbody></table>
                                    <!-- // END PREHEADER -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                	<!-- BEGIN HEADER // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateHeader" style="border-collapse: collapse; background-color: rgb(248, 108, 89);">
                                        <tbody><tr>
                                            <td valign="top" class="headerContent" style="color: rgb(255, 255, 255); font-family: 'Open Sans'; font-size: 14px; font-weight: 400; line-height: 100%; padding: 20px 0px; text-align: center; vertical-align: middle;">
                                            	myafterschoolprograms
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <!-- // END HEADER -->
                                </td>
                            </tr>

                        	<tr>
                            	<td align="center" valign="top">
                                	<!-- BEGIN BODY // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody" style="border-collapse: collapse; background-color: rgb(255, 255, 255); border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: rgb(208, 208, 208);">
                                        <tbody><tr>
                                            <td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(149, 149, 149); font-family: 'Open Sans'; font-size: 14px; line-height: 150%; padding: 20px; text-align: left;">
                                            	@yield('content')
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <!-- // END BODY -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                	<!-- BEGIN FOOTER // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateFooter" style="border-collapse: collapse; background-color: rgb(238, 238, 238);">
                                        <tbody>
                                        <tr>
                                            <td valign="top" class="footerContent" style="padding: 20px; color: rgb(149, 149, 149); font-family: 'Open Sans'; font-size: 10px; line-height: 150%; text-align: left;" mc:edit="footer_content01">
                                                <em>Copyright © {{ $year }} myafterschoolprograms, inc., All rights reserved.</em>
                                                <br>
                                                {{ $description }}
                                                <br>
                                                <br>
                                                <strong>Our mailing address is:</strong>
                                                <br>
                                                {{ $return_email }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" class="footerContent" style="padding: 20px; color: rgb(149, 149, 149); font-family: 'Open Sans'; font-size: 10px; line-height: 150%; text-align: left;" mc:edit="footer_content02">
                                            	<a href="{{ $unsubscribe_link }}" style="color: rgb(96, 96, 96); font-weight: normal; text-decoration: underline;">unsubscribe from this list</a>&nbsp;&nbsp;&nbsp;<a href="{{ $profile_preferences_link }}" style="color: rgb(96, 96, 96); font-weight: normal; text-decoration: underline;">update subscription preferences</a>&nbsp;
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <!-- // END FOOTER -->
                                </td>
                            </tr>
                        </tbody></table>
                        <!-- // END TEMPLATE -->
                    </td>
                </tr>
            </tbody></table>
        </center>
    
</body>
</html>
