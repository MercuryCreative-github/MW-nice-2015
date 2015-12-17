<?php
/**
 * Plugin Name: TMF Menu icons widget
 */

class menu_icons_widget extends WP_Widget
{

    function menu_icons_widget(){
        $widget_ops = array(
            'classname' => 'menu_icons_widget',
            'description' => '-TMF Menu items with icons'
        );
        parent::__construct('menu_icons_widget', "-TMF Menu items with icons", $widget_ops);       
    }

    function widget( $args, $instance )
    {
        $menu_image_icon        =  $instance['menu_image_icon'];
        $menu_icon_item_texto   = $instance['menu_icon_item_texto'];
        $menu_icon_item_texto2  = $instance['menu_icon_item_texto2'];
        $menu_icon_item_url     = $instance['menu_icon_item_url'];
        $checkbox               = $instance['external'];
        if($checkbox){$external='_blank';}else{$external='_self';};

        ?>
        <div id='list_icons_widget' class='widget list_icons_widget'>

            <div class="home-list-icon">
                <ul>
                    <li linkTo="<?php echo $instance["menu_icon_item_url"]; ?>" external="<?php echo $checkbox;?>">
                        <a target="<?php echo $external;?>" href="<?php echo $instance["menu_icon_item_url"]; ?>"><img src="<?php echo $instance["menu_image_icon"]; ?>" alt="<?php echo $instance["menu_icon_item_texto"]; ?>"></a>
                        <a target="<?php echo $external;?>" class="list-agenda-link" href="<?php echo $instance["menu_icon_item_url"]; ?>"><?php echo $instance["menu_icon_item_texto"]; ?>
                        </br><small><?php echo $instance["menu_icon_item_texto2"]; ?></small></a>
                    </li>
                </ul>
            </div>
             
            <div class="clear"></div>        

        </div>
            
        <?php
 
}

function update( $new_instance, $old_instance )
 {
    $instance = $old_instance;
    $instance['menu_image_icon']         =  strip_tags( $new_instance['menu_image_icon']);
    $instance['menu_icon_item_texto']    =  strip_tags( $new_instance['menu_icon_item_texto'], '<p><a><strong><ul><li>' );
    $instance['menu_icon_item_texto2']   =  strip_tags( $new_instance['menu_icon_item_texto2'], '<p><a><strong><ul><li>' );
    $instance['menu_icon_item_url']      =  strip_tags( $new_instance['menu_icon_item_url'], '<p><a><strong><ul><li>' );
    $instance['external']                =  strip_tags( $new_instance['external']);

 
    return $instance;
    }


function form( $instance ){
    $menu_image_icon = '';
    if(isset($instance['menu_image_icon'])){$menu_image_icon = $instance['menu_image_icon'];}
    ?>
    <p>
        <label for="<?php echo $this->get_field_id('menu_icon_item_texto'); ?>">Text</label>
        <input class="widefat" placeholder="text to display" id="<?php echo $this->get_field_id('menu_icon_item_texto'); ?>" name="<?php echo $this->get_field_name('menu_icon_item_texto'); ?>" type="text" value="<?php echo esc_attr($instance["menu_icon_item_texto"]); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('menu_icon_item_texto2'); ?>">Small Text</label>
        <input class="widefat" placeholder="aditional small text" id="<?php echo $this->get_field_id('menu_icon_item_texto2'); ?>" name="<?php echo $this->get_field_name('menu_icon_item_texto2'); ?>" type="text" value="<?php echo esc_attr($instance["menu_icon_item_texto2"]); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('menu_icon_item_url'); ?>">Link</label>
        <input class="widefat" id="<?php echo $this->get_field_id('menu_icon_item_url'); ?>" name="<?php echo $this->get_field_name('menu_icon_item_url'); ?>" type="text" value="<?php echo esc_attr($instance["menu_icon_item_url"]); ?>" />
    </p>
    <p>
        <div style="float:left"><input type="checkbox" name="<?php echo $this->get_field_name('external'); ?>" value="1" id="<?php echo $this->get_field_id('external'); ?>" <?php if($instance['external']){echo 'checked';}?>>Open in a new tab</div>
        <div style="clear:both"></div>
    </p>
    <p>
        <label for="<?php echo $this->get_field_name( 'menu_image_icon' ); ?>"><?php _e( 'menu_image_icon:' ); ?></label>
       <input name="<?php echo $this->get_field_name( 'menu_image_icon' ); ?>" id="<?php echo $this->get_field_id( 'menu_image_icon' ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $menu_image_icon ); ?>" />
        <input class="upload_menu_image_icon_button" type="button" value="Upload Image" />
        <img class="showIMGphp" src="<?php echo esc_url( $menu_image_icon ); ?>" alt="">
    </p>

    <?php } 
}

add_action('admin_enqueue_scripts', 'menu_of_icons_scripts');

    function menu_of_icons_scripts()
    {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_register_script('menu_of_icons', get_stylesheet_directory_uri() .'/widgets/list_of_icons/menu_of_icons.js', array('jquery'));
        wp_enqueue_script('menu_of_icons');
        wp_enqueue_style('thickbox');
    }

?>