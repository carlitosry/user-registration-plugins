<?php
/*
    Plugin Name: Custom User Registration Form
    Plugin URI: http://code.carlitosry.com
    Description: Updates user rating based on number of posts.
    Version: 1.0
    Author: @Carlitosry
    Author URI: http://carlitosry.com
 */

require_once( plugin_dir_path(__FILE__).'vendors/simple-php-captcha/simple-php-captcha.php');
require_once( plugin_dir_path(__FILE__).'config-extras.php');
require_once( plugin_dir_path(__FILE__).'form-registration-candidate.php');
require_once( plugin_dir_path(__FILE__).'form-registration-professional.php');
require_once( plugin_dir_path(__FILE__).'edit-form-user.php');
