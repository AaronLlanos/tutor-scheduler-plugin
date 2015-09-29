<?php 

/**
* 
*/
class Email_Controller
{
	public static function getCancellationMessage($eventDate, $tuteeFirstName, $tuteeLastName, $tuteeEmail, $tutorFirstName, $tutorLastName, $tutorEmail){
		return '<html xmlns="http://www.w3.org/1999/xhtml"><head>
		    	<!-- NAME: 1 COLUMN -->
		        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		        <title>*|MC:SUBJECT|*</title>
		        
		    <style type="text/css">
				body,#bodyTable,#bodyCell{
					height:100% !important;
					margin:0;
					padding:0;
					width:100% !important;
				}
				table{
					border-collapse:collapse;
				}
				img,a img{
					border:0;
					outline:none;
					text-decoration:none;
				}
				h1,h2,h3,h4,h5,h6{
					margin:0;
					padding:0;
				}
				p{
					margin:1em 0;
					padding:0;
				}
				a{
					word-wrap:break-word;
				}
				.ReadMsgBody{
					width:100%;
				}
				.ExternalClass{
					width:100%;
				}
				.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{
					line-height:100%;
				}
				table,td{
					mso-table-lspace:0pt;
					mso-table-rspace:0pt;
				}
				#outlook a{
					padding:0;
				}
				img{
					-ms-interpolation-mode:bicubic;
				}
				body,table,td,p,a,li,blockquote{
					-ms-text-size-adjust:100%;
					-webkit-text-size-adjust:100%;
				}
				#bodyCell{
					padding:20px;
				}
				.mcnImage{
					vertical-align:bottom;
				}
				.mcnTextContent img{
					height:auto !important;
				}
			/*
			*/
				body,#bodyTable{
					/*@editable*/background-color:#F2F2F2;
				}
			/*
			*/
				#bodyCell{
					/*@editable*/border-top:0;
				}
			/*
			@tab Page
			@section email border
			@tip Set the border for your email.
			*/
				#templateContainer{
					/*@editable*/border:0;
				}
			/*
			@tab Page
			@section heading 1
			@tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
			@style heading 1
			*/
				h1{
					/*@editable*/color:#606060 !important;
					display:block;
					/*@editable*/font-family:Helvetica;
					/*@editable*/font-size:40px;
					/*@editable*/font-style:normal;
					/*@editable*/font-weight:bold;
					/*@editable*/line-height:125%;
					/*@editable*/letter-spacing:-1px;
					margin:0;
					/*@editable*/text-align:left;
				}
			/*
			@tab Page
			@section heading 2
			@tip Set the styling for all second-level headings in your emails.
			@style heading 2
			*/
				h2{
					/*@editable*/color:#404040 !important;
					display:block;
					/*@editable*/font-family:Helvetica;
					/*@editable*/font-size:26px;
					/*@editable*/font-style:normal;
					/*@editable*/font-weight:bold;
					/*@editable*/line-height:125%;
					/*@editable*/letter-spacing:-.75px;
					margin:0;
					/*@editable*/text-align:left;
				}
			/*
			@tab Page
			@section heading 3
			@tip Set the styling for all third-level headings in your emails.
			@style heading 3
			*/
				h3{
					/*@editable*/color:#606060 !important;
					display:block;
					/*@editable*/font-family:Helvetica;
					/*@editable*/font-size:18px;
					/*@editable*/font-style:normal;
					/*@editable*/font-weight:bold;
					/*@editable*/line-height:125%;
					/*@editable*/letter-spacing:-.5px;
					margin:0;
					/*@editable*/text-align:left;
				}
			/*
			@tab Page
			@section heading 4
			@tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
			@style heading 4
			*/
				h4{
					/*@editable*/color:#808080 !important;
					display:block;
					/*@editable*/font-family:Helvetica;
					/*@editable*/font-size:16px;
					/*@editable*/font-style:normal;
					/*@editable*/font-weight:bold;
					/*@editable*/line-height:125%;
					/*@editable*/letter-spacing:normal;
					margin:0;
					/*@editable*/text-align:left;
				}
			/*
			*/
				#templatePreheader{
					/*@editable*/background-color:#FFFFFF;
					/*@editable*/border-top:0;
					/*@editable*/border-bottom:0;
				}
			/*
			*/
				.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
					/*@editable*/color:#606060;
					/*@editable*/font-family:Helvetica;
					/*@editable*/font-size:11px;
					/*@editable*/line-height:125%;
					/*@editable*/text-align:left;
				}
			/*
			*/
				.preheaderContainer .mcnTextContent a{
					/*@editable*/color:#606060;
					/*@editable*/font-weight:normal;
					/*@editable*/text-decoration:underline;
				}
			/*
			*/
				#templateHeader{
					/*@editable*/background-color:#FFFFFF;
					/*@editable*/border-top:0;
					/*@editable*/border-bottom:0;
				}
			
				.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
					/*@editable*/color:#606060;
					/*@editable*/font-family:Helvetica;
					/*@editable*/font-size:15px;
					/*@editable*/line-height:150%;
					/*@editable*/text-align:left;
				}
			/*
			*/
				.headerContainer .mcnTextContent a{
					/*@editable*/color:#6DC6DD;
					/*@editable*/font-weight:normal;
					/*@editable*/text-decoration:underline;
				}
			/*
			*/
				#templateBody{
					/*@editable*/background-color:#FFFFFF;
					/*@editable*/border-top:0;
					/*@editable*/border-bottom:0;
				}
			/*
			@tab Body
			@section body text
			*/
				.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
					/*@editable*/color:#606060;
					/*@editable*/font-family:Helvetica;
					/*@editable*/font-size:15px;
					/*@editable*/line-height:150%;
					/*@editable*/text-align:left;
				}
			/*
			@tab Body
			@section body link
			*/
				.bodyContainer .mcnTextContent a{
					/*@editable*/color:#6DC6DD;
					/*@editable*/font-weight:normal;
					/*@editable*/text-decoration:underline;
				}
			/*
			@tab Footer
			@section footer style
			*/
				#templateFooter{
					/*@editable*/background-color:#FFFFFF;
					/*@editable*/border-top:0;
					/*@editable*/border-bottom:0;
				}
			/*
			@tab Footer
			@section footer text
			*/
				.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
					/*@editable*/color:#606060;
					/*@editable*/font-family:Helvetica;
					/*@editable*/font-size:11px;
					/*@editable*/line-height:125%;
					/*@editable*/text-align:left;
				}
			/*
			@tab Footer
			@section footer link
			*/
				.footerContainer .mcnTextContent a{
					/*@editable*/color:#606060;
					/*@editable*/font-weight:normal;
					/*@editable*/text-decoration:underline;
				}
			@media only screen and (max-width: 480px){
				body,table,td,p,a,li,blockquote{
					-webkit-text-size-adjust:none !important;
				}

		}	@media only screen and (max-width: 480px){
				body{
					width:100% !important;
					min-width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				td[id=bodyCell]{
					padding:10px !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnTextContentContainer]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnBoxedTextContentContainer]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcpreview-image-uploader]{
					width:100% !important;
					display:none !important;
				}

		}	@media only screen and (max-width: 480px){
				img[class=mcnImage]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnImageGroupContentContainer]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageGroupContent]{
					padding:9px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageGroupBlockInner]{
					padding-bottom:0 !important;
					padding-top:0 !important;
				}

		}	@media only screen and (max-width: 480px){
				tbody[class=mcnImageGroupBlockOuter]{
					padding-bottom:9px !important;
					padding-top:9px !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnCaptionTopContent],table[class=mcnCaptionBottomContent]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnCaptionLeftTextContentContainer],table[class=mcnCaptionRightTextContentContainer],table[class=mcnCaptionLeftImageContentContainer],table[class=mcnCaptionRightImageContentContainer],table[class=mcnImageCardLeftTextContentContainer],table[class=mcnImageCardRightTextContentContainer]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
					padding-right:18px !important;
					padding-left:18px !important;
					padding-bottom:0 !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardBottomImageContent]{
					padding-bottom:9px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardTopImageContent]{
					padding-top:18px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
					padding-right:18px !important;
					padding-left:18px !important;
					padding-bottom:0 !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardBottomImageContent]{
					padding-bottom:9px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardTopImageContent]{
					padding-top:18px !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnCaptionLeftContentOuter] td[class=mcnTextContent],table[class=mcnCaptionRightContentOuter] td[class=mcnTextContent]{
					padding-top:9px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnCaptionBlockInner] table[class=mcnCaptionTopContent]:last-child td[class=mcnTextContent]{
					padding-top:18px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnBoxedTextContentColumn]{
					padding-left:18px !important;
					padding-right:18px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnTextContent]{
					padding-right:18px !important;
					padding-left:18px !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section template width
			*/
				table[id=templateContainer],table[id=templatePreheader],table[id=templateHeader],table[id=templateBody],table[id=templateFooter]{
					/*@tab Mobile Styles
		@section template width
					/*@editable*/width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section heading 1
			@tip Make the first-level headings larger in size for better readability on small screens.
			*/
				h1{
					/*@editable*/font-size:24px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section heading 2
			@tip Make the second-level headings larger in size for better readability on small screens.
			*/
				h2{
					/*@editable*/font-size:20px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section heading 3
			@tip Make the third-level headings larger in size for better readability on small screens.
			*/
				h3{
					/*@editable*/font-size:18px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section heading 4
			@tip Make the fourth-level headings larger in size for better readability on small screens.
			*/
				h4{
					/*@editable*/font-size:16px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section Boxed Text
			@tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
			*/
				table[class=mcnBoxedTextContentContainer] td[class=mcnTextContent],td[class=mcnBoxedTextContentContainer] td[class=mcnTextContent] p{
					/*@editable*/font-size:18px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section Preheader Visibility
			*/
				table[id=templatePreheader]{
					/*@editable*/display:block !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section Preheader Text
			@tip Make the preheader text larger in size for better readability on small screens.
			*/
				td[class=preheaderContainer] td[class=mcnTextContent],td[class=preheaderContainer] td[class=mcnTextContent] p{
					/*@editable*/font-size:14px !important;
					/*@editable*/line-height:115% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section Header Text
			@tip Make the header text larger in size for better readability on small screens.
			*/
				td[class=headerContainer] td[class=mcnTextContent],td[class=headerContainer] td[class=mcnTextContent] p{
					/*@editable*/font-size:18px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section Body Text
			@tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
			*/
				td[class=bodyContainer] td[class=mcnTextContent],td[class=bodyContainer] td[class=mcnTextContent] p{
					/*@editable*/font-size:18px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section footer text
			@tip Make the body content text larger in size for better readability on small screens.
			*/
				td[class=footerContainer] td[class=mcnTextContent],td[class=footerContainer] td[class=mcnTextContent] p{
					/*@editable*/font-size:14px !important;
					/*@editable*/line-height:115% !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=footerContainer] a[class=utilityLink]{
					display:block !important;
				}

		}</style></head>
		    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		        <center>
		            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
		                <tbody><tr>
		                    <td align="center" valign="top" id="bodyCell">
		                        <!-- BEGIN TEMPLATE // -->
		                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
		                            <tbody><tr>
		                                <td align="center" valign="top">
		                                    <!-- BEGIN PREHEADER // -->
		                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templatePreheader">
		                                        <tbody><tr>
		                                        	<td valign="top" class="preheaderContainer" style="padding-top:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock">
		    <tbody class="mcnTextBlockOuter">
		        <tr>
		            <td valign="top" class="mcnTextBlockInner">
		                
		                <table align="left" border="0" cellpadding="0" cellspacing="0" width="366" class="mcnTextContentContainer">
		                    <tbody><tr>
		                        
		                        <td valign="top" class="mcnTextContent" style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:0;">
		                        
		                            
		                        </td>
		                    </tr>
		                </tbody></table>
		                
		                <table align="right" border="0" cellpadding="0" cellspacing="0" width="197" class="mcnTextContentContainer">
		                    <tbody><tr>
		                        
		                        <td valign="top" class="mcnTextContent" style="padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:0;">
		                        
		                            <a href="*|ARCHIVE|*" target="_blank">View this email in your browser</a>
		                        </td>
		                    </tr>
		                </tbody></table>
		                
		            </td>
		        </tr>
		    </tbody>
		</table></td>
		                                        </tr>
		                                    </tbody></table>
		                                    <!-- // END PREHEADER -->
		                                </td>
		                            </tr>
		                            <tr>
		                                <td align="center" valign="top">
		                                    <!-- BEGIN HEADER // -->
		                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader">
		                                        <tbody><tr>
		                                            <td valign="top" class="headerContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock">
		    <tbody class="mcnImageBlockOuter">
		            <tr>
		                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
		                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer">
		                        <tbody><tr>
		                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
		                                
		                                    
		                                        <img align="center" alt="" src="https://gallery.mailchimp.com/4aff826dc4e577c6773550167/images/da5b5dd6-1f79-449f-8447-e2f6a4463da8.png" width="564" style="max-width:2226px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
		                                    
		                                
		                            </td>
		                        </tr>
		                    </tbody></table>
		                </td>
		            </tr>
		    </tbody>
		</table></td>
		                                        </tr>
		                                    </tbody></table>
		                                    <!-- // END HEADER -->
		                                </td>
		                            </tr>
		                            <tr>
		                                <td align="center" valign="top">
		                                    <!-- BEGIN BODY // -->
		                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
		                                        <tbody><tr>
		                                            <td valign="top" class="bodyContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock">
		    <tbody class="mcnTextBlockOuter">
		        <tr>
		            <td valign="top" class="mcnTextBlockInner">
		                
		                <table align="left" border="0" cellpadding="0" cellspacing="0" width="600" class="mcnTextContentContainer">
		                    <tbody><tr>
		                        
		                        <td valign="top" class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;">
		                        
		                            <h1 style="text-align: center;">Your Appointment<br> Has Been Cancelled</h1>

		<ul>
			<li><strong>When: </strong>'.$eventDate.'</li>
			<li><strong>Tutor Name: </strong>'.$tutorFirstName. ' ' .$tutorLastName.'</li>
			<li><strong>Tutor Email: </strong>'.$tutorEmail.'</li>
			<li><strong>Tutee Name</strong>: '.$tuteeFirstName. ' ' .$tuteeLastName.'</li>
			<li><strong>Tutee Email:</strong> '.$tuteeEmail.'</li>
		</ul>

		<p style="text-align: center;">This appointment has been cancelled by either the tutor, or the student. Thank you.</p>

		                        </td>
		                    </tr>
		                </tbody></table>
		                
		            </td>
		        </tr>
		    </tbody>
		</table></td>
		                                        </tr>
		                                    </tbody></table>
		                                    <!-- // END BODY -->
		                                </td>
		                            </tr>
		                            <tr>
		                                <td align="center" valign="top">
		                                    <!-- BEGIN FOOTER // -->
		                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateFooter">
		                                        <tbody><tr>
		                                            <td valign="top" class="footerContainer" style="padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock">
		    <tbody class="mcnTextBlockOuter">
		        <tr>
		            <td valign="top" class="mcnTextBlockInner">
		                
		                <table align="left" border="0" cellpadding="0" cellspacing="0" width="600" class="mcnTextContentContainer">
		                    <tbody><tr>
		                        
		                        <td valign="top" class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;">
		                        
		                            <h3 style="line-height: 20.7999992370605px; text-align: center;">This email is automated. Please do not reply directly to this email.</h3>
		<br>
		The Longhorn Center for Academic Excellence</em>
		                        </td>
		                    </tr>
		                </tbody></table>
		                
		            </td>
		        </tr>
		    </tbody>
		</table></td>
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
		    

		</body></html>';
	}

	public static function getSuccessMessage($eventDate, $tutorSubject, $tutorName, $tutorEmail, $tuteeName, $tuteeEmail, $noteToTutor, $plugin_location) {
		return '
		<html xmlns="http://www.w3.org/1999/xhtml"><head>
		    	<!-- NAME: 1 COLUMN -->
		        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		        <title>*|MC:SUBJECT|*</title>
		        
		    <style type="text/css">
				body,#bodyTable,#bodyCell{
					height:100% !important;
					margin:0;
					padding:0;
					width:100% !important;
				}
				table{
					border-collapse:collapse;
				}
				img,a img{
					border:0;
					outline:none;
					text-decoration:none;
				}
				h1,h2,h3,h4,h5,h6{
					margin:0;
					padding:0;
				}
				p{
					margin:1em 0;
					padding:0;
				}
				a{
					word-wrap:break-word;
				}
				.ReadMsgBody{
					width:100%;
				}
				.ExternalClass{
					width:100%;
				}
				.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{
					line-height:100%;
				}
				table,td{
					mso-table-lspace:0pt;
					mso-table-rspace:0pt;
				}
				#outlook a{
					padding:0;
				}
				img{
					-ms-interpolation-mode:bicubic;
				}
				body,table,td,p,a,li,blockquote{
					-ms-text-size-adjust:100%;
					-webkit-text-size-adjust:100%;
				}
				#bodyCell{
					padding:20px;
				}
				.mcnImage{
					vertical-align:bottom;
				}
				.mcnTextContent img{
					height:auto !important;
				}
			/*
			*/
				body,#bodyTable{
					/*@editable*/background-color:#F2F2F2;
				}
			/*
			*/
				#bodyCell{
					/*@editable*/border-top:0;
				}
			/*
			@tab Page
			@section email border
			@tip Set the border for your email.
			*/
				#templateContainer{
					/*@editable*/border:0;
				}
			/*
			@tab Page
			@section heading 1
			@tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
			@style heading 1
			*/
				h1{
					/*@editable*/color:#606060 !important;
					display:block;
					/*@editable*/font-family:Helvetica;
					/*@editable*/font-size:40px;
					/*@editable*/font-style:normal;
					/*@editable*/font-weight:bold;
					/*@editable*/line-height:125%;
					/*@editable*/letter-spacing:-1px;
					margin:0;
					/*@editable*/text-align:left;
				}
			/*
			@tab Page
			@section heading 2
			@tip Set the styling for all second-level headings in your emails.
			@style heading 2
			*/
				h2{
					/*@editable*/color:#404040 !important;
					display:block;
					/*@editable*/font-family:Helvetica;
					/*@editable*/font-size:26px;
					/*@editable*/font-style:normal;
					/*@editable*/font-weight:bold;
					/*@editable*/line-height:125%;
					/*@editable*/letter-spacing:-.75px;
					margin:0;
					/*@editable*/text-align:left;
				}
			/*
			@tab Page
			@section heading 3
			@tip Set the styling for all third-level headings in your emails.
			@style heading 3
			*/
				h3{
					/*@editable*/color:#606060 !important;
					display:block;
					/*@editable*/font-family:Helvetica;
					/*@editable*/font-size:18px;
					/*@editable*/font-style:normal;
					/*@editable*/font-weight:bold;
					/*@editable*/line-height:125%;
					/*@editable*/letter-spacing:-.5px;
					margin:0;
					/*@editable*/text-align:left;
				}
			/*
			@tab Page
			@section heading 4
			@tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
			@style heading 4
			*/
				h4{
					/*@editable*/color:#808080 !important;
					display:block;
					/*@editable*/font-family:Helvetica;
					/*@editable*/font-size:16px;
					/*@editable*/font-style:normal;
					/*@editable*/font-weight:bold;
					/*@editable*/line-height:125%;
					/*@editable*/letter-spacing:normal;
					margin:0;
					/*@editable*/text-align:left;
				}
			/*
			*/
				#templatePreheader{
					/*@editable*/background-color:#FFFFFF;
					/*@editable*/border-top:0;
					/*@editable*/border-bottom:0;
				}
			/*
			*/
				.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
					/*@editable*/color:#606060;
					/*@editable*/font-family:Helvetica;
					/*@editable*/font-size:11px;
					/*@editable*/line-height:125%;
					/*@editable*/text-align:left;
				}
			/*
			*/
				.preheaderContainer .mcnTextContent a{
					/*@editable*/color:#606060;
					/*@editable*/font-weight:normal;
					/*@editable*/text-decoration:underline;
				}
			/*
			*/
				#templateHeader{
					/*@editable*/background-color:#FFFFFF;
					/*@editable*/border-top:0;
					/*@editable*/border-bottom:0;
				}
			
				.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
					/*@editable*/color:#606060;
					/*@editable*/font-family:Helvetica;
					/*@editable*/font-size:15px;
					/*@editable*/line-height:150%;
					/*@editable*/text-align:left;
				}
			/*
			*/
				.headerContainer .mcnTextContent a{
					/*@editable*/color:#6DC6DD;
					/*@editable*/font-weight:normal;
					/*@editable*/text-decoration:underline;
				}
			/*
			*/
				#templateBody{
					/*@editable*/background-color:#FFFFFF;
					/*@editable*/border-top:0;
					/*@editable*/border-bottom:0;
				}
			/*
			@tab Body
			@section body text
			*/
				.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
					/*@editable*/color:#606060;
					/*@editable*/font-family:Helvetica;
					/*@editable*/font-size:15px;
					/*@editable*/line-height:150%;
					/*@editable*/text-align:left;
				}
			/*
			@tab Body
			@section body link
			*/
				.bodyContainer .mcnTextContent a{
					/*@editable*/color:#6DC6DD;
					/*@editable*/font-weight:normal;
					/*@editable*/text-decoration:underline;
				}
			/*
			@tab Footer
			@section footer style
			*/
				#templateFooter{
					/*@editable*/background-color:#FFFFFF;
					/*@editable*/border-top:0;
					/*@editable*/border-bottom:0;
				}
			/*
			@tab Footer
			@section footer text
			*/
				.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
					/*@editable*/color:#606060;
					/*@editable*/font-family:Helvetica;
					/*@editable*/font-size:11px;
					/*@editable*/line-height:125%;
					/*@editable*/text-align:left;
				}
			/*
			@tab Footer
			@section footer link
			*/
				.footerContainer .mcnTextContent a{
					/*@editable*/color:#606060;
					/*@editable*/font-weight:normal;
					/*@editable*/text-decoration:underline;
				}
			@media only screen and (max-width: 480px){
				body,table,td,p,a,li,blockquote{
					-webkit-text-size-adjust:none !important;
				}

		}	@media only screen and (max-width: 480px){
				body{
					width:100% !important;
					min-width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				td[id=bodyCell]{
					padding:10px !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnTextContentContainer]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnBoxedTextContentContainer]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcpreview-image-uploader]{
					width:100% !important;
					display:none !important;
				}

		}	@media only screen and (max-width: 480px){
				img[class=mcnImage]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnImageGroupContentContainer]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageGroupContent]{
					padding:9px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageGroupBlockInner]{
					padding-bottom:0 !important;
					padding-top:0 !important;
				}

		}	@media only screen and (max-width: 480px){
				tbody[class=mcnImageGroupBlockOuter]{
					padding-bottom:9px !important;
					padding-top:9px !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnCaptionTopContent],table[class=mcnCaptionBottomContent]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnCaptionLeftTextContentContainer],table[class=mcnCaptionRightTextContentContainer],table[class=mcnCaptionLeftImageContentContainer],table[class=mcnCaptionRightImageContentContainer],table[class=mcnImageCardLeftTextContentContainer],table[class=mcnImageCardRightTextContentContainer]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
					padding-right:18px !important;
					padding-left:18px !important;
					padding-bottom:0 !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardBottomImageContent]{
					padding-bottom:9px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardTopImageContent]{
					padding-top:18px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
					padding-right:18px !important;
					padding-left:18px !important;
					padding-bottom:0 !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardBottomImageContent]{
					padding-bottom:9px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardTopImageContent]{
					padding-top:18px !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnCaptionLeftContentOuter] td[class=mcnTextContent],table[class=mcnCaptionRightContentOuter] td[class=mcnTextContent]{
					padding-top:9px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnCaptionBlockInner] table[class=mcnCaptionTopContent]:last-child td[class=mcnTextContent]{
					padding-top:18px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnBoxedTextContentColumn]{
					padding-left:18px !important;
					padding-right:18px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnTextContent]{
					padding-right:18px !important;
					padding-left:18px !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section template width
			*/
				table[id=templateContainer],table[id=templatePreheader],table[id=templateHeader],table[id=templateBody],table[id=templateFooter]{
					/*@tab Mobile Styles
		@section template width
					/*@editable*/width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section heading 1
			@tip Make the first-level headings larger in size for better readability on small screens.
			*/
				h1{
					/*@editable*/font-size:24px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section heading 2
			@tip Make the second-level headings larger in size for better readability on small screens.
			*/
				h2{
					/*@editable*/font-size:20px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section heading 3
			@tip Make the third-level headings larger in size for better readability on small screens.
			*/
				h3{
					/*@editable*/font-size:18px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section heading 4
			@tip Make the fourth-level headings larger in size for better readability on small screens.
			*/
				h4{
					/*@editable*/font-size:16px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section Boxed Text
			@tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
			*/
				table[class=mcnBoxedTextContentContainer] td[class=mcnTextContent],td[class=mcnBoxedTextContentContainer] td[class=mcnTextContent] p{
					/*@editable*/font-size:18px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section Preheader Visibility
			*/
				table[id=templatePreheader]{
					/*@editable*/display:block !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section Preheader Text
			@tip Make the preheader text larger in size for better readability on small screens.
			*/
				td[class=preheaderContainer] td[class=mcnTextContent],td[class=preheaderContainer] td[class=mcnTextContent] p{
					/*@editable*/font-size:14px !important;
					/*@editable*/line-height:115% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section Header Text
			@tip Make the header text larger in size for better readability on small screens.
			*/
				td[class=headerContainer] td[class=mcnTextContent],td[class=headerContainer] td[class=mcnTextContent] p{
					/*@editable*/font-size:18px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section Body Text
			@tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
			*/
				td[class=bodyContainer] td[class=mcnTextContent],td[class=bodyContainer] td[class=mcnTextContent] p{
					/*@editable*/font-size:18px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section footer text
			@tip Make the body content text larger in size for better readability on small screens.
			*/
				td[class=footerContainer] td[class=mcnTextContent],td[class=footerContainer] td[class=mcnTextContent] p{
					/*@editable*/font-size:14px !important;
					/*@editable*/line-height:115% !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=footerContainer] a[class=utilityLink]{
					display:block !important;
				}

		}</style></head>
		    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		        <center>
		            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
		                <tbody><tr>
		                    <td align="center" valign="top" id="bodyCell">
		                        <!-- BEGIN TEMPLATE // -->
		                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
		                            <tbody><tr>
		                                <td align="center" valign="top">
		                                    <!-- BEGIN PREHEADER // -->
		                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templatePreheader">
		                                        <tbody><tr>
		                                        	<td valign="top" class="preheaderContainer" style="padding-top:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock">
		    <tbody class="mcnTextBlockOuter">
		        <tr>
		            <td valign="top" class="mcnTextBlockInner">
		                
		                <table align="left" border="0" cellpadding="0" cellspacing="0" width="366" class="mcnTextContentContainer">
		                    <tbody><tr>
		                        
		                        <td valign="top" class="mcnTextContent" style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:0;">
		                        
		                            
		                        </td>
		                    </tr>
		                </tbody></table>
		                
		                <table align="right" border="0" cellpadding="0" cellspacing="0" width="197" class="mcnTextContentContainer">
		                    <tbody><tr>
		                        
		                        <td valign="top" class="mcnTextContent" style="padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:0;">
		                        
		                            <a href="*|ARCHIVE|*" target="_blank">View this email in your browser</a>
		                        </td>
		                    </tr>
		                </tbody></table>
		                
		            </td>
		        </tr>
		    </tbody>
		</table></td>
		                                        </tr>
		                                    </tbody></table>
		                                    <!-- // END PREHEADER -->
		                                </td>
		                            </tr>
		                            <tr>
		                                <td align="center" valign="top">
		                                    <!-- BEGIN HEADER // -->
		                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader">
		                                        <tbody><tr>
		                                            <td valign="top" class="headerContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock">
		    <tbody class="mcnImageBlockOuter">
		            <tr>
		                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
		                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer">
		                        <tbody><tr>
		                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
		                                
		                                    
		                                        <img align="center" alt="" src="https://gallery.mailchimp.com/4aff826dc4e577c6773550167/images/da5b5dd6-1f79-449f-8447-e2f6a4463da8.png" width="564" style="max-width:2226px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
		                                    
		                                
		                            </td>
		                        </tr>
		                    </tbody></table>
		                </td>
		            </tr>
		    </tbody>
		</table></td>
		                                        </tr>
		                                    </tbody></table>
		                                    <!-- // END HEADER -->
		                                </td>
		                            </tr>
		                            <tr>
		                                <td align="center" valign="top">
		                                    <!-- BEGIN BODY // -->
		                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
		                                        <tbody><tr>
		                                            <td valign="top" class="bodyContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock">
		    <tbody class="mcnTextBlockOuter">
		        <tr>
		            <td valign="top" class="mcnTextBlockInner">
		                
		                <table align="left" border="0" cellpadding="0" cellspacing="0" width="600" class="mcnTextContentContainer">
		                    <tbody><tr>
		                        
		                        <td valign="top" class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;">
		                        
		                            <h1 style="text-align: center;">We Successfully<br>
		Booked Your Appointment!</h1>

		<ul>
			<li><strong>Where: </strong>SSB 4.400</li>
			<li><strong>When: </strong>'.$eventDate.'</li>
			<li><strong>Subject: </strong>'.$tutorSubject.'</li>
			<li><strong>Tutor Name: </strong>'.$tutorName.'</li>
			<li><strong>Tutor Email: </strong>'.$tutorEmail.'</li>
			<li><strong>Tutee Name</strong>: '.$tuteeName.'</li>
			<li><strong>Tutee Email:</strong> '.$tuteeEmail.'</li>
			<li><strong>Note to Tutor:</strong> <p>'.$noteToTutor.'</p></li>
		</ul>

		                        </td>
		                    </tr>
		                </tbody></table>
		                
		            </td>
		        </tr>
		    </tbody>
		</table></td>
		                                        </tr>
		                                    </tbody></table>
		                                    <!-- // END BODY -->
		                                </td>
		                            </tr>
		                            <tr>
		                                <td align="center" valign="top">
		                                    <!-- BEGIN FOOTER // -->
		                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateFooter">
		                                        <tbody><tr>
		                                            <td valign="top" class="footerContainer" style="padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock">
		    <tbody class="mcnTextBlockOuter">
		        <tr>
		            <td valign="top" class="mcnTextBlockInner">
		                
		                <table align="left" border="0" cellpadding="0" cellspacing="0" width="600" class="mcnTextContentContainer">
		                    <tbody><tr>
		                        
		                        <td valign="top" class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;">
		                        
		                            <h3 style="line-height: 20.7999992370605px; text-align: center;">This email is automated. Please do not reply directly to this email.</h3>
		<br>
		<em>If you need to cancel your appointment, you can do so by clicking <a href="'.$plugin_location.'">this link.</a><br>
		<br>
		The Longhorn Center for Academic Excellence</em>
		                        </td>
		                    </tr>
		                </tbody></table>
		                
		            </td>
		        </tr>
		    </tbody>
		</table></td>
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
		    

		</body></html>';
	}
}