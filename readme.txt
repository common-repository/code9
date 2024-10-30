=== Code9 ===
Contributors: Code9fair
Donate link: https://paypal.me/code9fair
Tags: 2FA,2-step login,WordPress authentication,two step authentication,verification password,anti brute force login,xmlrpc.php
Requires at least: 4.1
Tested up to: 6.2
Stable tag: 1.0.13
Requires PHP: 5.6.4
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
 
Code9 2-step verification code for users. utility tool for wordpress. lightweight and high performance.

== Description ==

== 2-Step Verification Code ==

Code9 2-step verification code will add more protection to site admin area.

* Allow admin to create 2-step verification code to every user.
* Allow user to create 2-step verification code after active plugin.
* Can change 2-step verification code anytime at profile setting page.
* Blocked. if user type 2-step verification code wrong more than 4 attemps.
* Admin can force all user to type 2-step verification code again.
* Admin can active and deactive 2-step verification code anytime.

== Anti Brute Force ==

Prevent attacker from continuous login. (Including xmlrpc.php) 
* If plugin detects that there is a continuous login. Plugin will redirect user to Recapcha page before allow user to continue login.

== Installation ==

* Upload the Code9 plugin to your site.
* Ativate plugin.
* On admin menu (left side menu of admin area) click Code9.
* Check Use 2 step sign in verification code

== Screenshots ==

1. Active 2-step verification code.
2. When user sign in but does not set up 2-step verification code. Plugin will force user to create new 2-step verification code.
3. Confirm 2-step verification code.
4. If user already setup 2-step verification code. Plugin will ask user to input 2-step verification code.
5. User can change 2-step verification code anytime at profile setting page.
6. User input wrong 2-step verification code.
7. If user input 2-step verification code wrong more than 4 attemps. Account will locked.
8. User can try 2-step verification again when locked time is up.
9. Install and activate Code9 plugin.
10. Prevent user to continuous login if user has repeatedly entering wrong username or password.

== Changelog ==

= 1.0.1 =
 * Add function anti brute force attack.
= 1.0.2 =
* Use include functions instead of require.
= 1.0.3 =
* Downgrade plugin minimum requirement to PHP version 5.6.4 and Wordpress version 4.1
* Fixed bug can't force all user to sign out 2-step verification.
= 1.0.4 =
* Add Logs tabs to show who is trying to login to your site but fail.
= 1.0.5 =
* Show data on log tabs when attacker try to login more than 2 attempts. 
= 1.0.6 =
* Add 2 step verification code blocking time setting.
= 1.0.7 =
* Extract single static file to multiple files.
= 1.0.8 =
* Remove unnecessary static file.
= 1.0.9 =
* Add design to error page when user can not pass 2-step verification.
= 1.0.10 =
* Only admin role delete_others_posts can edit setting.
= 1.0.11 =
* Fixed table log to full width when no log data.
= 1.0.12 =
* Fixed force to logout when use Wordpress with Cloudflare.
= 1.0.13 =
* Fixed bug Wrong security IP.