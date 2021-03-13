=== Events by Devllo ===
Contributors: devlloplugins
Tags: calendar, events, event, event manager, event management, fullcalendar
Requires at least: 4.4
Tested up to: 5.7
Requires PHP: 5.5
Stable tag: 1.0.3.1
License: GPLv2 or later

This is a simple event management plugin for adding and listing your events, show event locations on map, link to online Event locations. It also integrates with FullCalendar to show a calendar with all events.


== Description ==
This is a simple event management plugin for adding and listing your events, show event locations on a map, link to online Event locations. It also integrates with FullCalendar to show a calendar with all events.
You can display events list using the shortcode [devllo-events] and the Calendar using [devllo-calendar]


== Installation ==
You can install directly from the Plugin Repository using the Plugins system in WordPress.

= MANUAL INSTALLATION =
Upload devllo-events.php to the /wp-content/plugins/ directory
Activate the plugin through the ‘Plugins’ menu in WordPress

= AFTER INSTALLATION =
The plugin will automatically create the pages Events and Calendar, if those pages don\'t already exist and add the shortcodes [devllo-events] and [devllo-calendar].
You can manually edit the pages to add these shortcodes.

== Screenshots ==
1. Add Event Page showing Event fields.
2. Single Event Page.
3. Event Calendar Page.
4. Event List Page.

== Frequently Asked Questions ==
= Where do I find the settings? =
Under Events -> Settings
This is where you add the Google Map API

= How do I display the events list and Calendar? =
The plugin will automatically create the pages Events and Calendar, if those pages don't already exist and add the shortcodes [devllo-events] and [devllo-calendar].

= I found a bug in the plugin. =
Please post it in the [WordPress support forum](https://wordpress.org/support/plugin/devllo-events/) and we'll look into it as soosn as possible.


== Changelog ==
= 1.0.3 - 12/02/2021 =
Tested and Update WordPress version
BUG FIX: Fixed missing year on single event page
ENHANCEMENT: Added Event Cost Text Box
ENHANCEMENT: Added Date and Time Selector on Event Edit Page


= 1.0.2.2 - 22/01/2021 =
BUG FIX: Fixed Gutenberg Publish/Update Error

= 1.0.2.1 - 21/01/2021 =
BUG FIX: Fix Add On Menu

= 1.0.2 - 20/01/2021 =
BUG FIX: Fix styling error on single event page
ENHANCEMENT: Add Add-Ons Page
ENHANCEMENT: Fix styling on settings page

= 1.0.1 - 20/09/2020 =
BUG FIX: Fix styling error from Bootstrap on WooCommerce pages

= 1.0.0 - 19/09/2020 =
ENHANCEMENT: Add Event Organiser Checkbox Option on Settings Page
ENHANCEMENT: Add Event Comments Checkbox Option on Settings Page
ENHANCEMENT: Add Select Pages options for Events and Calendar Pages
ENHANCEMENT: Add Option to select between two different Events Page Template
ENHANCEMENT: Add Blog Grid Styled Template for Events Page Template
ENHANCEMENT: Add Action Hooks

= 0.4.2 - 01/09/2020 =
Fix wrong URL bug on admin top menu
Fix text domain error
Add hooks on single event page
Fix Header styling
Hide Events admin bar for non admins
Don't show Map and Event Details headings if empty

= 0.4 - 29/08/2020 =
Fix Event Organiser role capabilities
Add Admin Toolbar

= 0.3.3 - 28/08/2020 =
Fix Translation Issues

= 0.3.2 =
Update Language files.

= 0.3.1 =
Update Readme and banner for initial release.

= 0.3 =
Initial release.
