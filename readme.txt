=== Plugin Name ===
Contributors: dz0ny
Donate link: http://example.com/
Tags: debug, logging
Requires at least: 3.0
Tested up to: 3.1
Stable tag: 1.1

Loggy is simple express server for remote logging with REST API and Wordpress plugin.

== Description ==

## Instalation node.js

    npm install loggy

  See example/server.js if you want to use cluster or 

    var app = require("Loggy");
    app.listen(3000);
    console.log("Loggy server listening on port %d", app.address().port);

##Usage

  Visit localhost:3000 install bookmarklet and activate it on wordpress installation. Then where you want to use it

    global $Loggy;
    $Loggy->debug(string..array..object);    
    $Loggy->info(string..array..object);      

== Installation ==

    Edit loggy.php to fit your needs, especially secret_key and server.
    Include loggy.php in your Wordpress installation and activate the plugin.
    After that you can use functions $Loggy->debug(); and $Loggy->info(); in your code;

