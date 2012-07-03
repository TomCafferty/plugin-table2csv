plugin-table2csv
================

Create a csv file from the first table on a dokuwiki page

Installation
============
1. Install the Tools plugin.
2. Modify Tools plugin. 
   Upload the files from this release's /tools folder into the respective plugins/tools folders overwriting the baseline tools plugin files. 
   (Note: If you were using the tools plugin save your current tools/conf/default.php file. 
    The update will turn off all other tools. 
    After the update modify the new default.php file to turn the tools you were using back on in the variable $conf['tools']).
3. Install the tabl22csv plugin using the Plugin Manager and the download URL above. 
   If you install this plugin manually, make sure it is installed in lib/plugins/table2csv/

Usage
=====
Add the following plugin code. This will provide an export selection. 
  ~~TOOLS:both~~
The file page should display the plugin Tools selection to Export To csv in the top and bottom right corners of the page. 
Select this to export the first table into a csv file. 
The filename and path can be specified in the /conf/default.php file. 
It currently defaults to table.csv in the dokuwiki base install folder.

License
=======
Copyright (C) Tom Cafferty <tcafferty@glocalfocal.com>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; version 2 of the License

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.


