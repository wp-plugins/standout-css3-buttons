<?php
/*
Plugin Name: Standout CSS3 Buttons
Plugin URI: http://www.jimmyscode.com/wordpress/standout-css3-buttons/
Description: Display CSS3 style buttons on your website using shortcodes.
Version: 0.0.1
Author: Jimmy Pena
Author URI: http://www.jimmyscode.com/
Contributors: jp2112
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=NRHAAC7Q9Q2X6
Tags: css3, button, gradient, link
Requires at least: 3.5
Tested up to: 3.5.1
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
*/
/*  Copyright 2013  Jimmy Pena

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, visit http://www.gnu.org/licenses/gpl.html
*/

add_shortcode('standout-css3-button', 'css3button');
function css3button($atts, $content = null) {
  // enqueue CSS only on pages with shortcode
  css3_button_styles();

  // get parameters
  extract( shortcode_atts( array(
	'class' => 'button-dribbble',
      'href' => '#'
      ), $atts ) );
  return '<a class="' . filter_var($class, FILTER_SANITIZE_STRING) . '" href="' . filter_var($href, FILTER_SANITIZE_URL) . '">' . do_shortcode($content) . '</a>';
}
// -------------------------------------------------------------------
// CSS file queueing
// -------------------------------------------------------------------
function css3_button_styles() {
  wp_register_style( 'standout_css3_button_style', 
    plugins_url('standout-css3-buttons/standout-css3-buttons.css'), 
    array(), 
    "0.0.1", 
    'all' );
  // enqueueing:
  wp_enqueue_style( 'standout_css3_button_style' );
}
?>