<?php die() ?>
Admin Tools 2.1.14
================================================================================
~ Layout improvements under Joomla! 1.7
~ Small improvements to DFIShield, making sure that the use of numerous ../ instances won't throw it off
~ The Post-Installation wizard is no longer shown in the Core release, as it's not relevant
~ CSS improvements to the Post-Installation wizard
~ Fix Permissions will automatically skip over the contents of the cache (front- and back-end), tmp and log directories
# Joomla! red error text displayed when updating Joomla! w/out Akeeba Backup installed (thanks, Fotis, for the heads up)
# The Advanced mode of CSRFShield would also run the basic mode (referrer filtering), causing troubles on many sites
# Notices thrown in the post-installation wizard (thank you @ot2sen!)
# #166: Array upload fields break UploadShield
# Under Joomla! 1.7, with "Disable editing back-end users" enabled, you could edit a back-end user and remove him from the Manager/Administrator/Super Administrator group
# Use of wrong constant could throw a warning message in the post-installation wizard
# Joomla! 1.7 session storage could overflow when using the Fix Permissions feature, locking you out of your site until you cleared your browser's cache and cookies

Admin Tools 2.1.13
================================================================================
! A few sites would never get past the post-setup view

Admin Tools 2.1.12
================================================================================
+ Admin Tools update notification emails (Admin Tools Professional only)
+ Joomla! update notification emails (Admin Tools Professional only)
+ Post-installation wizard, just like the one of Akeeba Backup
+ Adding force-reload button to the Joomla! update view, in case something's stuck
~ Removing default .htaccess Maker exceptions (they didn't make much sense and were only meant as examples)
~ Adapting to Joomla's new stupid policy of providing upgrade packages only from the .0 and the immediately previous release (e.g. 1.5.0 to 1.5.25 and 1.5.24 to 1.5.25, but NOT 1.5.23 to 1.5.25)
# Downloading a Joomla! update failed on hosts were the tmp directory is unwritable
# Non-standard administrator templates could have a problem with the Joomla! update icon module hiding everything on the page

Admin Tools 2.1.11
================================================================================
+ #148 Failed logins can optionally count as security exceptions, allowing you to use the automatic IP blocking after a number of failed login attempts
+ Adding an Apply (Joomla! 1.5) / Save (Joomla! 1.7) button in the WAF Configuration page
+ Added back the WAF Exceptions feature on popular request
+ IP lookup link in security exception email
+ More options for the inactive user removal feature
~ Making all back-end links absolute instead of relative
# DFIShield would block JCE's image and file managers
# Access from blacklisted IPs would send out an email and trigger a log message. That's pointless.
# The CHANGELOG div caused a horizontal scrollbar to display
# The Yes/No labels in Configure WAF are always shown in English in Joomla! 1.6 and later
# Notices thrown by pro.php
# Only Super Administrators could access Admin Tools on Joomla! 1.6 and later
# Javascript error thrown by the admin module if the Control Panel admin module is disabled
# Joomla! 1.7 or later changed the way the integrated extension update system works, rendering our update feeds invalid (Note: Live Update was still functional, as it's a standalone update system)
! .htaccess Maker would always allow PHP files inside the templates directory to be web-accessible.

Admin Tools 2.1.10
================================================================================
- Rolling back WAF Exceptions; the feature does not work with SEF enabled and the workaround causes routing issues
# Undefined variable in UploadShield

Admin Tools 2.1.9
================================================================================
# Changelog link not working on Firefox
! The "System - Admin Tools" plugin could interfere with routing

Admin Tools 2.1.8
================================================================================
# Joomla! 1.7.0 to 1.7.1 update failed due to a slightly different package format than what was expected.

Admin Tools 2.1.7
================================================================================
+ Ability to partially override the template= switch for multi-template sites
+ Clean-up inactive users (those who registered, but never logged in)
+ The Joomla! update icon now integrates itself into the Quick Icons module in Joomla! 1.6/1.7
+ IPs in the Administrator Whitelist or the "Never block these IPs" lists will not trigger any security exceptions and not be logged at all
+ Display the CHANGELOG inside the component's Control Panel page
# If your server runs the GeoIP PECL module, Admin Tools causes a PHP Fatal Error
# Clean Temporary Directory feature throws notices and warnings when your tmp directory is already empty
# Yes/No values not translated in Master Password view
# Using Apply (Joomla! 1.5) or Save (Joomla! 1.6+) on a new record, didn't display the just saved record, essentialy acting as Save & New
# The Joomal! update status check icon module was installed hidden in Joomla! 1.6/1.7
# #57 WAF Exceptions not active when SEF is enabled
# Database schema updates were not applied from Joomla! 1.7.0 to 1.7.1 updates
# Undefined variables in Permissions Configuration page cause it to throw notices (kudos to user doorknob on our forum for the fix!)

Admin Tools 2.1.6
================================================================================
~ Update of Akeeba Standard Installion Library for Joomla! 1.6/1.7
+ Added permissions setting 0640 to the list
+ You can now allow access to media files inside cache, includes, language, logs and tmp directories without allowing full access to those directories
# Expired auto-banned IP addresses were not cleaned up
# Minimum access level not honoured under Joomla! 1.5
# Joomla! 1.5 ACL feature: would not list Managers
# Joomla! 1.5: If your access level was lower than the minimum, accessing Admin Tools caused an infinite redirection loop

Admin Tools 2.1.5
================================================================================
+ Ability to upgrade from Joomla! 1.6.5+ straight to Joomla! 1.7, including the necessary database changes and removal of obsolete files
~ Project Honeypot HTTP:BL integration is now standalone and does not require the entire Bad Behaviour integration to be activated
~ Watered down Bad Behaviour itnegration to work around known issues with modern browsers
# Fatal error when trying to access a view restricted by the ACL instead of a redirection taking place
# CSRFShield's advanced method not working
# Workaround for Joomla! 1.6+ bug resulting in "Can not build admin menus" and "DB function reports no error" messages when trying to install the component after a failed installation/update
# Site crash if somehow the component is uninstalled but the plugin is not
# Site crash if somehow the component is uninstalled but the module is not
# Wrong loading order, wouldn't load the JSON workaround class on PHP 5.1 hosts

Admin Tools 2.1.4
================================================================================
! Internal Server Error 500 in the back-end due to class file not being properly loaded

Admin Tools 2.1.3
================================================================================
+ IP lookup link in Exceptions Log and Auto IP Ban pages
# The Joomla! Update feature got confused when running inside a Joomla! 1.7 beta release
# File execution order would always be applied, no matter what the user selected
# Must not allow Admin Tools to upgrade from 1.6 to 1.7 due to schema changes

Admin Tools 2.1.2
================================================================================
# PHP notice thrown when logging a security exception
# The tmpl whitelist in WAF was not being taken into account
# Resetting the IP filter in auto-blocked IP administrator page would result in no records being displayed
# The URL Redirection management page had two forms named adminForm, creating Javascript issues
# Automatic IP block email body would be an untranslated key (ATOOLS_LBL_WAF_AUTOIPBLOCKEMAIL_BODY)
# Enabling the scheduling options in Admin Tools plugin would result in a PHP fatal error
# Minor layout issue in GeoBlocking continents list
# Clicking on the scheduling button in the control panel resulted in an error page on Joomla! 1.6/1.7
# Against common sense, on some servers using JModel outside of a controller *does not* load the respective model and returns false. Ugh!

Admin Tools 2.1.1
================================================================================
- Removed "Anti-leech protection" from .htaccess Maker, as modern browsers stopped sending absolute URIs in the HTTP Referer field
# "cpanelModelCpanel not found" message on Joomla! 1.6's and JCE 1.5.7.x's administrator page
# Sometimes Joomla! wouldn't load the JModel class automatically, leading to a PHP fatal error
# Joomla! 1.6 doesn't run the SQL files on update; ugly but working workaround applied
# Joomla! 1.7-Alpha1 would be proposed instead of Joomla! 1.6.4 as a Joomla! core update

Admin Tools 2.1
================================================================================

+ Adding file permissions mode 0440 to the list
+ Local copy of cacerts.pem allows Live Update and other download requests to work with HTTPS URLs on Windows, CentOS and other servers without a system copy of cacert.pem
+ Do not auto-ban IPs in a configurable safe list or the administrator white list
+ #33 Administration of auto-banned IPs
+ #12 Improved email notifications for Super Administrator log-in
+ #11 Email after automatic IP block
+ Bad Behavior reason added to the Security Exceptions Log and the exception email sent to site administrators
+ #101 Allow direct update from 1.6 to 1.7
+ #32 Allow customisation of Admin Tools' 403 message
~ .htaccess Maker: Improved on-the-fly GZip compression rules compatible with more (and newer!) Apache versions
# The referer filtering would block incoming requests from Google AdWords, PayPal etc when they were requesting dynamic pages (generated on the fly by Joomla!) with a .html suffix.
# Leftover tables on uninstallation
# Fatal error about missing JComponentHelper under some circumstances
# #83 .htaccess Maker settings lost when Joomla! component parameter storage overflows
# Opening the plugin editor through the Control Panel button didn't work in Joomla! 1.6 and above
# You would get a warning that the Admin Tools plugin does not exist on Joomla! 1.6 or 1.7
# Loading the GeoIP include file would cause a problem on systems where the GeoIP PECL extension was already loaded