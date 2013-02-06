=== Standout CSS3 Buttons ===
Contributors: jp2112
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=NRHAAC7Q9Q2X6
Tags: css3, button, gradient, link
Requires at least: 3.5
Tested up to: 3.5.1
Stable tag: trunk
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html

Display CSS3 style buttons on your website using shortcodes.

== Description ==

Based on <a href="http://www.briangardner.com/social-media-buttons/">this blog post from Brian Gardner</a>, display cool CSS3 style gradient buttons on your site using shortcodes.

Requires PHP 5.2 due to filter_var function.

If you use and enjoy this plugin, please rate it and click the "Works" button below so others know that it works with the latest version of WordPress.

== Installation ==

1. Upload the plugin through the WordPress interface.

2. Activate the plugin through the 'Plugins' menu in WordPress.

3. Insert shortcode on posts or pages.

== Frequently Asked Questions ==

= How do I use the plugin? =

Use a shortcode to call the plugin from any page or post like this:

[standout-css3-button class="button-dribbble" href="http://www.google.com/"]Click here[/standout-css3-button]

This will output the following:

<a class="button-dribbble" href="http://www.google.com/">Click here</a>

You can also use the shortcode in your PHP code (functions.php, or a plugin) using the <a href="http://codex.wordpress.org/Function_Reference/do_shortcode">do_shortcode</a> function, ex:

`echo do_shortcode('[standout-css3-button class="button-dribbble" href="http://www.google.com/"]Click here[/css3-button]');`

The default value for the class attribute is "button-dribbble". Leave out this parameter to use the default, or specify which class you want. Available classes are

<ul>
<li>button-dribble</li>
<li>button-facebook</li>
<li>button-googleplus</li>
<li>button-linkedin</li>
<li>button-pinterest</li>
<li>button-rss</li>
<li>button-tumblr</li>
<li>button-twitter</li>
</ul>

== Screenshots ==

See  <a href="http://www.briangardner.com/social-media-buttons/">this blog post from Brian Gardner</a> for examples.

== Changelog ==

= 0.0.1 =
created

== Upgrade Notice ==

= 0.0.1 =
created