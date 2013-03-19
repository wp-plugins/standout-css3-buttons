<?php
/*
Plugin Name: Standout CSS3 Buttons
Plugin URI: http://www.jimmyscode.com/wordpress/standout-css3-buttons/
Description: Display CSS3 style buttons on your website using popular social media colors.
Version: 0.0.6
Author: Jimmy Pe&ntilde;a
Author URI: http://www.jimmyscode.com/
License: GPLv2 or later
*/
// plugin constants
define('SCSS3B_VERSION', '0.0.6');
define('SCSS3B_PLUGIN_NAME', 'Standout CSS3 Buttons');
define('SCSS3B_SLUG', 'standout-css3-buttons');
define('SCSS3B_LOCAL', 'scss3b');
define('SCSS3B_OPTION', 'scss3b');
/* default values */
define('SCSS3B_DEFAULT_ENABLED', true);
define('SCSS3B_DEFAULT_STYLE', '');
define('SCSS3B_DEFAULT_URL', '');
define('SCSS3B_DEFAULT_NOFOLLOW', true);
define('SCSS3B_DEFAULT_NEWWINDOW', false);
define('SCSS3B_DEFAULT_SHOW', false);
define('SCSS3B_AVAILABLE_STYLES', 'button-dribbble,button-facebook,button-googleplus,button-linkedin,button-pinterest,button-rss,button-tumblr,button-twitter,button-turquoise,button-emerald,button-somekindofblue,button-amethyst,button-bluegray,button-tangerine,button-fall,button-adobe,button-lightgray,button-dull,button-fancypurple,button-dullpurple,button-crispblue,button-braised,button-midnight,button-salmon,button-neongreen,button-brown');
/* option array member names */
define('SCSS3B_DEFAULT_ENABLED_NAME', 'enabled');
define('SCSS3B_DEFAULT_STYLE_NAME', 'cssclass');
define('SCSS3B_DEFAULT_URL_NAME', 'href');
define('SCSS3B_DEFAULT_NOFOLLOW_NAME', 'nofollow');
define('SCSS3B_DEFAULT_NEWWINDOW_NAME', 'opennewwindow');
define('SCSS3B_DEFAULT_SHOW_NAME', 'show');

// add custom quicktag
add_action('admin_print_footer_scripts', 'add_scss3b_quicktag', 100);
function add_scss3b_quicktag() {
?>
<script>
QTags.addButton('scss3b', 'CSS3 Button', '[standout-css3-button]', '[/standout-css3-button]', '', 'Standout CSS3 Button', '');
</script>
<?php }

// localization to allow for translations
add_action('init', 'scss3b_translation_file');
function scss3b_translation_file() {
  $plugin_path = plugin_basename(dirname(__FILE__)) . '/translations';
  load_plugin_textdomain(SCSS3B_LOCAL, '', $plugin_path);
  register_scss3b_style();
}
// tell WP that we are going to use new options
add_action('admin_init', 'scss3b_options_init');
function scss3b_options_init() {
  register_setting('scss3b_options', SCSS3B_OPTION);
}
// add Settings sub-menu
add_action('admin_menu', 'scss3b_plugin_menu');
function scss3b_plugin_menu() {
  add_options_page(SCSS3B_PLUGIN_NAME, SCSS3B_PLUGIN_NAME, 'manage_options', SCSS3B_SLUG, 'scss3b_page');
}
// plugin settings page
// http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/
// http://www.onedesigns.com/tutorials/how-to-create-a-wordpress-theme-options-page
function scss3b_page() {
  // check perms
  if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permission to access this page', SCSS3B_LOCAL));
  }
?>
  <div class="wrap">
    <?php screen_icon(); ?>
    <h2><?php echo SCSS3B_PLUGIN_NAME; ?></h2>
    <form method="post" action="options.php">
      <?php settings_fields('scss3b_options'); ?>
      <?php $options = scss3b_getpluginoptions(); ?>
      <?php update_option(SCSS3B_OPTION, $options); ?>
      <table class="form-table">
        <tr valign="top"><th scope="row"><strong><label for="scss3b[<?php echo SCSS3B_DEFAULT_ENABLED_NAME; ?>]"><?php _e('Plugin enabled?', SCSS3B_LOCAL); ?></label></strong></th>
					<td><input type="checkbox" id="scss3b[<?php echo SCSS3B_DEFAULT_ENABLED_NAME; ?>]" name="scss3b[<?php echo SCSS3B_DEFAULT_ENABLED_NAME; ?>]" value="1" <?php checked('1', $options[SCSS3B_DEFAULT_ENABLED_NAME]); ?> /></td>
        </tr>
				<tr valign="top"><td colspan="2"><?php _e('Is plugin enabled? Uncheck this to turn it off temporarily.', SCSS3B_LOCAL); ?></td></tr>
				<tr valign="top"><th scope="row"><strong><label for="scss3b[<?php echo SCSS3B_DEFAULT_STYLE_NAME; ?>]"><?php _e('Default style', SCSS3B_LOCAL); ?></label></strong></th>
					<td><select id="scss3b[<?php echo SCSS3B_DEFAULT_STYLE_NAME; ?>]" name="scss3b[<?php echo SCSS3B_DEFAULT_STYLE_NAME; ?>]">
          <?php $buttonstyles = explode(",", SCSS3B_AVAILABLE_STYLES);
            foreach($buttonstyles as $buttonstyle) {
              echo '<option value="' . $buttonstyle . '"' . selected($buttonstyle, $options[SCSS3B_DEFAULT_STYLE_NAME]) . '>' . $buttonstyle . '</option>';
            } ?>
          </select></td>
        </tr>
	  <tr valign="top"><td colspan="2"><?php _e('Select the style you would like to use as the default.', SCSS3B_LOCAL); ?></td></tr>
        <tr valign="top"><th scope="row"><strong><label for="scss3b[<?php echo SCSS3B_DEFAULT_URL_NAME; ?>]"><?php _e('Default button URL', SCSS3B_LOCAL); ?></label></strong></th>
		<td><input type="text" id="scss3b[<?php echo SCSS3B_DEFAULT_URL_NAME; ?>]" name="scss3b[<?php echo SCSS3B_DEFAULT_URL_NAME; ?>]" value="<?php echo $options[SCSS3B_DEFAULT_URL_NAME]; ?>" style="width:500px" /></td>
        </tr>
	  <tr valign="top"><td colspan="2"><?php _e('Enter default URL to use for buttons, if you do not pass one to the plugin via shortcode or function.', SCSS3B_LOCAL); ?></td></tr>
        <tr valign="top"><th scope="row"><strong><label for="scss3b[<?php echo SCSS3B_DEFAULT_NOFOLLOW_NAME; ?>]"><?php _e('Nofollow button link?', SCSS3B_LOCAL); ?></label></strong></th>
		<td><input type="checkbox" id="scss3b[<?php echo SCSS3B_DEFAULT_NOFOLLOW_NAME; ?>]" name="scss3b[<?php echo SCSS3B_DEFAULT_NOFOLLOW_NAME; ?>]" value="1" <?php checked('1', $options[SCSS3B_DEFAULT_NOFOLLOW_NAME]); ?> /></td>
        </tr>
	  <tr valign="top"><td colspan="2"><?php _e('Check this box to add rel="nofollow" to button links.', SCSS3B_LOCAL); ?></td></tr>
        <tr valign="top"><th scope="row"><strong><label for="scss3b[<?php echo SCSS3B_DEFAULT_NEWWINDOW_NAME; ?>]"><?php _e('Open links in new window?', SCSS3B_LOCAL); ?></label></strong></th>
		<td><input type="checkbox" id="scss3b[<?php echo SCSS3B_DEFAULT_NEWWINDOW_NAME; ?>]" name="scss3b[<?php echo SCSS3B_DEFAULT_NEWWINDOW_NAME; ?>]" value="1" <?php checked('1', $options[SCSS3B_DEFAULT_NEWWINDOW_NAME]); ?> /></td>
        </tr>
	  <tr valign="top"><td colspan="2"><?php _e('Check this box to open links in a new window instead of the same window.', SCSS3B_LOCAL); ?></td></tr>
      </table>
      <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Changes', SCSS3B_LOCAL); ?>" />
      </p>
    </form>
    <h2>Support</h2>
    <div style="background:#eff;border:1px solid gray;padding:20px">
    If you like this plugin, please <a href="http://wordpress.org/extend/plugins/<?php echo SCSS3B_SLUG; ?>/">rate it on WordPress.org</a> and click the "Works" button so others know it will work for your WordPress version. For support please visit the <a href="http://wordpress.org/support/plugin/<?php echo SCSS3B_SLUG; ?>">forums</a>.
    </div>
  </div>
  <?php  
}

// shortcode and function
add_shortcode('standout-css3-button', 'scss3button');
function scss3button($atts, $content = null) {
  // get parameters
  extract( shortcode_atts( array(
    SCSS3B_DEFAULT_STYLE_NAME => SCSS3B_DEFAULT_STYLE, 
    SCSS3B_DEFAULT_URL_NAME => SCSS3B_DEFAULT_URL, 
    SCSS3B_DEFAULT_NOFOLLOW_NAME => SCSS3B_DEFAULT_NOFOLLOW, 
    SCSS3B_DEFAULT_NEWWINDOW_NAME => SCSS3B_DEFAULT_NEWWINDOW, 
    SCSS3B_DEFAULT_SHOW_NAME => SCSS3B_DEFAULT_SHOW
    ), $atts ) );

  $options = scss3b_getpluginoptions();
  $enabled = $options[SCSS3B_DEFAULT_ENABLED_NAME];

  if ($enabled) { // check for parameters, then settings, then defaults
    // check for overridden parameters, if nonexistent then get from DB
    if ($href === SCSS3B_DEFAULT_URL) { // no url passed to function, try settings page
      $href = $options[SCSS3B_DEFAULT_URL_NAME];
      if (!$href) { // no url on settings page either
        $enabled = false;
      }
    }
    if ($cssclass === SCSS3B_DEFAULT_STYLE) {
      $cssclass = $options[SCSS3B_DEFAULT_STYLE_NAME];
	if ($cssclass === false) { // no style on settings page
	  $cssclass = SCSS3B_DEFAULT_STYLE;
	}
    }
    if ($nofollow === SCSS3B_DEFAULT_NOFOLLOW) {
      $nofollow = $options[SCSS3B_DEFAULT_NOFOLLOW_NAME];
      if ($nofollow === false) {
        $nofollow = SCSS3B_DEFAULT_NOFOLLOW;
      }
    }
    if ($opennewwindow === SCSS3B_DEFAULT_NEWWINDOW) {
      $opennewwindow = $options[SCSS3B_DEFAULT_NEWWINDOW_NAME];
      if ($opennewwindow === false) {
        $opennewwindow = SCSS3B_DEFAULT_NEWWINDOW;
      }
    }
  }
  // do some actual work
  if ($enabled) {
    // make sure style is valid
    $cssclasses = explode(',', SCSS3B_AVAILABLE_STYLES);
    if (!in_array($cssclass, $cssclasses)) {
      $cssclass = $options[SCSS3B_DEFAULT_STYLE_NAME];
      if ($cssclass === false) {
        $cssclass = SCSS3B_DEFAULT_STYLE;
      }
    }
    // enqueue CSS only on pages with shortcode
    scss3b_button_styles();
    $output = '<a' . ($opennewwindow ? ' target="_blank" ' : ' ') . 'class="' . $cssclass . '" href="' . esc_html($href) . '"' . ($nofollow ? ' rel="nofollow"' : '') . '>' . do_shortcode($content) . '</a>';
  } else { // plugin disabled
    $output = '<!-- ' . SCSS3B_PLUGIN_NAME . ': plugin is disabled. Check Settings page. -->';
  }
  if ($show) {
    echo $output;
  } else {
    return $output;
  }
}

// show admin messages to plugin user
add_action('admin_notices', 'scss3b_showAdminMessages');
function scss3b_showAdminMessages() {
  // http://wptheming.com/2011/08/admin-notices-in-wordpress/
  global $pagenow;
  if (current_user_can('manage_options')) { // user has privilege
    if ($pagenow == 'options-general.php') {
      if ($_GET['page'] == SCSS3B_SLUG) { // we are on JP's Get RSS Feed settings page
        $options = scss3b_getpluginoptions(); // get_option(SCSS3B_OPTION); // don't use encapsulated function here
        if ($options) {
	    $enabled = $options[SCSS3B_DEFAULT_ENABLED_NAME];
	    if ($enabled === false) {
		echo '<div class="updated">' . SCSS3B_PLUGIN_NAME . ' ' . __('is currently disabled.', SCSS3B_LOCAL) . '</div>';
	    }
	  }
	}
    } // end page check
  } // end privilege check
}
// http://bavotasan.com/2009/a-settings-link-for-your-wordpress-plugins/
// Add settings link on plugin page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'scss3b_plugin_settings_link' );
function scss3b_plugin_settings_link($links) {
  $settings_link = '<a href="options-general.php?page=' . SCSS3B_SLUG . '">' . __('Settings', SCSS3B_LOCAL) . '</a>';
  array_unshift($links, $settings_link);
  return $links;
}
function scss3b_button_styles() {
  wp_enqueue_style('standout_css3_button_style');
}
function register_scss3b_style() {
  wp_register_style('standout_css3_button_style', 
    plugins_url(plugin_basename(dirname(__FILE__)) . '/css/standout-css3-buttons.css'), 
    array(), 
    SCSS3B_VERSION, 
    'all' );
}
function scss3b_getpluginoptions() {
  return get_option(SCSS3B_OPTION, array(SCSS3B_DEFAULT_ENABLED_NAME => SCSS3B_DEFAULT_ENABLED, SCSS3B_DEFAULT_STYLE_NAME => SCSS3B_DEFAULT_STYLE, SCSS3B_DEFAULT_URL_NAME => SCSS3B_DEFAULT_URL, SCSS3B_DEFAULT_NOFOLLOW_NAME => SCSS3B_DEFAULT_NOFOLLOW, SCSS3B_DEFAULT_NEWWINDOW_NAME => SCSS3B_DEFAULT_NEWWINDOW));
}
?>