<?php
global $wpdb;
if (!current_user_can('edit_posts') && ! current_user_can('edit_pages') )
{
 	return;
}
else
{
	?>
	<div id="right">
		<div id="breadcrumbs">
			<div>
				<div>
					<ul>
						<li class="first"></li>
						<li>
							<a href="#">
								<?php _e("BOOKINGS ENGINE", bookings_engine); ?>
							</a>
						</li>				
						<li class="last">
							<a href="#">
								<?php _e("Dashboard", bookings_engine); ?>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="section">
			<div class="message red">
				<span>
					<strong>
						<?php _e( "You are using Lite Version of Bookings Engine. To enjoy full features, purchase Commercial Version now by clicking <a href='http://bookings-engine.com' target='_blank'>here</a>. ", bookings_engine ); ?>
					</strong>
				</span>
			</div>		
			<div class="box">					
				<div class="title">
					<?php _e("Action Panel", bookings_engine); ?>
					<span class="hide"></span>
				</div>
				<div class="content">
					<ul class="midnav">
		  				<li>
			  				<a href="#bookNewService" data-toggle="modal">
			  					<img src="<?php echo plugins_url('/images/icons/color/date.png', __FILE__) ?>" alt="">
			  					<span>
			  						<?php _e( "Book a Service", bookings_engine ); ?>
			  					</span>
			  				</a>
			  				<strong id="uxBookingsCount"></strong>
			  			</li>
	                  	<li>
				    		<a href="#addNewService" data-toggle="modal">
				    			<img src="<?php echo plugins_url('/images/icons/color/order-149.png', __FILE__) ?>" alt="">
				    			<span>
				    				<?php _e( "Add Services", bookings_engine ); ?>
				    			</span>
				    		</a>
				    		<strong id="uxServiceCount"></strong>
				    	</li>
				    	<li>
				   			<a href="#BlockOuts" data-toggle="modal">
				   				<img src="<?php echo plugins_url('/images/icons/color/busy.png', __FILE__) ?>" alt="">
				   				<span>
				   					<?php _e( "Block Outs", bookings_engine ); ?>
				   				</span>
				   			</a>
				   			<strong id="uxBlockOutsCount"></strong>
				   		</li>
				    	<li>
				   			<a href="#couponsMenu" data-toggle="modal">
				   				<img src="<?php echo plugins_url('/images/icons/color/bank.png', __FILE__) ?>" alt="">
				   				<span>
				   					<?php _e( "Coupons", bookings_engine ); ?>
				   				</span>
				   			</a>
				   			<strong id="uxCouponsCount"></strong>
				   		</li>					   					   		
	             		<li>
				   			<a href="#defaultSettings" data-toggle="modal">
				   				<img src="<?php echo plugins_url('/images/icons/color/settings.png', __FILE__) ?>" alt="">
				   				<span>
				   					<?php _e( "Default Settings", bookings_engine ); ?>
				   				</span>
				   			</a>
				   		</li>                                                                                        		  		
	 					<li>
				   			<a href="#ReminderSettings" data-toggle="modal">
				   				<img src="<?php echo plugins_url('/images/icons/color/phone.png', __FILE__) ?>" alt="">
				   				<span>
				   					<?php _e( "Reminder Settings", bookings_engine ); ?>
				   				</span>
				   			</a>
				   			<strong id="uxDashboardReminderSettings"></strong>
				   		</li>
	 					<li>
				   			<a href="#shortcodes" data-toggle="modal">
				   				<img src="<?php echo plugins_url('/images/icons/color/lightbulb.png', __FILE__) ?>" alt="">
				   				<span>
				   					<?php _e( "ShortCodes", bookings_engine ); ?>
				   				</span>
				   			</a>
				   		</li>			    	
	                    <li>
				   			<a href="#paypalSettings" data-toggle="modal">
				   				<img src="<?php echo plugins_url('/images/icons/color/paypal.png', __FILE__) ?>" alt="">
				   				<span>
				   					<?php _e( "Paypal Settings", bookings_engine ); ?>
				   				</span>
				   			</a>
				   			<strong id="uxDashboardPaypalSettings"></strong>
				   		</li> 
	                    <li>
				   			<a href="#mailChimpSettings" data-toggle="modal">
				   				<img src="<?php echo plugins_url('/images/icons/color/mailchimp.png', __FILE__) ?>" alt="">
				   				<span>
				   					<?php _e( "Mailchimp Settings", bookings_engine ); ?>
				   				</span>
				   			</a>
				   			<strong id="uxDashboardMailChimpSettings"></strong>
				   		</li>                                              
	              	    <li>
				   			<a href="#facebookConnect" data-toggle="modal">
				   				<img src="<?php echo plugins_url('/images/icons/color/facebook.png', __FILE__) ?>" alt="">
				   				<span>
				   					<?php _e( "Facebook Connect", bookings_engine ); ?>
				   				</span>
				   			</a>
				   			<strong id="uxDashboardFacebookConnect"></strong>
				   		</li>			   		
	              	    <li>
				   			<a href="#autoApproveBookings" data-toggle="modal">
				   				<img src="<?php echo plugins_url('/images/icons/color/check.png', __FILE__) ?>" alt="">
				   				<span>
				   					<?php _e( "Auto Approve", bookings_engine ); ?>
				   				</span>
				   			</a>
				   			<strong id="uxDashboardAutoApprove"></strong>
				   		</li>			   		
	              	    <li>
				   			<a href="#deleteAllBookings" data-toggle="modal" onclick="DeleteAllBookings();">
				   				<img src="<?php echo plugins_url('/images/icons/color/brainstorming.png', __FILE__) ?>" alt="">
				   				<span>
				   					<?php _e( "Delete All Bookings", bookings_engine ); ?>
				   				</span>
				   			</a>
				   		</li> 			   		
	              	    <li>
				   			<a href="#restorFactorySettings" data-toggle="modal" onclick="RestoreFactorySettings();">
				   				<img src="<?php echo plugins_url('/images/icons/color/config.png', __FILE__) ?>" alt="">
				   				<span>
				   					<?php _e( "Restore Factory Settings", bookings_engine ); ?>
				   				</span>
				   			</a>
				   		</li>  			   		  
					</ul>
				</div>	
			</div>
			<div class="box">
				<div class="title">
					<?php _e("Upcoming Bookings", bookings_engine); ?>
					<span class="hide"></span>
				</div>
				<div class="content">
					<div class="table-overflow">
						<table class="table table-striped" id="data-table-upcoming-events">
						 	<thead>
						   		<tr>
						   		  <?php
						   		  	$paypalEnable = $wpdb->get_var
						   		  	(
						   		  		$wpdb->prepare
						   		  		(
						   		  			"SELECT PaymentGatewayValue FROM ".payment_Gateway_settingsTable()." where PaymentGatewayKey = %s ",
						   		  			"paypal-enabled"
						   		  		)
									);
									if($paypalEnable == 1)
									{
									?>
									<th style="width:2% !important"></th>
						   		  	<?php
						   		  	}
						   		  	?>
										<th style="width:12% !important"><?php _e( "Client Name", bookings_engine ); ?></th>
										<th style="width:10% !important"><?php _e( "Mobile", bookings_engine ); ?></th>
										<th style="width:12% !important"><?php _e( "Service", bookings_engine ); ?></th>
										<th style="width:20% !important"><?php _e( "Booking Date", bookings_engine ); ?></th>
										<th style="width:12% !important"><?php _e( "Time Slot", bookings_engine ); ?></th>
										<th style="width:5% !important"></th>
								</tr>
							</thead>
						  	<tbody>
						  		<?php
						  			$currentdate = date("Y-m-d"); 
									$newDate = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")+30, date("Y")));
						   			$uxUpcomingBookings = $wpdb->get_results
			                       	(
						               	$wpdb->prepare
						               	(
								           	"SELECT CONCAT(".customersTable().".CustomerFirstName,'  ',". customersTable().".CustomerLastName) as ClientName,".servicesTable().".ServiceTotalTime,
								           	".customersTable().".CustomerMobile,". servicesTable(). ".ServiceName, ".servicesTable().".ServiceFullDay, ".servicesTable().".ServiceColorCode,
								           	".servicesTable().".ServiceStartTime, ".servicesTable().".ServiceEndTime, ".bookingTable().".BookingDate ,". bookingTable().".TimeSlot,
								           	". bookingTable().".PaymentStatus,". bookingTable().".BookingId,". bookingTable().".BookingStatus from ".bookingTable()." 
								           	LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().".CustomerId= ".customersTable().".CustomerId ". "  
								          	LEFT OUTER JOIN " .servicesTable()." ON ".bookingTable().".ServiceId=".servicesTable().".ServiceId 
								         	ORDER BY ".bookingTable().".BookingDate asc",""
						                 )													
			                       	);
			                   		$timeFormats = $wpdb->get_var
			                        (
			                        	$wpdb->prepare
						   		  		(
			                        		"SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = %s ",
			                        		"default_Time_Format"
			                        	)
									);
			                        for($flag = 0; $flag < count($uxUpcomingBookings); $flag++)
						            {
										$multipleBookings = $wpdb->get_results
										(
											$wpdb->prepare
										    (
										        "Select ".multiple_bookingTable().".bookingDate from ".multiple_bookingTable()." JOIN 
       											". bookingTable() ." on ".multiple_bookingTable().".bookingId = ". bookingTable() .".BookingId WHERE 
       											". multiple_bookingTable().".bookingId = %d ORDER BY ".multiple_bookingTable().".bookingDate asc",
       											$uxUpcomingBookings[$flag]->BookingId  
        									)
										);
										$dateFormat = $wpdb->get_var
										(
											$wpdb->prepare
											(
												'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s ',
												"default_Date_Format"
											)
										);
										$allocatedMultipleDates = "<div id=\"tags1_tagsinput\" class=\"tagsinput\" style=\"width: 100%; min-height: auto; height: auto; \">";
						            	for($MBflag=0; $MBflag < count($multipleBookings); $MBflag++)
						            	{
						            		if($dateFormat == 0)
												{
													$bookingDateFormat =  date("M d, Y", strtotime($multipleBookings[$MBflag]->bookingDate));
												}
												else if($dateFormat == 1)
												{
													$bookingDateFormat =  date("Y/m/d", strtotime($multipleBookings[$MBflag]->bookingDate));
												}	
												else if($dateFormat == 2)
												{
													$bookingDateFormat = date("m/d/Y", strtotime($multipleBookings[$MBflag]->bookingDate));
												}	
												else if($dateFormat == 3)
												{
													$bookingDateFormat =  date("d/m/Y", strtotime($multipleBookings[$MBflag]->bookingDate));
													
												}	
						            		$allocatedMultipleDates .= "<span style=\"background-color:".$uxUpcomingBookings[$flag]->ServiceColorCode.";color:#fff;border:solid 1px ".$uxUpcomingBookings[$flag]->ServiceColorCode . "\" class=\"tag\"><span>" . $bookingDateFormat .''. "</span></span>";
										}
										$allocatedMultipleDates.= "</div>";
										if($uxUpcomingBookings[$flag]->BookingStatus == "Approved")
										{
						               	?>					                 			
											<tr class="success hovertip"  data-original-title="<?php _e("Booking Status : Approved", bookings_engine ); ?>" data-placement="left">
										<?php
										}
										else if($uxUpcomingBookings[$flag]->BookingStatus == "Disapproved")
										{
										?>
											<tr class="error hovertip"  data-original-title="<?php _e("Booking Status : Disapproved", bookings_engine ); ?>" data-placement="left">
										<?php	
										}
										else if($uxUpcomingBookings[$flag]->BookingStatus == "Pending Approval")
										{
										?>
											<tr class="warning hovertip"  data-original-title="<?php _e("Booking Status : Pending Approval", bookings_engine ); ?>" data-placement="left">
										<?php	
										}
										else if($uxUpcomingBookings[$flag]->BookingStatus == "Cancelled")
										{
										?>
											<tr class="info hovertip"  data-original-title="<?php _e("Booking Status : Cancelled", bookings_engine ); ?>" data-placement="left">
										<?php	
										}
										else
										{
										?>
										<tr>
										<?php	
										}	
										if($paypalEnable == 1)
										{
											if($uxUpcomingBookings[$flag]->PaymentStatus == "Completed")
											{																																								
											?>
												<td>
													<div style="width:15px;height:15px;background-color:green" title="Payment Recieved"></div>
												</td>
											<?php
											}
											else if($uxUpcomingBookings[$flag]->PaymentStatus == "Cancelled")
											{
											?>
												<td>
													<div style="width:10px;height:15px;background-color:red" title="Payment Cancelled"></div>
												</td>
											<?php
											}
											else 
											{
											?>
												<td>
													<div style="width:15px;height:15px;background-color:orange" title="Awaiting Payment"></div>
												</td>
											<?php
											}
										}
										?>
										<td><?php echo $uxUpcomingBookings[$flag]->ClientName?></td>
										<td><?php echo $uxUpcomingBookings[$flag]->CustomerMobile?></td>
										<td><?php echo $uxUpcomingBookings[$flag]->ServiceName;?></td>
										<?php
											if($uxUpcomingBookings[$flag]->ServiceFullDay  == 1)
											{
										?>
												<td><?php echo $allocatedMultipleDates;?></td>
										<?php
											}
											else
											{
												$allocatedSingleDates = "<div id=\"tags1_tagsinput\" class=\"tagsinput\" style=\"width: 100%; min-height: auto; height: auto; \">";
												if($dateFormat == 0)
													{
														 $SingleDate = date("M d, Y", strtotime($uxUpcomingBookings[$flag]->BookingDate));
													}
													else if($dateFormat == 1)
													{
														 $SingleDate = date("Y/m/d", strtotime($uxUpcomingBookings[$flag]->BookingDate));
													}	
													else if($dateFormat == 2)
													{
														$SingleDate = date("m/d/Y", strtotime($uxUpcomingBookings[$flag]->BookingDate));
													}	
													else if($dateFormat == 3)
													{
														$SingleDate =  date("d/m/Y", strtotime($uxUpcomingBookings[$flag]->BookingDate));
													}
													$allocatedSingleDates .= "<span style=\"background-color:".$uxUpcomingBookings[$flag]->ServiceColorCode.";color:#fff;border:solid 1px ".$uxUpcomingBookings[$flag]->ServiceColorCode . "\" class=\"tag\"><span>" . $SingleDate .''. "</span></span></div>";
													?><td><?php echo $allocatedSingleDates; ?></td><?php
											}
											$getHours_bookings = floor(($uxUpcomingBookings[$flag] -> TimeSlot)/60);
											$getMins_bookings = ($uxUpcomingBookings[$flag] -> TimeSlot) % 60;
											$hourFormat_bookings = $getHours_bookings . ":" . "00";
											if($timeFormats == 0)
											{
												$time_in_12_hour_format_bookings  = DATE("g:i a", STRTOTIME($hourFormat_bookings));
											}
											else 
											{
												$time_in_12_hour_format_bookings  = DATE("H:i", STRTOTIME($hourFormat_bookings));
											}
						                    if($getMins_bookings!=0)
					                        {
							                   	$hourFormat_bookings = $getHours_bookings . ":" . $getMins_bookings;
							                   	if($timeFormats == 0)
												{
													$time_in_12_hour_format_bookings  = DATE("g:i a", STRTOTIME($hourFormat_bookings));
												}
												else 
												{
													$time_in_12_hour_format_bookings  = DATE("H:i", STRTOTIME($hourFormat_bookings));
												}
						                    }
											$totalBookedTime = $uxUpcomingBookings[$flag]->TimeSlot + $uxUpcomingBookings[$flag]->ServiceTotalTime;
											$getHours_bookings = floor(($totalBookedTime)/60);
											$getMins_bookings = ($totalBookedTime) % 60;
											$hourFormat_bookings = $getHours_bookings . ":" . "00";
											if($timeFormats == 0)
											{
												$time_in_12_hour_format_bookings_End  = DATE("g:i a", STRTOTIME($hourFormat_bookings));
											}
											else 
											{
												$time_in_12_hour_format_bookings_End  = DATE("H:i", STRTOTIME($hourFormat_bookings));
											}
						                    if($getMins_bookings!=0)
					                        {
							                   	$hourFormat_bookings = $getHours_bookings . ":" . $getMins_bookings;
							                   	if($timeFormats == 0)
												{
													$time_in_12_hour_format_bookings_End  = DATE("g:i a", STRTOTIME($hourFormat_bookings));
												}
												else 
												{
													$time_in_12_hour_format_bookings_End  = DATE("H:i", STRTOTIME($hourFormat_bookings));
												}
						                    }
											if($uxUpcomingBookings[$flag]->ServiceFullDay == 0)													
											{
											?>
												<td><?php echo $time_in_12_hour_format_bookings ." - ". $time_in_12_hour_format_bookings_End ?></td>
											<?php
											}
											else
											{
											?>
												<td>-</td>
											<?php
											}
											?>
											<td>
												<a class="icon-edit hovertip fancybox" data-original-title="<?php _e("Edit Booking?", bookings_engine ); ?>" data-placement="top" href="#EditBooking" data-toggle="modal" onclick="editBooking(<?php echo $uxUpcomingBookings[$flag]->BookingId; ?>);"></a>&nbsp;&nbsp;
												<?php
												if($uxUpcomingBookings[$flag]->BookingStatus != "Cancelled")
												{
												?>
													<a style="display: none;" class="icon-envelope hovertip" data-original-title="<?php _e("Send Email Again?", bookings_engine ); ?>" data-placement="top" href="#" onclick="resendEmail('<?php echo $uxUpcomingBookings[$flag]->BookingId;?>','<?php echo $uxUpcomingBookings[$flag]->BookingStatus;?>')"></a>&nbsp;&nbsp;
												<?php
												}
												?>
												<a class="icon-trash hovertip" data-original-title="<?php _e("Delete Booking?", bookings_engine ); ?>" data-placement="top" href="#" onclick="deleteBooking(<?php echo $uxUpcomingBookings[$flag]->BookingId; ?>)"></a>
											</td>
										</tr>
									<?php
									}
									?>
							</tbody>
						</table>
					</div>
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
	<div id="facebookConnect" class="modal hide fade" role="dialog" aria-hidden="true">	
		<div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		    <h3><?php _e( "Facebook Connect Settings",bookings_engine ); ?></h3>
		</div>		
		<div class="body">
			<a href="http://bookings-engine.com" target="_blank">
				<img src="<?php echo plugins_url('images/fb-settings.png',__FILE__) ?>" />
			</a>				        
		</div>			
	</div>
	<div id="mailChimpSettings" class="modal hide fade" role="dialog" aria-hidden="true">
		<div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		    <h3><?php _e( "MailChimp Settings",bookings_engine ); ?></h3>
		</div>		
		<div class="body">
			<a href="http://bookings-engine.com" target="_blank">
				<img src="<?php echo plugins_url('images/mailchimpl-settings.png',__FILE__) ?>" />
			</a>				        
		</div>	
	</div>
	<div id="addNewService" class="modal hide fade" role="dialog" aria-hidden="true">
		<form id="uxFrmAddServices" class="form-horizontal" method="post" action="">
			<div class="modal-header">
		    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		   		<h3><?php _e( "Add New Service", bookings_engine ); ?></h3>
			</div>		
			<div class="message green" id="successMessage" style="display:none;margin-left:10px;">
				<span>
					<strong>
						<?php _e( "Success! Service has been saved.", bookings_engine ); ?>
					</strong>
				</span>
			</div>
			<div class="message red" id="errorMessageServices" style="display:none;margin-left:10px;">
				<span>
					<strong>
						<?php _e( "Error! Max Bookings should be greater than 1", bookings_engine ); ?>
					</strong>
				</span>
			</div>
			<div class="message red" id="timeErrorMessage" style="display:none;margin-left:10px;">
				<span>
					<strong>
						<?php _e( "Error! Please Enter the Valid Time.", bookings_engine ); ?>
					</strong>
				</span>
			</div>					
			<div class="body">
				<div class="block well" style="margin:10px;">					
					<div class="box">
						<div class="content">
							<div class="row">
								<label>
									<?php _e( "Service Color :", bookings_engine ); ?>
								</label>
								<div class="right">
									<div id="colorPickerService" class="cw-color-picker" rel="uxServiceColor" style="position: absolute;z-index: 1111;background: #fff;border: 1px solid;margin-top:30px;"></div>		
	                            	<input class="widefat" type="text" value="#e76e6f"  id="uxServiceColor" name="uxServiceColor"  onfocus="colorFocus();" onblur="colorHide();" style="color:#000;">	                            	                             
								</div>
							</div>
         					<div class="row">
								<label>
									<?php _e( "Service Name :", bookings_engine ); ?>
								</label>
								<div class="right">
									<input type="text" class="required span12" name="uxServiceName" id="uxServiceName"/> 
								</div>
							</div>
							<div class="row">
								<?php
		                    		$costIcon = $wpdb->get_var
		                    		(
		                    			$wpdb->prepare
		                    			(
		                    				"SELECT CurrencySymbol FROM ".currenciesTable()." where CurrencyUsed = %d",
		                    				1
		                    			)
									);
	                    		?>								
								<label>
									<?php _e( "Service Cost (".$costIcon."):", bookings_engine ); ?>
								</label>
								<div class="right">
									<input type="text" class="required span12" name="uxServiceCost" id="uxServiceCost"/> 
								</div>
							</div>
							<div class="row">
								<label style="top:10px">
									<?php _e( "Service Type :", bookings_engine );?>
								</label>
								<div class="right">
									<input type="radio" id="uxServiceTypeEnable" name="uxServiceType" class="style" value="0" onclick="singleBooking();" checked="checked">&nbsp;&nbsp;<?php _e( "Single Booking", bookings_engine );?>
									<input type="radio" id="uxServiceTypeDisable" name="uxServiceType" onclick="groupBooking();" class="style" value="1" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Group Bookings", bookings_engine );?> 	
								</div>
							</div>
							<div class="row" id="maxBooking" Style="display: none;">
								<label>
									<?php _e( "Max Bookings :", bookings_engine ); ?>
								</label>
								<div class="right">
									<input type="text" class="required span12" name="uxMaxBookings" id="uxMaxBookings" value="1"/> 
								</div>
							</div>																						
							<div class="row">
								<label  style="top:10px">
									<?php _e( "Full Day Service :", bookings_engine ); ?>
								</label>
								<div class="right">
									<input type="checkbox" value=""  id="uxFullDayService" name="uxFullDayService" onclick="divControlsShowHide();" > 
								</div>
							</div>
							<div class="row" id="divMaxDays" style="display : none;">
								<label>
									<?php _e( "Allow Max. Days :", bookings_engine ); ?>
								</label>
								<div class="right">
									<select name="uxMaxDays" class="required" id="uxMaxDays" style="width:100px;" > 
										<option value="Unlimited">Unlimited</option>
										<?php
										for($days = 1; $days < 31; $days++)
										{
										?>
											<option value="<?php echo $days; ?>"><?php echo $days; ?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="row" id="divCostType" style="display : none;">
								<label>
									<?php _e( "Cost Type :", bookings_engine ); ?>
								</label>
								<div class="right">
									<input type="radio" id="uxServiceCostType" name="uxCostType" class="style" value="0" checked="checked">&nbsp;&nbsp;<?php _e( "Per Day", bookings_engine );?>
									<input type="radio" id="uxServiceCostType" name="uxCostType" class="style" value="1" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Fixed", bookings_engine );?> 
								</div>
							</div>														
							<div class="row" id="divServiceTime">
								<label>
									<?php _e( "Service Time :", bookings_engine ); ?>
								</label>
								<div class="right">
									<select name="uxServiceHours" class="required" id="uxServiceHours" style="width:100px;" >
	                            		<?php
											for ($hr = 0; $hr <= 23; $hr++) 
											{
												if ($hr < 10) 
												{
												?>
													<option value="<?php echo "0" . $hr; ?>"><?php _e( $hr, bookings_engine ) . _e( " Hrs", bookings_engine ); ?></option>
												<?php
												}
												else
												{
												?>
													<option value="<?php echo $hr; ?>"><?php  _e( $hr, bookings_engine ) . _e( " Hrs", bookings_engine ); ?></option>
												<?php
												}
											}
										?>
                            		</select>
	                            	<select name="uxServiceMins" class="required" id="uxServiceMins" style="width:100px;" >
	                            		<?php
											for ($min = 0; $min < 60; $min += 5) 
											{
												if ($min < 10) 
												{
												?>
													<option value="<?php echo "0" . $min; ?>"><?php _e( $min, bookings_engine ) . _e( " Mins", bookings_engine ); ?></option>
												<?php
												}
												else
												{
												?>
													<option value="<?php echo $min; ?>"><?php _e( $min, bookings_engine ) . _e( " Mins", bookings_engine ); ?></option>
												<?php
												}
											}
										?>
	                            	</select> 
								</div>
							</div>							
							<div class="row" id="divStartTime">
								<label>
									<?php _e( "Start Time :", bookings_engine ); ?>
								</label>
								<div class="right">
									<select name="uxStartTimeHours" class="required" id="uxStartTimeHours" style="width:60px;" >
	                            		<?php
											for ($hr = 0; $hr <= 12; $hr++) 
											{
												if ($hr < 10) 
												{
													echo "<option value=0" . $hr . " >0" . $hr . "</option>";
												}
												else 
												{
													echo "<option value=" . $hr . ">" . $hr . "</option>";
												}
											}
										?>
	                            	</select>
	                            	<select name="uxStartTimeMins" class="required" id="uxStartTimeMins" style="width:60px;" >
	                            		<?php
										for ($min = 0; $min < 60; $min += 5) 
											{
												if ($min < 10) 
												{
													echo "<option value=0" . $min . ">0" . $min . "</option>";
												}
												else
												{
													echo "<option value=" . $min . ">" . $min . "</option>";
												}
											}
										?>
	                            	</select>
	                            	<select name="uxStartTimeAMPM" class="required" id="uxStartTimeAMPM" style="width:60px;" >
	                            		<option value="<?php _e( "AM", bookings_engine ); ?>"><?php _e( "AM", bookings_engine ); ?></option>
				                    	<option value="<?php _e( "PM", bookings_engine ); ?>"><?php _e( "PM", bookings_engine ); ?></option>
	                            	</select>
	                        	</div>
							</div>
							<div class="row"  id="divEndTime">
								<label>
									<?php _e( "End Time :", bookings_engine ); ?>
								</label>
								<div class="right">
									<select name="uxEndTimeHours" class="required" id="uxEndTimeHours" style="width:60px;" >
                            			<?php
										for ($hr = 0; $hr <= 12; $hr++) 
										{
											if ($hr < 10) 
											{
												echo "<option value=0" . $hr . " >0" . $hr . "</option>";
											}
											else 
											{
												echo "<option value=" . $hr . ">" . $hr . "</option>";
											}	
										}
										?>
                           			</select>
	                            	<select name="uxEndTimeMins" class="required" id="uxEndTimeMins" style="width:60px;" >
		                            	<?php
											for ($min = 0; $min < 60; $min += 5) 
											{
												if ($min < 10) 
												{
													echo "<option value=0" . $min . ">0" . $min . "</option>";
												}
												else
												{
													echo "<option value=" . $min . ">" . $min . "</option>";
												}
											}
										?>
		                            </select>
                            		<select name="uxEndTimeAMPM" class="required" id="uxEndTimeAMPM" style="width:60px;" >
	                            		<option value="<?php _e( "AM", bookings_engine ); ?>"><?php _e( "AM", bookings_engine ); ?></option>
					                    <option value="<?php _e( "PM", bookings_engine ); ?>"><?php _e( "PM", bookings_engine ); ?></option>
	                            	</select>								
								</div>
							</div>
  						 	<script>
	                        	jQuery("#uxStartTimeHours").val("09");
	                        	jQuery("#uxStartTimeMins").val("00");
	                        	jQuery("#uxStartTimeAMPM").val("AM");
	                        	jQuery("#uxEndTimeHours").val("05");
	                        	jQuery("#uxEndTimeMins").val("00");
	                        	jQuery("#uxEndTimeAMPM").val("PM");
	                        	jQuery("#uxMaxDays").val("1");
	                        </script>		
                    	</div>
          			</div>
	          		<div class="row" style="border-bottom:none">
						<label></label>
						<div class="right">
							<button type="submit" class="blue">
								<span>
									<?php _e( "Submit & Save Changes", bookings_engine ); ?>	   			
								</span>
							</button>
						</div>
					</div>	
				</div>
			</div>
		</form>
	</div>
	<div id="defaultSettings" class="modal hide fade" role="dialog" aria-hidden="true">
		<form id="uxFrmGeneralSettings" class="form-horizontal" method="post" action="">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			   <h3><?php _e( "Default Settings", bookings_engine ); ?></h3>
			</div>		
			<div class="message green" id="successDefaultSettingsMessage" style="display:none;margin-left:10px;">
				<span>
					<strong><?php _e( "Success! Default Settings has been saved.", bookings_engine ); ?></strong>
				</span>
			</div>				
			<div class="body">
				<div class="block well" style="margin:10px;">					
					<div class="box">
						<div class="content">
							<div class="row">
								<label>
									<?php _e( "Currency :", bookings_engine ); ?>
								</label>
								<div class="right">
									<?php
										$currency = $wpdb->get_col
										(
											$wpdb->prepare
											(
												"SELECT CurrencyName From ".currenciesTable()." order by CurrencyName ASC",''
											)
										);	
										$currency_code = $wpdb->get_col
										(
											$wpdb->prepare
											(
												"SELECT CurrencySymbol From ".currenciesTable()." order by CurrencyName ASC",''
											)
										);	
										$currency_sel = $wpdb -> get_var
										(
											$wpdb->prepare
											(
												"SELECT CurrencyName FROM ".currenciesTable(). " where CurrencyUsed = %d",
												1
											)
										);
									?>
									<select name="uxDdlDefaultCurrency" id="uxDdlDefaultCurrency" style="width:200px;">
										<?php
											for ($flagCurrency = 0; $flagCurrency < count($currency); $flagCurrency++)
											{
												if ($currency[$flagCurrency] == $currency_sel)
												{
													$currencyCode = $currency_code[$flagCurrency];
													?>
													<option value="<?php echo $currency[$flagCurrency];?>" selected='selected'><?php echo "(" . $currencyCode . ")  ";echo $currency[$flagCurrency];?></option>
													<?php 
												}
												else
												{
												?>
													<option value="<?php echo $currency[$flagCurrency];?>"><?php echo "(" . $currency_code[$flagCurrency] . ")  ";echo $currency[$flagCurrency]; ?></option>
												<?php 
												}
											}
										?>                           		 	
									</select>
								</div>
							</div>
							<div class="row">
								<label>
									<?php _e( "Country :", bookings_engine ); ?>
								</label>
								<div class="right">
									<select name="uxDdlDefaultCountry" class="style required" id="uxDdlDefaultCountry" style="width:200px;">  
										<?php
											$country = $wpdb->get_col
											(
												$wpdb->prepare
												(
													"SELECT CountryName From ".countriesTable()."  order by CountryName ASC"
												)
											);	
											$sel_country = $wpdb -> get_var
											(
												$wpdb->prepare
												(	
													'SELECT CountryName  FROM ' . countriesTable() . ' where CountryUsed = %d',
													1
												)
											);
											for ($flagCountry = 0; $flagCountry < count($country); $flagCountry++)
											{
												if ($sel_country == $country[$flagCountry])
												{
												?>
													<option value="<?php echo $country[$flagCountry];?>" selected='selected'><?php echo $country[$flagCountry];?></option>
												<?php 
												}
												else
							                	{
												?>
													 <option value="<?php echo $country[$flagCountry];?>"><?php echo $country[$flagCountry];?></option>
											    <?php 
									   			}
											}
										?>                      		 	
   	                				</select>
								</div>
							</div>
							<div class="row">
								<?php
				            		$dateFormat = $wpdb->get_var
				            		(
										$wpdb->prepare
										(	
				            				'SELECT GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
				            				"default_Date_Format"
				            			)
									);
								?>
								<label>
									<?php _e( "Date Format :", bookings_engine ); ?>
								</label>
								<div class="right">
									<select name="uxDefaultDateFormat" class="style required" id="uxDefaultDateFormat" style="width:200px;">
										<?php
											$date = date('j'); 
											$monthName = date('F');
											$monthNumeric = date('m');
											$year = date('Y');
											if($dateFormat == 0)
					                		{
					                		?>	
					                			<option value="0" selected="selected">
					                				<?php echo  $monthName ." ".$date.",  ".$year; ?>
					                			</option>
					                			<option value="1">
					                				<?php echo  $year ."/".$monthNumeric."/".$date; ?>
					                			</option>
					                			<option value="2">
					                				<?php echo  $monthNumeric ."/".$date."/".$year; ?>
					                			</option>
					                			<option value="3">
					                				<?php echo $date ."/".$monthNumeric."/".$year;  ?>
					                			</option>
											<?php				                                    			
					                		}
											else if($dateFormat == 1)
											{
											?>
												<option value="0">
													<?php echo  $monthName ." ".$date.",  ".$year; ?>
												</option>
					                			<option value="1" selected="selected">
					                				<?php echo  $year ."/".$monthNumeric."/".$date; ?>
					                			</option>
					                			<option value="2">
					                				<?php echo  $monthNumeric ."/".$date."/".$year; ?>
					                			</option>
					                			<option value="3">
					                				<?php echo $date ."/".$monthNumeric."/".$year;  ?>
					                			</option>
											<?php				                                    																			
											}
					                		else if($dateFormat == 2)
											{
											?>
												<option value="0">
													<?php echo  $monthName ." ".$date.",  ".$year; ?>
												</option>
					                			<option value="1" >
					                				<?php echo  $year ."/".$monthNumeric."/".$date; ?>
					                			</option>
					                			<option value="2" selected="selected">
					                				<?php echo  $monthNumeric ."/".$date."/".$year; ?>
					                			</option>
					                			<option value="3">
					                				<?php echo $date ."/".$monthNumeric."/".$year;  ?>
					                			</option>
											<?php				                                    																			
											}
					                		else 
											{
											?>
												<option value="0">
													<?php echo  $monthName ." ".$date.",  ".$year; ?>
												</option>
					                			<option value="1" >
					                				<?php echo  $year ."/".$monthNumeric."/".$date; ?>
					                			</option>
					                			<option value="2">
					                				<?php echo  $monthNumeric ."/".$date."/".$year; ?>
					                			</option>
					                			<option value="3" selected="selected">
					                				<?php echo $date ."/".$monthNumeric."/".$year;  ?>
					                			</option>
											<?php				                                    																			
											}
				                			?>																
                					</select> 	
								</div>
							</div>
							<div class="row">
								<?php
				            		$timeFormat = $wpdb -> get_var
				            		(
										$wpdb->prepare
										(	
				            				'SELECT GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
				            				"default_Time_Format"
				            			)
									);
				            		$minuteFormat = $wpdb -> get_var
									(
										$wpdb->prepare
										(	
				            				'SELECT GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
				            				"default_Slot_Minute_Format"
				            			)
									);
								?>
								<label>
									<?php _e( "Time Format :", bookings_engine ); ?>
								</label>
								<div class="right">
									<select name="uxDefaultTimeFormat" class="style required" id="uxDefaultTimeFormat" style="width:200px;">
										<?php				                                    		
					                		if($timeFormat == 0)
					                		{
					               			?>	
					                			<option value="0" selected="selected">
					                				<?php _e( "12 Hours", bookings_engine ); ?>
					                			</option>
					                			<option value="1">
					                				<?php _e( "24 Hours", bookings_engine ); ?>
					                			</option>
											<?php				                                    			
					                		}
											else 
											{
											?>
												<option value="0">
													<?php _e( "12 Hours", bookings_engine ); ?>
												</option>
					                			<option value="1" selected="selected">
					                				<?php _e( "24 Hours", bookings_engine ); ?>
					                			</option>
											<?php				                                    																			
											}
					                		?>															
	                				</select> 		
								</div>
							</div>
							<div class="row">
								<?php
				            		$default_Time_Zone = $wpdb->get_var
				            		(
										$wpdb->prepare
										(	
				            				'SELECT GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
				            				"default_Time_Zone"
				            			)
									);
			            		?>
			            		<label>
			            			<?php _e( "Time Zone :", bookings_engine ); ?>
			            		</label>
			            		<div class="right">
				            		<select name="uxDefaultTimeZone" class="style required" id="uxDefaultTimeZone" style="width:350px;">
									  <option value="-12.0">(GMT -12:00) Eniwetok, Kwajalein</option>
								      <option value="-11.0">(GMT -11:00) Midway Island, Samoa</option>
								      <option value="-10.0">(GMT -10:00) Hawaii</option>
								      <option value="-9.0">(GMT -9:00) Alaska</option>
								      <option value="-8.0">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
								      <option value="-7.0">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
								      <option value="-6.0">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
								      <option value="-5.0">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
								      <option value="-4.0">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
								      <option value="-3.5">(GMT -3:30) Newfoundland</option>
								      <option value="-3.0">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
								      <option value="-2.0">(GMT -2:00) Mid-Atlantic</option>
								      <option value="-1.0">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
								      <option value="0.0">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
								      <option value="1.0">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
								      <option value="2.0">(GMT +2:00) Kaliningrad, South Africa</option>
								      <option value="3.0">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
								      <option value="3.5">(GMT +3:30) Tehran</option>
								      <option value="4.0">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
								      <option value="4.5">(GMT +4:30) Kabul</option>
								      <option value="5.0">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
								      <option value="5.5">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
								      <option value="5.75">(GMT +5:45) Kathmandu</option>
								      <option value="6.0">(GMT +6:00) Almaty, Dhaka, Colombo</option>
								      <option value="7.0">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
								      <option value="8.0">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
								      <option value="9.0">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
								      <option value="9.5">(GMT +9:30) Adelaide, Darwin</option>
								      <option value="10.0">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
								      <option value="11.0">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
								      <option value="12.0">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>													
				                	</select>
			                		<script>
			                			jQuery('#uxDefaultTimeZone').val("<?php echo html_entity_decode($default_Time_Zone); ?>");
			                		</script> 	
			            		</div>
							</div>
							<div class="row">
								<label>
									<?php _e( "Service Display :", bookings_engine ); ?>
								</label>
								<div class="right">
									<?php
	                    				$servDisplay = $wpdb -> get_var
				                		(
											$wpdb->prepare
											(	
				                				'SELECT GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
				                				"default_Service_Display"
				                			)
										);
									?>
                    				<select name="uxServiceDisplayFormat" class="style required" id="uxServiceDisplayFormat" style="width:200px;">
										<?php
											if($servDisplay == 0)
											{
												?>
												<option selected="selected" value="0"><?php _e( "Radio Button", bookings_engine ); ?></option>
				                    			<option value="1"><?php _e( "Drop Down List", bookings_engine ); ?></option>
												<?php
											}
											else 
											{
												?>
												<option  value="0"><?php _e( "Radio Button", bookings_engine ); ?></option>
				                    			<option selected="selected" value="1"><?php _e( "Drop Down List", bookings_engine ); ?></option>
												<?php
											}                    			
										?>														
                    				</select> 	
								</div>
							</div>
				          	<div class="row" style="border-bottom:none">
								<label></label>
								<div class="right">
									<button type="submit" class="blue">
		   								<span>
		   									<?php _e( "Submit & Save Changes", bookings_engine ); ?>	   			
		   								</span>
		   							</button>
		   						</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div id="paypalSettings" class="modal hide fade" role="dialog" aria-hidden="true">
		<div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		    <h3><?php _e( "PayPal Settings",bookings_engine ); ?></h3>
		</div>		
		<div class="body">
			<a href="http://bookings-engine.com" target="_blank">
				<img src="<?php echo plugins_url('images/paypal-settings.png',__FILE__) ?>" />
			</a>				        
		</div>	
	</div>
	<div id="autoApproveBookings" class="modal hide fade" role="dialog" aria-hidden="true">
		<form id="uxFrmAutoApprove" class="form-horizontal" method="post" action="">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			   <h3><?php _e( "Auto Approve Bookings", bookings_engine ); ?></h3>
			</div>		
			<div class="message green" id="successAutoApproveMessage" style="display:none;margin-left:10px;">
				<span>
					<strong><?php _e( "Success! Auto Approve has been saved.", bookings_engine ); ?></strong>
				</span>
			</div>				
			<div class="body">
				<div class="block well" style="margin:10px;">					
					<div class="box">
						<div class="content">
							<div class="row">
								<label style="top:10px;">
	                    			<?php _e( "Auto Approve :", bookings_engine ); ?>
	                    		</label>
	                    		<div class="right">
									<input type="radio" id="uxAutoApproveEnable" name="uxAutoApprove"  value="1" >&nbsp;&nbsp;<?php _e( "Enabled", bookings_engine );?>
	                    			<input type="radio" id="uxAutoApproveDisable" name="uxAutoApprove"  value="0" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Disabled", bookings_engine );?>
	                    		</div>
							</div>
							<div class="row" style="border-bottom:none">
								<label></label>
								<div class="right">
									<button type="submit" class="blue">
		   								<span>
		   									<?php _e( "Submit & Save Changes", bookings_engine ); ?>	   			
		   								</span>
		   							</button>
		   						</div>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div id="ReminderSettings" class="modal hide fade" role="dialog" aria-hidden="true">
		<div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		    <h3><?php _e( "Reminder Settings",bookings_engine ); ?></h3>
		</div>		
		<div class="body">
			<a href="http://bookings-engine.com" target="_blank">
				<img src="<?php echo plugins_url('images/reminder-settings.png',__FILE__) ?>" />
			</a>				        
		</div>	
	</div>
	<div id="BlockOuts" class="modal hide fade" role="dialog" aria-hidden="true">
		<div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		    <h3><?php _e( "Block Outs Settings",bookings_engine ); ?></h3>
		</div>		
		<div class="body">
			<a href="http://bookings-engine.com" target="_blank">
				<img src="<?php echo plugins_url('images/blockouts-settings.png',__FILE__) ?>" />
			</a>				        
		</div>		
	</div>	
	<div id="couponsMenu" class="modal hide fade" role="dialog" aria-hidden="true">
		<div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		    <h3><?php _e( "Coupons",bookings_engine ); ?></h3>
		</div>		
		<div class="body">
			<a href="http://bookings-engine.com" target="_blank">
				<img src="<?php echo plugins_url('images/coupons.png',__FILE__) ?>" />
			</a>				        
		</div>		
	</div>
	<div class="modal hide fade" role="dialog" aria-hidden="true" id="bookNewService">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h3><?php _e( "Book New Service", bookings_engine); ?></h3>
		</div>									
		<div class="body">
			<?php include_once 'bookingCalendarBackEnd.php' ?>
		</div> 
	</div>	
	<div id="shortcodes" class="modal hide fade" role="dialog" aria-hidden="true">
		<form id="uxFrmSortcodes" class="form-horizontal" method="post" action="#">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>	
	        	<h3><?php _e( "Shortcodes ", bookings_engine ); ?></h3>
	    	</div>
			<div class="body">
				<div class="block well" style="margin:10px;">					
					<div class="box">
						<div class="content">
							<div class="row">
								<label><?php _e( "Form Embed :", bookings_engine ); ?></label>
								<div class="right">
									<textarea   id="singleServiceCode" rows="2"  style="width:100%">[bookingEngineEmbed][/bookingEngineEmbed]</textarea>
								</div>
							</div>					   
							<div class="row">
								<label><?php _e( "Popup Form :", bookings_engine ); ?>
								</label>
								<div class="right">
									<textarea   id="allServicesCode" rows="2"  style="width:100%">[bookingEnginePopUp][/bookingEnginePopUp]</textarea>
								</div>
							</div>						   						
						</div>
					</div>
	            </div>
	        </div>
		</form>
	</div>
	<div id="EditBooking" class="modal hide fade" role="dialog" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>		
	    	<h3><?php _e( "Edit Customer Booking ", bookings_engine ); ?>
	    	</h3>
    	</div>
    	<div class="message green" id="successMessage" style="display:none;margin-left:10px;">
			<span>
				<strong>
					<?php _e( "Success! The Customer has been Updated.", bookings_engine ); ?>	
				</strong>
			</span>
		</div>
		<div class="message green" id="successMessageUpdateBooking" style="display:none;margin-left:10px;">
			<span>
				<strong>
					<?php _e( "Success! The Booking has been Updated.", bookings_engine ); ?>	
				</strong>
			</span>
		</div>
		<form id="uxFrmEditBooking" class="form-horizontal" method="post" action="#">					
			<div class="block well" style="margin:10px">
				 <div class="body" id="bookingDetails"></div>
			</div>
			<input type="hidden" id="bookingId" value="" />
	   		<div style="padding:10px">
	   			<button type="submit" class="blue">
		   			<span>
		   				<?php _e( "Submit & Save Changes", bookings_engine ); ?>	   			
		   			</span>
	   			</button>
	   		</div>				  
		</form>
	</div>			
	<script type="text/javascript">
		jQuery("#Dashboard").attr("class","current"); 
		jQuery.ajax
		({
			type: "POST",
			data: "target=getFacebookStatus&action=AjaxExecuteCalls",
			url:  ajaxurl,
			success: function(data) 
			{
				jQuery("#uxDashboardFacebookConnect").html(data);
			}
		});
		jQuery.ajax
		({
			type: "POST",
			data: "target=getMailChimpStatus&action=AjaxExecuteCalls",
			url:  ajaxurl,
			success: function(data) 
			{
				jQuery("#uxDashboardMailChimpSettings").html(data);
			}
		});
		jQuery(document).ready(function() 
		{
			jQuery('.cw-color-picker').each(function()
			{
				var $this = jQuery(this),
				id = $this.attr('rel');
				$this.farbtastic('#' + id);
			});
			colorHide();
			jQuery('.hovertip').tooltip();
			var RSEnable = jQuery('input:radio[name=uxReminderSettings]:checked').val();
	 		if(RSEnable == 1)
	 		{
	 			jQuery('#ReminderIntervalDiv').attr('style','');
	 		}
	 		else
	 		{
	 			jQuery('#ReminderIntervalDiv').css('display','none');
		   			
	 		}
	 		var PaypalEnable = jQuery('input:radio[name=uxPayPal]:checked').val();
	 		if(PaypalEnable == 1)
	 		{
	 			jQuery('#paypalUrl').attr('style','');
	 			jQuery('#paypalMerchantEmail').attr('style','');
		   		jQuery('#paypalThankYou').attr('style','');
		   		jQuery('#paypalIPN').attr('style','');	   		
		   		jQuery('#paypalCancellation').attr('style','');
	 		}
	 		else
	 		{
	 			jQuery('#paypalUrl').css('display','none');
	 			jQuery('#paypalMerchantEmail').css('display','none');
		   		jQuery('#paypalThankYou').css('display','none');
		   		jQuery('#paypalIPN').css('display','none');
		   		jQuery('#paypalCancellation').css('display','none');
	 		} 
	 		var uxReminderSettings =  jQuery('input:radio[name=uxReminderSettings]:checked').val();
			jQuery.ajax
			({
				type: "POST",
				data: "uxReminderSettings="+uxReminderSettings+"&target=ReminderSettingsShow&action=AjaxExecuteCalls",
				url:  ajaxurl,
				success: function(data) 
				{
				   if(data == "On")
				    {
				    	jQuery('#uxReminderSettingsEnable').attr('checked','checked');
				    	jQuery('#uxDashboardReminderSettings').html(data);
				    }
				    else
				    {
				    	jQuery('#uxReminderSettingsDisable').attr('checked','checked');
				    	jQuery('#uxDashboardReminderSettings').html(data);
				    }
				}
			}); 
			var uxAutoApprove =  jQuery('input:radio[name=uxAutoApprove]:checked').val();
	 		jQuery.ajax
			({
				type: "POST",
				data: "uxAutoApprove="+uxAutoApprove+"&target=AutoApproveShow&action=AjaxExecuteCalls",
				url:  ajaxurl,
				success: function(data) 
				{
					if(data == "On")
				    {
				    	jQuery('#uxAutoApproveEnable').attr('checked','checked');
				    	jQuery('#uxDashboardAutoApprove').html(data);
				    }
				    else
				    {
				    	jQuery('#uxAutoApproveDisable').attr('checked','checked');
				    	jQuery('#uxDashboardAutoApprove').html(data);
				    }
				}
			}); 			 			
	 	});
		jQuery('#uxServiceMins').val(30);
		jQuery("#uxFrmAddServices").validate
		({
			rules: 
			{
				uxServiceName: "required",
				uxServiceCost: 
				{
					required: true,
					number: true
				},
				uxMaxBookings: 
				{
					required: true,
					digits: true
				},
				uxServiceHours:
				{
					required : true,
				},
				uxServiceMins:
				{
					required : true,
				}
			},			
			highlight: function(label) 
			{	    	
				if(jQuery(label).closest('.control-group').hasClass('success'))
				{
				    jQuery(label).closest('.control-group').removeClass('success');
				}
				   	jQuery(label).closest('.control-group').addClass('errors');
			},
			success: function(label) 
			{
				label
				.text('Success!').addClass('valid')
				.closest('.control-group').addClass('success');
			},
			submitHandler: function(form) 
			{
				var uxServiceColor = jQuery('#uxServiceColor').val();
				var uxServiceName = jQuery('#uxServiceName').val();
				var uxServiceNameEncode  = encodeURIComponent(uxServiceName);
				var uxServiceCost = jQuery('#uxServiceCost').val();
				var uxServiceHours = jQuery('#uxServiceHours').val();
				var uxServiceMins = jQuery('#uxServiceMins').val();
				var uxMaxBookings = jQuery('#uxMaxBookings').val();
				var uxServiceType = jQuery('input:radio[name=uxServiceType]:checked').val();
				var uxStartTimeHours = jQuery('#uxStartTimeHours').val();
				var uxStartTimeMins = jQuery('#uxStartTimeMins').val();
				var uxStartTimeAMPM = jQuery('#uxStartTimeAMPM').val();
				var uxEndTimeHours = jQuery('#uxEndTimeHours').val();
				var uxEndTimeMins = jQuery('#uxEndTimeMins').val();
				var uxEndTimeAMPM = jQuery('#uxEndTimeAMPM').val();
				var uxFullDay = jQuery("#uxFullDayService").prop("checked");
				var uxMaxDays = jQuery("#uxMaxDays").val();
				var uxCostType = jQuery('input:radio[name=uxCostType]:checked').val();
				var uxTotalStartTime = parseInt(uxStartTimeHours * 60) + parseInt(uxStartTimeMins);
				var uxTotalEndTime = parseInt(uxEndTimeHours * 60) + parseInt(uxEndTimeMins);
			   	if(uxServiceType == 1 && uxMaxBookings > 1)
				{
					if((parseInt(uxStartTimeHours) != 12) && (uxTotalStartTime >= uxTotalEndTime) && (uxStartTimeAMPM == uxEndTimeAMPM) && (uxFullDay == 0))
				   	{
				   		jQuery('#errorMessageServices').css('display','none');
				   		jQuery('#timeErrorMessage').css('display','block');
				   	}
			   		else if((uxStartTimeAMPM == "PM") && (uxEndTimeAMPM == "AM") && (uxFullDay == 0))
			   		{
			   			jQuery('#errorMessageServices').css('display','none');
			   			jQuery('#timeErrorMessage').css('display','block');
			   		}
			   		else
			   		{
						jQuery.ajax
						({
							type: "POST",
							data: "uxServiceNameEncode="+uxServiceNameEncode+"&uxServiceCost="+uxServiceCost+"&uxServiceHours="+uxServiceHours+"&uxServiceColor="+uxServiceColor+
							"&uxFullDay="+uxFullDay+"&uxStartTimeHours="+uxStartTimeHours+"&uxStartTimeMins="+uxStartTimeMins+
							"&uxStartTimeAMPM="+uxStartTimeAMPM+"&uxEndTimeHours="+uxEndTimeHours+"&uxEndTimeMins="+uxEndTimeMins+"&uxEndTimeAMPM="+uxEndTimeAMPM+
							"&uxServiceMins="+uxServiceMins+"&uxMaxBookings="+uxMaxBookings+"&uxServiceType="+uxServiceType+"&uxMaxDays="+uxMaxDays+"&uxCostType="+uxCostType+"&target=addService&action=AjaxExecuteCalls",
							url:  ajaxurl,
							success: function(data) 
							{  
								jQuery('#timeErrorMessage').css('display','none');
								jQuery('#errorMessageServices').css('display','none');
							    jQuery('#successMessage').css('display','block');
							    setTimeout(function() 
							    {
							        jQuery('#successMessage').css('display','none');
									var checkPage = "<?php echo $_REQUEST['page']; ?>";
									window.location.href = "admin.php?page="+checkPage;
							    }, 2000);	
							}  
						});
					}
				}
				else if(uxServiceType == 0)
				{
					if((parseInt(uxStartTimeHours) != 12) && (uxTotalStartTime >= uxTotalEndTime) && (uxStartTimeAMPM == uxEndTimeAMPM) && (uxFullDay == 0))
				   	{
				   		jQuery('#errorMessageServices').css('display','none');
				   		jQuery('#timeErrorMessage').css('display','block');
				   	}
			   		else if((uxStartTimeAMPM == "PM") && (uxEndTimeAMPM == "AM") && (uxFullDay == 0))
			   		{
			   			jQuery('#errorMessageServices').css('display','none');
			   			jQuery('#timeErrorMessage').css('display','block');
			   		}
			   		else
				   	{
				   	jQuery.ajax
					({
						type: "POST",
						data: "uxServiceNameEncode="+uxServiceNameEncode+"&uxServiceCost="+uxServiceCost+"&uxServiceHours="+uxServiceHours+"&uxServiceColor="+uxServiceColor+
						"&uxFullDay="+uxFullDay+"&uxStartTimeHours="+uxStartTimeHours+"&uxStartTimeMins="+uxStartTimeMins+
						"&uxStartTimeAMPM="+uxStartTimeAMPM+"&uxEndTimeHours="+uxEndTimeHours+"&uxEndTimeMins="+uxEndTimeMins+"&uxEndTimeAMPM="+uxEndTimeAMPM+
						"&uxServiceMins="+uxServiceMins+"&uxMaxBookings="+uxMaxBookings+"&uxServiceType="+uxServiceType+"&uxMaxDays="+uxMaxDays+"&uxCostType="+uxCostType+"&target=addService&action=AjaxExecuteCalls",
						url:  ajaxurl,
						success: function(data) 
						{  
							jQuery('#errorMessageServices').css('display','none');
						    jQuery('#timeErrorMessage').css('display','none');
						    jQuery('#successMessage').css('display','block');
						    setTimeout(function() 
						    {
						    	jQuery('#successMessage').css('display','none');
								var checkPage = "<?php echo $_REQUEST['page']; ?>";
								window.location.href = "admin.php?page="+checkPage;
						    }, 2000);	
						}   
					});
					}
				}
				else
				{
					jQuery('#errorMessageServices').css('display','block');
				}  
			}
		});
		function singleBooking()
		{
			jQuery('#maxBooking').css('display','none');
		}
		function groupBooking()
		{
			jQuery('#maxBooking').css('display','block');
		}	
		jQuery.ajax
		({
			type: "POST",
			data: "target=getPaypalStatus&action=AjaxExecuteCalls",
			url:  ajaxurl,
			success: function(data) 
			{
				jQuery("#uxDashboardPaypalSettings").html(data);
			}
		});
		jQuery("#uxFrmGeneralSettings").validate
		({
			submitHandler: function(form) 
		    {
				var uxDefaultcurrency  = jQuery('#uxDdlDefaultCurrency').val();
		    	var uxDefaultcountry  = jQuery('#uxDdlDefaultCountry').val();
		    	var uxDefaultTimeFormat =   jQuery('#uxDefaultTimeFormat').val();
		    	var uxDefaultDateFormat =   jQuery('#uxDefaultDateFormat').val();
		    	var uxServiceDisplayFormat =  jQuery('#uxServiceDisplayFormat').val();
		    	var StaffManagement = jQuery('input:radio[name=uxStaffManagement]:checked').val();
		    	var default_Time_Zone = encodeURIComponent(jQuery('#uxDefaultTimeZone').val());
		    	var default_Time_Zone_Name =  encodeURIComponent(jQuery("#uxDefaultTimeZone option[value='"+default_Time_Zone+"']").text());
	    	    jQuery.ajax
			    ({
					type: "POST",
					data: "default_Time_Zone_Name="+default_Time_Zone_Name+"&default_Time_Zone="+default_Time_Zone+"&uxServiceDisplayFormat="+uxServiceDisplayFormat+
					"&StaffManagement="+StaffManagement+"&uxDefaultcurrency="+uxDefaultcurrency+"&uxDefaultcountry="+uxDefaultcountry+
					"&uxDefaultTimeFormat="+uxDefaultTimeFormat+"&uxDefaultDateFormat="+uxDefaultDateFormat+
					"&target=updateGeneralSettings&action=AjaxExecuteCalls",
					url:  ajaxurl,
		            success: function(data) 
		            {  
		            	jQuery('#successDefaultSettingsMessage').css('display','block');
						setTimeout(function() 
					    {
					       	jQuery('#successDefaultSettingsMessage').css('display','none');
					       	var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
					    }, 2000);				            	
	                }
		        });
			}
		});
		jQuery("#uxFrmAutoApprove").validate
		({
			submitHandler: function(form) 
			{
				var uxAutoApprove =  jQuery('input:radio[name=uxAutoApprove]:checked').val();
			    jQuery.ajax
				({
					type: "POST",
					data: "uxAutoApprove="+uxAutoApprove+"&target=AutoApprove&action=AjaxExecuteCalls",
					url:  ajaxurl,
				    success: function(data) 
					{  
						jQuery('#successAutoApproveMessage').css('display','block');
						setTimeout(function() 
						{
							jQuery('#successAutoApproveMessage').css('display','none');
							var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
						}, 2000);
					}
				});
			}	   		
		});
		function DeleteAllBookings()
		{
			bootbox.confirm("<?php _e("Are you sure you want to Delete All Bookings?", bookings_engine ); ?>", function(confirmed) 
			{
				console.log("Confirmed: "+confirmed);
				if(confirmed == true)
				{
			  		jQuery.ajax
					({
						type: "POST",
						data: "target=DeleteAllBookings&action=AjaxExecuteCalls",
						url:  ajaxurl,
					    success: function(data) 
						{
							var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
						}
					});
				}
			});  
		}
		function RestoreFactorySettings()
		{
			bootbox.confirm("<?php _e("Are you sure you want to Restore Factory Settings ?", bookings_engine ); ?>", function(confirmed) 
			{
				console.log("Confirmed: "+confirmed);
				if(confirmed == true)
				{
					jQuery.ajax
					({
						type: "POST",
						data: "target=RestoreFactorySettings&action=AjaxExecuteCalls",
						url:  ajaxurl,
					    success: function(data) 
						{
							var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
						}
					});
				}
			});  
		}
		function deleteBooking(bookingId)
	    {
	    	bootbox.confirm("<?php _e("Are you sure you want to delete this Booking?", bookings_engine ); ?>", function(confirmed) 
			{
				console.log("Confirmed: "+confirmed);
				if(confirmed == true)
				{
					jQuery.ajax
					({
						type: "POST",
						data: "bookingId="+bookingId+"&target=deleteBooking&action=AjaxExecuteCalls",
						url:ajaxurl,
						success: function(data) 
					    {  
					    	var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
	
					    }
					});
				}
			});
	    }
	    function resendEmail(bookingId,status)
		{
			jQuery.ajax
			({
				type: "POST",
				data: "bookingId="+bookingId+"&status="+status+"&target=resendBookingEmail&action=AjaxExecuteCalls",
				url:ajaxurl,
				success: function(data) 
				{	
					bootbox.alert('<?php _e("Email has been Sent successfully.", bookings_engine ); ?>');	
				}
			})
		}
		<?php
		$paypalEnable = $wpdb->get_var("SELECT PaymentGatewayValue FROM ".payment_Gateway_settingsTable()." where PaymentGatewayKey = 'paypal-enabled'");
		if($paypalEnable == 1)
		{
		?>
			oTable = jQuery('#data-table-upcoming-events').dataTable
			({
				"bJQueryUI": false,
				"bAutoWidth": true,
				"sPaginationType": "full_numbers",
				"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
				"oLanguage": 
				{
					"sLengthMenu": "_MENU_"
				},
					"aaSorting": [[ 5, "asc" ]],
					"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0 ] },{ "bSortable": false, "aTargets": [ 6 ] }]
			});
			<?php
		}
		else
		{
		?>
			oTable = jQuery('#data-table-upcoming-events').dataTable
			({
				"bJQueryUI": false,
				"bAutoWidth": true,
				"sPaginationType": "full_numbers",
				"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
				"oLanguage": 
				{
					"sLengthMenu": "_MENU_"
				},
				"aaSorting": [[ 4, "asc" ]],
				"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 5 ] }]
			});
			<?php
		}
		?>
		function divControlsShowHide()
	 	{
	 		var uxFullDay = jQuery("#uxFullDayService").prop("checked");
	 		if(uxFullDay == true)
	 		{
	 			jQuery("#divServiceTime").css('display','none');
				jQuery("#divStartTime").css('display','none');
				jQuery("#divEndTime").css('display','none');
				jQuery("#divMaxDays").css('display','block');
				jQuery("#divCostType").css('display','block');
			}
			else
			{
				jQuery("#divCostType").css('display','none');
				jQuery("#divMaxDays").css('display','none');
				jQuery("#divServiceTime").css('display','block');
				jQuery("#divStartTime").css('display','block');
				jQuery("#divEndTime").css('display','block');
			}
	 	}
	 	function colorFocus()
		{
			jQuery("#colorPickerService").css('display','block');
		}
		function colorHide()
		{
			jQuery("#colorPickerService").css('display','none');
		}
		function editBooking(bookingId)
  		{
	     	jQuery.ajax
	  		({
	  			type: "POST",
	   			data: "bookingId="+bookingId+"&target=updatebooking&action=getAjaxExecuted",
	   			url:  ajaxurl,
	  			success: function(data) 
	  			{
	    			jQuery('#bookingDetails').html(data);
	 			} 
	  		});   
    	}
    	jQuery("#uxFrmEditBooking").validate
		 ({				
		     submitHandler: function(form) 
		     {
		     	var bookingHideId = jQuery("#bookingHideId").val();
		     	var uxBookingStatus = jQuery('#uxBookingStatus').val();		     		
		     	jQuery.ajax
				({
					type: "POST",
					data: "bookingHideId="+bookingHideId+"&uxBookingStatus="+uxBookingStatus+"&target=updateBookingStatus&action=AjaxExecuteCalls",
					url:  ajaxurl,
				    success: function(data) 
				    {
				    	jQuery('#successMessageUpdateBooking').css('display','block');  
				        setTimeout(function() 
						{
							var checkPage = "<?php echo $_REQUEST['page']; ?>";
						    window.location.href = "admin.php?page="+checkPage;
						}, 2000);
					}
			    });
		     }	   		
		 });
	</script>
<?php
}
?>