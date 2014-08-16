=== Standout CSS3 Buttons ===
Tags: css3, button, gradient, link, rounded, CSS button
Requires at least: 3.5
Tested up to: 3.9
Contributors: jp2112
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7EX9NB9TLFHVW
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display CSS3 style buttons with gradient color styles on your website using shortcodes or PHP function call.

== Description ==

Based on <a href="http://www.briangardner.com/social-media-buttons/">this blog post from Brian Gardner</a>, display cool CSS3 style gradient buttons on your site using shortcodes.

You can also call the plugin in your functions.php or in a plugin. Choose from several different color styles, partially inspired by social media, or create your own.

<h3>If you need help with this plugin</h3>

If this plugin breaks your site or just flat out does not work, please go to <a href="http://wordpress.org/plugins/standout-css3-buttons/#compatibility">Compatibility</a> and click "Broken" after verifying your WordPress version and the version of the plugin you are using.

Then, create a thread in the <a href="http://wordpress.org/support/plugin/standout-css3-buttons">Support</a> forum with a description of the issue. Make sure you are using the latest version of WordPress and the plugin before reporting issues, to be sure that the issue is with the current version and not with an older version where the issue may have already been fixed.

<strong>Please do not use the <a href="http://wordpress.org/support/view/plugin-reviews/standout-css3-buttons">Reviews</a> section to report issues or request new features.</strong>

= Features =

- Create unlimited number of modern style buttons
- Works with most browsers, but degrades nicely in older browsers
- CSS3 compliant, no Javascript or other code is used to generate button (note that Javascript is used to open links in new windows)
- CSS only loads on pages with shortcode or function call
- You can use shortcodes inside shortcodes, i.e. [standout-css3-button][my_shortcode][/standout-css3-button]
- Many different color styles to choose from, but you can also create your own
- Custom CSS automatically busts caches when you update it. Change it as often as you want, it will display changes in real-time!

= Shortcode =

To display on any post or page, use this shortcode:

[standout-css3-button href="http://www.yahoo.com/"]Button text goes here[/standout-css3-button]

Make sure you go to the plugin settings page after installing to set options.

<strong>If you use and enjoy this plugin, please rate it and click the "Works" button below so others know that it works with the latest version of WordPress.</strong>

== Installation ==

1. Upload the plugin through the WordPress interface.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Settings &raquo; 'Standout CSS3 Buttons' and configure the plugin.
4. Insert shortcode on posts or pages, or call the plugin from your PHP code.

To remove this plugin, go to the 'Plugins' menu in WordPress, find the plugin in the listing and click "Deactivate". After the page refreshes, find the plugin again in the listing and click "Delete".

== Frequently Asked Questions ==

= How do I use the plugin? =

Use a shortcode to call the plugin from any page or post like this:

`[standout-css3-button cssclass="button-dribbble" href="http://www.google.com/"]
Click here
[/standout-css3-button]`

This will output the following:

`<a class="scss3b-button-dribbble" href="http://www.google.com/" rel="nofollow">Click here</a>`

CSS styling from the included .css file will be applied to this link. You may also include shortcodes within the shortcode.

The shortcode can also be used in your PHP code (functions.php, or a plugin) using the <a href="http://codex.wordpress.org/Function_Reference/do_shortcode">do_shortcode</a> function, ex:

`echo do_shortcode('[standout-css3-button cssclass="scss3b-button-dribbble" 
href="http://www.google.com/"]Click here[/standout-css3-button]');`

You can also call the plugin's function in your PHP code like this:

`add_action('the_content', 'show_css3_button');
function show_css3_button($content) {
  if (is_page('home')) { // we are on a page with slug 'home'
    if (function_exists('scss3button')) { // plugin is installed/active
      $content .= scss3button(array('cssclass' => 'scss3b-button-rss', 
'href' => 'http://www.google.com/'), 
'Click here');
    }
  }
  return $content;
}`

This will add a button (with `scss3b-button-rss` color style) at the end of your content, if you are on a page with a slug named "home". Always wrap plugin function calls with a `function_exists` check so that your site doesn't go down if the plugin isn't active.

In short, 'standout-css3-button' is the shortcode and 'scss3button' is the PHP function name.

= What are the plugin defaults? =

The plugin arguments and default values may change over time. To get the latest list of arguments and defaults, look at the settings page after installing the plugin. That is where the latest list will always be located. You will see what parameters you can specify and which ones are required.

= What styles are available? =

The following styles are available.

<ul>
<li>scss3b-button-dribbble (<strong>default</strong>)</li>
<li>scss3b-button-facebook</li>
<li>scss3b-button-googleplus</li>
<li>scss3b-button-linkedin</li>
<li>scss3b-button-pinterest</li>
<li>scss3b-button-rss</li>
<li>scss3b-button-tumblr</li>
<li>scss3b-button-twitter</li>
<li>scss3b-button-turquoise</li>
<li>scss3b-button-emerald</li>
<li>scss3b-button-somekindofblue</li>
<li>scss3b-button-amethyst</li>
<li>scss3b-button-bluegray</li>
<li>scss3b-button-tangerine</li>
<li>scss3b-button-fall</li>
<li>scss3b-button-adobe</li>
<li>scss3b-button-lightgray</li>
<li>scss3b-button-dull</li>
<li>scss3b-button-fancypurple</li>
<li>scss3b-button-dullpurple</li>
<li>scss3b-button-crispblue</li>
<li>scss3b-button-braised</li>
<li>scss3b-button-midnight</li>
<li>scss3b-button-brown</li>
<li>scss3b-button-sourgreen</li>
</ul>

See the dropdown list on the plugin settings menu for the most updated list. Visit http://www.jimmyscode.com/wordpress/standout-css3-buttons/ for a live demo of each style.

= How do I create my own color schemes? =

1. When you are entering the shortcode or calling the plugin function from PHP, instead of using one of the built-in color names ("emerald", "facebook" etc), use the class name you want to use. Ex: "bluegreen"

Do not add the "scss3b-button-" prefix. This will be added automatically by the plugin. The resulting class name will be <strong>scss3b-button-<em>whatever you typed</em></strong>.

In this example, the custom CSS class will be `scss3b-button-bluegreen`.

2. Go to the plugin settings page. There is a textarea there where you enter the CSS you want to use.

If you need help writing the CSS, look at the existing CSS file the plugin uses (filename: standout-css3-buttons.css in the /css/ subfolder) as a model for what CSS you need. Then just change the color values accordingly and paste it into the textarea. If you want to do something above and beyond what is already in the CSS, please search the web to find help. <strong>Please don't use the plugin support forum to ask for CSS help unless there is an issue with the existing CSS.</strong>

The custom CSS stylesheet will be enqueued on pages where custom CSS class names are used.

<strong>Note: you must include the FULL class name in the custom CSS textarea (ex: <em>.scss3b-button-mycustomcolor { font-style:verdana }</em>). However, when you actually call the class in your shortcode you only use the color name you created in step #1 above (ex: <em>[standout-css3-button cssclass="mycustomcolor" href="http://www.google.com/"]Click here[/standout-css3-button]</em>).</strong>

= I added the shortcode to a page but I don't see anything. =

Clear your browser cache and also clear your cache plugin (if any). If you still don't see anything, check your webpage source for the following:

`<!-- Standout CSS3 Buttons: plugin is disabled. Check Settings page. -->`

This means you didn't pass a necessary setting to the plugin. For example, you must specify the URL either in the shortcode or on the plugin settings page. You should also check that the "enabled" checkbox on the plugin settings page is checked.

= I don't see rounded corners. =

Make sure you aren't using `rounded="0"` in your shortcode. If you are not, make sure your browser is up to date and check if it supports the `border-radius` CSS attribute. You may have to view the page in another browser. You may also need to refresh your browser and clear your caching plugin. Also, check the plugin settings page to make sure the "rounded corner CSS" checkbox is checked.

= I cleared my browser cache and my caching plugin but the buttons still look wrong. =

Are you using a plugin that minifies or combines CSS files at runtime? If so, try excluding the plugin CSS file from minification.

= I cleared my cache and still don't see what I want. =

The CSS files include a `?ver` query parameter. This parameter is incremented with every upgrade in order to bust caches. Make sure none of your plugins or functions are stripping this query parameter. Also, if you are using a CDN, flush it or send an invalidation request for the plugin CSS files so that the edge servers request a new copy of it.

= I don't want the post editor toolbar button. How do I remove it? =

Add this to your functions.php:

`remove_action('admin_enqueue_scripts', 'scss3b_ed_buttons');`

= I don't want the admin CSS. How do I remove it? =

Add this to your functions.php:

`remove_action('admin_head', 'insert_scss3b_admin_css');`

= I don't want the plugin CSS. How do I remove it? =

Add this to your functions.php:

`add_action('wp_enqueue_scripts', 'remove_scss3b_style');
function remove_scss3b_style() {
  wp_deregister_style('standout_css3_button_style');
}`

= I don't see the plugin toolbar button(s). =

This plugin adds one or more toolbar buttons to the HTML editor. You will not see them on the Visual editor.

The label on the toolbar button is "CSS3 Button".

= I am using the shortcode but the parameters aren't working. =

On the plugin settings page, go to the "Parameters" tab. There is a list of possible parameters there along with the default values. Make sure you are spelling the parameters correctly.

The Parameters tab also contains sample shortcode and PHP code.

== Screenshots ==

1. Plugin settings page
2. All buttons

== Changelog ==

= 0.2.9 =
- updated .pot file and readme

= 0.2.8 =
- fixed validation issue

= 0.2.7 =
- code fix
- admin CSS and page updates

= 0.2.6 = 
- code fix
- if plugin is temporarily disabled (via plugin settings page), skip some code to save some cycles
- add your own custom css class name
- added jquery dependency
- updated support tab

= 0.2.5 =
- code optimizations
- use 'href', 'url' or 'link' as the URL parameter name
- plugin settings page is now tabbed
- made CSS responsive

= 0.2.4 =
- fix2 for wp_kses

= 0.2.3 =
- fix for wp_kses

= 0.2.2 =
- some minor code optimizations
- verified compatibility with 3.9

= 0.2.1 =
- OK, I am going to stop playing with the plugin now. Version check rolled back (again)

= 0.2.0 =
- prepare strings for internationalization
- plugin now requires WP 3.5 and PHP 5.0 and above
- minor code optimization

= 0.1.9 =
- *** PLEASE BACKUP YOUR CUSTOM CSS BEFORE UPGRADING, JUST IN CASE ***
- added 'scss3b-' prefix to CSS classes, you must update your custom css
- custom CSS is preserved across updates (I hope)
- minor bug with parameter table on plugin settings page
- minor plugin settings page update

= 0.1.8 =
- added submit button to top of plugin settings form

= 0.1.7 =
- All CSS and JS automatically busts cache
- added color "sourgreen"
- removed screen_icon() (deprecated)
- compatible with WP 3.8.1

= 0.1.6 =
- refactored admin CSS
- added helpful links on plugin settings page and plugins page

= 0.1.5 =
- editor button now outputs required parameters when clicking it
- custom CSS textbox to enter your own CSS styling for custom classes
- code refactored for efficiency
- CSS files automatically bust caches
- minified CSS somewhat
- updated FAQ/readme

= 0.1.4 =
fixed uninstall routine, actually deletes options now

= 0.1.3 =
- updated the plugin settings page list of parameters to indicate whether they are required or not
- updated FAQ section of readme.txt

= 0.1.2 =
some security hardening added

= 0.1.1 =
added textbox to enter your own css class name, which you must define in your own stylesheet

= 0.1.0 =
- minor code refactoring
- changed width of buttons to "auto"

= 0.0.9 =
- target="_blank" is deprecated, replaced with javascript fallback

= 0.0.8 =
- minor code refactoring

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

= 0.2.9 =
- updated .pot file and readme

= 0.2.8 =
- fixed validation issue

= 0.2.7 =
- code fix; admin CSS and page updates

= 0.2.6 = 
- code fix; added enabled checks; added custom css class option; added jquery dependency; updated support tab

= 0.2.5 =
- code optimizations; use 'href', 'url' or 'link' as the URL parameter name; plugin settings page is now tabbed; made CSS responsive

= 0.2.4 =
- fix2 for wp_kses

= 0.2.3 =
- fix for wp_kses

= 0.2.2 =
- some minor code optimizations, verified compatibility with 3.9

= 0.2.1 =
- OK, I am going to stop playing with the plugin now. Version check rolled back (again)

= 0.2.0 =
- prepare strings for internationalization, plugin now requires WP 3.5 and PHP 5.0 and above, minor code optimization

= 0.1.9 =
- *** PLEASE BACKUP YOUR CUSTOM CSS BEFORE UPGRADING, JUST IN CASE ***, added 'scss3b-' prefix to CSS classes, you must update your custom css, custom CSS is preserved across updates (I hope), minor bug with parameter table on plugin settings page, minor plugin settings page update

= 0.1.8 =
- added submit button to top of plugin settings form

= 0.1.7 =
- All CSS and JS automatically busts cache, 
- added color "sourgreen", 
- removed screen_icon() (deprecated), 
- compatible with WP 3.8.1

= 0.1.6 =
- refactored admin CSS
- added helpful links on plugin settings page and plugins page

= 0.1.5 =
- editor button now outputs required parameters when clicking it
- custom CSS textbox to enter your own CSS styling for custom classes
- code refactored for efficiency
- CSS files automatically bust caches
- minified CSS somewhat
- updated FAQ/readme

= 0.1.4 =
fixed uninstall routine, actually deletes options now

= 0.1.3 =
- updated the plugin settings page list of parameters to indicate whether they are required or not
- updated FAQ section of readme.txt

= 0.1.2 =
some security hardening added

= 0.1.1 =
added textbox to enter your own css class name, which you must define in your own stylesheet

= 0.1.0 =
- minor code refactoring
- changed width of buttons to "auto"

= 0.0.9 =
- target="_blank" is deprecated, replaced with javascript fallback

= 0.0.8 =
- minor code refactoring

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