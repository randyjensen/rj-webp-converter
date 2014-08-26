=== RJ WebP Converter ===
Contributors: randyjensen
Donate link: http://www.randyjensen.com/
Tags: webp, responsive, images, rwd, media
Requires at least: 3.9
Tested up to: 3.9.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically convert JPG and PNG images to WebP as they are uploaded to the Media Uploader.

== Description ==

Automatically convert JPG and PNG images to WebP as they are uploaded to the Media Uploader.

== Installation ==

1. Download the plugin zip file
1. Upload the ZIP file through the 'Plugins > Add New > Upload' screen in your WordPress dashboard
1. Activate the plugin through the 'Plugins' menu in WordPress

== Description ==

Automatically convert JPG and PNG images to WebP as they are uploaded to the Media Uploader.

You'll almost certainly need to change the permissions for the cwebp lib file to 744. You can view the FAQ for instructions on how to do that.

== Frequently Asked Questions ==

= The WebP images are not being created =
This is because the file that is needed for conversion is not writable. The file that needs to be modified is: /wp-content/plugins/rj-webp-converter/libs/libwebp-0.4.1-rc1-linux-x86-32/bin/cwebp

You'll need to change the permissions of this file to 744. You can use an FTP program or the command line with something like: "sudo chmod 744 cwebp".

If you want to see the debug output, turn WP_DEBUG on and go to the Media Library and upload a new PNG/JPG image. You should see the error where the image progress meter shows up.

= Does this make WebP versions of all my already uploaded images? =
No. Not yet. It only does images uploaded after you've installed and activated the plugin.

= Does this make my website server WebP images to Chrome/Opera? =
No. It only handles converting the images as you upload them.

== Screenshots ==

== Changelog ==

= 1.0 =
* 2014-08-26
* Initial release

== Upgrade Notice ==

= 1.0 =
* 2014-08-26
* Initial release
