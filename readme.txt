=== MyAnimeList Widget ===
Contributors: Vievern
Donate link: http://www.vievern.com/wordpress_plugins
Tags: myanimelist, mal, anime, parsing, myanimelist.net, widget, feed, rss
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: trunk

Plugin adds widget that shows your last updates on http://myanimelist.net (parsing)

== Description ==

Plugin adds widget that shows your last updates on http://myanimelist.net (parsing)
You can choose what type of parsing use:

* Once Per Day (option) - Caching your updates in option in WP-database, parsing only one time per day.
* Once Per Day (file) - Caching your updates in file `cache.html` in plugin-directory, parsing only one time per day.
* Always - Parsing every time when widget showing.

Also, you can config widget's CSS (from widget-control) with `#mal_parsed` parent-style and change widget title.

== Installation ==

1. Upload `myanimelist-widget` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Go to `Widgets` menu in wp-admin and configurate plugin (you need to change username).
1. Place `MAL Last List Updates` widget to your wp-theme sidebar.

== Screenshots ==

1. MyAnimeList Widget - Configuration
2. MyAnimeList Widget - Sidebar Widget

== Frequently Asked Questions ==

= What is it "MyAnimeList"? =

MyAnimeList.net was created by an anime fan, for anime fans. It was designed from the ground up to give the user a quick and no-hassle way to catalog their anime or manga collection. Over 40,000 users sign in every day to help build the world's largest social anime and manga database and community.

Created and actively maintained by [Garrett Gyssler](http://myanimelist.net/profile/Xinil)

= What is it "MyAnimeList Widget (plugin)"? =

Plugin adds widget that shows your last updates on http://myanimelist.net (parsing)

= How to config MyAnimeList Widget? =

Go to `Widgets` menu in wp-admin and configurate plugin (You must change username. Maybe css and title too).

== Changelog ==

= 1.1 =
* Added file-caching

= 1.0 =
* First release.

== Upgrade Notice ==

= 1.1 =
If you don't like option-caching - update plugin for file-caching. You must change your MAL username again, if you update plugin automatically.

= 1.0 =
This version is first release of this plugin.