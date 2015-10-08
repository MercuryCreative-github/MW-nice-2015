<?php
 
class tmf_widget extends WP_Widget {
 
    function tmf_widget(){
         $widget_ops = array('classname' => 'tmf_widget', 'description' => "Banner Home" );
        parent::__construct('tmf_widget', "Banner Home", $widget_ops);
    }
 
     function widget($args,$instance){
        echo $before_widget;    
        ?>
      <?php wp_addpub ( "bannerID=3" ) ; ?>
        <?php
        echo $after_widget;
    }
 
    function update($new_instance, $old_instance){
          
    }
 
    function form($instance){
       
    }    
} 
 
?>