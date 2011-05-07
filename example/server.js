var app = require("Loggy");
app.listen(80);
console.log("Loggy server listening on port %d", app.address().port);