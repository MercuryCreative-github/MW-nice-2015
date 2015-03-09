<?php

class menu_titles_widget extends WP_Widget
{

    function menu_titles_widget(){
        $widget_ops = array(
            'classname' => 'menu_titles_widget',
            'description' => '-TMF Menu titles'
        );
        $this->WP_Widget('menu_titles_widget', "-TMF Menu titles", $widget_ops);       
    }

    function widget( $args, $instance )
    {
        extract($args);
        extract($instance);

        echo $before_widget;
 
        ?>
        <div id='list_titles_widget' class='widget list_titles_widget'>
            <div class="home-titles"><h4><?php echo $menu_title;?></h4></div> 
        </div>
            
        <?php
 
        echo $after_widget;
}

function update( $new_instance, $old_instance )
 {
    $instance = $old_instance;
    $instance['menu_title']  =  strip_tags( $new_instance['menu_title'], '<p><a><strong><ul><li>' );
 
    return $instance;
    }


 function form( $instance ){
    $defaults = array(
                'menu_title' => 'Enter title'                
            );
    $instance = wp_parse_args((array )$instance, $defaults);
    ?>
    <p>
        <label for="<?php echo $this->get_field_id('menu_title'); ?>">Title</label>
        <input  class="widefat" 
                id="<?php echo $this->get_field_id('menu_title'); ?>" 
                name="<?php echo $this->get_field_name('menu_title'); ?>" 
                type="text" 
                value="<?php echo esc_attr($instance["menu_title"]); ?>" 
        />
    </p>
   

    <?php } 
}
?>