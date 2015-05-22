<?php
 /**
 * Plugin Name: Twitter for TMF
 */

class twitter_widget extends WP_Widget {
 
     function twitter_widget(){
        $widget_ops = array('classname' => 'twitter_widget', 'description' => "-TMF Twitter" );
        $this->WP_Widget('twitter_widget', "-TMF Twitter", $widget_ops);
    }
 
      function widget($args,$instance){
        ?>
        <div id='twitter_widget' class='widget twitter_widget'>
            <div class="widget-heading clearfix">
                
                <h2 class="tw-title">Latest on Twitter</h2>
                <script>[CBC country="cn" show="n"]</script><a class="twfollow" title="Follow TM Forum on Twitter" href="https://twitter.com/tmforumorg" target="_blank"><script> [/CBC] </script>
                    <img style="margin-top:15px;" class="alignright size-full wp-image-1723" alt="followtw" src="/wp-content/themes/flexform-child/images/followtw.png" width="93" height="31" />
                <script>[CBC country="cn" show="n"]</script></a><script> [/CBC] </script>
                <script>[CBC country="cn" show="n"]</script><a class="twitter-timeline" width"100%" height="380" href="https://twitter.com/tmforumorg" data-widget-id="365265624051617792" data-chrome="noheader transparent" data-link-color="#338ECC" data-border-color="#ffffff" data-tweet-limit="3" data-src-2x="false" data-src="false" >
                    Tweets by @tmforumorg
                </a><script> [/CBC] </script>
                <script>
                [CBC country="cn" show="n"]
                    !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
                [/CBC]
                </script>
            </div>
        </div>
        <div class="clear"></div>
    <?php }
};
?>