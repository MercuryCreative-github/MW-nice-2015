<?php
	/*
	Template Name: Planner
	*/
	get_header(); 
	the_post(); 
	$option = get_option('montreal_theme_options'); 
?>

<div class="container" style="background:url(<?php echo $option['background_image']; ?>);">

<section class="row white bigpadding">

<section class="row bigtoppadding midbottompadding">

<h3 class="blacktext bold midbottommargin center uppercase"><?php the_title(); ?></h3>
<div class="three columns alpha centered blackhorizontal"></div>
<div class="eight columns centered smalltoppadding">
<div class="meta center"><?php the_content(); ?></div>
</div>
</section>

<script type="text/javascript">
	function CheckAllTranslated(x)
	{
	   
	if (ISBLANK(x.fieldnm_1.value)) 
		{ 	
			    alert('<?php _e('Please define value for Your name field !!', 'montreal'); ?>');
	    	    return false;
	    }
	
	if (ISBLANK(x.fieldnm_2.value)) 
		{ 	
			    alert('<?php _e('Please define value for Your E-mail field !!', 'montreal'); ?>');
	    	    return false;
	    }
	
	if (ISBLANK(x.fieldnm_11.value)) 
		{ 	
			    alert('<?php _e('Please define value for Your project budget field !!', 'montreal'); ?>');
	    	    return false;
	    }
	
	 
		 return true;
	}
</script> 

          <section class="row">
                <div class="ten columns centered smallpadding">
                    <form method="post" action="<?php echo get_template_directory_uri(); ?>/email_scripts/projectplanner.php" onsubmit="return CheckAllTranslated(this);" id="form1">
                        <h6 class="extrabold smallbottompadding"><?php _e('Hello there', 'montreal'); ?></h6>

                        <div class="row">
                            <dl class="field six columns">
                                <dd><label for="name"><?php _e('Your Name*', 'montreal'); ?></label></dd>

                                <dt class="text"><input type="text" id="name" name="fieldnm_1" data-form="required"></dt>
                                <input type="text" id="check" name="fieldnm_99">

                                <dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
                            </dl>

                            <dl class="field six columns">
                                <dd><label for="email"><?php _e('Your E-mail*', 'montreal'); ?></label></dd>

                                <dt class="text"><input type="text" id="email" name="fieldnm_2" data-form="required"></dt>

                                <dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
                            </dl>
                        </div>

                        <div class="row">
                            <dl class="field six columns">
                                <dd><label for="telephone"><?php _e('Telephone number', 'montreal'); ?></label></dd>

                                <dt class="text"><input type="text" id="telephone" name="fieldnm_3"></dt>
								<dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
                            </dl>

                            <dl class="field six columns">
                                <dd><label for="company"><?php _e('Company name', 'montreal'); ?></label></dd>

                                <dt class="text"><input type="text" id="company" name="fieldnm_4"></dt>
								<dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
                            </dl>
                        </div>

                        <div class="row">
                            <dl class="field six columns">
                                <dd><label for="website"><?php _e('Website URL (if applicable)', 'montreal'); ?></label></dd>

                                <dt class="text"><input type="text" id="website" name="fieldnm_5"></dt>
								<dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
                            </dl>

                            <dl class="field six columns">
                                <dd><label for="location"><?php _e('Your location', 'montreal'); ?></label></dd>

                                <dt class="text"><input type="text" id="location" name="fieldnm_6"></dt>
								<dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
                            </dl>
                        </div>

                        <h6 class="largetoppadding smallbottompadding extrabold"><?php _e('Project details', 'montreal'); ?></h6>

                        <dl class="field row">
                            <dd><label for="message"><?php _e('Please describe your project concept or idea', 'montreal'); ?></label></dd>

                            <dt class="textarea">
                            <textarea id="message" name="fieldnm_7"></textarea></dt>
							<dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
                        </dl>

                        <div class="row">
                            <dl class="field six columns">
                                <dd><label for="req"><?php _e('Project requirements', 'montreal'); ?></label></dd>

                                <dt class="text"><input type="text" id="req" name="fieldnm_8" placeholder="<?php _e('Website, Branding, Mobile App etc', 'montreal'); ?>"></dt>
                            <dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
							</dl>

                            <dl class="field six columns">
                                <dd><label for="start"><?php _e('When do you hope to start', 'montreal'); ?></label></dd>

                                <dt class="text"><input type="text" id="start" name="fieldnm_9" data-form="required"></dt>
                            <dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
							</dl>
                        </div>

                        <div class="row">
                            <dl class="field six columns">
                                <dd><label for="launch"><?php _e('When do you hope to launch', 'montreal'); ?></label></dd>

                                <dt class="text"><input type="text" id="launch" name="fieldnm_10"></dt>
                            <dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
							</dl>

                            <dl class="field six columns">
                                <dd><label for="budget"><?php _e('Your budget*', 'montreal'); ?></label></dd>

                                <dt class="text"><input type="text" id="budget" name="fieldnm_11" data-form="required"></dt>

                                <dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
                            </dl>
                        </div>

                        <h6 class="largetoppadding smallbottompadding extrabold"><?php _e('Design and feel', 'montreal'); ?></h6>

                        <dl class="field row">
                            <dd><label for="look"><?php _e('Please describe your desired look and feel', 'montreal'); ?></label></dd>

                            <dt class="textarea">
                            <textarea id="look" name="fieldnm_12" placeholder="<?php _e('Clean, Modern, Minimal, Fun etc', 'montreal'); ?>"></textarea></dt>
                        <dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
						</dl>

                        <dl class="field row">
                            <dd><label for="insp"><?php _e('Any inspiration for your project', 'montreal'); ?></label></dd>

                            <dt class="textarea">
                            <textarea id="insp" name="fieldnm_13" placeholder="<?php _e('Website or design you like etc', 'montreal'); ?>"></textarea></dt>
                        <dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
						</dl>

                        <dl class="field row">
                            <dd><label for="extra"><?php _e('Anything else you want us to know', 'montreal'); ?></label></dd>

                            <dt class="textarea">
                            <textarea id="extra" name="fieldnm_14"></textarea></dt>
                        <dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
						</dl><input type="submit" name="Submit" value="<?php _e('Submit','montreal'); ?>" class="submit">
                    </form>

                    <div class="eight columns centered bigtoppadding">
                        <p class="greytext italic center"><span class="blacktext"><?php _e('Privacy Policy:</span>&nbsp; We will never share your information with anyone. We will only contact you with regards to your enquiry.', 'montreal'); ?></p>
                    </div>
                </div>
            
         
            </section>
</section>
</div>
<?php 
	get_footer();