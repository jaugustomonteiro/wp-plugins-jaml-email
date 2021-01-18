<?php
/*
Plugin name: Jaml E-mail
Plugin uri: 
Description: Plugin para enviar dados para E-mail
Version: 1.0
Author: Augusto Monteiro
Author uri: 
License: GPLv2 or later
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once plugin_dir_path( __FILE__ ) . 'inc/jaml-sendEmail.php';
