<div id="right">
	<div id="breadcrumbs">
		<div>
			<div>
				<ul>
					<li class="first"></li>
					<li>
						<a href="#"><?php _e( "BOOKINGS ENGINE", bookings_engine ); ?></a>
					</li>				
					<li class="last">
						<a href="#"><?php _e( "REPORT A BUG", bookings_engine ); ?></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="section">
		<div class="message green" id="SuccessReportBug" style="display:none;">
			<span>
				<strong><?php _e("Success! The Email has been sent.", bookings_engine); ?></strong>
			</span>
		</div>
		<div class="box">
			<div class="title">
				<?php _e("Report a Bug", bookings_engine); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<form id="uxFrmReportABug" class="form-horizontal" method="post" action="#">
					<div class="row">
						<label><?php _e("Your Email :", bookings_engine); ?></label>
						<div class="right">
							<input type="text" class="required span12" name="uxReportEmailAddress" id="uxReportEmailAddress" value=""/>
						</div>
					</div>
					<div class="row">
						<label><?php _e("Subject :", bookings_engine); ?></label>
						<div class="right">
							<input type="text" class="required span12" name="uxReportSubject" id="uxReportSubject" value=""/>
						</div>
					</div>
					<div class="row">
						<label><?php _e("Bug / Issue :", bookings_engine); ?></label>
						<div class="right">
							<?php wp_editor("", $id = 'uxReportBug', $prev_id = 'title', $media_buttons = true, $tab_index = 1);?>
						</div>
					</div>
					<div class="row" style="border-bottom:none">						
						<div class="right">
							<button type="submit" class="blue"><span><?php _e("Report It!", bookings_engine); ?></span></button>
						</div>
					</div>					
				</form>
			</div>
		</div>
	</div>
</div>
<div id="footer">
		<div class="split">
			&copy; <?php _e( "2013 Bookings-Engine", bookings_engine ); ?>
		</div>
		<div class="split right">
			<?php _e( "Powered by ", bookings_engine ); ?>
			<a href="#" >
			<?php _e( "Bookings Engine!", bookings_engine ); ?>
			</a>
		</div>
	</div>
</div>
</div>
<script>
jQuery("#ReportBug").attr("class","current"); 
jQuery("#uxFrmReportABug").validate
({
	rules:
	{
		uxReportEmailAddress: 
		{
			required: true,
			email:true
		},
		uxReportBug: 
		{
			required:true
		},	
		uxReportSubject:"required"
	},			
	highlight: function(label) 
	{	    	
		if(jQuery(label).closest('.control-group').hasClass('success'))
		{
			jQuery(label).closest('.control-group').removeClass('success');
		}
	 		jQuery(label).closest('.control-group').addClass('errors');
	  	},	  	
	   	submitHandler: function(form) 
	   	{
	  		var uxReportEmailAddress = jQuery('#uxReportEmailAddress').val();
			if (jQuery("#wp-uxReportBug-wrap").hasClass("tmce-active"))
			{
	    		var uxReportBug  = encodeURIComponent(tinyMCE.get('uxReportBug').getContent());
	    	}
	    	else
	    	{
	    		var uxReportBug  = encodeURIComponent(jQuery('#uxReportBug').val());
	    	}	  	     	
	     	var uxReportSubject = encodeURIComponent(jQuery('#uxReportSubject').val());
	     	jQuery.ajax
		    ({
				type: "POST",
				data: "uxReportEmailAddress="+uxReportEmailAddress+"&uxReportBug="+uxReportBug+"&uxReportSubject="+uxReportSubject+"&target=reportABug&action=getAjaxExecuted",
				url:  ajaxurl,
		        success: function(data) 
		        {  
		        	jQuery('#SuccessReportBug').css('display','block');
					setTimeout(function() 
				{
					jQuery('#SuccessReportBug').css('display','none');
					var checkPage = "<?php echo $_REQUEST['page']; ?>";
					window.location.href = "admin.php?page="+checkPage;
				}, 2000);
				}
			});
		}
});
</script>
