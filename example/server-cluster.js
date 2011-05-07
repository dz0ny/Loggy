var cluster = require('cluster')
   , app = require('Loggy');
 
 cluster(app)
   .use(cluster.logger())
   .use(cluster.stats())
   .use(cluster.pidfiles())
   .use(cluster.cli())
   .use(cluster.repl(8888))
   .listen(3000);

// run with nohup node server.js &