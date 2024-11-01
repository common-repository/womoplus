=== womoplus ===
Contributors: ebenefuenf
Stable tag: trunk
Requires at least: 4.9
Tested up to: 6.6
Requires PHP: 5.6.33
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Provides integration of the womoplus RV rent software to user defined pages. This plugin is only useful for customers of the womoplus RV rent software.

== Description ==

**This plugin is only useful for customers of the womoplus RV rent software.**

Through this app you can integrate the womoplus rent software. The plugin works by loading external javascript code and injecting the womoplus application in the WordPress page you define.

It displays your RVs, allows searching by availability, tag, name etc. Finally the customer can send a booking request.

== Installation ==

1. Prepare a WordPress page where the rent process should be integrated. Add an ID to the HTML element where the app should load.
2. Add the shortcode [womoplus] to this page so that the app can be initialized.
3. Install the womoplus plugin through WordPress directly or manually upload the plugin.
4. Activate the plugin.
5. Use the "Womoplus" settings page to set the page name you prepared earlier.
6. Set the "DOM Element" setting to the id you prepared earlier (prefix with #). There the content will be injected (everything below is replaced).
7. All other settings are optional.
8. In order for URL rewriting (SPA rewrite on page refresh) to work disable/enable the plugin again.
9. Verify that the app loads on your page.
10. Make sure to use https for your site, which is required by DSGVO.

== Changelog ==

= 1.9 =
* Fix styles option was not correctly initialized.

= 1.8 =
* Add scrollTopOffset option.

= 1.7 =
* Add option for custom text in list view.

= 1.6 =
* Add option to only show filters applicable to campers.

= 1.5 =
* Allow disabling of google maps script loading to fix conflicting scripts error.

= 1.4 =
* Remove <base> tag from HTML if existing to fix frontend routing.

= 1.3 =
* Setting "Proxy Prefix": change default and add description.

= 1.2 =
* Only load google places script when places option has been activated.
* Extend Installation Documentation

= 1.1 =
* Fix `script_loader_tag` not returning script correctly.

= 1.0 =
* Initial
