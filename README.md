plugin-table2csv
================

Create a csv file from the first table on a dokuwiki page

Installation
============
1. Install the branch version of the Tools plugin from https://github.com/TomCafferty/plugin-tools/zipball/master.
2. Install the table2csv plugin using the Plugin Manager and the download URL above. 
   If you install this plugin manually, make sure it is installed in lib/plugins/table2csv/

Usage
=====
Add the following plugin code. This will provide an export selection. 
  ~~TOOLS:both~~
Add the following plugin code. This will be used to identify the table because by specifying a start marker of any text on the page the plugin will select the first table following the start marker.  The startmarker cannot be part of the table such as a column heading or caption. Replace "any text" with your start marker. No quotes are used unless thay are in your start marker.
<table2csv>&startMarker=any text&</table2csv>
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


