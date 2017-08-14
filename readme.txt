=== WordPress Cache and CDN plugin - fast, easy to use, instant results ===
Contributors: pigeonhut, Jody Nesbitt, optimisation.io
Tags: Database, DB Cleanup, CDN Rewrite, WordPress Cache, Minify CSS, Minify JS, Easy CDN
Requires at least: 4.6
Tested up to: 4.7.3
Stable tag: 1.1.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Fast, easy to use cache for WordPress with option for 3 separate CDN's. Optimize Database.

== Description ==
<font color="blue"><strong>Fast, easy to use cache</strong></font> for WordPress with option for up-to 3 separate CDN's - for js, css & images from 3 providers.<br>
Added the ability to set and forget <strong>Database cleanups</strong> on a scheduled timescale including removing revisions, cleanup transients, remove comment spam. Generally help keep the Database lean and tidy.

We have many features planned and have an active development cycle which will be user focused based on feedback.

For extra performance we recommend our <a href="https://wordpress.org/plugins/wp-disable/">Disbaler plugin</a>, which helps <strong>reduce HTTP requests</strong> and removes unused items from your website.
For image compression and optimization we recommend our <a href="https://wordpress.org/plugins/wp-image-compression//">Image Compression plugin</a>

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->WP Disable screen to configure the plugin


== Frequently Asked Questions ==

= What about Minification, do I still need it? =

Yes, you absolutely do, and none come close to the awesome <a href="https://en-gb.wordpress.org/plugins/autoptimize/"> Autoptimize</a> by Frank Goossens.

= I would like to contribute/I have an idea =

Please send us any <a href="https://optimisation.io/contact-us/">Feedback</a> if you would like to contribute or have any ideas to add.

= Do I need to use a CDN ? =

No, you do not need to use one, but if you do, we have made it really simple to add on your CDN of choice.  We offer 3 routes for CDN, so you can effectively run 3 CDN's one for JS, CSS & images.<br>
Bare in mind, if you choose to use a CDN, your files will be uploaded and stored on the CDN of choice, please consult their privacy policies.



== Screenshots ==


== Changelog ==
= 1.1.2 =
* Bug fix on DB scheduling
* Updated Visuals

= 1.1.1 =
* Fix for Scheduler on Database optimisation

= 1.1.0 =
* Big update - added support for Database cleanup and optimisation
* Set schedulded DB cleanup

= 1.0.32 =
* Added Support for Gzip on Apache Servers
* Tested back to WP 4.2 and added support.

= 1.0.31 =
bug fix showing errors in dashboard on older PHP installs.

= 1.0.3 =
Moved Navigation under Tools menu to clean up WP sidebar a bit

= 1.0.2 =
bug fix on activation

= 1.0.1 =
Initial commit
Minor Bug fixes and content cleanup
Added paths for 3 x CDN
Added default files for CDN types

= CREDITS =
This WordPress cache plugin is partial based on Cache Enabler which is a fork of Cachify.
