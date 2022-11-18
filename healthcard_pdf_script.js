var system = require('system');
var page = require('webpage').create();

page.paperSize = {
    format: 'A4',
    margin: '0px'
};

page.viewportSize = { width: 595, height: 842 };

var $url = system.args[1];
var $file_name = system.args[2];
page.open($url, function(status) {
    
    console.log("Status: " + status);
    
    if(status === "success") {
        
        page.evaluate(function() {
            
            jQuery("link").each(function(i, v) {
                jQuery(v).attr("media", "all");
            });
            
            jQuery('body').prepend('<style>a[href]:after { content : " " !important; }</style>');
            
        });
        
        page.render($file_name,{format: 'pdf'});
    }
    
    phantom.exit();
    
});