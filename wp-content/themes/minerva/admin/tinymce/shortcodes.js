// Creates a new plugin class and a custom listbox
tinymce.create('tinymce.plugins.shortcodes', {
    createControl: function(n, cm) {
        switch (n) {
            case 'shortcodes':
                var mlb = cm.createListBox('shortcodes', {
                    title : 'Shortcodes',
                    onselect : function(v) {
                    
                        // Get selected text
                        tinyMCE.execCommand('mceInsertContent',false,v);
                    
                    }
                });
                
                // Add some values to the list box
                mlb.add('Dropcap', '[dropcap][/dropcap]');
                mlb.add('Pullquote Left', '[pullquote_left][/pullquote_left]');
                mlb.add('Pullquote Right', '[pullquote_right][/pullquote_right]');
                mlb.add('Tabs', '[tabs]'+"\r\n"+'[tab title="your title here"]your content here[/tab]'+"\r\n"+'[/tabs]');
                mlb.add('Toggle', '[toggle title="your title here"]your content here[/toggle]'); 
                mlb.add('Bullet List', '[bulletlist][/bulletlist]');
                mlb.add('Check List', '[checklist][/checklist]');
                mlb.add('Arrow List', '[arrowlist][/arrowlist]');
                mlb.add('Image', '[image source="" align=""]');
                mlb.add('Info Box', '[info][/info]');
                mlb.add('Success Box', '[success][/success]');
                mlb.add('Warning Box', '[warning][/warning]');
                mlb.add('Error Box', '[error][/error]');
                mlb.add('Button', '[button link=""][/button]');
                mlb.add('Google Map', '[gmap width="" height="" latitude="" longitude="" zoom="" html="" popup=""]');
                mlb.add('Youtube Video', '[youtube_video id= width="" height=""]');
                mlb.add('Vimeo Video', '[vimeo_video id= width="" height=""]');        
                mlb.add('Line', '[line]');               
                mlb.add('One Fourth', '[col_214][/col_214]');
                mlb.add('One Fourth (last)', '[col_214_last][/col_214_last]');
                mlb.add('One Third', '[col_297][/col_297]');
                mlb.add('One Third (last)', '[col_297_last][/col_297_last]');
                mlb.add('One Half', '[col_461][/col_461]');
                mlb.add('One Half (last)', '[col_461_last][/col_461_last]');
                mlb.add('Two Third', '[col_629][/col_629]');
                mlb.add('Two Third (last)', '[col_629_last][/col_629_last]');
            return mlb;                

        }
        return null;
    }
});
// Register plugin with a short name
tinymce.PluginManager.add('shortcodes', tinymce.plugins.shortcodes);
tinyMCE.init({
  plugins : 'shortcodes', // - means TinyMCE will not try to load it
  theme_advanced_buttons1 : 'shortcodes' // Add the new example listbox to the toolbar
});