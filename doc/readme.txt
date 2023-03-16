########################################################
# 	Mantis Bugtracker Add-On
# 	CheckPlugin Version 1.02
#	2023 plugin by Cas Nuy www.NUY.info
########################################################

CheckPlugin plugin

This plugin will check each installed plugin for possible updates.
This can be done online via the admin menu or thru a scheduled job.
When online, an overview is presented with the status of your plugins with the option to download the plugin if an update is available.
As a scheduled job, an email is send to the defined email adddress. Message will contain similar information as when the program is executed online.

Prerequisites
The plugin expects to find a file called version.txt in the root of the plugin directory.
This plugin should have 3 entries:
Version: 1.02 #
Devurl: http://www.nuy.info/mantisplugins/CheckPlugin/version.txt #
Location: http://www.nuy.info/mantisplugins/updatedplugin.zip #
Version holds the version of the plugin installed.
This line starts with "Version:" and ends with a "#".
Devurl holds the location of the version.txt file on the site of the developer. This allows easy comparison of the version istalled versus the version available.
This line starts with "Devurl:" and ends with a "#".
Location holds the location from where the updated plugin can be downloaded.
This line starts with "location:" and ends with a "#".
The sequence of the 3 entries is not relevant.

Installation
No tables are required for this plugin.
Plugin should be installed as any other plugin.
Do not forget to configure the plugin after instalation.

Usage
After installion you will find an entry on the manage menu "Check Plugins" where you can activate the check.
In case a plugin cannot be checked, corresponding message will be presented.
In case you would like to schedule a job on your server to run periodically:
This needs to be set up by your admin using either CRON or Windows Scheduled tasks.
In order to run in batch mode, one needs to schedule the following job:
1. exec_check_plugin.php (http://localhost/mantis/plugins/Checkplugin/pages/exec_check_plugin.php)
In addition, ensure to have download location specified within the config, including a valid email address.


GITHUB plugins
In case the plugins are hosted @ Github, the urls need to use the following syntax:
Devurl: https://github.com/mantisbt-plugins/CheckPlugin/blob/main/version.txt #
Location: https://github.com/mantisbt-plugins/CheckPlugin/archive/refs/heads/main.zip #
Replace "CheckPlugin" with the name of your plugin.