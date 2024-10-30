=== LS Buddypress Activity plus tabs extension ===
Contributors: lenasterg, NTS on cti.gr
Tags: BuddyPress, group, activity, tabs, widgets, extension
Requires at least: WP 5.9
Requires Plugins: buddypress, bp-activity-plus-reloaded
Tested up to: WP 6.1.1
Stable tag: 4.0
License:  GNU General Public License 3.0 or newer (GPL)
License URI: https://www.gnu.org/licenses/gpl.html

Extends the functionality of Activity Plus Reloaded for BuddyPress plugin by adding related tabs in each group.

== Description ==
Extends the functionality of 'Activity Plus Reloaded for BuddyPress' plugin, by adding tabs in a group for the uploaded Photos (images), Videos, Links and related widgets. 
Requires Activity Plus Reloaded for BuddyPress plugin (https://wordpress.org/plugins/bp-activity-plus-reloaded/) to by installed.
Tested up to BuddyPress 11.0

== Installation ==
1. Upload plugin folder `/LS-buddypress-activity-plus-tabs/` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==
1. How can I hide a tab or a widget?
Answer: The plugin uses the Activity Plus Reloaded for BuddyPress plugin's settings,  allowed items. 
In case you want to hide more tabs or widgets or you have Activity Plus Reloaded for BuddyPress lower than version 1.0.8 you can:
-  for hiding tabs use the filter 'ls_bpfb_allowed_tabs'
-  for hiding widgets  use the filter 'ls_bpfb_allowed_widgets'


== Screenshots ==
1. Tabs (Links, Videos, Images) in group's navigation bar
2. BuddyPress Group's Videos widget 
3. BuddyPress Group's Videos widget in a single group in frontend

== Changelog ==

= 4.0 (27 January 2023) =
* Compatibility check for WP 6.1.1 and BuddyPress 11.0
* Compatibility with Activity Plus Reloaded for BuddyPress plugin version 1.0.8
* New widgets for 'Group Links', 'Group Videos' and 'Group Images'
* Filters for hiding tabs ('ls_bpfb_allowed_tabs') and widgets ('ls_bpfb_allowed_widgets')
* Code optimization. 
* Added 'Requires plugin header'

= 3.0 =
* Added compatibility with Activity Plus Reloaded for BuddyPress plugin

= 2.9.3 (23 November 2017) =
* Compatibility fixes 

= 2.9.2 (16 March 2017) =
* Compatibility check for WP 4.7.3 and BuddyPress 2.8.2

= 2.9.1 (17 April 2015) =
* Fix a typo which prevented the image tab to show up.

= 2.9 (6 April 2015) =
* Add widget for current group

= 2.8 (17.11.2014) =
 * "Add new" buttons added

= 2.7 (22.10.2013) =
 * Fix for not Buddypress ready themes

= 2.6 (22.10.2013) =
 * Fix some notices

= 2.5 (16.10.2013) =
 * Improved  syntax for lighter mysql queries

= 2.4 (9.9.2013) =
*Fix a typo
* Added FAQ how to hide a tab

= 2.3 (5.9.2013) =
* Fix a bug which broke the RSS feeds

= 2.2 (13.8.2013) =
* Fix a bug which occured when checking if buddypress activity plugin active


= 2.1 (9.8.2013) =
* Remove parentheses from items count

= 2.0 (2.8.2013) =
* Change visibility of tabs to private
* Fix a bug which displayed the tabs on the create group steps

= 1.0 (30.7.2013) =
* Initial version 