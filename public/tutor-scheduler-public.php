<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    tutor-appointment-scheduler
 * @subpackage tutor-appointment-scheduler/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    tutor-appointment-scheduler
 * @subpackage tutor-appointment-scheduler/public
 * @author     Your Name <email@example.com>
 */
class Tutor_Scheduler_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( 
									$plugin_name,
									$version,
									$courses_table_name,
									$tutor_table_name,
									$C2T_table_name,
									$events_table_name 
								) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->courses_table_name = $courses_table_name;
		$this->tutor_table_name = $tutor_table_name;
		$this->C2T_table_name = $C2T_table_name;
		$this->events_table_name = $events_table_name;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tutor-scheduler-public.css', array(), $this->version, 'all' );

		//Bootstrap
		wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'css/libs/bootstrap.min.css', array(), $this->version, 'all' );
		//FullCalendar
		wp_enqueue_style( 'fullcalendar', plugin_dir_url( __FILE__ ) . 'css/libs/full-calendar.min.css', array(), $this->version, 'all' );
		//AddThisEvent
		wp_enqueue_style( 'add-this-event', plugin_dir_url( __FILE__ ) . 'css/libs/addthisevent.theme5.css', array(), '1.6.0', 'all' );
		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */


		//Moment.js
		wp_enqueue_script( 'moment', plugin_dir_url( __FILE__ ) . 'js/libs/moment.min.js', array(), '2.10.3', false );
		//Bootstrap
		wp_enqueue_script( 'bootstrap', plugin_dir_url( __FILE__ ) . 'js/libs/bootstrap.min.js', array( 'jquery' ), '3.3.5', false );
		//FullCalendar
		wp_enqueue_script( 'fullcalendar', plugin_dir_url( __FILE__ ) . 'js/libs/full-calendar.min.js', array( 'jquery', 'moment' ), '2.3.2', false );
		//underscore
		wp_enqueue_script( 'underscore', plugin_dir_url( __FILE__ ) . 'js/libs/underscore.min.js', array(), '1.8.3', false );
		//AddThisEvent
		wp_enqueue_script( 'add-this-event', plugin_dir_url( __FILE__ ) . 'js/libs/add-this-event.min.js', array(), '1.6.0', false );
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tutor-scheduler-public.js', array( 'jquery', 'underscore', 'fullcalendar', 'add-this-event' ), $this->version, false );
		
		wp_localize_script( $this->plugin_name, 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

	}

	public function send_confirmation_email($tutor_ID) {

		$tutor = json_decode($this->get_tutors($tutor_ID));

		$tutorEmail = $tutor[0]->{"email"};
		$tutorFirstName = $tutor[0]->{"first_name"};
		$tutorLastName = $tutor[0]->{"last_name"};
		$tutorSubject = $_POST["tutor_subject"];
		$eventDate = $_POST["event_date"];
		// multiple recipients
		$to  = $_POST["email"] . ', '; // note the comma
		$to .= $tutorEmail;

		// subject
		$subject = 'LCAE - Tutor Appointment Confirmation';

		// message
		$message = '
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
			<li><strong>Tutor Name: </strong>'.$tutorFirstName.' '.$tutorLastName.'</li>
			<li><strong>Tutor Email: </strong>'.$tutorEmail.'</li>
			<li><strong>Tutee Name</strong>: '.$_POST["first_name"].' '.$_POST["last_name"].'</li>
			<li><strong>Tutee Email:</strong> '.$_POST["email"].'</li>
			<li><strong>Note to Tutor:</strong> <p>'.$_POST["note_to_tutor"].'</p></li>
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
		<em>If you need to cancel your appointment, you can do so by clicking this link.<br>
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

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		$headers .= 'To: '.$_POST["first_name"] .' <'.$_POST["email"].'>, '. $tutorFirstName.' <'.$tutorEmail.'>'."\r\n";
		$headers .= 'From: LCAE <lcae@austin.utexas.edu>'."\r\n";
		// $headers .= 'Cc: birthdayarchive@example.com'."\r\n";
		// $headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

		// Mail it
		mail($to, $subject, $message, $headers);
	}

	public function confirm_tas_appointment() {
		global $wpdb;

		if ( !wp_verify_nonce( $_REQUEST['nonce'], "confirm_tas_appointment")) {
			exit("No naughty business please");
		}

		$sql = 'SELECT date_taken FROM '.$this->events_table_name.' WHERE id = '.$_POST["event_id"];
		//Update the date_taken flag on this specific appointment
		if (!$wpdb->update($this->events_table_name, array('date_taken' => 1), array('id' => $_REQUEST["event_id"]) )
			 || !$wpdb->get_var($sql) != 0) {
			$result["type"] = "error";
		}else{
			$result["type"] = "success";
			//Send a confirmation email to student
			$this->send_confirmation_email($_REQUEST["tutor_id"]);	
		}




		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$result = json_encode($result);
			echo $result;
		}
		else {
			header("Location: ".$_SERVER["HTTP_REFERER"]);
		}

		die();
	}

	/**
	 * [get_courses description]
	 * @return [type] [description]
	 */
	public function get_courses(){
		global $wpdb;

 		// echo '<script type="text/javascript">console.log("Courses table name =  ' . $this->courses_table_name . '");</script>';
		
		$query = "
			SELECT id, name
			FROM " . $this->courses_table_name . "
			ORDER BY id
		";

		$courses = $wpdb->get_results($query);

		return json_encode($courses);
	}

	/**
	 * [get_courses description]
	 * @return [type] [description]
	 */
	public function get_tutors($tutorID = -1){
		global $wpdb;
		if ($tutorID == -1) {
			$query = "
				SELECT id, first_name, last_name
				FROM " . $this->tutor_table_name . "
				ORDER BY id
			";
		}else{
			$query = "
				SELECT *
				FROM " . $this->tutor_table_name . "
				WHERE id = " . $tutorID . "
			";
		}	
		

		$tutors = $wpdb->get_results($query);

		return json_encode($tutors);
	}

	/**
	 * [get_C2T description]
	 * @return [type] [description]
	 */
	public function get_C2T() {
		global $wpdb;
		
		$query = "
			SELECT course_ID, tutor_ID
			FROM " . $this->C2T_table_name . "
			ORDER BY id
			";

		$C2T = $wpdb->get_results($query);

		return json_encode($C2T);
	}

	/**
	 * [get_C2T description]
	 * @return [type] [description]
	 */
	public function get_events($eventID = -1) {
		global $wpdb;
		
		$query = "
				SELECT *
				FROM " . $this->events_table_name . "
				WHERE date_taken = 0
				";
		

		$events = $wpdb->get_results($query);

		return json_encode($events);
	}


	/**
	 * Hook that will load the shortcode which loads the front-end of the site
	 */
	public function run( $atts ) {

		$courses = $this->get_courses();		
		$tutors = $this->get_tutors();		
		$C2T = $this->get_C2T();		
		$events = $this->get_events();

		echo 	'<script type="text/javascript">
					var coursesJSON = ' . $courses . ';
					var tutorsJSON = ' . $tutors . ';
					var C2TJSON = ' . $C2T . ';
					var eventJSON = ' . $events . ';
				</script>';

		if (!require_once 'partials/tutor-appointment-scheduler-display.php') {
			return 'Error failed to load the Calendar';
		}		
	}

}
