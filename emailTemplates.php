<div id="right">
	<div id="breadcrumbs">
		<div>
			<div>
				<ul>
					<li class="first"></li>
					<li>
						<a href="#">
							<?php _e( "BOOKINGS ENGINE", bookings_engine ); ?>
						</a>
					</li>				
					<li class="last">
						<a href="#">
							<?php _e( "EMAIL TEMPLATES", bookings_engine ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="section">
		<div class="message green" id="PendingConfirmationSuccess" style="display:none">
			<span>
				<strong>
					<?php _e( "Success! The Email has been saved.", bookings_engine ); ?>
				</strong>
			</span>
		</div>
		<?php
			$result = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".email_templatesTable()." where EmailType = %s",
					"booking-pending-confirmation"
				)
			);
		?>
				
		<div class="box">
			<div class="title">
				<?php _e( "Approval Pending Email Template [Sent to Client]",bookings_engine ); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<form id="uxFrmPendingConfirmationEmailTemplate" class="form-horizontal" method="post" action="#">
					<div class="row">
						<label>
							<?php _e( "Email Subject :", bookings_engine ); ?>
						</label>
						<div class="right">
							<input type="text" class="required span12"name="uxPendingConfirmationEmailTemplateSubject" value="<?php echo $result->  EmailSubject ;?>" id="uxPendingConfirmationEmailTemplateSubject"/>
						</div>
					</div>
					<div class="row">
						<label>
							<?php _e( "Email Content :", bookings_engine ); ?>
						</label>
						<div class="right">
							<?php   
					    		$content = stripslashes($result->EmailContent);
								wp_editor($content, $id = 'uxPendingConfirmationEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 1); 
					    	?>						
						</div>
					</div>				
					<div class="row" style="border-bottom:none">						
						<div class="right">
							<button type="submit" class="blue">
								<span>
									<?php _e("Submit & Save Changes", bookings_engine); ?>
								</span>
							</button>
						</div>
					</div>					
				</form>
			</div>
		</div>
		<div class="message green" id="ConfirmationSuccess" style="display:none">
			<span>
				<strong>
					<?php _e( "Success! The Email has been saved.", bookings_engine ); ?>
				</strong>
			</span>
		</div>		
		<?php
			$result = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".email_templatesTable()." where EmailType = %s",
					"booking-confirmation"
				)
			);
		?>		
		<div class="box">
			<div class="title">
				<?php _e( "Approved Email Template [Sent to Client]",bookings_engine ); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<form id="uxFrmConfirmationEmailTemplate" class="form-horizontal" method="post" action="#">
					<div class="row">
						<label>
							<?php _e( "Email Subject :", bookings_engine ); ?>
						</label>
						<div class="right">
							<input type="text" class="required span12"name="uxConfirmationEmailTemplateSubject" value="<?php echo $result->  EmailSubject ;?>" id="uxConfirmationEmailTemplateSubject"/>
						</div>
					</div>
					<div class="row">
						<label>
							<?php _e( "Email Content :", bookings_engine ); ?>
						</label>
						<div class="right">
							<?php   
					    		$content = stripslashes($result->EmailContent);
								wp_editor($content, $id = 'uxConfirmationEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 1); 
					    	?>						
						</div>
					</div>				
					<div class="row" style="border-bottom:none">						
						<div class="right">
							<button type="submit" class="blue">
								<span>
									<?php _e("Submit & Save Changes", bookings_engine); ?>
								</span>
							</button>
						</div>
					</div>					
				</form>
			</div>
		</div>
		<div class="message green" id="BookingDeclinedSuccess" style="display:none">
			<span>
				<strong>
					<?php _e( "Success! The Email has been saved.", bookings_engine ); ?>
				</strong>
			</span>
		</div>		
		<?php
			$result = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".email_templatesTable()." where EmailType = %s",
					"booking-disapproved"
				)
			);
		?>		
		<div class="box">
			<div class="title">
				<?php _e( "Disapproved Email Template [Sent to Client]",bookings_engine ); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<form id="uxFrmBookingDeclinedEmailTemplate" class="form-horizontal" method="post" action="#">
					<div class="row">
						<label>
							<?php _e( "Email Subject :", bookings_engine ); ?>
						</label>
						<div class="right">
							<input type="text" class="required span12"name="uxBookingDeclinedEmailTemplateSubject" value="<?php echo $result->  EmailSubject ;?>" id="uxBookingDeclinedEmailTemplateSubject"/>
						</div>
					</div>
					<div class="row">
						<label>
							<?php _e( "Email Content :", bookings_engine ); ?>
						</label>
						<div class="right">
							<?php   
					    		$content = stripslashes($result->EmailContent);
								wp_editor($content, $id = 'uxBookingDeclinedEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 1); 
					    	?>						
						</div>
					</div>				
					<div class="row" style="border-bottom:none">						
						<div class="right">
							<button type="submit" class="blue">
								<span>
									<?php _e("Submit & Save Changes", bookings_engine); ?>
								</span>
							</button>
						</div>
					</div>					
				</form>
			</div>
		</div>
		<div class="message green" id="AdminApproveDisapproveSuccess" style="display:none">
			<span>
				<strong>
					<?php _e( "Success! The Email has been saved.", bookings_engine ); ?>
				</strong>
			</span>
		</div>		
		<?php
			$result = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".email_templatesTable()." where EmailType = %s",
					"admin-control"
				)
			);
		?>		
		<div class="box">
			<div class="title">
				<?php _e( "Approve/Disapprove Email Template [Sent to Admin]",bookings_engine ); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<form id="uxFrmAdminApproveDisapproveEmailTemplate" class="form-horizontal" method="post" action="#">
					<div class="row">
						<label>
							<?php _e( "Email Subject :", bookings_engine ); ?>
						</label>
						<div class="right">
							<input type="text" class="required span12"name="uxAdminApproveDisapproveEmailTemplateSubject" value="<?php echo $result->  EmailSubject ;?>" id="uxAdminApproveDisapproveEmailTemplateSubject"/>
						</div>
					</div>
					<div class="row">
						<label>
							<?php _e( "Email Content :", bookings_engine ); ?>
						</label>
						<div class="right">
							<?php   
					    		$content = stripslashes($result->EmailContent);
								wp_editor($content, $id = 'uxAdminApproveDisapproveEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 1); 
					    	?>						
						</div>
					</div>				
					<div class="row" style="border-bottom:none">						
						<div class="right">
							<button type="submit" class="blue">
								<span>
									<?php _e("Submit & Save Changes", bookings_engine); ?>
								</span>
							</button>
						</div>
					</div>					
				</form>
			</div>
		</div>
		<div class="message green" id="PaypalAdminNotificationSuccess" style="display:none">
			<span>
				<strong>
					<?php _e( "Success! The Email has been saved.", bookings_engine ); ?>
				</strong>
			</span>
		</div>		
		<?php
			$result = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".email_templatesTable()." where EmailType = %s",
					"paypal-payment-notification"
				)
			);
		?>		
		<div class="box">
			<div class="title">
				<?php _e( "Paypal Admin Notification Email Template [Sent to Admin]",bookings_engine ); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<form id="uxFrmPaypalAdminNotificationEmailTemplate" class="form-horizontal" method="post" action="#">
					<div class="row">
						<label>
							<?php _e( "Email Subject :", bookings_engine ); ?>
						</label>
						<div class="right">
							<input type="text" class="required span12"name="uxPaypalAdminNotificationEmailTemplateSubject" value="<?php echo $result->  EmailSubject ;?>" id="uxPaypalAdminNotificationEmailTemplateSubject"/>
						</div>
					</div>
					<div class="row">
						<label>
							<?php _e( "Email Content :", bookings_engine ); ?>
						</label>
						<div class="right">
							<?php   
					    		$content = stripslashes($result->EmailContent);
								wp_editor($content, $id = 'uxPaypalAdminNotificationEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 1); 
					    	?>						
						</div>
					</div>				
					<div class="row" style="border-bottom:none">						
						<div class="right">
							<button type="submit" class="blue">
								<span>
									<?php _e("Submit & Save Changes", bookings_engine); ?>
								</span>
							</button>
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
	jQuery("#EmailTemplate").attr("class","current");
	jQuery("#uxFrmPendingConfirmationEmailTemplate").validate
	({
		submitHandler: function(form) 
	    { 
			var PendingConfirmationEmailTemplateSubject =  encodeURIComponent(jQuery("#uxPendingConfirmationEmailTemplateSubject").val());
			if (jQuery("#wp-uxPendingConfirmationEmailTemplate-wrap").hasClass("tmce-active"))
			{
		    	var PendingConfirmationEmailTemplateContent  = encodeURIComponent(tinyMCE.get('uxPendingConfirmationEmailTemplate').getContent());
		    }
		    else
		    {
		    	var PendingConfirmationEmailTemplateContent  = encodeURIComponent(jQuery('#uxPendingConfirmationEmailTemplate').val());
		    }									
			jQuery.ajax
			({
				type: "POST",
				data: "PendingConfirmationEmailTemplateSubject="+PendingConfirmationEmailTemplateSubject+
				"&PendingConfirmationEmailTemplateContent="+PendingConfirmationEmailTemplateContent+
				"&target=updatePendingConfirmationEmailTemplate&action=AjaxExecuteCalls",
				url:  ajaxurl,
			    success: function(data) 
			    {  
			    	jQuery('#PendingConfirmationSuccess').css('display','block');
			        setTimeout(function() 
					{
						jQuery('#PendingConfirmationSuccess').css('display','none');
					},2000);
			    }
			});
		}
	});
	jQuery("#uxFrmConfirmationEmailTemplate").validate
	({
		submitHandler: function(form) 
	    {
			var ConfirmationEmailTemplateSubject =  encodeURIComponent(jQuery("#uxConfirmationEmailTemplateSubject").val());
			if (jQuery("#wp-uxConfirmationEmailTemplate-wrap").hasClass("tmce-active"))
			{
		    	var ConfirmationEmailTemplateContent  = encodeURIComponent(tinyMCE.get('uxConfirmationEmailTemplate').getContent());
		    }
		    else
		    {
		    	var ConfirmationEmailTemplateContent  = encodeURIComponent(jQuery('#uxConfirmationEmailTemplate').val());
		    }					
		   	jQuery.ajax
			({
				type: "POST",
				data: "ConfirmationEmailTemplateSubject="+ConfirmationEmailTemplateSubject+
				"&ConfirmationEmailTemplateContent="+ConfirmationEmailTemplateContent+"&target=updateConfirmationEmailTemplate&action=AjaxExecuteCalls",
				url:  ajaxurl,
			    success: function(data) 
			    {  
			     	jQuery('#ConfirmationSuccess').css('display','block');
		           	setTimeout(function() 
				    {
				    	jQuery('#ConfirmationSuccess').css('display','none');
					}, 2000);
			    }
			});
		}
	});
	jQuery("#uxFrmBookingDeclinedEmailTemplate").validate
	({
		submitHandler: function(form) 
	    {
			var DeclineEmailTemplateSubject =  encodeURIComponent(jQuery("#uxBookingDeclinedEmailTemplateSubject").val());
			if (jQuery("#wp-uxBookingDeclinedEmailTemplate-wrap").hasClass("tmce-active"))
			{
		    	var DeclineEmailTemplateContent  = encodeURIComponent(tinyMCE.get('uxBookingDeclinedEmailTemplate').getContent());
		    }
		    else
		    {
		    	var DeclineEmailTemplateContent  = encodeURIComponent(jQuery('#uxBookingDeclinedEmailTemplate').val());
		    }				
		    jQuery.ajax
			({
				type: "POST",
				data: "DeclineEmailTemplateSubject="+DeclineEmailTemplateSubject+
				"&DeclineEmailTemplateContent="+DeclineEmailTemplateContent+"&target=updateDeclinedEmailTemplate&action=AjaxExecuteCalls",
				url:  ajaxurl,
			    success: function(data) 
			    {  
				  	jQuery('#BookingDeclinedSuccess').css('display','block');
			       	setTimeout(function() 
				    {
				    	jQuery('#BookingDeclinedSuccess').css('display','none');						    		    
				 	}, 2000);
			    }
			});
		}
	});
	jQuery("#uxFrmAdminApproveDisapproveEmailTemplate").validate
	({
		submitHandler: function(form) 
	    {
			var AdminApproveDisapproveEmailTemplateSubject =  encodeURIComponent(jQuery("#uxAdminApproveDisapproveEmailTemplateSubject").val());
			if (jQuery("#wp-uxAdminApproveDisapproveEmailTemplate-wrap").hasClass("tmce-active"))
			{
		    	var AdminApproveDisapproveEmailTemplateContent  = encodeURIComponent(tinyMCE.get('uxAdminApproveDisapproveEmailTemplate').getContent());
		    }
		    else
		    {
		    	var AdminApproveDisapproveEmailTemplateContent  = encodeURIComponent(jQuery('#uxAdminApproveDisapproveEmailTemplate').val());
		    }				
		    jQuery.ajax
			({
				type: "POST",
				data: "AdminApproveDisapproveEmailTemplateSubject="+AdminApproveDisapproveEmailTemplateSubject+
				"&AdminApproveDisapproveEmailTemplateContent="+AdminApproveDisapproveEmailTemplateContent+
				"&target=updateAdminApproveDisapproveEmailTemplate&action=AjaxExecuteCalls",
				url:  ajaxurl,
			    success: function(data) 
			    {  
	  		    	jQuery('#AdminApproveDisapproveSuccess').css('display','block');
		          	setTimeout(function() 
				    {
				    	jQuery('#AdminApproveDisapproveSuccess').css('display','none');
			        }, 2000);
			    }
			});
		}
	});	
	jQuery("#uxFrmPaypalAdminNotificationEmailTemplate").validate
	({
		submitHandler: function(form) 
	    {
			var PaypalAdminNotificationEmailTemplateSubject =  encodeURIComponent(jQuery("#uxPaypalAdminNotificationEmailTemplateSubject").val());
			if (jQuery("#wp-uxPaypalAdminNotificationEmailTemplate-wrap").hasClass("tmce-active"))
			{
		    	var PaypalAdminNotificationEmailTemplateContent  = encodeURIComponent(tinyMCE.get('uxPaypalAdminNotificationEmailTemplate').getContent());
		    }
		    else
		    {
		    	var PaypalAdminNotificationEmailTemplateContent  = encodeURIComponent(jQuery('#uxPaypalAdminNotificationEmailTemplate').val());
		    }				
		    jQuery.ajax
			({
				type: "POST",
				data: "PaypalAdminNotificationEmailTemplateSubject="+PaypalAdminNotificationEmailTemplateSubject+
				"&PaypalAdminNotificationEmailTemplateContent="+PaypalAdminNotificationEmailTemplateContent+
				"&target=updatePaypalAdminNotificationEmailTemplate&action=AjaxExecuteCalls",
				url:  ajaxurl,
			    success: function(data) 
			    {  
		         	jQuery('#PaypalAdminNotificationSuccess').css('display','block');
		           	setTimeout(function() 
				    {
					   	jQuery('#PaypalAdminNotificationSuccess').css('display','none');
					}, 2000);
			    }
		    });
			}
	});
	jQuery("#uxFrmPaypalCancellationNotificationEmailTemplate").validate
	({
		submitHandler: function(form) 
		{
			var PaypalCancellationNotificationEmailTemplateSubject =  encodeURIComponent(jQuery("#uxPaypalCancellationNotificationEmailTemplateSubject").val());
			if (jQuery("#wp-uxPaypalCancellationNotificationEmailTemplate-wrap").hasClass("tmce-active"))
			{
				var PaypalCancellationNotificationEmailTemplateContent  = encodeURIComponent(tinyMCE.get('uxPaypalCancellationNotificationEmailTemplate').getContent());
			}
	   		else
	   		{
				var PaypalCancellationNotificationEmailTemplateContent  = encodeURIComponent(jQuery('#uxPaypalCancellationNotificationEmailTemplate').val());
			}				
			jQuery.ajax
			({
				type: "POST",
				data: "PaypalCancellationNotificationEmailTemplateSubject="+PaypalCancellationNotificationEmailTemplateSubject+
				"&PaypalCancellationNotificationEmailTemplateContent="+PaypalCancellationNotificationEmailTemplateContent+
				"&target=updatePaypalCancellationNotificationEmailTemplate&action=AjaxExecuteCalls",
				url:  ajaxurl,
				success: function(data) 
				{  
					jQuery('#PaypalCancellationNotificationSuccess').css('display','block');
			    	setTimeout(function() 
					{
						jQuery('#PaypalCancellationNotificationSuccess').css('display','none');
					}, 2000);
				}
	    	});
		}
	});
</script>