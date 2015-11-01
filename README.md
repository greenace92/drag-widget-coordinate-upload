# drag-widget-coordinate-upload

A wording demo can be found here: http://ambigy.com/account.php

Draggable widget through jQuery with auto-upload of coordinates for later recall and positioning of widget

This is the starting point for a modular website/portfolio creation

The idea is to add widgets which have different content/purposes and their own properties such as size/position

This first part covers a single basic draggable widget which when released, uploads its coordinates to a sql database

When the page is reloaded, the widget is located where it was last dropped

Included are six files:

binoculars.png an icon for a non-functioning button
gear.png an icon for a non-functioning button

Both of these buttons appear next to the draggable widget to indicate how the draggable widget might be modified

dbconnect.php is a file for the mysql database connection
I currently link a database connection file at the top of my php files that require connection to mysql database

index.php is the main file which is what you would use to see the demo
update_coordinate.php is the file used to update the coordinate via AJAX

widgets.sql is the table which would go into the database in this case named ambigy however you would change that to your particular project.

