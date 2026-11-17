=== Page As Subdomain Lite ===
Contributors: zinger252
Donate link: https://webostock.com/market-item/wordpress-page-as-subdomain-pro/8860/
Tags: subdomain, pages, seo, page
Requires at least: 5.0
Requires PHP: 7.2
Tested up to: 7.1
Stable tag: 2.6.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Convert page into Subdomain, instantly convert any WordPress page to subdomain, i.e. page-name.site.com

== Description ==


As the title WordPress Page as Subdomain Lite says it all this plugin convert any of your single page into sub domain used for wordpress seo.

WordPress Page as Subdomain Pro empower WordPress to easily convert any single page into Subdomains for website.

= IMPORTANT =


Do not forget to setup a WildCard Subdomain.

= Usage =

[youtube https://www.youtube.com/watch?v=Vdcu7M5VT4c]

With Better Voice
[youtube https://www.youtube.com/watch?v=MOWZXJz17-I]

Simply Create a Page. Then Visit Pages > Subdomains > Select Page from dropdown and hit Save Settings.
You may require one time Configuration of adding Wildcard Subdomain but most of the Host already did it. 
If you want to know how to add Wildcard Subdomain 
[Click here](https://codex.wordpress.org/Configuring_Wildcard_Subdomains/)



= Pro Features =

- Convert All Pages to Subdomain

- Exclude Pages

- Login Cookie


[Get Pro](https://webostock.com/market-item/wordpress-page-as-subdomain-pro/8860/)


= Related Plugins =
[Post As Subdomain Free](http://wordpress.org/plugins/post-as-subdomain-free)
[Post As Subdomain Pro](https://webostock.com/market-item/wordpress-post-subdomain-pro-2/31781/)
[Category Subdomain Pro](https://webostock.com/market-item/category-subdomain-pro/31782/)
[WooCommerce Category Subdomain Pro](https://webostock.com/market-item/woocommerce-category-subdomain-pro-2/31783/)
[Page as Subdomain Pro](https://webostock.com/market-item/wordpress-page-subdomain-pro/31776/)


= Troubleshoot =

Getting Logged out issue?
Set following in your wp-config.php replace domain.com with your domain, notice the dot before domain.

`define('COOKIE_DOMAIN', '.domain.com');
define('COOKIEPATH', '/');
define('COOKIEHASH', md5('domain.com'));`



No  Access-Control-Allow-Origin 
Add following to your .htaccess file.

THIS WILL BE YOUR COMPLETE HTACCESS FILE. [CLICK HERE](https://pastebin.com/s9HSZfps)

`Header set Access-Control-Allow-Origin "*"`


= Discussion about SEO and Subdomains =
[youtube https://www.youtube.com/watch?v=G_3ySITP4O8]

== External services ==

This plugin works on your own server. It contacts these services only in the cases below:

1. **alisaleem252.com newsletter** - only if the "Subscribe to our Newsletter" box on the settings screen is ticked when you press Save Settings. Your site administrator email address and display name are sent once per email address. Untick the box to opt out. Privacy policy: https://alisaleem252.com/privacy_policy.html
2. **WordPress.org** - the optional "More Addons" buttons download a plugin from WordPress.org when you press Install.
3. **YouTube** - the settings screen embeds a tutorial video from youtube.com. Privacy policy: https://policies.google.com/privacy

Subdomain rewrite rules are generated on your own server. Nothing is fetched to build them.

== Installation ==

1. Unzip `zip` and Upload Folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Set up a wildcard subdomain DNS record (*.yoursite.com) with your host.
1. Visit Pages > Subdomain, choose a page from the dropdown and press Save Settings.


== Frequently Asked Questions ==

= How to configure a WildCard Subdomain =

Read the following tutorial [Configuring_Wildcard_Subdomains](https://codex.wordpress.org/Configuring_Wildcard_Subdomains)


= Where do I choose the page? =

In the admin go to Pages > Subdomain, pick the page from the dropdown and press Save Settings.

= Do child pages work on the subdomain? =

Yes. If the selected page is "shop", its child page "shop/sizes" opens at shop.yoursite.com/sizes/ (up to three levels deep).

= Is it compatible with the Post as Subdomain plugins? =

Yes, version 2.6.0 can run next to Post as Subdomain Free and Pro.


== Changelog ==

= 2.6.0 =
* Faster: subdomain rewrite rules are now built on your own server. Before, every subdomain visit waited on a request to an external server (about 2 seconds) and the site rewrote its rules on every page view.
* Fixed: the subdomain no longer shows the wrong page when other subdomain plugins are active.
* Fixed: child pages and grandchild pages of the selected page now open on the subdomain.
* Fixed: saving settings stored a stray extra value; the page is now validated and must be a published page.
* Fixed: a PHP warning/fatal when the rules server was unreachable.
* Security: the settings save and the addon installer now check permissions and nonces properly, and only the listed addons can be installed.
* Privacy: the usage-tracking request was removed (no admin email is sent while rules are built), so the Do Not Track option is gone. The newsletter email is now sent once per address, not on every save.
* Changed: the text domain is now page-as-subdomain-lite, output is escaped, and removing the plugin deletes its settings.

= 2.5.6 =
* Added optional newsletter subscription checkbox on save (checked by default).

= 2.5.1 =
* Minor Bug fixed

= 2.5 =
* fixed URLs not working in admin panel

= 2.3 =
* js elementor fix

= 2.2 =
* Added Do not track option, to disable tracking of email address and added privacy policy.
* Files Structure changed.

= 2.0.1 =
* Added SSL Seurity

= 2.0 =
* Added Seurity

= 1.5 =
* Added Dropdown to select a page.
* Added link to WildCard Configuration Giude.
* Few bug fixed.

= 1.2 =
* Bug Fixed

== Upgrade Notice ==

= 2.6.0 =
Much faster subdomains, fixes a conflict with other subdomain plugins and removes the usage-tracking request. Recommended for all users.

= 1.5 =
This Version will fix few bugs, will also show dropdown in the subdomain menu, made easier for users to find their page.

= 1.2 =
This Version will fix few bugs.