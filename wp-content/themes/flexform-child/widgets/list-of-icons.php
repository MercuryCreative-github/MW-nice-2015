<?php
 

class list_icons_widget extends WP_Widget{

    function list_icons_widget(){
        $widget_ops = array('classname' => 'list_icons_widget', 'description' => "Icons Menu TMF" );
        parent::__construct('list_icons_widget', "Icons Menu TMF", $widget_ops);
    }

   

     function widget( $args, $instance )
    {
 
        $list_icon_item_texto0   = $instance['list_icon_item_texto0'];
        $image_icon   =  $instance['image_icon'];
        $list_icon_item_texto      = $instance['list_icon_item_texto'];
        $list_icon_item_url      = $instance['list_icon_item_url'];
 
 
        echo $before_widget;
 
        ?>
        <div id='list_icons_widget' class='widget list_icons_widget'>

          
<?php if($instance["list_icon_item_texto0"]){ ?>
<div class="home-titles"><h4><?=$instance["list_icon_item_texto0"]?></h4></div>


<?php } ?>
<div class="home-list-icon">
    <ul><li <?php if($instance["list_icon_item_texto0"]){ ?> class="first" <?php } ?>>
            <a href="<?php echo $instance["list_icon_item_url"]; ?>"><img src="<?php echo $instance["image_icon"]; ?>" alt="<?php echo $instance["list_icon_item_texto"]; ?>"></a>
            <a class="list-agenda-link" href="<?php echo $instance["list_icon_item_url"]; ?>"><?php echo $instance["list_icon_item_texto"]; ?></a>
            <a class="list-agenda-link" href="<?php echo $instance["list_icon_item_url"]; ?>"><?php echo $instance["list_icon_item_texto2"]; ?></a>
        </li>

   </ul></div>
<?php if($instance["list_icon_item_texto0"]){ ?>
    
<div class="clear"></div>  
<?php } ?>
            
            
        </div>
            
        <?php
 
        echo $after_widget;
    }

 function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;
 
        $instance['list_icon_item_texto0']  =  strip_tags( $new_instance['list_icon_item_texto0'], '<p><a><strong><ul><li>' );
        $instance['image_icon']             =  strip_tags( $new_instance['image_icon']);
        $instance['list_icon_item_texto']   =  strip_tags( $new_instance['list_icon_item_texto'], '<p><a><strong><ul><li>' );
        $instance['list_icon_item_url']     =  strip_tags( $new_instance['list_icon_item_url'], '<p><a><strong><ul><li>' );
 
        return $instance;
    }


    function form( $instance )
    {
       
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('list_icons_texto0'); ?>">Title</label>
                <small>This is mandatory for the first item but it should be empty on the rest</small>
                <input class="widefat" id="<?php echo $this->get_field_id('list_icon_item_texto0'); ?>" name="<?php echo $this->get_field_name('list_icon_item_texto0'); ?>" type="text" value="<?php echo esc_attr($instance["list_icon_item_texto0"]); ?>" />
            </p>  
            <div>
                <label>Image</label>
                <input class="widefat" placeholder="http://" id="<?php echo $this->get_field_id('image_icon'); ?>" name="<?php echo $this->get_field_name('image_icon'); ?>" type="text" value="<?php echo esc_attr($instance["image_icon"]); ?>" />

            </div>
            <p>
                <label for="<?php echo $this->get_field_id('list_icon_item_texto'); ?>">Text</label>
                <input class="widefat" placeholder="" id="<?php echo $this->get_field_id('list_icon_item_texto'); ?>" name="<?php echo $this->get_field_name('list_icon_item_texto'); ?>" type="text" value="<?php echo esc_attr($instance["list_icon_item_texto"]); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('list_icon_item_url'); ?>">Link</label>
                <input class="widefat" id="<?php echo $this->get_field_id('list_icon_item_url'); ?>" name="<?php echo $this->get_field_name('list_icon_item_url'); ?>" type="text" value="<?php echo esc_attr($instance["list_icon_item_url"]); ?>" />
            </p> 
        <?php
    }
 
   
 

}

?>