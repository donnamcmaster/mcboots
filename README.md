## Synopsis

McBoots is a WordPress template (parent theme) based on the Bootstrap 3 framework. It borrows heavily from Underscores (_s), UnderStrap (_strap), Roots/Sage, and the purely functional code of Cully Larson. But you can blame Donna McMaster for anything that doesn't work right.

## Motivation

I build a lot of small to medium-sized custom-designed, responsive WordPress sites and need a good clean starting point. Goals:

* Clean, simple, just what's needed and no more. 
* DRY (Don't Repeat Yourself), which meant removing HTML framework code from the standard template files (single.php, page.php, index.php, etc.)
* Follow the "WordPress Way" when it doesn't conflict with the above. 

## Status

I developed McBoots in early August 2016. As of June 2018, it's live on six sites plus two WIPs. Consider it Beta level, and please check the code and functionality for yourself before trusting it. Here are the main unfinished pieces: 

* several areas are still WIP, including comments and entry meta for post_type 'post'
* app.css and the bootstrap js files are not currently being minimized

## Installation and Setup

I'm not including build files with the project at this time. The only file that needs compilation is assets/less/app.less. It is compiled into assets/css/app.css. App.less includes the bootstrap files. 

I made one modification, to pick up variables.less from a copy in assets/less instead of from assets/less/bootstrap. This is because I find it easier to set colors, fonts, and other values in variables.less rather than overriding them later. If you prefer not to touch the Bootstrap distro, edit assets/less/bootstrap/bootstrap.less to pick up variables.php from the bootstrap directory instead. 

To understand the HTML wrapper code, look at layout.php and lib/layout-wrapper.php. lib/layout-wrapper.php uses the WordPress 'template_include' filter to capture the main content, and then passes it to layout.php, which embeds it into the wrapper. 

## Contributors

I appreciate your letting me know (via message or pull request) if you find any problems or see areas for improvement. You can contact me [via email](https://www.donnamcmaster.com/contact/ "at my website") or on Twitter as [@mcdonna](https://twitter.com/mcdonna). 

## License

Licensed under [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html).
