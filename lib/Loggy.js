
/**
 * Module dependencies.
 */

var express = require('express');
var nowjs = require("now");

var allowed_domains = [];
var my_secret_key = false;
// Configuration

function allowDomain (domain) {
  allowed_domains.push(domain)
}
module.exports.allowDomain = allowDomain;

function secretKey (key) {
  my_secret_key = key;
}
module.exports.secretKey = secretKey;

if (!module.parent) {
  my_secret_key = "mysecretkey"
}

if (my_secret_key) {
  var app = module.exports = express.createServer();
  var sync = nowjs.initialize(app);

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
      title: 'Loggy',
      server_location: app.address().address +":"+ app.address().port
    });
  });

  app.post('/1/info', function(req, res){
    console.log(req)
    if (req.body.secret_key === my_secret_key) {
      sync.now.InfoLog(req.body.stack, req.body.info, req.headers["user-agent"]);
      res.send(); 
    }else{
        res.send("Wrong secret key!"); 
    }
  });

  app.post('/1/debug', function(req, res){
    if (req.body.secret_key === my_secret_key) {
      sync.now.DebugLog(req.body.stack, req.body.info, req.headers["user-agent"]);
      res.send(); 
    }else{
        res.send("Wrong secret key!"); 
    }
  });
}else{
  console.log("Configure your secret key with app.secretKey('some string');");
}
// Only listen on $ node app.js

if (!module.parent) {
  app.listen(3000);
  console.log("Express server listening on port %d", app.address().port);
}
