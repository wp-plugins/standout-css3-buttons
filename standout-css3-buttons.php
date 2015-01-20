<?php
/*
Plugin Name: Standout CSS3 Buttons
Plugin URI: http://www.jimmyscode.com/wordpress/standout-css3-buttons/
Description: Display CSS3 style buttons with gradient color styles on your website using popular social media colors.
Version: 0.3.0
Author: Jimmy Pe&ntilde;a
Author URI: http://www.jimmyscode.com/
License: GPLv2 or later
*/
if (!defined('SCSS3B_PLUGIN_NAME')) {
	// plugin constants
	define('SCSS3B_PLUGIN_NAME', 'Standout CSS3 Buttons');
	define('SCSS3B_VERSION', '0.3.0');
	define('SCSS3B_SLUG', 'standout-css3-buttons');
	define('SCSS3B_LOCAL', 'scss3b');
	define('SCSS3B_OPTION', 'scss3b');
	define('SCSS3B_OPTIONS_NAME', 'scss3b_options');
	define('SCSS3B_PERMISSIONS_LEVEL', 'manage_options');
	define('SCSS3B_PATH', plugin_basename(dirname(__FILE__)));
	/* default values */
	define('SCSS3B_DEFAULT_ENABLED', true);
	define('SCSS3B_DEFAULT_STYLE', '');
	define('SCSS3B_DEFAULT_CUSTOM_STYLE', '');
	define('SCSS3B_DEFAULT_URL', '');
	define('SCSS3B_DEFAULT_CUSTOM_CSS', '');
	define('SCSS3B_DEFAULT_NOFOLLOW', false);
	define('SCSS3B_DEFAULT_SHOW', false);
	define('SCSS3B_DEFAULT_NEWWINDOW', false);
	define('SCSS3B_AVAILABLE_STYLES', 'button-dribbble,button-facebook,button-googleplus,button-linkedin,button-pinterest,button-rss,button-tumblr,button-twitter,button-turquoise,button-emerald,button-somekindofblue,button-amethyst,button-bluegray,button-tangerine,button-fall,button-adobe,button-lightgray,button-dull,button-fancypurple,button-dullpurple,button-crispblue,button-braised,button-midnight,button-salmon,button-neongreen,button-brown,button-sourgreen');
	/* option array member names */
	define('SCSS3B_DEFAULT_ENABLED_NAME', 'enabled');
	define('SCSS3B_DEFAULT_STYLE_NAME', 'cssclass');
	define('SCSS3B_DEFAULT_CUSTOM_STYLE_NAME', 'customclass');
	define('SCSS3B_DEFAULT_URL_NAME', 'href');
	define('SCSS3B_DEFAULT_NOFOLLOW_NAME', 'nofollow');
	define('SCSS3B_DEFAULT_SHOW_NAME', 'show');
	define('SCSS3B_DEFAULT_NEWWINDOW_NAME', 'opennewwindow');
	define('SCSS3B_DEFAULT_CUSTOM_CSS_NAME', 'customcss');
}
	// oh no you don't
	if (!defined('ABSPATH')) {
		wp_die(__('Do not access this file directly.', scss3b_get_local()));
	}

	// localization to allow for translations
	// also, register the plugin CSS file for later inclusion
	add_action('init', 'scss3b_translation_file');
	function scss3b_translation_file() {
		$plugin_path = scss3b_get_path() . '/translations';
		load_plugin_textdomain(scss3b_get_local(), '', $plugin_path);
		register_scss3b_style();
	}
	// tell WP that we are going to use new options
	// also, register the admin CSS file for later inclusion
	add_action('admin_init', 'scss3b_options_init');
	function scss3b_options_init() {
		register_setting(SCSS3B_OPTIONS_NAME, scss3b_get_option(), 'scss3b_validation');
		register_scss3b_admin_style();
		register_scss3b_admin_script();
	}
	// validation function
	function scss3b_validation($input) {
		if (!empty($input)) {
			// validate all form fields
			$input[SCSS3B_DEFAULT_ENABLED_NAME] = (bool)$input[SCSS3B_DEFAULT_ENABLED_NAME];
			$input[SCSS3B_DEFAULT_NOFOLLOW_NAME] = (bool)$input[SCSS3B_DEFAULT_NOFOLLOW_NAME];
			$input[SCSS3B_DEFAULT_NEWWINDOW_NAME] = (bool)$input[SCSS3B_DEFAULT_NEWWINDOW_NAME];
			$input[SCSS3B_DEFAULT_URL_NAME] = esc_url($input[SCSS3B_DEFAULT_URL_NAME]);
			$input[SCSS3B_DEFAULT_STYLE_NAME] = sanitize_html_class($input[SCSS3B_DEFAULT_STYLE_NAME]);
			$input[SCSS3B_DEFAULT_CUSTOM_STYLE_NAME] = sanitize_html_class($input[SCSS3B_DEFAULT_CUSTOM_STYLE_NAME]);
			$input[SCSS3B_DEFAULT_CUSTOM_CSS_NAME] = sanitize_text_field($input[SCSS3B_DEFAULT_CUSTOM_CSS_NAME]);
		}
		return $input;
	}
	// add Settings sub-menu
	add_action('admin_menu', 'scss3b_plugin_menu');
	function scss3b_plugin_menu() {
		add_options_page(SCSS3B_PLUGIN_NAME, SCSS3B_PLUGIN_NAME, SCSS3B_PERMISSIONS_LEVEL, scss3b_get_slug(), 'scss3b_page');
	}
	// plugin settings page
	// http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/
	// http://www.onedesigns.com/tutorials/how-to-create-a-wordpress-theme-options-page
	function scss3b_page() {
		// check perms
		if (!current_user_can(SCSS3B_PERMISSIONS_LEVEL)) {
			wp_die(__('You do not have sufficient permission to access this page', scss3b_get_local()));
		}
		?>
		<div class="wrap">
			<h2 id="plugintitle"><img src="<?php echo scss3b_getimagefilename('colors.png'); ?>" title="" alt="" height="64" width="64" align="absmiddle" /> <?php echo SCSS3B_PLUGIN_NAME; ?> by <a href="http://www.jimmyscode.com/">Jimmy Pe&ntilde;a</a></h2>
			<div><?php _e('You are running plugin version', scss3b_get_local()); ?> <strong><?php echo SCSS3B_VERSION; ?></strong>.</div>
			
			<?php /* http://code.tutsplus.com/tutorials/the-complete-guide-to-the-wordpress-settings-api-part-5-tabbed-navigation-for-your-settings-page--wp-24971 */ ?>
			<?php $active_tab = (isset($_GET['tab']) ? $_GET['tab'] : 'settings'); ?>
			<h2 class="nav-tab-wrapper">
			  <a href="?page=<?php echo scss3b_get_slug(); ?>&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>"><?php _e('Settings', scss3b_get_local()); ?></a>
				<a href="?page=<?php echo scss3b_get_slug(); ?>&tab=parameters" class="nav-tab <?php echo $active_tab == 'parameters' ? 'nav-tab-active' : ''; ?>"><?php _e('Parameters', scss3b_get_local()); ?></a>
				<a href="?page=<?php echo scss3b_get_slug(); ?>&tab=support" class="nav-tab <?php echo $active_tab == 'support' ? 'nav-tab-active' : ''; ?>"><?php _e('Support', scss3b_get_local()); ?></a>
			</h2>
			
			<form method="post" action="options.php">
			<?php settings_fields(SCSS3B_OPTIONS_NAME); ?>
			<?php $options = scss3b_getpluginoptions(); ?>
			<?php update_option(scss3b_get_option(), $options); ?>
			<?php if ($active_tab == 'settings') { ?>
			<h3 id="settings"><img src="<?php echo scss3b_getimagefilename('settings.png'); ?>" title="" alt="" height="61" width="64" align="absmiddle" /> <?php _e('Plugin Settings', scss3b_get_local()); ?></h3>
				<table class="form-table" id="theme-options-wrap">
					<tr valign="top"><th scope="row"><strong><label title="<?php _e('Is plugin enabled? Uncheck this to turn it off temporarily.', scss3b_get_local()); ?>" for="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_ENABLED_NAME; ?>]"><?php _e('Plugin enabled?', scss3b_get_local()); ?></label></strong></th>
						<td><input type="checkbox" id="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_ENABLED_NAME; ?>]" name="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_ENABLED_NAME; ?>]" value="1" <?php checked('1', scss3b_checkifset(SCSS3B_DEFAULT_ENABLED_NAME, SCSS3B_DEFAULT_ENABLED, $options)); ?> /></td>
					</tr>
					<?php scss3b_explanationrow(__('Is plugin enabled? Uncheck this to turn it off temporarily.', scss3b_get_local())); ?>
					<?php scss3b_getlinebreak(); ?>
					<tr valign="top"><th scope="row"><strong><label title="<?php _e('Select the style you would like to use as the default.', scss3b_get_local()); ?>" for="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_STYLE_NAME; ?>]"><?php _e('Default style', scss3b_get_local()); ?></label></strong></th>
						<td><select id="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_STYLE_NAME; ?>]" name="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_STYLE_NAME; ?>]">
						<?php $buttonstyles = explode(",", SCSS3B_AVAILABLE_STYLES);
							sort($buttonstyles);
							foreach($buttonstyles as $buttonstyle) {
								echo '<option value="' . $buttonstyle . '"' . selected($buttonstyle, scss3b_checkifset(SCSS3B_DEFAULT_STYLE_NAME, SCSS3B_DEFAULT_STYLE, $options), false) . '>' . $buttonstyle . '</option>';
							} ?>
						</select></td>
					</tr>
			<?php scss3b_explanationrow(__('Select the style you would like to use as the default if no style is otherwise specified.', scss3b_get_local())); ?>
			<?php scss3b_getlinebreak(); ?>
			<tr valign="top"><th scope="row"><strong><label title="<?php _e('Enter default URL to use for buttons, if you do not pass one to the plugin via shortcode or function.', scss3b_get_local()); ?>" for="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_URL_NAME; ?>]"><?php _e('Default button URL', scss3b_get_local()); ?></label></strong></th>
			<td><input type="url" id="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_URL_NAME; ?>]" name="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_URL_NAME; ?>]" value="<?php echo scss3b_checkifset(SCSS3B_DEFAULT_URL_NAME, SCSS3B_DEFAULT_URL, $options); ?>" /></td>
					</tr>
			<?php scss3b_explanationrow(__('Enter default URL to use for buttons. This URL will be used if you do not override it at the shortcode level.', scss3b_get_local())); ?>
			<?php scss3b_getlinebreak(); ?>
					<tr valign="top"><th scope="row"><strong><label title="<?php _e('Check this box to add rel=nofollow to button links.', scss3b_get_local()); ?>" for="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_NOFOLLOW_NAME; ?>]"><?php _e('Nofollow button link?', scss3b_get_local()); ?></label></strong></th>
			<td><input type="checkbox" id="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_NOFOLLOW_NAME; ?>]" name="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_NOFOLLOW_NAME; ?>]" value="1" <?php checked('1', scss3b_checkifset(SCSS3B_DEFAULT_NOFOLLOW_NAME, SCSS3B_DEFAULT_NOFOLLOW, $options)); ?> /></td>
					</tr>
			<?php scss3b_explanationrow(__('Check this box to add rel="nofollow" to button links. You can override this at the shortcode level.', scss3b_get_local())); ?>
			<?php scss3b_getlinebreak(); ?>
			<tr valign="top"><th scope="row"><strong><label title="<?php _e('Check this box to open links in a new window.', scss3b_get_local()); ?>" for="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_NEWWINDOW_NAME; ?>]"><?php _e('Open links in new window?', scss3b_get_local()); ?></label></strong></th>
				<td><input type="checkbox" id="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_NEWWINDOW_NAME; ?>]" name="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_NEWWINDOW_NAME; ?>]" value="1" <?php checked('1', scss3b_checkifset(SCSS3B_DEFAULT_NEWWINDOW_NAME, SCSS3B_DEFAULT_NEWWINDOW, $options)); ?> /></td>
			</tr>
			<?php scss3b_explanationrow(__('Check this box to open links in a new window. You can override this at the shortcode level.', scss3b_get_local())); ?>
			<?php scss3b_getlinebreak(); ?>
					<tr valign="top"><th scope="row"><strong><label title="<?php _e('Enter custom CSS', scss3b_get_local()); ?>" for="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_CUSTOM_CSS_NAME; ?>]"><?php _e('Enter custom CSS', scss3b_get_local()); ?></label></strong></th>
			<td><textarea rows="12" cols="75" id="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_CUSTOM_CSS_NAME; ?>]" name="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_CUSTOM_CSS_NAME; ?>]"><?php echo scss3b_checkifset(SCSS3B_DEFAULT_CUSTOM_CSS_NAME, SCSS3B_DEFAULT_CUSTOM_CSS, $options); ?></textarea></td>
			</tr>
			<?php scss3b_explanationrow(__('If you use your own custom class names, enter the CSS here. Use the custom class name (minus the "scss3b-button-" prefix) in the shortcode or when calling the function in PHP.', scss3b_get_local())); ?>
			<?php scss3b_getlinebreak(); ?>
			<tr valign="top"><th scope="row"><strong><label title="<?php _e('Enter custom CSS class name', scss3b_get_local()); ?>" for="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_CUSTOM_STYLE_NAME; ?>]"><?php _e('Enter custom CSS class name', scss3b_get_local()); ?></label></strong></th>
				<td><input type="text" id="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_CUSTOM_STYLE_NAME; ?>]" name="<?php echo scss3b_get_option(); ?>[<?php echo SCSS3B_DEFAULT_CUSTOM_STYLE_NAME; ?>]" value="<?php echo scss3b_checkifset(SCSS3B_DEFAULT_CUSTOM_STYLE_NAME, SCSS3B_DEFAULT_CUSTOM_STYLE, $options); ?>" /></td>
					</tr>
			<?php scss3b_explanationrow(__('Add an additional CSS class here. This class name will be added to the button.', scss3b_get_local())); ?>
				</table>
				<?php submit_button(); ?>
			<?php } elseif ($active_tab == 'parameters') { ?>
			<h3 id="parameters"><img src="<?php echo scss3b_getimagefilename('parameters.png'); ?>" title="" alt="" height="64" width="64" align="absmiddle" /> <?php _e('Plugin Parameters and Default Values', scss3b_get_local()); ?></h3>
			These are the parameters for using the shortcode, or calling the plugin from your PHP code.
			
			For available colors, see the dropdown list above.

			<?php echo scss3b_parameters_table(scss3b_get_local(), scss3b_shortcode_defaults(), scss3b_required_parameters()); ?>			

			<h3 id="examples"><img src="<?php echo scss3b_getimagefilename('examples.png'); ?>" title="" alt="" height="64" width="64" align="absmiddle" /> <?php _e('Shortcode and PHP Examples', scss3b_get_local()); ?></h3>
			<h4><?php _e('Shortcode Format:', scss3b_get_local()); ?></h4>
			<?php echo '<pre style="background:#FFF">' . scss3b_get_example_shortcode('standout-css3-button', scss3b_shortcode_defaults(), scss3b_get_local()) . 'Content goes here[/standout-css3-button]</pre>'; ?>

			<h4><?php _e('PHP Format:', scss3b_get_local()); ?></h4>
			<?php echo scss3b_get_example_php_code('standout-css3-button', 'scss3button', scss3b_shortcode_defaults()); ?>
			<?php _e('<small>Note: \'show\' is false by default; set it to <strong>true</strong> echo the output, or <strong>false</strong> to return the output to your PHP code.</small>', scss3b_get_local()); ?>
			<?php } else { ?>
			<h3 id="support"><img src="<?php echo scss3b_getimagefilename('support.png'); ?>" title="" alt="" height="64" width="64" align="absmiddle" /> <?php _e('Support', scss3b_get_local()); ?></h3>
				<div class="support">
				<?php echo scss3b_getsupportinfo(scss3b_get_slug(), scss3b_get_local()); ?>
				</div>
			<?php } ?>
			</form>
		</div>
		<?php }
	// shortcode and function
	add_shortcode('standout-css3-button', 'scss3button');
	function scss3button($atts, $content = null) {
		// get parameters
		extract(shortcode_atts(scss3b_shortcode_defaults(), $atts));
		// plugin is enabled/disabled from settings page only
		$options = scss3b_getpluginoptions();
		if (!empty($options)) {
			$enabled = (bool)$options[SCSS3B_DEFAULT_ENABLED_NAME];
		} else {
			$enabled = SCSS3B_DEFAULT_ENABLED;
		}
		
		$output = '';
		
		// ******************************
		// derive shortcode values from constants
		// ******************************
		if ($enabled) {
			$temp_style = constant('SCSS3B_DEFAULT_STYLE_NAME');
			$cssclass = $$temp_style;
			$temp_custom_style = constant('SCSS3B_DEFAULT_CUSTOM_STYLE_NAME');
			$scss3bcustomclass = $$temp_custom_style;
			$temp_url = constant('SCSS3B_DEFAULT_URL_NAME');
			$linkurl = $$temp_url;
			$temp_nofollow = constant('SCSS3B_DEFAULT_NOFOLLOW_NAME');
			$nofollow = $$temp_nofollow;
			$temp_window = constant('SCSS3B_DEFAULT_NEWWINDOW_NAME');
			$opennewwindow = $$temp_window;
			$temp_show = constant('SCSS3B_DEFAULT_SHOW_NAME');
			$show = $$temp_show;
		}

		// ******************************
		// sanitize user input
		// ******************************
		if ($enabled) {
			$linkurl = esc_url($linkurl);
			$cssclass = sanitize_html_class($cssclass);
			if (!$cssclass) {
				$cssclass = SCSS3B_DEFAULT_STYLE;
			}
			$scss3bcustomclass = sanitize_html_class($scss3bcustomclass);
			if (!$scss3bcustomclass) {
				$scss3bcustomclass = SCSS3B_DEFAULT_CUSTOM_STYLE;
			}
			$nofollow = (bool)$nofollow;
			$opennewwindow = (bool)$opennewwindow;
			$show = (bool)$show;

			// allow alternate parameter names for url
			if (!empty($atts['url'])) {
				$linkurl = esc_url($atts['url']);
			} elseif (!empty($atts['link'])) {
				$linkurl = esc_url($atts['link']);
			}
		}
		// ******************************
		// check for parameters, then settings, then defaults
		// ******************************
		if ($enabled) {
			if ($content === null) { 
				// what is the point of a button w/ no text?
				$enabled = false;
				$output = '<!-- ' . SCSS3B_PLUGIN_NAME . ': ';
				$output .= __('plugin is disabled. Either you did not pass a necessary setting to the plugin, or did not configure a default. Check Settings page.', scss3b_get_local());
				$output .= ' -->';
			} else { 
				if ($linkurl == SCSS3B_DEFAULT_URL) { // no url passed to function, try settings page
					$linkurl = $options[SCSS3B_DEFAULT_URL_NAME];
					if (($linkurl == SCSS3B_DEFAULT_URL) || ($linkurl == false)) { // no url on settings page either
						$enabled = false;
						$output = '<!-- ' . SCSS3B_PLUGIN_NAME . ': ';
						$output .= __('plugin is disabled. Either you did not pass a necessary setting to the plugin, or did not configure a default. Check Settings page.', scss3b_get_local());
						$output .= ' -->';
					}
				}
			}
		}
		if ($enabled) {
			// plugin is enabled and there is content
			// check for overridden parameters, if nonexistent then get from DB
			$scss3bcustomclass = scss3b_setupvar($scss3bcustomclass, SCSS3B_DEFAULT_CUSTOM_STYLE, SCSS3B_DEFAULT_CUSTOM_STYLE_NAME, $options);
			$nofollow = scss3b_setupvar($nofollow, SCSS3B_DEFAULT_NOFOLLOW, SCSS3B_DEFAULT_NOFOLLOW_NAME, $options);
			$opennewwindow = scss3b_setupvar($opennewwindow, SCSS3B_DEFAULT_NEWWINDOW, SCSS3B_DEFAULT_NEWWINDOW_NAME, $options);
			
			// check if existing color value was passed
			if (($cssclass == false) || ($cssclass == SCSS3B_DEFAULT_STYLE)) {
				// not passed by shortcode, use default
				$cssclass = 'scss3b-' . $options[SCSS3B_DEFAULT_STYLE_NAME];
			} else { // a value was passed, check if it is one of the available classes. if not, assume a custom class and load custom.css
				$buttonclasses = explode(",", SCSS3B_AVAILABLE_STYLES);
				if (!in_array($cssclass, $buttonclasses)) {
					// write CSS to custom.css file
					$myFile = dirname(__FILE__) . '/css/custom.css';
					$fh = @fopen($myFile, 'w+');
					@fwrite($fh, $options[SCSS3B_DEFAULT_CUSTOM_CSS_NAME]);
					@fclose($fh);
					// enqueue custom css file
					scss3b_custom_styles();
					// 'fix' class name
					$cssclass = 'scss3b-button-' . $cssclass;
				} else {
					$cssclass = 'scss3b-' . $cssclass;
				}
			} // end color

			// enqueue CSS only on pages with shortcode
			scss3b_button_styles();

			$output = '<a';
			$output .= ' class="scss3b-button' . ($scss3bcustomclass ? ' ' . $scss3bcustomclass : '');
			$output .= ' ' . $cssclass . '"';
			$output .= ($opennewwindow ? ' onclick="window.open(this.href); return false;" onkeypress="window.open(this.href); return false;" ' : '');
			$output .= ($nofollow ? ' rel="nofollow"' : '');
			$output .= ' href="' . $linkurl . '"';
			$output .= '>';
			$output .= do_shortcode(wp_kses_post(force_balance_tags($content)));
			$output .= '</a>';
			
		} else { // plugin disabled
			$output = '<!-- ' . SCSS3B_PLUGIN_NAME . ': ';
			$output .= __('plugin is disabled. Either you did not pass a necessary setting to the plugin, or did not configure a default. Check Settings page.', scss3b_get_local());
			$output .= ' -->';
		} // end enabled check
		if ($show) {
			echo $output;
		} else {
			return $output;
		}
	} // end shortcode
	// show admin messages to plugin user
	add_action('admin_notices', 'scss3b_showAdminMessages');
	function scss3b_showAdminMessages() {
		// http://wptheming.com/2011/08/admin-notices-in-wordpress/
		global $pagenow;
		if (current_user_can(SCSS3B_PERMISSIONS_LEVEL)) { // user has privilege
			if ($pagenow == 'options-general.php') { // we are on Settings page
				if (isset($_GET['page'])) {
					if ($_GET['page'] == scss3b_get_slug()) { // we are on this plugin's settings page
						$options = scss3b_getpluginoptions();
						if (!empty($options)) {
							$enabled = (bool)$options[SCSS3B_DEFAULT_ENABLED_NAME];
							$cssclass = $options[SCSS3B_DEFAULT_STYLE_NAME];
							$linkurl = $options[SCSS3B_DEFAULT_URL_NAME];
							if (!$enabled) {
								echo '<div id="message" class="error">' . SCSS3B_PLUGIN_NAME . ' ' . __('is currently disabled.', scss3b_get_local()) . '</div>';
							}
							if (($cssclass === SCSS3B_DEFAULT_STYLE) || ($cssclass === false) || ($linkurl === SCSS3B_DEFAULT_URL) || ($linkurl === false)) {
								echo '<div id="message" class="updated">' . __('Please confirm the default CSS style and URL and click "Save".', scss3b_get_local()) . '</div>';
							}
						}
					}
				}
			} // end page check
		} // end privilege check
	} // end admin msgs function
	// enqueue admin CSS if we are on the plugin options page
	add_action('admin_head', 'insert_scss3b_admin_css');
	function insert_scss3b_admin_css() {
		global $pagenow;
		if (current_user_can(SCSS3B_PERMISSIONS_LEVEL)) { // user has privilege
			if ($pagenow == 'options-general.php') {
				if (isset($_GET['page'])) {
					if ($_GET['page'] == scss3b_get_slug()) { // we are on this plugin's settings page
						scss3b_admin_styles();
					}
				}
			}
		}
	}
	// add helpful links to plugin page next to plugin name
	// http://bavotasan.com/2009/a-settings-link-for-your-wordpress-plugins/
	// http://wpengineer.com/1295/meta-links-for-wordpress-plugins/
	add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'scss3b_plugin_settings_link');
	add_filter('plugin_row_meta', 'scss3b_meta_links', 10, 2);
	
	function scss3b_plugin_settings_link($links) {
		return scss3b_settingslink($links, scss3b_get_slug(), scss3b_get_local());
	}
	function scss3b_meta_links($links, $file) {
		if ($file == plugin_basename(__FILE__)) {
			$links = array_merge($links,
			array(
				sprintf(__('<a href="http://wordpress.org/support/plugin/%s">Support</a>', scss3b_get_local()), scss3b_get_slug()),
				sprintf(__('<a href="http://wordpress.org/extend/plugins/%s/">Documentation</a>', scss3b_get_local()), scss3b_get_slug()),
				sprintf(__('<a href="http://wordpress.org/plugins/%s/faq/">FAQ</a>', scss3b_get_local()), scss3b_get_slug())
			));
		}
		return $links;	
	}
	// enqueue/register the plugin CSS file
	function scss3b_button_styles() {
		wp_enqueue_style('standout_css3_button_style');
	}
	function register_scss3b_style() {
		wp_register_style('standout_css3_button_style', 
			plugins_url(scss3b_get_path() . '/css/standout-css3-buttons.css'), 
			array(), 
			SCSS3B_VERSION . "_" . date('njYHis', filemtime(dirname(__FILE__) . '/css/standout-css3-buttons.css')),
			'all' );
	}
	// enqueue/register the admin CSS file
	function scss3b_admin_styles() {
		wp_enqueue_style('scss3b_admin_style');
	}
	function register_scss3b_admin_style() {
		wp_register_style('scss3b_admin_style',
			plugins_url(scss3b_get_path() . '/css/admin.css'),
			array(),
			SCSS3B_VERSION . "_" . date('njYHis', filemtime(dirname(__FILE__) . '/css/admin.css')),
			'all');
	}
	// enqueue/register the custom CSS file
	function scss3b_custom_styles() {
		wp_register_style('scss3b_custom_style',
			plugins_url(scss3b_get_path() . '/css/custom.css'),
		array(),
		SCSS3B_VERSION . "_" . date('njYHis', filemtime(dirname(__FILE__) . '/css/custom.css')),
		'all');
		wp_enqueue_style('scss3b_custom_style');
	}
	// enqueue/register the admin JS file
	add_action('admin_enqueue_scripts', 'scss3b_ed_buttons');
	function scss3b_ed_buttons($hook) {
		if (($hook == 'post-new.php') || ($hook == 'post.php')) {
			wp_enqueue_script('scss3b_add_editor_button');
		}
	}
	function register_scss3b_admin_script() {
		wp_register_script('scss3b_add_editor_button',
			plugins_url(scss3b_get_path() . '/js/editor_button.js'), 
			array('quicktags'), 
			SCSS3B_VERSION . "_" . date('njYHis', filemtime(dirname(__FILE__) . '/js/editor_button.js')),
			true);
	}
	// when plugin is activated, create options array and populate with defaults
	register_activation_hook(__FILE__, 'scss3b_activate');
	function scss3b_activate() {
		$options = scss3b_getpluginoptions();
		update_option(scss3b_get_option(), $options);

		// delete option when plugin is uninstalled
		register_uninstall_hook(__FILE__, 'uninstall_scss3b_plugin');
	}
	function uninstall_scss3b_plugin() {
		delete_option(scss3b_get_option());
	}
	// function to validate hex color values
	function scss3b_filter_hex_color($colorvalue) {
		if (preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $colorvalue)) {
			return $colorvalue;
		}
	}
	// generic function that returns plugin options from DB
	// if option does not exist, returns plugin defaults
	function scss3b_getpluginoptions() {
		return get_option(scss3b_get_option(), 
			array(
				SCSS3B_DEFAULT_ENABLED_NAME => SCSS3B_DEFAULT_ENABLED, 
				SCSS3B_DEFAULT_STYLE_NAME => SCSS3B_DEFAULT_STYLE, 
				SCSS3B_DEFAULT_CUSTOM_STYLE_NAME => SCSS3B_DEFAULT_CUSTOM_STYLE, 
				SCSS3B_DEFAULT_URL_NAME => SCSS3B_DEFAULT_URL, 
				SCSS3B_DEFAULT_NOFOLLOW_NAME => SCSS3B_DEFAULT_NOFOLLOW, 
				SCSS3B_DEFAULT_NEWWINDOW_NAME => SCSS3B_DEFAULT_NEWWINDOW, 
				SCSS3B_DEFAULT_CUSTOM_CSS_NAME => SCSS3B_DEFAULT_CUSTOM_CSS
			));
	}
	// function to return shortcode defaults
	function scss3b_shortcode_defaults() {
		return array(
			SCSS3B_DEFAULT_URL_NAME => SCSS3B_DEFAULT_URL, 
			SCSS3B_DEFAULT_STYLE_NAME => SCSS3B_DEFAULT_STYLE, 
			SCSS3B_DEFAULT_CUSTOM_STYLE_NAME => SCSS3B_DEFAULT_CUSTOM_STYLE, 
			SCSS3B_DEFAULT_NOFOLLOW_NAME => SCSS3B_DEFAULT_NOFOLLOW, 
			SCSS3B_DEFAULT_NEWWINDOW_NAME => SCSS3B_DEFAULT_NEWWINDOW, 
			SCSS3B_DEFAULT_SHOW_NAME => SCSS3B_DEFAULT_SHOW
			);
	}
	// function to return parameter status (required or not)
	function scss3b_required_parameters() {
		return array(
			true,
			false,
			false,
			false,
			false,
			false
		);
	}
	
	// encapsulate these and call them throughout the plugin instead of hardcoding the constants everywhere
	function scss3b_get_slug() { return SCSS3B_SLUG; }
	function scss3b_get_local() { return SCSS3B_LOCAL; }
	function scss3b_get_option() { return SCSS3B_OPTION; }
	function scss3b_get_path() { return SCSS3B_PATH; }
	
	function scss3b_settingslink($linklist, $slugname = '', $localname = '') {
		$settings_link = sprintf( __('<a href="options-general.php?page=%s">Settings</a>', $localname), $slugname);
		array_unshift($linklist, $settings_link);
		return $linklist;
	}
	function scss3b_setupvar($var, $defaultvalue, $defaultvarname, $optionsarr) {
		if ($var == $defaultvalue) {
			$var = $optionsarr[$defaultvarname];
			if (!$var) {
				$var = $defaultvalue;
			}
		}
		return $var;
	}
	function scss3b_getsupportinfo($slugname = '', $localname = '') {
		$output = __('Do you need help with this plugin? Check out the following resources:', $localname);
		$output .= '<ol>';
		$output .= '<li>' . sprintf( __('<a href="http://wordpress.org/extend/plugins/%s/">Documentation</a>', $localname), $slugname) . '</li>';
		$output .= '<li>' . sprintf( __('<a href="http://wordpress.org/plugins/%s/faq/">FAQ</a><br />', $localname), $slugname) . '</li>';
		$output .= '<li>' . sprintf( __('<a href="http://wordpress.org/support/plugin/%s">Support Forum</a><br />', $localname), $slugname) . '</li>';
		$output .= '<li>' . sprintf( __('<a href="http://www.jimmyscode.com/wordpress/%s">Plugin Homepage / Demo</a><br />', $localname), $slugname) . '</li>';
		$output .= '<li>' . sprintf( __('<a href="http://wordpress.org/extend/plugins/%s/developers/">Development</a><br />', $localname), $slugname) . '</li>';
		$output .= '<li>' . sprintf( __('<a href="http://wordpress.org/plugins/%s/changelog/">Changelog</a><br />', $localname), $slugname) . '</li>';
		$output .= '</ol>';
		
		$output .= sprintf( __('If you like this plugin, please <a href="http://wordpress.org/support/view/plugin-reviews/%s/">rate it on WordPress.org</a>', $localname), $slugname);
		$output .= sprintf( __(' and click the <a href="http://wordpress.org/plugins/%s/#compatibility">Works</a> button. ', $localname), $slugname);
		$output .= '<br /><br /><br />';
		$output .= __('Your donations encourage further development and support. ', $localname);
		$output .= '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7EX9NB9TLFHVW"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" alt="Donate with PayPal" title="Support this plugin" width="92" height="26" /></a>';
		$output .= '<br /><br />';
		return $output;
	}
	
	function scss3b_parameters_table($localname = '', $sc_defaults, $reqparms) {
	  $output = '<table class="widefat">';
		$output .= '<thead><tr>';
		$output .= '<th title="' . __('The name of the parameter', $localname) . '"><strong>' . __('Parameter Name', $localname) . '</strong></th>';
		$output .= '<th title="' . __('Is this parameter required?', $localname) . '"><strong>' . __('Is Required?', $localname) . '</strong></th>';
		$output .= '<th title="' . __('What data type this parameter accepts', $localname) . '"><strong>' . __('Data Type', $localname) . '</strong></th>';
		$output .= '<th title="' . __('What, if any, is the default if no value is specified', $localname) . '"><strong>' . __('Default Value', $localname) . '</strong></th>';
		$output .= '</tr></thead>';
		$output .= '<tbody>';
		
		$plugin_defaults_keys = array_keys($sc_defaults);
		$plugin_defaults_values = array_values($sc_defaults);
		$required = $reqparms;
		for($i = 0; $i < count($plugin_defaults_keys); $i++) {
			$output .= '<tr>';
			$output .= '<td><strong>' . $plugin_defaults_keys[$i] . '</strong></td>';
			$output .= '<td>';
			
			if ($required[$i] === true) {
				$output .= '<strong>';
				$output .= __('Yes', $localname);
				$output .= '</strong>';
			} else {
				$output .= __('No', $localname);
			}
			
			$output .= '</td>';
			$output .= '<td>' . gettype($plugin_defaults_values[$i]) . '</td>';
			$output .= '<td>';
			
			if ($plugin_defaults_values[$i] === true) {
				$output .= '<strong>';
				$output .= __('true', $localname);
				$output .= '</strong>';
			} elseif ($plugin_defaults_values[$i] === false) {
				$output .= __('false', $localname);
			} elseif ($plugin_defaults_values[$i] === '') {
				$output .= '<em>';
				$output .= __('this value is blank by default', $localname);
				$output .= '</em>';
			} elseif (is_numeric($plugin_defaults_values[$i])) {
				$output .= $plugin_defaults_values[$i];
			} else { 
				$output .= '"' . $plugin_defaults_values[$i] . '"';
			} 
			$output .= '</td>';
			$output .= '</tr>';
		}
		$output .= '</tbody>';
		$output .= '</table>';
		
		return $output;
	}
	function scss3b_get_example_shortcode($shortcodename = '', $sc_defaults, $localname = '') {
		$output = '[' . $shortcodename . ' ';
		
		$plugin_defaults_keys = array_keys($sc_defaults);
		$plugin_defaults_values = array_values($sc_defaults);
		
		for($i = 0; $i < count($plugin_defaults_keys); $i++) {
			if ($plugin_defaults_keys[$i] !== 'show') {
				if (gettype($plugin_defaults_values[$i]) === 'string') {
					$output .= '<strong>' . $plugin_defaults_keys[$i] . '</strong>=\'' . $plugin_defaults_values[$i] . '\'';
				} elseif (gettype($plugin_defaults_values[$i]) === 'boolean') {
					$output .= '<strong>' . $plugin_defaults_keys[$i] . '</strong>=' . ($plugin_defaults_values[$i] == false ? 'false' : 'true');
				} else {
					$output .= '<strong>' . $plugin_defaults_keys[$i] . '</strong>=' . $plugin_defaults_values[$i];
				}
				if ($i < count($plugin_defaults_keys) - 2) {
					$output .= ' ';
				}
			}
		}
		$output .= ']';
		
		return $output;
	}
	function scss3b_get_example_php_code($shortcodename = '', $internalfunctionname = '', $sc_defaults) {
		$plugin_defaults_keys = array_keys($sc_defaults);
		$plugin_defaults_values = array_values($sc_defaults);
		
		$output = '<pre style="background:#FFF">';
		$output .= 'if (shortcode_exists(\'' . $shortcodename . '\')) {<br />';
		$output .= '  $atts = array(<br />';
		for($i = 0; $i < count($plugin_defaults_keys); $i++) {
			$output .= '    \'' . $plugin_defaults_keys[$i] . '\' => ';
			if (gettype($plugin_defaults_values[$i]) === 'string') {
				$output .= '\'' . $plugin_defaults_values[$i] . '\'';
			} elseif (gettype($plugin_defaults_values[$i]) === 'boolean') {
				$output .= ($plugin_defaults_values[$i] == false ? 'false' : 'true');
			} else {
				$output .= $plugin_defaults_values[$i];
			}
			if ($i < count($plugin_defaults_keys) - 1) {
				$output .= ', <br />';
			}
		}
		$output .= '<br />  );<br />';
		$output .= '   echo ' . $internalfunctionname . '($atts);';
		$output .= '<br />}';
		$output .= '</pre>';
		return $output;	
	}
	function scss3b_checkifset($optionname, $optiondefault, $optionsarr) {
		return (isset($optionsarr[$optionname]) ? $optionsarr[$optionname] : $optiondefault);
	}
	function scss3b_getlinebreak() {
	  echo '<tr valign="top"><td colspan="2"></td></tr>';
	}
	function scss3b_explanationrow($msg = '') {
		echo '<tr valign="top"><td></td><td><em>' . $msg . '</em></td></tr>';
	}
	function scss3b_getimagefilename($fname = '') {
		return plugins_url(scss3b_get_path() . '/images/' . $fname);
	}
?>