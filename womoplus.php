<?php

defined('ABSPATH') or die('No script kiddies please!');

/*

Plugin Name: womoplus
Description: Provides integration of the womoplus rent software.
Version:     1.9
Author:      ebenefuenf.de
License:     GPL2

womoplus plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

womoplus plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with womoplus plugin. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

function womoplus($atts)
{
    $options = get_option('womoplus_options');

    return "<script type=\"text/javascript\">"
        . "var base = document.getElementsByTagName('base')[0];"
        . "if (base) {base.parentNode.removeChild(base)};"
        . "neorent.init({"
        . "host: '" . $options['proxyprefix'] . "',"
        . "base: '/" . $options['base'] . "',"
        . "element: '" . $options['element'] . "',"
        . "styles: '" . str_replace(["\r\n", "\r", "\n"], '', $options['styles']) . "',"
        . "ui: {"
        . "dsgvo: '" . $options['dsgvo'] . "',"
        . "email: '" . $options['email'] . "',"
        . "showHomeLink: " . (boolval($options['showhomelink']) ? 'true' : 'false') . ","
        . "showSales: " . (boolval($options['showsales']) ? 'true' : 'false') . ","
        . "usePlacesFilter: " . (boolval($options['useplaces']) ? 'true' : 'false') . ","
        . (boolval($options['camperfilters']) ? 'useTagsFilter: false,' : '')
        . (boolval($options['camperfilters']) ? 'useDimensionsFilter: false,' : '')
        . (boolval($options['camperfilters']) ? 'useBedLayoutFilter: false,' : '')
        . (boolval($options['camperfilters']) ? 'useBerthsWidthFilter: false,' : '')
        . "noResultText: '" . $options['noresulttext'] . "',"
        . "objectListText: '" . $options['objectlisttext'] . "',"
        . "bookingDateText: '" . $options['bookingdatetext'] . "',"
        . "bookingFooterText: '" . $options['bookingfootertext'] . "',"
        . "minCalendarRange: " . (int)$options['mincalendarrange'] . ","
        . "scrollTopOffset: " . (int)$options['scrolltopoffset'] . ","
        . "}});</script>";
}

add_shortcode("womoplus", "womoplus");


// ADMIN
add_action('admin_init', 'womoplus_admin_init');
function womoplus_admin_init()
{
    register_setting('womoplus-options', 'womoplus_options', 'plugin_options_validate');
    add_settings_section('womoplus_main', __('Main Settings', 'womoplus'), 'womoplus_main_section_text', 'womoplus');
    add_settings_field('womoplus_proxyprefix', __('Proxy Prefix', 'womoplus'), 'womoplus_proxyprefix_field', 'womoplus', 'womoplus_main');
    add_settings_field('womoplus_base', __('Page Name (URL Base)', 'womoplus'), 'womoplus_base_field', 'womoplus', 'womoplus_main');
    add_settings_field('womoplus_element', __('DOM Element', 'womoplus'), 'womoplus_element_field', 'womoplus', 'womoplus_main');
    add_settings_field('womoplus_dsgvo', __('DSGVO URL (for link in booking form)', 'womoplus'), 'womoplus_dsgvo_field', 'womoplus', 'womoplus_main');
    add_settings_field('womoplus_email', __('Your Email', 'womoplus'), 'womoplus_email_field', 'womoplus', 'womoplus_main');
    add_settings_field('womoplus_homelink', __('Show index in Navigation', 'womoplus'), 'womoplus_homelink_field', 'womoplus', 'womoplus_main');
    add_settings_field('womoplus_sales', __('Show sales area', 'womoplus'), 'womoplus_sales_field', 'womoplus', 'womoplus_main');
    add_settings_field('womoplus_useplaces', __('Use Google Places Search', 'womoplus'), 'womoplus_useplaces_field', 'womoplus', 'womoplus_main');
    add_settings_field('womoplus_notloadplaces', __('Do not load google maps script (to avoid conflicts with already loaded script)', 'womoplus'), 'womoplus_notloadplaces_field', 'womoplus', 'womoplus_main');
    add_settings_field('womoplus_camperfilters', __('Show filters for campers only', 'womoplus'), 'womoplus_camperfilters_field', 'womoplus', 'womoplus_main');
    add_settings_field('womoplus_mincalendarrange', __('Min. Calendar Range Selection', 'womoplus'), 'womoplus_mincalendarrange_field', 'womoplus', 'womoplus_main');
    add_settings_field('womoplus_scrolltopoffset', __('scrollTopOffset', 'womoplus'), 'womoplus_scrolltop_field', 'womoplus', 'womoplus_main');
    add_settings_field('womoplus_noresulttext', __('Custom text after no result', 'womoplus'), 'womoplus_noresulttext_field', 'womoplus', 'womoplus_main');
    add_settings_field('womoplus_objectlisttext', __('Custom text in vehicle list', 'womoplus'), 'womoplus_objectlisttext_field', 'womoplus', 'womoplus_main');
    add_settings_field('womoplus_bookingdatetext', __('Custom text after booking date', 'womoplus'), 'womoplus_bookingdatetext_field', 'womoplus', 'womoplus_main');
    add_settings_field('womoplus_bookingfootertext', __('Custom footer text', 'womoplus'), 'womoplus_bookingfootertext_field', 'womoplus', 'womoplus_main');
    add_settings_field('womoplus_styles', __('Custom CSS Styles', 'womoplus'), 'womoplus_styles_field', 'womoplus', 'womoplus_main');
}
function womoplus_main_section_text()
{
    echo '<p>' . _e('Settings to integrate womoplus in your site.', 'womoplus') . '</p>';
}
function womoplus_proxyprefix_field()
{
    $options = get_option('womoplus_options');
    $proxyprefix = (!isset($options['proxyprefix'])) ? 'https://office.womoplus.de/api/public/' : $options['proxyprefix'];
    echo "<input name='womoplus_options[proxyprefix]' size='40' type='text' value='{$proxyprefix}' placeholder='Expert users only'>";
}
function womoplus_base_field()
{
    $options = get_option('womoplus_options');
    $base = (!isset($options['base'])) ? 'reisemobile' : $options['base'];
    echo "<input name='womoplus_options[base]' size='40' type='text' value='{$base}' />";
}
function womoplus_element_field()
{
    $options = get_option('womoplus_options');
    $element = (!isset($options['element'])) ? '#app' : $options['element'];
    echo "<input name='womoplus_options[element]' size='40' type='text' value='{$element}' />";
}
function womoplus_dsgvo_field()
{
    $options = get_option('womoplus_options');
    echo "<input name='womoplus_options[dsgvo]' size='40' type='text' value='{$options['dsgvo']}' />";
}
function womoplus_email_field()
{
    $options = get_option('womoplus_options');
    echo "<input name='womoplus_options[email]' size='40' type='text' value='{$options['email']}' />";
}
function womoplus_homelink_field()
{
    $options = get_option('womoplus_options');
    echo "<input name='womoplus_options[showhomelink]' type='checkbox' value='1' " . checked('1', $options['showhomelink']) . "/>";
}
function womoplus_sales_field()
{
    $options = get_option('womoplus_options');
    $sales = !isset($options['showsales']) ? '0' : $options['showsales'];
    echo "<input name='womoplus_options[showsales]' type='checkbox' value='1' " . checked('1', $sales) . "/>";
}
function womoplus_useplaces_field()
{
    $options = get_option('womoplus_options');
    $useplaces = !isset($options['useplaces']) ? '0' : $options['useplaces'];
    echo "<input name='womoplus_options[useplaces]' type='checkbox' value='1' " . checked('1', $useplaces) . "/>";
}
function womoplus_notloadplaces_field()
{
    $options = get_option('womoplus_options');
    $notloadplaces = !isset($options['notloadplaces']) ? '0' : $options['notloadplaces'];
    echo "<input name='womoplus_options[notloadplaces]' type='checkbox' value='1' " . checked('1', $notloadplaces) . "/>";
}
function womoplus_camperfilters_field()
{
    $options = get_option('womoplus_options');
    $camperfilters = !isset($options['camperfilters']) ? '0' : $options['camperfilters'];
    echo "<input name='womoplus_options[camperfilters]' type='checkbox' value='1' " . checked('1', $camperfilters) . "/>";
}
function womoplus_mincalendarrange_field()
{
    $options = get_option('womoplus_options');
    $cal = !isset($options['mincalendarrange']) ? '5' : $options['mincalendarrange'];
    echo "<input name='womoplus_options[mincalendarrange]' size='2' type='text' value='{$cal}' />";
}
function womoplus_scrolltop_field()
{
    $options = get_option('womoplus_options');
    $cal = !isset($options['scrolltopoffset']) ? '10' : $options['scrolltopoffset'];
    echo "<input name='womoplus_options[scrolltopoffset]' size='2' type='text' value='{$cal}' />";
}
function womoplus_noresulttext_field()
{
    $options = get_option('womoplus_options');
    echo "<textarea name='womoplus_options[noresulttext]' rows='4' cols='50'>{$options['noresulttext']}</textarea>";
}
function womoplus_objectlisttext_field()
{
    $options = get_option('womoplus_options');
    echo "<textarea name='womoplus_options[objectlisttext]' rows='4' cols='50'>{$options['objectlisttext']}</textarea>";
}
function womoplus_bookingdatetext_field()
{
    $options = get_option('womoplus_options');
    echo "<textarea name='womoplus_options[bookingdatetext]' rows='4' cols='50'>{$options['bookingdatetext']}</textarea>";
}
function womoplus_bookingfootertext_field()
{
    $options = get_option('womoplus_options');
    echo "<textarea name='womoplus_options[bookingfootertext]' rows='4' cols='50'>{$options['bookingfootertext']}</textarea>";
}
function womoplus_styles_field()
{
    $options = get_option('womoplus_options');
    echo "<textarea name='womoplus_options[styles]' rows='4' cols='50'>{$options['styles']}</textarea>";
}

add_action('admin_menu', 'womoplus_setup_menu');
function womoplus_setup_menu()
{
    add_menu_page('Womoplus', 'Womoplus', 'manage_options', 'womoplus-options', 'womoplus_options_page');
}

function womoplus_options_page()
{
?>
    <div class="wrap">
        <h1><?php _e('Womoplus Options', 'womoplus'); ?></h1>
        <form action="options.php" method="post">
            <?php settings_fields('womoplus-options'); ?>
            <?php do_settings_sections('womoplus'); ?>
            <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
        </form>
    </div>
<?php
}

// i18n init
function womoplus_i18n_setup()
{
    load_plugin_textdomain('womoplus', false, dirname(plugin_basename(__FILE__)) . '/lang/');
}
add_action('after_setup_theme', 'womoplus_i18n_setup');


// include js and set attributes for script tag
function include_scripts()
{
    $pagename = get_query_var('pagename');
    $options = get_option('womoplus_options');
    $base = $options['base'];
    // only include on user defined page
    if ($pagename === $base) {
        wp_enqueue_script('womoplus', 'https://office.womoplus.de/neorent.js');

        if ($options['useplaces'] === '1' && $options['notloadplaces'] !== '1') {
            wp_enqueue_script('google_places', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAlP7eSEcvj-auDAH-4RLXUE2PDKl9PtWc&libraries=places');
        }
    }
}
add_action('wp_enqueue_scripts', 'include_scripts');

function add_js_attributes($tag, $handle)
{
    if ($handle === 'womoplus') {
        return str_replace('<script ', '<script crossorigin="anonymous" ', $tag);
    } else if ($handle === 'google_places') {
        return str_replace('<script ', '<script async ', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_js_attributes', 10, 2);

// URL rewrite
function womoplus_rewrite()
{
    $options = get_option('womoplus_options');
    $base = $options['base'];
    if (!empty($base)) {
        add_rewrite_rule($base . '/(.*)$', 'index.php?pagename=' . $base, 'top');
    }
}
function plugin_activate()
{
    womoplus_rewrite();
    flush_rewrite_rules();
}
function plugin_deactivate()
{
    flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'plugin_activate');
register_deactivation_hook(__FILE__, 'plugin_deactivate');

//add rewrite rules in case another plugin flushes rules
add_action('init', 'womoplus_rewrite');

// error_log("debug")
