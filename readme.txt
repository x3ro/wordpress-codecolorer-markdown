=== Plugin Name ===
Contributors: x3ro
Donate link: http://github.com/x3ro/wordpress-codecolorer-markdown
Tags: codecolorer, markdown, syntax, highlighting
Requires at least: 3.0
Tested up to: 3.4.1
Stable tag: v0.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Enables CodeColorer for any code block created by the markdown-for-wordpress-and-bbpress
plugin.


== Description ==

This plugin automatically wraps Markdown code blocks (indented by 4 spaces or a tab)
in CodeColorer tags. You can also specify what language the given snippet uses, by using
the following syntax:

        :ruby:
        class Foo < Bar
        end

That is, the name of the language, as you'd use it when creating a CodeColorer block,
enclosed by two colons on the very first line of the code snippet.

The source code repository can be found over at
[GitHub](http://github.com/x3ro/wordpress-codecolorer-markdown).

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload plugin folder to the `/wp-content/plugins/` directory
2. Make sure you have **codecolorer** and **markdown-for-wordpress-and-bbpress** installed
2. Activate the plugin through the 'Plugins' menu in WordPress


== Changelog ==

= 0.1-alpha =

First released version. Not extensively tested yet.
