
/**
 * Module dependencies.
 */

var express = require('express');
var nowjs = require("now");

var app = module.exports = express.createServer();
var sync = nowjs.initialize(app);
// Configuration

app.configure(function(){
  app.set('views', __dirname + '/../views');
  app.set('view engine', 'jade');
  app.use(express.bodyParser());
  app.use(express.methodOverride());
  app.use(express.compiler({ src: __dirname + '/../public', enable: ['less'] }));
  app.use(app.router);
  app.use(express.static(__dirname + '/../public'));
});

app.configure('development', function(){
  app.use(express.errorHandler({ dumpExceptions: true, showStack: true })); 
});

app.configure('production', function(){
  app.use(express.errorHandler()); 
});

// Routes

app.get('/', function(req, res){
  res.render('index', {
    title: 'Loggy'
  });
});

app.post('/1/info', function(req, res){
  sync.now.InfoLog(req.body.stack, req.body.info, req.headers["user-agent"]);
  res.send(); 
});

app.post('/1/debug', function(req, res){
  sync.now.DebugLog(req.body.stack, req.body.info, req.headers["user-agent"]);
  res.send(); 
});
// Only listen on $ node app.js

if (!module.parent) {
  app.listen(3000);
  console.log("Express server listening on port %d", app.address().port);
}
