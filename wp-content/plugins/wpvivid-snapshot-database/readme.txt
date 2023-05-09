=== Database Snapshots - WPvivid ===
Contributors: wpvivid
Tags: snapshot, database snapshot, database restore, rollback, database rollback
Requires at least: 4.5
Tested up to: 6.2
Requires PHP: 5.3
Stable tag: 0.9.4
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

Create snapshots of a WordPress database quickly.

== Description ==
WPvivid Database Snapshots allows you to quickly create snapshots of all tables in your WordPress database.

= Why Use Database Snapshots? =

Making a database snapshot is much faster than making a database backup. If you need a quicker rollback solution for safely testing WordPress database-related changes, use a snapshot.

A snapshot contains database only. If you need to back up the full site or files, you can use our free [WPvivid Backup Plugin](https://wordpress.org/plugins/wpvivid-backuprestore/).

== Features Spotlight ==
* Create a snapshot of WordPress database
* Create multiple snapshots
* Comment a snapshot
* Set up a retention for snapshots
* Restore the database from a snapshot
* More features are coming soon

== Minimum Requirements ==
* Character Encoding UTF-8
* PHP version 5.3
* MySQL version 4.1
* WordPress 4.5

== Support ==
We offer free support at the support forum for WPvivid Database Snapshots on WordPress.org.

== Installation and Uninstallation ==

= Install WPvivid Database Snapshot =
1.Go to your sites admin dashboard.
2.Navigate to Plugin Menu and search for WPvivid Database Snapshots.
3.Click Install Now then click Activate Plugin.

= Uninstall WPvivid Database Snapshot =
1.Click Deactivate from the Plugin Menu.
2.Click Delete.

== Privacy Policy and GDPR Compliance ==
WPvivid Database Snapshots is created and operated with full respect and protection of users personal information, and is in full compliance with General Data Protection Regulation(GDPR). Check out the following content to know the details:
= What personal data can WPvivid Database Snapshots access and how is the data processed? =
The free version of WPvivid Database Snapshots is only available to download from WordPress plugin repository. Thus, all the data related to the updates of the versions as well as the support forum for WPvivid Database Snapshots on WordPress.org is held by WordPress.org.
In addition, the implementations of creating snapshots and restoring the database from snapshots happen completely on your website server, there are no data come across any of our servers in the whole process.
The only personal data currently we can access are the contact data when you contact us by email, which may include your name, email address and other contact details. The data will only be used for the purposes of handling and resolving your enquiry.

== License ==
WPvivid Database Snapshots is licensed under GPL version 3 or later.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details:[https://www.gnu.org/licenses/gpl-3.0.en.html](https://www.gnu.org/licenses/gpl-3.0.en.html).

== Screenshots ==
1. Create a snapshot
2. Restore the site from a snapshot
3. WPvivid Database Snapshots settings

== Frequently Asked Questions ==
= What is the main difference between a database snapshot and a database backup?
Making a snapshot is to create a quick copy of all tables of the current website in the database, while making a database backup is to use SQL statements to export the database to an individual .sql file.
Therefore, a snapshot usually works as a quicker solution for short-term situations, for example, a quick rollback after doing database-related testings. While a backup is usually used for long-term data protection.
= What does WPvivid Database Snapshots do? =
WPvivid Database Snapshots enables you to create snapshots of your WordPress database and restore the database from a snapshot.
= Where are the snapshots stored?
Snapshots are stored in the same database for which the snapshots were made. Each snapshot has a unique prefix for it's tables.
= Is it possible to download snapshots? =
We don't offer a direct download option for snapshots. However, you can download snapshots by making a backup of the snapshots tables using WPvivid Backup Pro, then downloading the backup of the snapshots.
= Why does WPvivid Database Snapshots have a limit on snapshots retention=
That is because snapshots take up database space, too many snapshots may slow down the site, especially on shared web hosting.
= Does WPvivid Database Snapshots have a limit on the database size? =
No, WPvivid Database Snapshots does not have a limit on the database size and theoretically works for websites of any sizes.
= Do you provide support for the free version? Where? =
Yes, absolutely. Whenever you need it, help can be found from the support forum on WordPress.org for WPvivid Database Snapshots plugin.

== Contact us ==
Feel free to let us know how we can help using the support forum for WPvivid Database Snapshots on WordPress.org or our [contact form](https://wpvivid.com/contact-us).
== Changelog ==
= 0.9.4 =
- Fixed some bugs in the plugin code.
- Optimized the plugin code.
= 0.9.3 =
- Fixed some bugs in the plugin code.
- Optimized the plugin code.
= 0.9.2 =
- Added an option to create a quick database snapshots.
- Optimized the plugin code.
= 0.9.1 =
- Hello World!