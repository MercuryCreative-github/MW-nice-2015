<?php

class calendar_widget extends WP_Widget {

     function calendar_widget(){
        $widget_ops = array('classname' => 'calendar_widget', 'description' => "-TMF Calendar" );
        $this->WP_Widget('calendar_widget', "-TMF Calendar", $widget_ops);
    }

      function widget($args,$instance){
        extract($args);
        echo $before_widget;
        ?>
        <div id='calendar_widget' class='widget calendar_widget'>

<?php
if($instance["calendar_color"]){ $color=$instance["calendar_color"]; } else {$color = '#FFFFFF'; }
?>

<div class="widget-heading clearfix"><?php if($instance["calendar_texto0"]){ ?><h4><?=$instance["calendar_texto0"]?></h4><?php } ?></div>

<div class="nday" style="margin-bottom:10px;">
<div class="dday" style="background:<? echo $color ?>">
<p>
<?php if($instance["calendar_texto"]){ ?><?=$instance["calendar_texto"]?><?php } else {?>JUN<?php } ?><br>
<span><?=$instance["calendar_texto2"]?></span>
</p>
</div>
<div class="fday">
<strong><?=$instance["calendar_texto3"]?></strong><br>
<?=$instance["calendar_texto4"]?>
</div>
</div>

<div class="clear"></div>

</div>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance){
        $instance = $old_instance;
		$instance["calendar_texto0"] = strip_tags($new_instance["calendar_texto0"],'<span></br><br>');
        $instance["calendar_texto"] = strip_tags($new_instance["calendar_texto"]);
        $instance["calendar_texto2"] = strip_tags($new_instance["calendar_texto2"]);
        $instance["calendar_texto3"] = strip_tags($new_instance["calendar_texto3"]);
        $instance["calendar_texto4"] = strip_tags($new_instance["calendar_texto4"]);
        $instance["calendar_color"] = strip_tags($new_instance["calendar_color"]);

        return $instance;
    }

     function form($instance){
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('calendar_texto0'); ?>">Title</label>
            <input class="widefat" id="<?php echo $this->get_field_id('calendar_texto'); ?>" name="<?php echo $this->get_field_name('calendar_texto0'); ?>" type="text" value="<?php echo esc_attr($instance["calendar_texto0"]); ?>" />
         </p>
         <p>
            <label for="<?php echo $this->get_field_id('calendar_texto'); ?>">Month</label>
            <input class="widefat" placeholder="JUN" id="<?php echo $this->get_field_id('calendar_texto'); ?>" name="<?php echo $this->get_field_name('calendar_texto'); ?>" type="text" value="<?php echo esc_attr($instance["calendar_texto"]); ?>" />
         </p>
         <p>
            <label for="<?php echo $this->get_field_id('calendar_texto2'); ?>">Day Number</label>
            <input class="widefat" id="<?php echo $this->get_field_id('calendar_texto2'); ?>" name="<?php echo $this->get_field_name('calendar_texto2'); ?>" type="text" value="<?php echo esc_attr($instance["calendar_texto2"]); ?>" />
         </p>
         <p>
            <label for="<?php echo $this->get_field_id('calendar_texto3'); ?>">Day Name / Event Title</label>
            <input class="widefat" id="<?php echo $this->get_field_id('calendar_texto3'); ?>" name="<?php echo $this->get_field_name('calendar_texto3'); ?>" type="text" value="<?php echo esc_attr($instance["calendar_texto3"]); ?>" />
         </p>
         <p>
            <label for="<?php echo $this->get_field_id('calendar_texto4'); ?>">Time</label>
            <input class="widefat" id="<?php echo $this->get_field_id('calendar_texto4'); ?>" name="<?php echo $this->get_field_name('calendar_texto4'); ?>" type="text" value="<?php echo esc_attr($instance["calendar_texto4"]); ?>" />
         </p>
         <!--p>
            <label for="<?php echo $this->get_field_id('calendar_color'); ?>">Color</label>
            <input class="widefat" placeholder="#009FE3,#0082C9,#0063A4,#013B81" id="<?php echo $this->get_field_id('calendar_color'); ?>" name="<?php echo $this->get_field_name('calendar_color'); ?>" type="text" value="<?php echo esc_attr($instance["calendar_color"]); ?>" />
         </p-->
         <?php
    }
}

?>
