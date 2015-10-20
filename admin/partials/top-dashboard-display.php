<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    tutor-appointment-scheduler
 * @subpackage tutor-appointment-scheduler/admin/partials
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<!-- Create a header in the default WordPress 'wrap' container -->
<div class="wrap bootstrap-wpadmin">

    <!-- Add the icon to the page -->
    <h2><span class="dashicons dashicons-calendar-alt"></span> &nbsp; <?php echo get_admin_page_title(); ?> Dashboard</h2>

    <!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
    <hr>
    <h4 class="text-center">Welcome to the LCAE tutor dashboard!</h4>
    <p><b>If the styles do not work:</b></p>
    <ol>
    	<li>Enable the "Include Twitter Bootstrap CSS in the WordPress Admin" option in the Bootstrap Plugin > CSS Settings.</li>
    	<li>Click "Save Settings at the bottom of the page"</li>
    </ol>
    <div class="row">
    	<div class="col-sm-6 col-xs-6">
    		<div class="tas-admin-card">
    			<p>In order to manage students and their schedules, click the button below.</p><br>
    			<a class="text-center btn btn-primary" href="<?php menu_page_url( $this->student_slug, true ); ?>">Manage Students</a>
			</div>
    	</div>
    	<div class="col-sm-6 col-xs-6">
    		<div class="tas-admin-card">
				<p>In order to manage tutor's courses, click the button below.  &nbsp;<b>Note: </b>This option allows adding new courses and assigning them to students.</p>
    			<a class="text-center btn btn-primary" href="<?php menu_page_url( $this->courses_slug, true ); ?>">Manage Courses</a>
    		</div>
    	</div>
    </div>
    <h3 class="text-center">This plugin is powered by:</h3>
    <div class="well well-lg bg-primary">
        <a href="http://getbootstrap.com"><img class="img-rounded" style="height: 100px; width: 100px;" src="<?php echo plugins_url( 'images/bootstrap.png', __DIR__ ); ?>"></a>
        <a href="http://fullcalendar.io"><img class="img-rounded" style="height: 100px; width: 100px;" src="<?php echo plugins_url( 'images/fullcalendar.png', __DIR__ ); ?>"></a>
        <img class="img-rounded" style="height: 100px; width: 100px;" src="<?php echo plugins_url( 'images/htmlcss.png', __DIR__ ); ?>">
        <a href="http://jquery.com"><img class="img-rounded" style="height: 100px; width: 100px;" src="<?php echo plugins_url( 'images/jquery.png', __DIR__ ); ?>"></a>
        <a href="http://momentjs.com"><img class="img-rounded" style="height: 100px; width: 100px;" src="<?php echo plugins_url( 'images/moment.png', __DIR__ ); ?>"></a>
        <a href="http://php.net"><img class="img-rounded" style="height: 100px; width: 100px;" src="<?php echo plugins_url( 'images/php.png', __DIR__ ); ?>"></a>
        <a href="http://underscorejs.org"><img class="img-rounded" style="height: 100px; width: 100px;" src="<?php echo plugins_url( 'images/underscore.png', __DIR__ ); ?>"></a>
    </div>


</div><!-- /.wrap -->