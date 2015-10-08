<?php
if (!class_exists('separator_widget')):
    class separator_widget extends WP_Widget
    {

        function separator_widget()
        {
            $widget_ops = array('classname' => 'separator_widget', 'description' =>
                    '-TMF Separator');
            parent::__construct('separator_widget', "-TMF Separator", $widget_ops);
        }

        function widget($args, $instance)
        {
            extract($args);

            $height = $instance['height'];
            $checkbox = $instance['border'];
            if ($checkbox) {
                $border = 'border:none';
            } else {
                $border = 'border-top:#CACACA 1px solid';
            }
            ;
            echo $before_widget; ?>
            <div style="height:1px; margin: <?php echo $height*0.5.'px 0; ' . $border; ?>"></div>
        <?php echo $after_widget;
        }

        function update($new_instance, $old_instance)
        {
            $instance = $old_instance;
            $instance['height'] = strip_tags($new_instance['height']);
            $instance['border'] = strip_tags($new_instance['border']);

            return $instance;
        }

        function form($instance)
        {
            $defaults = array(
                'height' => '60',
                'border' => '0'
            );
            $instance = wp_parse_args((array )$instance, $defaults);
        ?>
            <p>This is a simple separator</p>
             <p>
                <label for="<?php echo $this->get_field_id('height'); ?>">Separator Height</label>
                <input class="widefat"
                    placeholder="60"
                    id="<?php echo $this->get_field_id('height'); ?>"
                    name="<?php echo $this->get_field_name('height'); ?>"
                    type="text"
                    value="<?php echo esc_attr($instance['height']); ?>"
                />
            </p>
            <p>
                <div style="float:left; margin-right:10px">
                    <input  type="radio"
                            name="<?php echo $this->get_field_name('border'); ?>"
                            value="1" <?php if ($instance['border']) { echo 'checked';} ?>
                            id="<?php echo $this->get_field_id('border'); ?>">Hide Line
                </div>
                <div style="float:left">
                    <input  type="radio"
                            name="<?php echo $this->get_field_name('border'); ?>"
                            value="0"
                            id="<?php echo $this->get_field_id('border'); ?>" <?php if (!$instance['border']) {echo 'checked';} ?>>Show Line
                </div>
                <div style="clear:both"></div>
            </p>
    <?php
        }
    }
endif;
?>
