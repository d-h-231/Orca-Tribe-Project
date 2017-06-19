(function() {
    tinymce.create("tinymce.plugins.orca_button_plugin", {

        //url argument holds the absolute url of our plugin directory
        init : function(ed, url) {

            //add new button     
            ed.addButton("dropcap", {
                title : "Dropcap",
                cmd : "dropcap_command",
                image : url + '/dropcap.png'
            });
            
            ed.addButton("pullquote", {
                title: 'Pullquote',
		        image: url + '/pullquote.png',
		        cmd : "pullquote_command"
            });

            //button functionality.
            ed.addCommand("dropcap_command", function() {
                var selected_text = ed.selection.getContent();
                var return_text = "<span style='font-size: 80px; float: left; paddint-right: 7px; line-height: 72px'>" + selected_text + "</span>" + "-";
                ed.execCommand("mceInsertContent", 0, return_text);
            });
            
            ed.addCommand("pullquote_command", function(){
                ed.windowManager.open( {
                    title: 'Pullquote',
                    body: [{
                        type: 'textbox',
                        minHeight: 200,
                        minWidth: 600,
                        multiline: true,
                        name: 'quoteBox',
                        tooltip: 'Enter quote here',
                        label: 'Quote',
                        },
                        
                        {
                            type: 'textbox',
                            name: 'sourceBox',
                            label: 'Source',
                        },
                        
                        {
                            type: 'listbox',
                            name: 'float',
                            tooltip: 'Align on page',
                            label: 'Float',
                            'values': [
                                {text: "left", value: "l"},
                                {text: "center", value: "c"},
                                {text: "right", value: "r"}
                            ]
                        }
                          ],
                    onsubmit: function( e ) {
                        if (e.data.float == "l"){
                         ed.insertContent("<div style= 'float: left; font-size: 20px; width: 50%; margin: 16px'>" + e.data.quoteBox + "<br>" + "<span style='font-style: italic; float: right; font-size: 20px; text-transform: uppercase; color: grey; font-weight: bold'>" + "-" + e.data.sourceBox + "</span>" + "</div>" + "-");
                        }
                        else if (e.data.float == "c"){
                          ed.insertContent("<div style= 'font-size: 20px; width: 100%; margin: 16px'>" + e.data.quoteBox + "<br>" + "<span style='font-style: italic; float: right; font-size: 20px; text-transform: uppercase; color: grey; font-weight: bold'>" + "-" + e.data.sourceBox + "</span>" + "</div>" + "-");
                        }
                        else{
                           ed.insertContent("<div style= 'float: right; font-size: 20px; width: 50%; margin: 16px'>" + e.data.quoteBox + "<br>" + "<span style='font-style: italic; float: right; font-size: 20px; text-transform: uppercase; color: grey; font-weight: bold'>" + "-" + e.data.sourceBox + "</span>" + "</div>" + "-");
                        }
                    }
                });
            });
        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : "Orca Buttons",
                author : "Michael Hall",
                version : "0.8"
            };
        }
    });

    tinymce.PluginManager.add("orca_button_plugin", tinymce.plugins.orca_button_plugin);
})();
