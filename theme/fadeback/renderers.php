<?php
class theme_fadeback_core_renderer extends core_renderer {

    public function heading($text, $level = 2, $classes = 'main', $id = null) {
 
 	if($level == 2) {
    $content  = html_writer::start_tag('div', array('class'=>'headingwrap'));
    $content .= parent::heading($text, $level, $classes, $id);
    }
   	else {
    $content  = parent::heading($text, $level, $classes, $id);
    }
    if($level == 2) {
    $content .= html_writer::end_tag('div');
    }
    return $content;
}
       
        

    //end class
 
}