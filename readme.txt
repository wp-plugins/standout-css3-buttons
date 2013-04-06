=== Standout CSS3 Buttons ===
Tags: css3, button, gradient, link, rounded, CSS button
Requires at least: 3.5
Tested up to: 3.5.1
Contributors: jp2112
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7EX9NB9TLFHVW
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display CSS3 style buttons on your website using shortcodes or PHP function call.

== Description ==

<strong>Update: As of version 0.0.2, there is a new way to call the plugin from PHP. If you are currently calling the plugin from your functions.php or another plugin, please read the <a href="http://wordpress.org/extend/plugins/standout-css3-buttons/faq/">FAQ</a>.

Based on <a href="http://www.briangardner.com/social-media-buttons/">this blog post from Brian Gardner</a>, display cool CSS3 style gradient buttons on your site using shortcodes.

You can also call the plugin in your functions.php or in a plugin. Choose from several different color styles, partially inspired by social media.

= Features =

- Create unlimited number of modern style buttons
- Works with most browsers, but degrades nicely in older browsers
- CSS3 compliant, no Javascript or other code is used to generate button
- CSS only loads on pages with shortcode or function call
- Many different color styles to choose from
- Links can be opened in new window if requested

<strong>If you use and enjoy this plugin, please rate it and click the "Works" button below so others know that it works with the latest version of WordPress.</strong>

== Installation ==

1. Upload the plugin through the WordPress interface.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Settings &raquo; Standout CSS3 Buttons and configure the plugin.
4. Insert shortcode on posts or pages, or call the plugin from your PHP code.

To remove this plugin, go to the 'Plugins' menu in WordPress, find the plugin in the listing and click "Deactivate". After the page refreshes, find the plugin again in the listing and click "Delete".

== Frequently Asked Questions ==

= How do I use the plugin? =

Use a shortcode to call the plugin from any page or post like this:

`[standout-css3-button cssclass="button-dribbble" href="http://www.google.com/"]Click here[/standout-css3-button]`

This will output the following:

`<a class="button-dribbble" href="http://www.google.com/" rel="nofollow">Click here</a>`

CSS styling from the included .css file will be applied to this link.

You may also include shortcodes within the shortcode.

The shortcode can also be used in your PHP code (functions.php, or a plugin) using the <a href="http://codex.wordpress.org/Function_Reference/do_shortcode">do_shortcode</a> function, ex:

`echo do_shortcode('[standout-css3-button cssclass="button-dribbble" href="http://www.google.com/"]Click here[/standout-css3-button]');`

You can also call the plugin in your PHP code like this:

`add_action('the_content', 'show_css3_button');
function show_css3_button($content) {
  if (is_page('home')) { // we are on a page with slug 'home'
    if (function_exists('scss3button')) { // plugin is installed/active
      $content .= scss3button(array('cssclass' => 'button-rss', 'href' => 'http://www.google.com/'), 'Click here');
    }
  }
  return $content;
}`

This will add a button (with `button-rss` color style) at the end of your content, if you are on a page with a slug named "home". Always wrap plugin function calls with a `function_exists` check so that your site doesn't go down if the plugin isn't active.

= What are the plugin defaults? =

By default, following values are passed to the plugin:

- cssclass => button-dribbble
- href => ''
- nofollow => true
- opennewwindow => false

Also, by default, values are returned, not echoed. You need to explicitly request that the plugin output be echoed by passing `'show' => true` in the array when calling the plugin via function.

To change defaults on a site-wide basis, go to the Settings page. To change defaults on a per-shortcode basis, pass new values to each shortcode or function call. Priority is given to parameters passed via shortcode or function.

The plugin arguments and default values may change over time. To get the latest list of arguments and defaults, look at the settings page.

= What styles are available? =

The following styles are available.

<ul>
<li>button-dribbble (<strong>default</strong>)</li>
<li>button-facebook</li>
<li>button-googleplus</li>
<li>button-linkedin</li>
<li>button-pinterest</li>
<li>button-rss</li>
<li>button-tumblr</li>
<li>button-twitter</li>
<li>button-turquoise</li>
<li>button-emerald</li>
<li>button-somekindofblue</li>
<li>button-amethyst</li>
<li>button-bluegray</li>
<li>button-tangerine</li>
<li>button-fall</li>
<li>button-adobe</li>
<li>button-lightgray</li>
<li>button-dull</li>
<li>button-fancypurple</li>
<li>button-dullpurple</li>
<li>button-crispblue</li>
<li>button-braised</li>
<li>button-midnight</li>
<li>button-brown</li>
</ul>

See http://www.jimmyscode.com/wordpress/standout-css3-buttons/ for a live demo of each style.

= I added the shortcode to a page but I don't see anything. =

Clear your browser cache and also clear your cache plugin (if any). If you still don't see anything, check your webpage source for the following:

`<!-- Standout CSS3 Buttons: plugin is disabled. Check Settings page. -->`

This means you didn't pass a necessary setting to the plugin. For color buttons, you must specify the URL. You should also check that the "enabled" checkbox on the plugin settings page is checked.

= I cleared my browser cache and my caching plugin but the buttons still look wrong. =

Are you using a plugin that minifies CSS? If so, try excluding the plugin CSS file from minification.

= I don't want the post editor toolbar buttons. How do I remove them? =

Add this to your functions.php:

`remove_action('admin_print_footer_scripts', 'add_scss3b_quicktag');`

= I don't want the admin CSS. How do I remove it? =

Add this to your functions.php:

`remove_action('admin_head', 'insert_scss3b_admin_css');`

= I don't want the plugin CSS. How do I remove it? =

Add this to your functions.php:

`add_action('wp_enqueue_scripts', 'remove_scss3b_style');
function remove_scss3b_style() {
  wp_deregister_style('standout_css3_button_style');
}`

== Screenshots ==

1. This is what the buttons look like.

See  <a href="http://www.briangardner.com/social-media-buttons/">this blog post from Brian Gardner</a> and the <a href="http://www.jimmyscode.com/wordpress/standout-css3-buttons/">plugin demo page</a> for more.

== Changelog ==

= 0.0.7 =
- added donate link on admin page
- admin page CSS added
- various admin page tweaks
- minor code refactoring
- added shortcode defaults display on settings page

= 0.0.6 =
- added new colors (brown)
- updated readme.txt
- minor code refactoring
- added option to open links in new window
- css file refactoring

= 0.0.5 =
- added new colors (midnight, salmon, neongreen)
- another minor admin page update
- updated readme.txt

= 0.0.4 =
- moved quicktag script further down the page
- minor admin page update
- added 14 new button color sets

= 0.0.3 =
- updated admin messages code
- updated readme

= 0.0.2 = 
* added admin menu
* code refactoring
* added quicktag for post editor toolbar
* prepped the plugin for translations
* nofollow links by default
* CSS is conditional (only included on pages with shortcode/function call)

= 0.0.1 =
created

== Upgrade Notice ==

= 0.0.7 =
- added donate link on admin page
- admin page CSS added
- various admin page tweaks
- minor code refactoring
- added shortcode defaults display on settings page

= 0.0.6 =
- added new colors (brown)
- updated readme.txt
- minor code refactoring
- added option to open links in new window
- css file refactoring

= 0.0.5 =
- added new colors (midnight, salmon, neongreen)
- another minor admin page update
- updated readme.txt

= 0.0.4 =
- moved quicktag script further down the page
- minor admin page update
- added 14 new button color sets

= 0.0.3 =
- updated admin messages code
- updated readme

= 0.0.2 = 
* added admin menu
* code refactoring
* added quicktag for post editor toolbar
* prepped the plugin for translations
* nofollow links by default
* CSS is conditional (only included on pages with shortcode/function call)

= 0.0.1 =
created