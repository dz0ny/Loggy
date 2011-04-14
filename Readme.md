
# Loggy

Loggy is simple express server for remote logging with simple api and websockets.

## Installation PHP

  Include loggy.php in your wordpress instalation and activate the plugin. After that you can use functions $Loggy->debug(); and $Loggy->info(); in your code; 

## Instalation node.js

	npm install loggy
  See example/server.js if you want to use cluster.

## API
  
  POST @server/v1/info #info(string) and JSON encoded trace(array)->path and trace(array)->line
  POST @server/v1/debug #debug(string) and JSON encoded trace(array)->path and trace(array)->line

## License 

(The MIT License)

Copyright (c) 2011 Janez Troha &lt;janez.troha@gmail.com&gt;

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
'Software'), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.