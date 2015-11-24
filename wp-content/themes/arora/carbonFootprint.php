<?php

 $arr  = array(
		array("Petrol(l)", "petrol", 2.33, "Please enter your petrol usage (in numericals)", false),
		array("Diesel Fuel(l)" , "diesel_fuel", 2.68, "Please enter your diesel fuel (in numericals)", false),
		array("Auto LPG(kg)", "auto_lpg", 3.06, "Please enter the amount of auto LPG you use (in numericals)", false),
		array("Taxis(km)", "taxis", 0.31, "Please enter the approximate km you travel by taxi (in numericals)", false),
		array("Local bus(km)", "local_bus", 0.05, "Please enter the approximate km travelled by bus (in numericals)", false),
		array("Autorickshaw", "autorickshaw", 0.05, "Please enter the approximate km travelled by autorickshaw (in numericals)", false),
		array("Local train(km)", "local_train", 0.01, "Please enter the approximate km travelled by train (in numericals)", false),
		array("Number of LPG cylinders used for cooking", "lpg_cyl", 42.5, "Please enter the number of LPG cylinders used for cooking(in numericals)", false),
		array("Amount of CNG used at home(m3)", "cng", 1.82, "Please enter the amount of CNG used (in numericals)", false),
		array("Electricity used (kWh)", "electricity", 0.9, "Please enter the kilowatts of electricity used (in numericals)", false)
	);

$len = count($arr);
//If the form is submitted
if(!empty($_POST)) {	
	//Check to see if the honeypot captcha field was filled in
	if(!isset($_POST['checking']) or trim($_POST['checking']) !== '') {
		$captchaError = true;
	} else {
		for($i=0;$i < $len; $i++){
			if(trim($_POST[$arr[$i][1]]) == '' or !preg_match('/^\d+$/',$_POST[$arr[$i][1]]) ){
				$arr[$i][4]= true;
				$hasError = true;
			}
		}
		//If there is no error, send the email
		if(!isset($hasError)) {
			$numTrees = 0;
			for($i=0; $i< $len; $i++){
				$numTrees += $_POST[$arr[$i][1]] * $arr[$i][2];
			}
		}
	}
} ?>
<?php get_header(); ?>

<link rel="stylesheet" type="text/css" src="<?php echo get_template_directory_uri(); ?>/bootstrap.min.css">
<div class="row">


<!--Content-->
 <div id="sub_banner">
<h1>
<?php the_title(); ?>
</h1>
</div>
<div id="content">
<div class="top-content">

                   <?php if(have_posts()): ?><?php while(have_posts()): ?><?php the_post(); ?>
                <div <?php post_class(); ?> id="post-<?php the_ID(); ?>"> 
                
                <div class="post_content">
                   
                   <!-- <a class="postimg"><?php the_post_thumbnail('medium'); ?></a>
                   
                   
                   <div class="metadate"> <?php edit_post_link(); ?></div> -->
	                  	<?php if(!isset($hasError) && isset($numTrees)) { ?>

							<div class="thanks">
								<h1>Thanks, for trying us out</h1>
								<p>The total number of trees you need to plant to offset your carbon footprint is <?=$numTrees;?></p>
							</div>

						<?php } else { ?>
							<h1> Find out your carbon footprint</h1>
							<p> Are you curious about the number of trees you need to plant each year to offset your carbon footprint? Fill in the values below and find out! </p>
								
								<?php if(isset($hasError) || isset($captchaError)) { ?>
									<div data-alert class="alert-box warning round">
										There was an error submitting the form.
										<a href="#" class="close">&times;</a>
									</div>
								<?php } ?>

		

							<div class="container container-fluid">
								<form action="<?php the_permalink(); ?>" id="contactForm" method="post" class="form">
									<?php for($i=0;$i<$len; $i++) { ?>
										<div class="form-group">
											<?php if($arr[$i][4] == true) {?>
												<div data-alert class="alert-box warning round">
													<?=$arr[$i][3];?>
													<a href="#" class="close">&times;</a>
												</div>
											<?php } ?>
											<label for="<?=$arr[$i][1];?>"><?=$arr[$i][0];?></label>
											<input class="form-control" type="text" name="<?=$arr[$i][1];?>" id="<?=$arr[$i][1];?>" value="<?php if(isset($_POST[$arr[$i][1]])) echo $_POST[$arr[$i][1]];?>" required="true" />
										</div>
									<? } ?>
									<div class="form-group">
										<label for="checking"> Please leave this field empty </label>
										<input class="form-control" type="text" name="checking" id="checking" />
									</div>
									<button type="submit" class="btn btn-default">Submit</button>
								</form>
							</div>
							<?php } ?>
                    </div>
                    <div style="clear:both"></div>	
                    <div class="post_info_wrap"><?php the_content(); ?> </div>
                    <div style="clear:both"></div>	
                    
            <div class="post_wrap_n">         
                   
                   
</div>

                
                        
            <?php endwhile ?> 
            
                </div>   
				<div class="comments_template"><?php comments_template('',true); ?></div>
            <?php endif ?>


</div>

    
    <!--POST END--> 
   
    
<?php if(of_get_option('nosidebar_checkbox') == "0"){ ?><?php get_sidebar();?><?php } ?>
</div>
</div>
</div>

<?php get_footer(); ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/bootstrap.min.js"></script>	