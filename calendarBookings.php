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
							<?php _e( "Bookings", bookings_engine ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="section">		
		<div class="box">
			<div class="title">
				<?php _e("Advanced Booking Filter", bookings_engine); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<div class="row">
					<label>
						<?php _e("Services", bookings_engine); ?>
					</label>			
					<?php
					$service = $wpdb->get_results
					(
						$wpdb->prepare
						(
							"SELECT * FROM ".servicesTable()." order by ServiceName ASC",''
						)
					);
					?>
					<div class="right">
						<select name="uxDdlBookingServices" class="style required" id="uxDdlBookingServices" onchange="showServicesBooking();" style="width:50%">
				   			<option value ="allServices">
				   				<?php _e( "All Services", bookings_engine ); ?>
				   			</option>	
				    <?php
				  	for( $flagServicesDropdown = 0; $flagServicesDropdown < count($service); $flagServicesDropdown++)
				 	{
					?>
							<option value ="<?php echo $service[$flagServicesDropdown]->ServiceId;?>">
								<?php echo $service[$flagServicesDropdown]->ServiceName;?>
							</option>
					<?php 
					} 
					?>
					    </select>	
			        </div>	
				</div>
				<div class="row">
					<label style="top:10px;">
						<?php _e("Bookings Status", bookings_engine); ?>
					</label>
					<div class="right">
						<input type="checkbox" class="style" name="uxBookingStatus1" id="uxBookingStatus1" onclick="showServicesBooking();" checked="checked"/>&nbsp; &nbsp;<?php _e( "Pending Approval", bookings_engine ); ?>
						<input type="checkbox" class="style" name="uxBookingStatus2" id="uxBookingStatus2" onclick="showServicesBooking();" checked="checked" style="margin-left:10px;"/>&nbsp; &nbsp;<?php _e( "Approved", bookings_engine ); ?>
						<input type="checkbox" class="style" name="uxBookingStatus3" id="uxBookingStatus3" onclick="showServicesBooking();" checked="checked" style="margin-left:10px;"/>&nbsp; &nbsp;<?php _e( "Disapproved", bookings_engine ); ?>
						<input type="checkbox" class="style" name="uxBookingStatus4" id="uxBookingStatus4" onclick="showServicesBooking();" checked="checked" style="margin-left:10px;"/>&nbsp; &nbsp;<?php _e( "Cancelled", bookings_engine ); ?>
						<input type="checkbox" class="style" name="uxBookingStatus5" id="uxBookingStatus5" onclick="showServicesBooking();" checked="checked" style="margin-left:10px;"/>&nbsp; &nbsp;<?php _e( "Block Outs", bookings_engine ); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="box">
			<div class="title">
				<?php _e("Booking Calendar", bookings_engine); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<div id="calendar"></div>
              	<div id="dynamicCalendar"></div>
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
<script type="text/javascript">
	jQuery("#Bookings").attr("class","current");
		//===== Calendar =====//
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	jQuery(document).ready(function()
	{			
		showServicesBooking();	 	
	});			
	function showServicesBooking()
	{
		var serviceId = jQuery('#uxDdlBookingServices').val();
		var uxBookingStatus1 = jQuery('input:checkbox[name=uxBookingStatus1]:checked').val();
		var uxBookingStatus2 = jQuery('input:checkbox[name=uxBookingStatus2]:checked').val();
		var uxBookingStatus3 = jQuery('input:checkbox[name=uxBookingStatus3]:checked').val();
		var uxBookingStatus4 = jQuery('input:checkbox[name=uxBookingStatus4]:checked').val();
		var uxBookingStatus5 = jQuery('input:checkbox[name=uxBookingStatus5]:checked').val();
		if(uxBookingStatus1 == "on")
		{
			var status1 = "true";
		}
		else
		{
			var status1 = "false";
		}
		if(uxBookingStatus2 == "on")
		{
			var status2 = "true";
		}
		else
		{
			var status2 = "false";
		}
		if(uxBookingStatus3 == "on")
		{
			var status3 = "true";
		}
		else
		{
			var status3 = "false";
		}
		if(uxBookingStatus4 == "on")
		{
			var status4 = "true";
		}
		else
		{
			var status4 = "false";
		}
		if(uxBookingStatus5 == "on")
		{
			var status5 = "true";
		}
		else
		{
			var status5 = "false";
		}
		if(serviceId == "allServices")
		{
			var id = "allServices";
		}
		else
		{
			var id = 1;
		}	
		jQuery.ajax
		({
			type: "POST",
			data: "action=AjaxExecuteCalls&target=getBookings&ServiceId="+serviceId+"&status1="+status1+"&status2="+status2+
			"&status3="+status3+"&status4="+status4+"&status5="+status5,
			url:ajaxurl,
			success: function(data) 
			{						
				jQuery('#dynamicCalendar').html(data);					
			}
		});
	}
	
</script>
