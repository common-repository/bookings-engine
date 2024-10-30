<?php
if (!current_user_can('edit_posts') && ! current_user_can('edit_pages') )
{
 	return;
}
else 
{
	$url = plugins_url('', __FILE__);
	if(isset($_REQUEST['target']) && isset($_REQUEST['action']))
	{
		if($_REQUEST['target'] == "cancelBooking")
		{
			$bookingId = intval($_REQUEST['bookingId']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".bookingTable()." SET BookingStatus  = %s WHERE BookingId = %d",
					"Cancelled",
					$bookingId
				)
			);
			die();
		}
		else if($_REQUEST['target'] == "deleteBooking")
		{
			$bookingId = intval($_REQUEST['bookingId']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"DELETE FROM ".bookingTable()." WHERE BookingId = %d",
					$bookingId
				)
			);
			die();
		}
		else if($_REQUEST['target'] == 'resendBookingEmail')
		{
			include_once 'mails.php';
			$bookingId = intval($_REQUEST['bookingId']);
			$uxBookingStaus = esc_attr($_REQUEST['status']);
			if($uxBookingStaus == "Pending Approval")
			{
				MailManagement($bookingId,"approval_pending");	
				MailManagement($bookingId,"admin");
			}
			else if($uxBookingStaus == "Approved")
			{
				MailManagement($bookingId,"approved");
			}
			else if($uxBookingStaus == "Disapproved")
			{
				MailManagement($bookingId,"disapproved");
			}
			die();
		}
		else if($_REQUEST['target'] == "addService")
		{
			$uxServiceNameEncode = html_entity_decode($_REQUEST['uxServiceNameEncode']);
			$uxServiceCost = doubleval($_REQUEST['uxServiceCost']);
			$uxServiceHours = intval($_REQUEST['uxServiceHours']);
			$uxServiceMins = intval($_REQUEST['uxServiceMins']);
			$uxServicesTotalTime = $uxServiceHours  * 60 + $uxServiceMins;
			$uxMaxBookings = intval($_REQUEST['uxMaxBookings']);
			$uxServiceType = intval($_REQUEST['uxServiceType']);
			$uxServiceColor = esc_attr($_REQUEST['uxServiceColor']);
			$uxStartTimeHours = intval($_REQUEST['uxStartTimeHours']);
			$uxStartTimeMins = intval($_REQUEST['uxStartTimeMins']);
			$uxStartTimeAMPM = esc_attr($_REQUEST['uxStartTimeAMPM']);
			$uxEndTimeHours = intval($_REQUEST['uxEndTimeHours']);
			$uxEndTimeMins= intval($_REQUEST['uxEndTimeMins']);
			$uxEndTimeAMPM = esc_attr($_REQUEST['uxEndTimeAMPM']);
			$uxFullDay = esc_attr($_REQUEST['uxFullDay']);
			$uxMaxDays = esc_attr($_REQUEST['uxMaxDays']);
			$uxCostType = intval($_REQUEST['uxCostType']);
			if($uxFullDay == "true")
			{
				$ServiceFullDay = 1;
			}
			else 
			{
				$ServiceFullDay = 0;
			}
			if($uxStartTimeAMPM == "PM")
			{
				if($uxStartTimeHours <= 11)
				{
					$uxStartTimeHour = $uxStartTimeHours + 12;
				}
				else if($uxStartTimeHours == 12)
				{
					$uxStartTimeHour = 12;
				}
			}
			else if($uxStartTimeAMPM == "AM")
			{
				if($uxStartTimeHours == 12)
				{
					$uxStartTimeHour = 0;
				}
				else 
				{
					$uxStartTimeHour = $uxStartTimeHours;
				}
			}
			else 
			{
				$uxStartTimeHour = $uxStartTimeHours;
			}
			if($uxEndTimeAMPM == "PM")
			{
				if($uxEndTimeHours <= 11)
				{
					$uxEndTimeHour = $uxEndTimeHours + 12;
				}
				else if($uxEndTimeHours == 12)
				{
					$uxEndTimeHour = 12;
				}
			}
			else if($uxEndTimeAMPM == "AM")
			{
				if($uxEndTimeHours == 12)
				{
					$uxEndTimeHour = 0;
				}
				else 
				{
					$uxEndTimeHour = $uxEndTimeHours;
				}
			}
			else 
			{
				$uxEndTimeHour = $uxEndTimeHours;
			}
			if($uxFullDay== "false")
			{
				$ServiceTotalStartTime = ($uxStartTimeHour * 60) + $uxStartTimeMins;
				$ServiceTotalEndTime = ($uxEndTimeHour * 60) + $uxEndTimeMins;
			}
			else 
			{
				$ServiceTotalStartTime = 0;
				$ServiceTotalEndTime = 0;
				$uxServicesTotalTime = 0;
			}
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO ".servicesTable()."(ServiceName,ServiceCost,ServiceTotalTime,ServiceMaxBookings,Type,ServiceFullDay,ServiceStartTime,ServiceEndTime,ServiceColorCode,MaxDays,CostType ) 
					VALUES( %s, %f, %d, %d, %d, %d, %d, %d, %s, %s, %d)",
					$uxServiceNameEncode,
					$uxServiceCost,
					$uxServicesTotalTime,
					$uxMaxBookings,
					$uxServiceType,
					$ServiceFullDay,
					$ServiceTotalStartTime,
					$ServiceTotalEndTime,
					$uxServiceColor,
					$uxMaxDays,
					$uxCostType
				)
			);
			$lastid = $wpdb->insert_id;
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".servicesTable()." SET ServiceDisplayOrder = %d WHERE ServiceId = %d",
					$lastid,
					$lastid
				)
			);
			 die();
		}
		else if($_REQUEST['target'] == "getServiceCount")
		{
			$count = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(ServiceId) FROM ' . servicesTable(),''
				)
			);
			echo $count;
			die();
		}	
		else if($_REQUEST['target'] == "getFacebookStatus")
		{
			$FBStatus = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT SocialMediaValue FROM ' . social_Media_settingsTable() . ' where SocialMediaKey = %s',
					"facebook-connect-enable"
				)
			);
			if($FBStatus == 0)
			{
				echo "Off";
			}
			else 
			{
				echo "On";	
			}
			die();
		}
		else if($_REQUEST['target'] == "getMailChimpStatus")
		{
			$MCStatus = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT AutoResponderValue FROM ' . auto_Responders_settingsTable() . ' where AutoResponderKey = %s',
					"mail-chimp-enabled"
				)
			);
			if($MCStatus == 0)
			{
				echo "Off";
			}
			else 
			{
				echo "On";
			}
			die();
		}
		
		else if($_REQUEST['target'] == "getCustomerCount")
		{
			$count = $wpdb->get_var
			(
				$wpdb->prepare
				(
			 		'SELECT count(CustomerId) FROM ' . customersTable() ,''
				)
			);
			echo $count;
			die();
		}
		else if($_REQUEST['target'] == "getBookingCount")
		{
			$count = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(BookingId) FROM ' . bookingTable(),''
				)
			);
			echo $count;
			die();
		}
		else if($_REQUEST['target'] == "ReminderSettingsShow")
		{
			$uxReminderSettings = esc_attr($_REQUEST['uxReminderSettings']);
			$ReminderSettings = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where   GeneralSettingsKey = %s',
					"reminder-settings"
				)
			);
			$ReminderSettingsInterval = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where   GeneralSettingsKey = %s',
					"reminder-settings-interval"
				)
			);
			if($ReminderSettings == 1)
			{
				echo _e( "On", bookings_engine );
			}
			else
			{
				echo _e( "Off", bookings_engine );
			}
			die();
		}
		else if($_REQUEST['target'] == "getPaypalStatus")
		{
			$PPStatus = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT PaymentGatewayValue FROM ' . payment_Gateway_settingsTable() . ' where   PaymentGatewayKey = %s',
					"paypal-enabled"
				)
			);
			if($PPStatus == 0)
			{
				echo _e( "Off", bookings_engine );
			}
			else 
			{
				echo _e( "On", bookings_engine );
			}
			die();
		}
		else if($_REQUEST['target'] == "updateGeneralSettings")
		{
			$uxDefaultcurrency = esc_attr($_REQUEST['uxDefaultcurrency']);
			$uxDefaultcountry = esc_attr($_REQUEST['uxDefaultcountry']);
			$uxDefaultTimeFormat = intval($_REQUEST['uxDefaultTimeFormat']);
			$uxDefaultDateFormat = $_REQUEST['uxDefaultDateFormat'];
			$StaffManagement = intval($_REQUEST['StaffManagement']);
			$uxServiceDisplayFormat = intval($_REQUEST['uxServiceDisplayFormat']);
			$default_Time_Zone = html_entity_decode($_REQUEST['default_Time_Zone']);
			$default_Time_Zone_Name = html_entity_decode($_REQUEST['default_Time_Zone_Name']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".currenciesTable()." SET CurrencyUsed = %d  WHERE CurrencyName = %s",
					1,
					$uxDefaultcurrency
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".currenciesTable()." SET CurrencyUsed = %d  WHERE CurrencyName != %s",
					0,
					$uxDefaultcurrency
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".countriesTable()." SET CountryUsed = %d where CountryName = %s",
					1,
					$uxDefaultcountry
				)
			);	
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".countriesTable()." SET CountryUsed = %d where CountryName != %s",
					0,
					$uxDefaultcountry
				)
			);	
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %d  WHERE GeneralSettingsKey = %s",
					$uxDefaultTimeFormat,
					"default_Time_Format"
				)
			);
			
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %d  WHERE GeneralSettingsKey = %s",
					$uxDefaultDateFormat,
					"default_Date_Format"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %s  WHERE GeneralSettingsKey = %s",
					$default_Time_Zone,
					"default_Time_Zone"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %s  WHERE GeneralSettingsKey = %s",
					$default_Time_Zone_Name,
					"default_Time_Zone_Name"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %s  WHERE GeneralSettingsKey = %s",
					$StaffManagement,
					"default_Staff_Management_Settings"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %s  WHERE GeneralSettingsKey = %s",
					$uxServiceDisplayFormat,
					"default_Service_Display"
				)
			);
			die();
		}	
		else if($_REQUEST['target'] == "AutoApprove")
		{
			$uxAutoApprove = esc_attr($_REQUEST['uxAutoApprove']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %s WHERE GeneralSettingsKey = %s",
					$uxAutoApprove,
					"auto-approve-enable"
				)
			);
			die();
		}
		else if($_REQUEST['target'] == "AutoApproveShow")
		{
			$uxAutoApprove = esc_attr($_REQUEST['uxAutoApprove']);
			$AutoApprove = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where   GeneralSettingsKey = %s',
					"auto-approve-enable"
				)
			);
			if($AutoApprove == 1)
			{
				echo _e( "On", bookings_engine );
			}
			else 
			{
				echo _e( "Off", bookings_engine );
			}
			die();
		}
		else if($_REQUEST['target'] == "DeleteAllBookings")
		{
			$wpdb->query
			(
				$wpdb->prepare
				(
					"TRUNCATE Table ".bookingTable(),""
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"TRUNCATE Table ".multiple_bookingTable(),""
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"TRUNCATE Table ".bookingsCountTable(),""
				)
			);
			die();
		}	
		else if($_REQUEST['target'] == "RestoreFactorySettings")
		{
			include_once 'bookings-engine.php';
			executeDeleteDatabaseCalls();
			executeCreateDatabaseCalls();
			die();
		}
		else if($_REQUEST['target'] == "editService")
		{
			$serviceId = intval($_REQUEST['serviceId']);
			$uxServiceEdit = $wpdb->get_row
			(
				$wpdb->prepare
				(
					'SELECT ServiceName,ServiceCost,ServiceTotalTime,ServiceMaxBookings,Type,ServiceColorCode,ServiceFullDay,
					ServiceStartTime,ServiceEndTime,MaxDays,CostType FROM ' . servicesTable() . ' where ServiceId = %d',
					$serviceId
				)
			); 
			$CheckBooking = $wpdb->get_var 
			(
				$wpdb->prepare
				(
					'SELECT count(ServiceId) FROM ' . bookingTable() . ' where ServiceId = %d',
					$serviceId
				)
			);
			?>
			<div class="body">
				<div class="block well" style="margin:10px;">
					<div class="box">
						<div class="content">
							<div class="row">
								<label><?php _e( "Service Color :", bookings_engine ); ?></label>
								<div class="right">
									<div id="EditcolorPickerService" class="cw-color-picker" rel="uxEditServiceColorCode" style="position: absolute;z-index: 1111;background: #fff;border: 1px solid;margin-top:30px;"></div>		
									<input class="widefat" type="text" value="<?php echo $uxServiceEdit->ServiceColorCode; ?>"  id="uxEditServiceColorCode" name="uxEditServiceColorCode"  onfocus="colorFocus();" onblur="colorHide();" style="color:#000;">	                            	                             
								</div>
							</div>
						</div>
						<div class="row">
							<label><?php _e( "Service Name :", bookings_engine ); ?></label>
							<div class="right">
								<input type="text" class="required span12" name="uxEditServiceName" id="uxEditServiceName" value="<?php echo $uxServiceEdit->ServiceName; ?>"/>
							</div>
						</div>
						<div class="row">
							<label><?php _e( "Cost :", bookings_engine ); ?></label>
							<div class="right">
								<input type="text" class="required span12" name="uxEditServiceCost" id="uxEditServiceCost" value="<?php echo $uxServiceEdit->ServiceCost; ?>"/>
							</div>
						</div>
						<div class="row">
							<label><?php _e( "Service Type :", bookings_engine );?></label>
							<?php
							if($uxServiceEdit->Type == 0)
							{
							?>
								<div class="right">
									<input type="radio" id="uxEditServiceTypeEnable" name="uxEditServiceType" class="style" value="0" onclick="singleBookingType();" checked="checked">&nbsp;&nbsp;<?php _e( "Single Booking", bookings_engine );?>
									<input type="radio" id="uxEditServiceTypeDisable" name="uxEditServiceType" onclick="groupBookingType();" class="style" value="1">&nbsp;&nbsp;<?php _e( "Group Bookings", bookings_engine );?>
								</div>
							<?php
							}
							else
							{
							?>
								<div class="right">
									<input type="radio" id="uxEditServiceTypeEnable" name="uxEditServiceType" class="style" value="0" onclick="singleBookingType();">&nbsp;&nbsp;<?php _e( "Single Booking", bookings_engine );?>
									<input type="radio" id="uxEditServiceTypeDisable" name="uxEditServiceType" onclick="groupBookingType();" class="style" value="1" checked="checked">&nbsp;&nbsp;<?php _e( "Group Bookings", bookings_engine );?>	
								</div>
							<?php
							}
							?>
						</div>
						<?php
							if($uxServiceEdit->Type == 0)
							{
						?>
								<div class="row" id="editMaxBooking" style="display: none;">
									<label><?php _e( "Max Bookings<br/>(Each Slot) :", bookings_engine ); ?></label>
									<div class="right">
										<input type="text" class="required span12" name="uxEditMaxBookings" id="uxEditMaxBookings" value="<?php echo $uxServiceEdit->ServiceMaxBookings; ?>"/>
									</div>
								</div>
							<?php
							}
							else 
							{
								?>
								<div class="row" id="editMaxBooking" style="display: block;">
									<label><?php _e( "Max Bookings<br/>(Each Slot) :", bookings_engine ); ?></label>
									<div class="right">
										<input type="text" class="required span12" name="uxEditMaxBookings" id="uxEditMaxBookings" value="<?php echo $uxServiceEdit->ServiceMaxBookings; ?>"/>
									</div>
								</div>
								<?php
							}
							?>
								<div class="row">
									<label><?php _e( "Full Day Service :", bookings_engine ); ?></label>
									<div class="right">
										<?php
										if($uxServiceEdit->ServiceFullDay == 1)
										{
											?>
			  								<input type="checkbox" value="" checked="checked"  id="uxEditFullDayService" name="uxEditFullDayService" onclick="divEditControlsShowHide();" >
			  								<?php
										}
										else
										{
											?>
			  								<input type="checkbox" value=""  id="uxEditFullDayService" name="uxEditFullDayService" onclick="divEditControlsShowHide();" >
			  								<?php
										}
										?>
									</div>
								</div>
							<?php
							if($uxServiceEdit->ServiceFullDay == 0)
							{
							?>
								<div class="row" id="divEditMaxDays" style="display : none;">
									<label><?php _e( "Allow Max. Days :", bookings_engine ); ?></label>
									<div class="right">
									<?php
										$MaxDays = $uxServiceEdit->MaxDays;
									?>
										<select name="uxEditMaxDays" id="uxEditMaxDays" class="required" style="width:100px;">
											<option value="Unlimited"><?php _e("Unlimited",bookings_engine); ?></option>
									<?php
									for($days = 1; $days < 31; $days++)
									{
										if($days == $MaxDays)
										{
											echo "<option selected='selected' value=" . $days . " >" . $days . " </option>";
										}
										else 
										{
											?>
											<option value="<?php echo $days; ?>"><?php echo $days; ?></option>
											<?php
										}
									}
									?>
										</select>
									</div>
								</div>
							<?php
							}
							else 
							{
								?>
								<div class="row" id="divEditMaxDays" style="display : block;">
									<label><?php _e( "Allow Max. Days :", bookings_engine ); ?></label>
									<div class="right">
									<?php
										$MaxDays = $uxServiceEdit->MaxDays;
									?>
										<select name="uxEditMaxDays" id="uxEditMaxDays" class="required" style="width:100px;">
											<option value="Unlimited"><?php _e("Unlimited",bookings_engine); ?></option>
										<?php
										for($days = 1; $days < 31; $days++)
										{
											if($days == $MaxDays)
											{
												echo "<option selected='selected' value=" . $days . " >" . $days . " </option>";
											}
											else 
											{
												?>
												<option value="<?php echo $days; ?>"><?php echo $days; ?></option>
												<?php
											}
										}
										?>
										</select>
									</div>
								</div>
							<?php
							}
							if($uxServiceEdit->ServiceFullDay == 0)
							{
								?>
								<div class="row" id="divEditCostType" style="display : none;">
									<label><?php _e( "Cost Type :", bookings_engine ); ?></label>
									<div class="right">
										<input type="radio" id="uxEditCostType" name="uxEditCostType" class="style" value="0" checked="checked">&nbsp;&nbsp;<?php _e( "Per day", bookings_engine );?>
										<input type="radio" id="uxEditCostType" name="uxEditCostType" class="style" value="1">&nbsp;&nbsp;<?php _e( "Fixed", bookings_engine );?>
									</div>
								</div>
							<?php
							}
							else 
							{
							?>
								<div class="row" id="divEditCostType" style="display : block;">
									<label><?php _e( "Cost Type :", bookings_engine ); ?></label>
									<?php
									$CostType = $uxServiceEdit->CostType;
									if($CostType == 0)
									{
									?>
										<div class="right">
											<input type="radio" id="uxEditCostType" name="uxEditCostType" class="style" value="0" checked="checked">&nbsp;&nbsp;<?php _e( "Per day", bookings_engine );?>
											<input type="radio" id="uxEditCostType" name="uxEditCostType" class="style" value="1">&nbsp;&nbsp;<?php _e( "Fixed", bookings_engine );?>
										</div>
									<?php
									}
									else 
									{
									?>
										<div class="right">
											<input type="radio" id="uxEditCostType" name="uxEditCostType" class="style" value="0">&nbsp;&nbsp;<?php _e( "Per day", bookings_engine );?>
											<input type="radio" id="uxEditCostType" name="uxEditCostType" class="style" value="1" checked="checked">&nbsp;&nbsp;<?php _e( "Fixed", bookings_engine );?>
										</div>
									<?php
									}
									?>
								</div>
								<?php
							}
							if($uxServiceEdit->ServiceFullDay == 0)
							{
								?>
								<div class="row" id="divEditServiceTime" style="display:block">
									<label><?php _e( "Service Time :", bookings_engine ); ?></label>
									<?php
										$serviceTotalTime =  $uxServiceEdit->ServiceTotalTime;
										$getHours_bookings = floor(($serviceTotalTime)/60);
										$getTMins_bookings = ($serviceTotalTime) % 60;
										$hourFormat_bookings = $getHours_bookings . ":" . "00";
										$STT  = DATE("H", STRTOTIME($hourFormat_bookings));
									?>
									<div class="right">
										<select name="uxEditServiceHours" class="required" id="uxEditServiceHours" style="width:100px;" >
										<?php
											for ($hr = 0; $hr <= 23; $hr++) 
											{
												if($hr == $STT)
												{
													if($hr < 10)
													{
														echo "<option selected='selected' value=0" . $hr . " >0" . $hr . " Hours</option>";
													}
													else 
													{
														?>
														<option selected="selected" value="<?php echo $hr; ?>"><?php _e( $hr, 'bookings_engine' ) . _e( " Hours", bookings_engine ); ?></option>
														<?php
														}
												}
												else 
												{
													if($hr < 10)
													{
														echo "<option value=0" . $hr . " >0" . $hr . " Hours</option>";
													}
													else 
													{
														?>
														<option value="<?php echo $hr; ?>"><?php  _e( $hr, bookings_engine ) . _e( " Hours", bookings_engine ); ?></option>
														<?php
													}
												}
											}
											?>
										</select>
										<select name="uxEditServiceMins" class="required" id="uxEditServiceMins" style="width:100px;" >
										<?php
											for ($min = 0; $min < 60; $min += 5) 
											{
												if($min == $getTMins_bookings)
												{
													if($min < 10)
													{
														echo "<option selected='selected' value=0" . $min . ">0" . $min . " Minutes</option>";	
													}
													else 
													{
														?>
														<option selected="selected" value="<?php echo $min; ?>"><?php _e( $min, 'bookings_engine' ) . _e( " Minutes", bookings_engine ); ?></option>
														<?php
													}
												}
												else 
												{
													if($min < 10)
													{
														echo "<option value=0" . $min . ">0" . $min . " Minutes</option>";	
													}
													else 
													{
														?>
													<option value="<?php echo $min; ?>"><?php  _e( $min, bookings_engine ) . _e( " Minutes", bookings_engine ); ?></option>
													<?php
													}
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="row" id="divEditStartTime" style="display:block">
									<label><?php _e( "Start Time :", bookings_engine ); ?></label>
									<?php
										$timeFormats = $wpdb->get_var
										(
											$wpdb->prepare
											(
												"SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = %s",
												'default_Time_Format'
											)
										);
									$serviceStTime =  $uxServiceEdit->ServiceStartTime;
									$getHours_bookings = floor(($serviceStTime)/60);
									$getMins_bookings = ($serviceStTime) % 60;
									$hourFormat_bookings = $getHours_bookings . ":" . "00";
									if($timeFormats == 0)
									{
										$Shr  = DATE("g", STRTOTIME($hourFormat_bookings));
										$Am = DATE("A", STRTOTIME($hourFormat_bookings));
									}
									else 
									{
										$Shr  = DATE("H", STRTOTIME($hourFormat_bookings));
									}
									?>
									<div class="right">
										<select name="uxEditStartTimeHours" class="required" id="uxEditStartTimeHours" style="width:50px;" >
										<?php
											for ($hr = 0; $hr <= 12; $hr++) 
											{
												if($hr == $Shr)
												{
													if($hr < 10)
													{
														echo "<option selected='selected' value=0" . $hr . " >0" . $hr . " </option>";
													}
													else 
													{
														?>
														<option selected='selected' value=" <?php echo $hr; ?>"> <?php _e( $hr, 'bookings_engine' ); ?> </option>
														<?php
													}
												}
												else 
												{
													if($hr < 10)
													{
														echo "<option value=0" . $hr . " >0" . $hr . " </option>";
													}
													else 
													{
														?>
														<option value=" <?php echo $hr; ?>"> <?php _e( $hr, 'bookings_engine' ); ?> </option>
														<?php
													}	
												}
											}
											?>
										</select>
										<select name="uxEditStartTimeMins" class="required" id="uxEditStartTimeMins" style="width:50px;" >
										<?php
											for ($min = 0; $min < 60; $min += 5) 
											{
												if($min == $getMins_bookings)
												{
													if($min < 10)
													{
														echo "<option selected='selected' value=0" . $min . ">0" . $min . " </option>";
													}
													else
													{
														?>
														<option selected='selected' value=" <?php echo $min; ?>"> <?php _e( $min, 'bookings_engine' ); ?> </option>
														<?php
													}
												}
												else
												{
													if($min < 10)
													{
														echo "<option value=0" . $min . ">0" . $min . " </option>";
													}
													else 
													{
														?>
														<option value=" <?php echo $min; ?>"> <?php _e( $min, 'bookings_engine' ); ?> </option>
														<?php
													}
												}
											}
											?>
										</select>
										<select name="uxEditStartTimeAMPM" class="required" id="uxEditStartTimeAMPM" style="width:50px;" >
										<?php
											if($Am == "AM")
											{
												echo "<option selected='selected' value='AM'>AM</option>";
												echo "<option value='PM'>PM</option>";
											}
											else 
											{
												echo "<option value='AM'>AM</option>";
												echo "<option selected='selected' value='PM'>PM</option>";
											}	
											?>
										</select>
									</div>
								</div>
								<div class="row" id="divEditEndTime" style="display:block">
									<label><?php _e( "End Time :", bookings_engine ); ?></label>
									<?php
										$serviceEndTime =  $uxServiceEdit->ServiceEndTime;
										$getHours_bookings = floor(($serviceEndTime)/60);
										$getMins_bookings = ($serviceEndTime) % 60;
										$hourFormat_bookings = $getHours_bookings . ":" . "00";
										if($timeFormats == 0)
										{
											$Ehr  = DATE("g", STRTOTIME($hourFormat_bookings));
											$Am = DATE("A", STRTOTIME($hourFormat_bookings));
										}
										else
										{
											$Ehr  = DATE("H", STRTOTIME($hourFormat_bookings));
											$Am = DATE("A", STRTOTIME($hourFormat_bookings));
										}
									?>
									<div class="right">
										<select name="uxEditEndTimeHours" class="required" id="uxEditEndTimeHours" style="width:50px;" >
										<?php
										for ($hr = 0; $hr <= 12; $hr++) 
										{
											if($hr == $Ehr)
											{
												if($hr < 10)
												{
													echo "<option selected='selected' value=0" . $hr . " >0" . $hr . " </option>";
												}
												else 
												{
													echo "<option selected='selected' value=" . $hr . ">" . $hr . "</option>";
												}
											}
											else 
											{
												if($hr < 10)
												{
													echo "<option value=0" . $hr . " >0" . $hr . " </option>";
												}
												else 
												{
													echo "<option value=" . $hr . ">" . $hr . "</option>";
												}
											}
										}
										?>
										</select>
										<select name="uxEditEndTimeMins" class="required" id="uxEditEndTimeMins" style="width:50px;" >
										<?php
											for ($min = 0; $min < 60; $min += 5) 
											{
												if($min == $getMins_bookings)
												{
													if($min < 10)
													{
														echo "<option selected='selected' value=0" . $min . ">0" . $min . " </option>";
													}
													else
													{
														echo "<option selected='selected' value=" . $min . ">" . $min . "</option>";
													}
												}
												else
												{
													if($min < 10)
													{
														echo "<option value=0" . $min . ">0" . $min . " </option>";
													}
													else 
													{
														echo "<option value=" . $min . ">" . $min . "</option>";
													}
												}
											}
											?>
										</select>
										<select name="uxEditEndTimeAMPM" class="required" id="uxEditEndTimeAMPM" style="width:50px;" >
										<?php
											if($Am == "AM")
											{
												echo "<option selected='selected' value='AM'>AM</option>";
												echo "<option value='PM'>PM</option>";
											}
											else 
											{
												echo "<option value='AM'>AM</option>";
												echo "<option selected='selected' value='PM'>PM</option>";
											}	
											?>
										</select>
									</div>
								</div>
							<?php
	 						}
							else 
							{
								?>
								<div class="row" id="divEditServiceTime" style="display:none">
									<label><?php _e( "Service Time :", bookings_engine ); ?></label>
									<?php
										$serviceTotalTime =  $uxServiceEdit->ServiceTotalTime;
										$getHours_bookings = floor(($serviceTotalTime)/60);
										$getTMins_bookings = ($serviceTotalTime) % 60;
										$hourFormat_bookings = $getHours_bookings . ":" . "00";
										$STT  = DATE("H", STRTOTIME($hourFormat_bookings));
									?>
									<div class="right">
										<select name="uxEditServiceHours" class="required" id="uxEditServiceHours" style="width:100px;" >
										<?php
											for ($hr = 0; $hr <= 23; $hr++) 
											{
												if($hr == $STT)
												{
													if($hr < 10)
													{
														echo "<option selected='selected' value=0" . $hr . " >0" . $hr . " Hours</option>";
													}
													else 
													{
														?>
														<option selected="selected" value="<?php echo $hr; ?>"><?php _e( $hr, 'bookings_engine' ) . _e( " Hours", bookings_engine ); ?></option>
														<?php
													}
												}
												else 
												{
													if($hr < 10)
													{
														echo "<option value=0" . $hr . " >0" . $hr . " Hours</option>";
													}
													else {
														?>
													<option value="<?php echo $hr; ?>"><?php  _e( $hr, bookings_engine ) . _e( " Hours", bookings_engine ); ?></option>
													<?php
													}
												}
											}
											?>
										</select>
										<select name="uxEditServiceMins" class="required" id="uxEditServiceMins" style="width:100px;" >
										<?php
											for ($min = 0; $min < 60; $min += 5) 
											{
												if($min == $getTMins_bookings)
												{
													if($min < 10)
													{
														echo "<option selected='selected' value=0" . $min . ">0" . $min . " Minutes</option>";	
													}
													else 
													{
														?>
														<option selected="selected" value="<?php echo $min; ?>"><?php _e( $min, 'bookings_engine' ) . _e( " Minutes", bookings_engine ); ?></option>
														<?php
													}
												}
												else 
												{
													if($min < 10)
													{
														echo "<option value=0" . $min . ">0" . $min . " Minutes</option>";	
													}
													else 
													{
														?>
													<option value="<?php echo $min; ?>"><?php  _e( $min, bookings_engine ) . _e( " Minutes", bookings_engine ); ?></option>
													<?php
													}
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="row" id="divEditStartTime" style="display:none">
									<label><?php _e( "Start Time :", bookings_engine ); ?></label>
									<?php
										$timeFormats = $wpdb->get_var
										(
											$wpdb->prepare
											(
												"SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = %s",
												'default_Time_Format'
											)
										);
										$serviceStTime =  $uxServiceEdit->ServiceStartTime;
										$getHours_bookings = floor(($serviceStTime)/60);
										$getMins_bookings = ($serviceStTime) % 60;
										$hourFormat_bookings = $getHours_bookings . ":" . "00";
										if($timeFormats == 0)
										{
											$Shr  = DATE("g", STRTOTIME($hourFormat_bookings));
											$Am = DATE("A", STRTOTIME($hourFormat_bookings));
										}
										else 
										{
											$Shr  = DATE("H", STRTOTIME($hourFormat_bookings));
										}
									?>
									<div class="right">
										<select name="uxEditStartTimeHours" class="required" id="uxEditStartTimeHours" style="width:50px;" >
										<?php
										for ($hr = 0; $hr <= 12; $hr++) 
										{
												if($hr == $Shr)
												{
													if($hr < 10)
													{
														echo "<option selected='selected' value=0" . $hr . " >0" . $hr . " </option>";
													}
													else 
													{
														?>
														<option selected='selected' value=" <?php echo $hr; ?>"> <?php _e( $hr, 'bookings_engine' ); ?> </option>
														<?php
													}
												}
												else 
												{
													if($hr < 10)
													{
														echo "<option value=0" . $hr . " >0" . $hr . " </option>";
													}
													else 
													{
														?>
														<option value=" <?php echo $hr; ?>"> <?php _e( $hr, 'bookings_engine' ); ?> </option>
														<?php
													}
												}
												
											}
											?>
										</select>
										<select name="uxEditStartTimeMins" class="required" id="uxEditStartTimeMins" style="width:50px;" >
										<?php
											for ($min = 0; $min < 60; $min += 5) 
											{
												if($min == $getMins_bookings)
												{
													if($min < 10)
													{
														echo "<option selected='selected' value=0" . $min . ">0" . $min . " </option>";
													}
													else
													{
														?>
														<option selected='selected' value=" <?php echo $min; ?>"> <?php _e( $min, 'bookings_engine' ); ?> </option>
														<?php
													}
												}
												else
												{
													if($min < 10)
													{
														echo "<option value=0" . $min . ">0" . $min . " </option>";
													}
													else 
													{
														?>
														<option value=" <?php echo $min; ?>"> <?php _e( $min, 'bookings_engine' ); ?> </option>
														<?php
													}
												}
											}
											?>
										</select>
										<select name="uxEditStartTimeAMPM" class="required" id="uxEditStartTimeAMPM" style="width:50px;" >
										<?php
										if($Am == "AM")
										{
											echo "<option selected='selected' value='AM'>AM</option>";
											echo "<option value='PM'>PM</option>";
										}
										else 
										{
											echo "<option value='AM'>AM</option>";
											echo "<option selected='selected' value='PM'>PM</option>";
										}
											?>
										</select>
									</div>
								</div>
								<div class="row" id="divEditEndTime" style="display:none">
									<label><?php _e( "End Time :", bookings_engine ); ?></label>
									<?php
										$serviceEndTime =  $uxServiceEdit->ServiceEndTime;
										$getHours_bookings = floor(($serviceEndTime)/60);
										$getMins_bookings = ($serviceEndTime) % 60;
										$hourFormat_bookings = $getHours_bookings . ":" . "00";
										if($timeFormats == 0)
										{
											$Ehr  = DATE("g", STRTOTIME($hourFormat_bookings));
											$Am = DATE("A", STRTOTIME($hourFormat_bookings));
										}
										else 
										{
											$Ehr  = DATE("H", STRTOTIME($hourFormat_bookings));
											$Am = DATE("A", STRTOTIME($hourFormat_bookings));
										}
									?>
									<div class="right">
										<select name="uxEditEndTimeHours" class="required" id="uxEditEndTimeHours" style="width:50px;" >
										<?php
											for ($hr = 0; $hr <= 12; $hr++) 
											{
											if($hr == $Ehr)
											{
												if($hr < 10)
												{
													echo "<option selected='selected' value=0" . $hr . " >0" . $hr . " </option>";
												}
												else 
												{
													echo "<option selected='selected' value=" . $hr . ">" . $hr . "</option>";
												}
											}
											else 
											{
												if($hr < 10)
												{
													echo "<option value=0" . $hr . " >0" . $hr . " </option>";
												}
												else
												{
													echo "<option value=" . $hr . ">" . $hr . "</option>";
												}
											}
										}
										?>
										</select>
										<select name="uxEditEndTimeMins" class="required" id="uxEditEndTimeMins" style="width:50px;" >
										<?php
										for ($min = 0; $min < 60; $min += 5) 
											{
												if($min == $getMins_bookings)
												{
													if($min < 10)
													{
														echo "<option selected='selected' value=0" . $min . ">0" . $min . " </option>";
													}
													else
													{
														echo "<option selected='selected' value=" . $min . ">" . $min . "</option>";
													}
												}
												else
												{
													if($min < 10)
													{
														echo "<option value=0" . $min . ">0" . $min . " </option>";
													}
													else 
													{
														echo "<option value=" . $min . ">" . $min . "</option>";
													}
												}
											}
											?>
										</select>
										<select name="uxEditEndTimeAMPM" class="required" id="uxEditEndTimeAMPM" style="width:50px;" >
										<?php
											if($Am == "AM")
											{
												echo "<option selected='selected' value='AM'>AM</option>";
												echo "<option value='PM'>PM</option>";
											}
											else 
											{
												echo "<option value='AM'>AM</option>";
												echo "<option selected='selected' value='PM'>PM</option>";
											}	
											?>
										</select>
									</div>
								</div>
								<?php
								}
							?>
					</div>
				</div>
			</div>
			<input type="hidden" id="hiddenServiceId" name="hiddenServiceId" value="<?php echo $serviceId; ?>" />
			<script>
				jQuery('.cw-color-picker').each(function()
				{
					var $this = jQuery(this),
					id = $this.attr('rel');
					$this.farbtastic('#' + id);
				});
			</script>
			<?php
			die();
		}
		else if($_REQUEST['target'] == "updateServiceTable")
		{
			$serviceId = intval($_REQUEST['serviceId']);
			$uxEditServiceName = html_entity_decode($_REQUEST['uxEditServiceName']);
			$uxEditServiceCost = doubleval($_REQUEST['uxEditServiceCost']);
			$uxEditMaxBookings = intval($_REQUEST['uxEditMaxBookings']);
			$uxEditServiceType = intval($_REQUEST['uxEditServiceType']);
			$uxEditServiceColorCode = esc_attr($_REQUEST['uxEditServiceColorCode']);
			$uxEditServiceHours = intval($_REQUEST['uxEditServiceHours']);
			$uxEditServiceMins = intval($_REQUEST['uxEditServiceMins']);
			$servTotalTime = $uxEditServiceHours * 60 + $uxEditServiceMins;
			$uxEditStartTimeHours = intval($_REQUEST['uxEditStartTimeHours']);
			$uxEditStartTimeMins = intval($_REQUEST['uxEditStartTimeMins']);
			$uxEditStartTimeAMPM = esc_attr($_REQUEST['uxEditStartTimeAMPM']);
			$uxEditEndTimeHours = intval($_REQUEST['uxEditEndTimeHours']);
			$uxEditEndTimeMins= intval($_REQUEST['uxEditEndTimeMins']);
			$uxEditEndTimeAMPM = esc_attr($_REQUEST['uxEditEndTimeAMPM']);
			$uxEditFullDay = esc_attr($_REQUEST['uxEditFullDay']);
			$uxEditMaxDays = esc_attr($_REQUEST['uxEditMaxDays']);
			$uxEditCostType = intval($_REQUEST['uxEditCostType']);
			if($uxEditStartTimeAMPM == "PM")
			{
				if($uxEditStartTimeHours <= 11)
				{
					$uxEditStartTimeHour = $uxEditStartTimeHours + 12;
				}
				else if($uxEditStartTimeHours == 12)
				{
					$uxEditStartTimeHour = 12;
				}
			}
			else if($uxEditStrAmPm == "AM")
			{
				if($uxEditStartTimeHours == 12)
				{
					$uxEditStartTimeHour = 0;
				}
				else 
				{
					$uxEditStartTimeHour = $uxEditStartTimeHours;
				}
			}
			else 
			{
				$uxEditStartTimeHour = $uxEditStartTimeHours;
			}
			
			if($uxEditEndTimeAMPM == "PM")
			{
				if($uxEditEndTimeHours <= 11)
				{
					$uxEditEndTimeHour = $uxEditEndTimeHours + 12;
				}
				else if($uxEditEndTimeHours == 12)
				{
					$uxEditEndTimeHour = 12;
				}
			}
			else if($uxEditStrAmPm == "AM")
			{
				if($uxEditEndTimeHours == 12)
				{
					$uxEditEndTimeHour = 0;
				}
				else 
				{
					$uxEditEndTimeHour = $uxEditEndTimeHours;
				}
			}
			else 
			{
				$uxEditEndTimeHour = $uxEditEndTimeHours;
			}
			if($uxEditFullDay == "0")
			{
				$ServiceTotalStartTime = ($uxEditStartTimeHour * 60) + $uxEditStartTimeMins;
				$ServiceTotalEndTime = ($uxEditEndTimeHour * 60) + $uxEditEndTimeMins;
			}
			else 
			{
				$ServiceTotalStartTime = 0;
				$ServiceTotalEndTime = 0;
				$servTotalTime = 0;
			}
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".servicesTable()." SET ServiceName = %s, ServiceCost = %f, ServiceMaxBookings = %d, Type = %d, ServiceColorCode = %s,
					ServiceFullDay = %d, ServiceTotalTime = %d, ServiceStartTime = %d, ServiceEndTime = %d, MaxDays = %s, CostType = %d WHERE ServiceId = %d",
					$uxEditServiceName,
					$uxEditServiceCost,
					$uxEditMaxBookings,
					$uxEditServiceType,
					$uxEditServiceColorCode,
					$uxEditFullDay,
					$servTotalTime,
					$ServiceTotalStartTime,
					$ServiceTotalEndTime,
					$uxEditMaxDays,
					$uxEditCostType,
					$serviceId
				)
			);
			die();
		}
		else if($_REQUEST['target'] == 'deleteService')
		{
				$serviceId = intval($_REQUEST['uxServiceId']);
				$countServiceId = $wpdb->get_var
				(
					$wpdb->prepare
					(
						'SELECT count(BookingId) FROM ' . bookingTable() . '  where ServiceId  = %d',
						$serviceId
					)
				);
				if($countServiceId !=0)
				{
					echo "booked"; 
				}
				else 
				{
					$wpdb->query
					(
						$wpdb->prepare
						(
							"DELETE FROM ".servicesTable()." WHERE serviceId = %d",
							$serviceId
						)
					);
				}
				die();
		} 
		else if($_REQUEST['target'] == "deleteBooking")
		{
			$bookingId = intval($_REQUEST['bookingId']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"DELETE FROM ".bookingTable()." WHERE BookingId = %d",
					$bookingId
				)
			);
			die();
		}
		else if($_REQUEST['target'] == 'resendBookingEmail')
		{
			include_once 'mails.php';
			$bookingId = intval($_REQUEST['bookingId']);
			$uxBookingStaus = esc_attr($_REQUEST['status']);
			if($uxBookingStaus == "Pending Approval")
			{
				MailManagement($bookingId,"approval_pending");	
				MailManagement($bookingId,"admin");			
			}
			else if($uxBookingStaus == "Approved")
			{
				MailManagement($bookingId,"approved");			
			}
			else if($uxBookingStaus == "Disapproved")
			{
				MailManagement($bookingId,"disapproved");		
			}
			die();
		}
		else if($_REQUEST['target'] == 'savedBookingForm')
		{
			$fieldcompare = html_entity_decode($_REQUEST['fieldcompare']);
			$bookingRadioVisible = intval($_REQUEST['bookingRadioVisible']);
			$bookingRadiooRequired = intval($_REQUEST['bookingRadiooRequired']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".bookingFormTable()." SET status = %d  WHERE BookingFormField = %s",
					$bookingRadioVisible,
					$fieldcompare
				)
			);
			if ($bookingRadioVisible == "0") 
			{
				$wpdb->query
				(
					$wpdb->prepare
					(
						"UPDATE ".bookingFormTable()." SET required = %d  WHERE BookingFormField = %s",
						0,
						$fieldcompare
					)
				);
			} 
			else 
			{
				if ($bookingRadiooRequired == "1") 
				{
					$wpdb->query
					(
						$wpdb->prepare
						(
							"UPDATE ".bookingFormTable()." SET required = %d  WHERE BookingFormField = %s",
							1,
							$fieldcompare
						)
					);	
					
				} 
				else 
				{
					$wpdb->query
					(
						$wpdb->prepare
						(
							"UPDATE ".bookingFormTable()." SET required = %d  WHERE BookingFormField = %s",
							0,
							$fieldcompare
						)
					);
				}
			}
			die();
			}
		
		else if($_REQUEST['target'] == "updatePendingConfirmationEmailTemplate")
		{
			$PendingConfirmationEmailTemplateSubject = html_entity_decode($_REQUEST['PendingConfirmationEmailTemplateSubject']);
			$PendingConfirmationEmailTemplateContent = html_entity_decode($_REQUEST['PendingConfirmationEmailTemplateContent']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".email_templatesTable()." SET EmailSubject = %s, EmailContent = %s  WHERE EmailType = %s",
					$PendingConfirmationEmailTemplateSubject,
					$PendingConfirmationEmailTemplateContent,
					"booking-pending-confirmation"
				)
			);
			die();
		}
		else if($_REQUEST['target'] == "updateConfirmationEmailTemplate")
		{
			$ConfirmationEmailTemplateSubject = html_entity_decode($_REQUEST['ConfirmationEmailTemplateSubject']);
			$ConfirmationEmailTemplateContent = html_entity_decode($_REQUEST['ConfirmationEmailTemplateContent']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".email_templatesTable()." SET EmailSubject = %s, EmailContent = %s  WHERE EmailType = %s",
					$ConfirmationEmailTemplateSubject,
					$ConfirmationEmailTemplateContent,
					"booking-confirmation"
				)
			);
			die();
		}
		else if($_REQUEST['target'] == "updateDeclinedEmailTemplate")
		{
			$DeclineEmailTemplateSubject = html_entity_decode($_REQUEST['DeclineEmailTemplateSubject']);
			$DeclineEmailTemplateContent = html_entity_decode($_REQUEST['DeclineEmailTemplateContent']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".email_templatesTable()." SET EmailSubject = %s, EmailContent = %s  WHERE EmailType = %s",
					$DeclineEmailTemplateSubject,
					$DeclineEmailTemplateContent,
					"booking-disapproved"
				)
			);
			die();
		}
		else if($_REQUEST['target'] == "updateAdminApproveDisapproveEmailTemplate")
		{
			$AdminApproveDisapproveEmailTemplateSubject = html_entity_decode($_REQUEST['AdminApproveDisapproveEmailTemplateSubject']);
			$AdminApproveDisapproveEmailTemplateContent = html_entity_decode($_REQUEST['AdminApproveDisapproveEmailTemplateContent']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".email_templatesTable()." SET EmailSubject = %s, EmailContent = %s  WHERE EmailType = %s",
					$AdminApproveDisapproveEmailTemplateSubject,
					$AdminApproveDisapproveEmailTemplateContent,
					"admin-control"
				)
			);
			die();
		}
		else if($_REQUEST['target'] == "updatePaypalAdminNotificationEmailTemplate")
		{
			$PaypalAdminNotificationEmailTemplateSubject = html_entity_decode($_REQUEST['PaypalAdminNotificationEmailTemplateSubject']);
			$PaypalAdminNotificationEmailTemplateContent = html_entity_decode($_REQUEST['PaypalAdminNotificationEmailTemplateContent']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".email_templatesTable()." SET EmailSubject = %s, EmailContent = %s  WHERE EmailType = %s",
					$PaypalAdminNotificationEmailTemplateSubject,
					$PaypalAdminNotificationEmailTemplateContent,
					"paypal-payment-notification"
				)
			);
			die();
		}
		else if($_REQUEST['target'] == "updatePaypalCancellationNotificationEmailTemplate")
		{
			$PaypalCancellationNotificationEmailTemplateSubject = html_entity_decode($_REQUEST['PaypalCancellationNotificationEmailTemplateSubject']);
			$PaypalCancellationNotificationEmailTemplateContent = html_entity_decode($_REQUEST['PaypalCancellationNotificationEmailTemplateContent']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".email_templatesTable()." SET EmailSubject = %s, EmailContent = %s  WHERE EmailType = %s",
					$PaypalCancellationNotificationEmailTemplateSubject,
					$PaypalCancellationNotificationEmailTemplateContent,
					"paypal-cancellation-notification"
				)
			);
			die();
		}
		else if($_REQUEST['target']== 'updateRecordsListings')
		{
			$updateRecordsArray = $_POST['recordsArray'];
			$listingCounter = 1;
			foreach ($updateRecordsArray as $recordIDValue)
			{
				$wpdb->query
				(
					$wpdb->prepare
					(
						"UPDATE ".servicesTable()." SET ServiceDisplayOrder  = %d WHERE ServiceId = %d",
						$listingCounter,
						$recordIDValue
					)
				);
				$listingCounter = $listingCounter + 1;
			}
			die();
	 	}
		else if($_REQUEST['target'] == 'reportABug')
		{
			$uxReportEmailAddress = esc_attr($_REQUEST['uxReportEmailAddress']);
			$uxReportBug = stripcslashes(html_entity_decode($_REQUEST['uxReportBug']));
			$uxReportSubject = stripcslashes(html_entity_decode($_REQUEST['uxReportSubject']));
			$to = "help@bookings-engine.com";
			$title=get_bloginfo('name');
			$headers= "From: " .$title. " <". $uxReportEmailAddress . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			$content = "
			<p>Email Address: ".$uxReportEmailAddress."
			</p><p>
			Bug: ".$uxReportBug."</p>";
			wp_mail($to,$uxReportSubject,$content,$headers);
			die();
		}
		else if($_REQUEST['target'] == 'becomeAff')
		{
			$uxReportEmailAddress = esc_attr($_REQUEST['uxReportEmailAddress']);
			$uxReportBug = stripcslashes(html_entity_decode($_REQUEST['uxReportBug']));
			$uxReportSubject = stripcslashes(html_entity_decode($_REQUEST['uxReportSubject']));
			$to = "help@bookings-engine.com";
			$title=get_bloginfo('name');
			$headers= "From: " .$title. " <". $uxReportEmailAddress . ">" ."\n" .
				"Content-Type: text/html; charset=\"" .
				get_option('blog_charset') . "\n";
			$content = "
			<p>Email Address: ".$uxReportEmailAddress."
			</p><p>
			Bug: ".$uxReportBug."</p>";
			wp_mail($to,$uxReportSubject,$content,$headers);
			die();
		}
		else if($_REQUEST['target'] == "editcustomers")
		{
			$customerId = intval($_REQUEST['customerId']);
			$customer = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".customersTable()." where CustomerId = %d",
					$customerId
				)
			);
			?>
			<div style="float:left;width:50%">
				<div class="row">
					<label class="control-label"><?php _e( "First Name :", bookings_engine ); ?></label>
					<div class="right">
						<input type="text" class="required" name="uxEditFirstName" id="uxEditFirstName" value="<?php echo $customer->CustomerFirstName;?>"/>
					</div>
				</div>
				<div class="row">
					<label class="control-label"><?php _e( "Last Name :", bookings_engine ); ?></label>
					<div class="right">
						<input type="text" class="required" name="uxEditLastName" id="uxEditLastName" value="<?php echo $customer->CustomerLastName;?>"/>
					</div>
				</div>
				<div class="row">
					<label class="control-label"><?php _e( "Email :", bookings_engine ); ?></label>
					<div class="right">
						<input type="text" class="required" name="uxEditEmailAddress" id="uxEditEmailAddress" value= "<?php echo $customer->CustomerEmail;?>"/>
					</div>
				</div>
				<div class="row">
					<label class="control-label"><?php _e( "Telephone :", bookings_engine ); ?></label>
					<div class="right">
						<input type="text" class="required span12" name="uxEditTelephoneNumber" id="uxEditTelephoneNumber" value="<?php echo $customer->CustomerTelephone;?>"/>
					</div>
				</div>
				<div class="row">
					<label class="control-label"><?php _e( "Mobile :", bookings_engine ); ?></label>
					<div class="right">
						<input type="text" class="required span12" name="uxEditMobileNumber" id="uxEditMobileNumber" value="<?php echo $customer->CustomerMobile;?>"/>
					</div>
				</div>
				<div class="row">
					<label class="control-label"><?php _e( "Skype Id :", bookings_engine ); ?></label>
					<div class="right">
						<input type="text" class="required span12" name="uxEditSkypeId" id="uxEditSkypeId" value="<?php echo $customer->CustomerSkypeId;?>"/>
					</div>
				</div>
				<div class="row">
					<label class="control-label"><?php _e( "Address 1 :", bookings_engine ); ?></label>
					<div class="right">
						<input type="text" class="required span12" name="uxEditAddress1" id="uxEditAddress1" value="<?php echo $customer->CustomerAddress1;?>"/>
					</div>
				</div>
			</div>
			<div style="float:left;width:50%">
				<div class="row">
					<label class="control-label"><?php _e( "Address 2 :", bookings_engine ); ?></label>
					<div class="right">
						<input type="text" class="required" name="uxEditAddress2" id="uxEditAddress2" value="<?php echo $customer->CustomerAddress2;?>"/>
					</div>
				</div>
				<div class="row">
					<label class="control-label"><?php _e( "City :", bookings_engine ); ?></label>
					<div class="right">
						<input type="text" class="required" name="uxEditCity" id="uxEditCity" value="<?php echo $customer->CustomerCity;?>"/>
					</div>
				</div>
				<div class="row">
					<label class="control-label"><?php _e( "Post Code :", bookings_engine ); ?></label>
					<div class="right">
						<input type="text" class="required" name="uxEditPostalCode" id="uxEditPostalCode" value= "<?php echo $customer->CustomerZipCode;?>"/>
					</div>
				</div>
				<div class="row">
					<label class="control-label"><?php _e( "Country :", bookings_engine ); ?></label>
					<div class="right">
						<select name="uxEditCountry" class="style required" id="uxEditCountry" style="margin-bottom:2px;">
						<?php
								$country = $wpdb->get_results
								(
									$wpdb->prepare
									(
										"SELECT CountryName,CountryId From ".countriesTable()." order by CountryName ASC"
									)
								);	
								$sel_country = $wpdb->get_var
								(
									$wpdb->prepare
									(
										"SELECT CountryName From ".countriesTable()." where CountryId = ".$customer->CustomerCountry
									)
								);
								for ($flagCountry = 0; $flagCountry < count($country); $flagCountry++)
								{
								?>
									<option value="<?php echo $country[$flagCountry]->CountryId;?>"><?php echo $country[$flagCountry]->CountryName;?></option>
								<?php 
								}
							?>
						</select>
					<script>
						jQuery('#uxEditCountry').val("<?php echo $customer->CustomerCountry;?>");
					</script>
				</div>
				</div>
				<div class="row">
					<label class="control-label"><?php _e( "Comments :", bookings_engine ); ?></label>
					<div class="right">
						<textarea class="required span12" name="uxEditComments" id="uxEditComments"  style="height:119px"><?php echo $customer->CustomerComments;?></textarea>
					</div>
				</div>
			</div>
			<input type="hidden" id="hiddenCustomerId" name="hiddenCustomerId" value="<?php echo $customer->CustomerId;?>" />
			<input type="hidden" id="hiddenCustomerName" name="hiddenCustomerName" value="<?php echo $customer->CustomerFirstName ." " . $customer->CustomerLastName ;?>" />		
			<?php
			die();
		}
		else if($_REQUEST['target'] == "updatecustomers")
		{
			echo $CustomerId = intval($_REQUEST['uxEditCustomerId']);
			$uxEditFirstName=esc_attr($_REQUEST['uxEditFirstName']);
			$uxEditLastName=esc_attr($_REQUEST['uxEditLastName']);
			$uxEditEmailAddress=esc_attr($_REQUEST['uxEditEmailAddress']);
			$uxEditTelephoneNumber=esc_attr($_REQUEST['uxEditTelephoneNumber']);
			$uxEditMobileNumber=esc_attr($_REQUEST['uxEditMobileNumber']);
			$uxEditAddress1=esc_attr($_REQUEST['uxEditAddress1']);
			$uxEditAddress2=esc_attr($_REQUEST['uxEditAddress2']);
			$uxEditCity=esc_attr($_REQUEST['uxEditCity']);
			$uxEditPostalCode=esc_attr($_REQUEST['uxEditPostalCode']);
			$uxEditCountry=intval($_REQUEST['uxEditCountry']);
			$uxEditComments=esc_attr($_REQUEST['uxEditComments']);
			$updateComments = esc_attr($_REQUEST['comment']);
			$uxEditSkypeId=esc_attr($_REQUEST['uxEditSkypeId']);
			if($updateComments != "no")
			{
				$wpdb->query
				(
					$wpdb->prepare
					(
						"UPDATE ".customersTable()." SET CustomerFirstName= %s, CustomerLastName = %s, CustomerEmail = %s,
						CustomerTelephone=%s, CustomerMobile = %s, CustomerAddress1=%s, CustomerAddress2=%s, CustomerCity=%s, 
						CustomerZipCode=%s,CustomerCountry=%d, CustomerComments=%s,CustomerSkypeId=%s WHERE CustomerId = %d",
						$uxEditFirstName,
						$uxEditLastName,
						$uxEditEmailAddress,
						$uxEditTelephoneNumber,
						$uxEditMobileNumber,
						$uxEditAddress1,
						$uxEditAddress2,
						$uxEditCity,
						$uxEditPostalCode,
						$uxEditCountry,
						$uxEditComments,
						$uxEditSkypeId,
						$CustomerId
					)
				);
			}
			else
			{
				$bookingFormData = $wpdb->get_results('SELECT * From '.bookingFormTable());
				for($flagField = 0; $flagField < count($bookingFormData); $flagField++)
				{
					if($bookingFormData[$flagField]->status == 1)
					{
						switch($bookingFormData[$flagField]->BookingFormId)
						{
							case 1:
							$wpdb->query
							(
								$wpdb->prepare
								(
									"UPDATE ".customersTable()." SET CustomerEmail = %s WHERE CustomerId = %d",
									$uxEditEmailAddress,
									$CustomerId
								)
							);	
							break;
							case 2:
							$wpdb->query
							(
								$wpdb->prepare
								(
									"UPDATE ".customersTable()." SET CustomerFirstName = %s WHERE CustomerId = %d",
									$uxEditFirstName,
									$CustomerId
								)
							);
							break;
							case 3:
							$wpdb->query
							(
								$wpdb->prepare
								(
									"UPDATE ".customersTable()." SET CustomerLastName = %s WHERE CustomerId = %d",
									$uxEditLastName,
									$CustomerId
								)
							);	
							break;
							case 4:
							$wpdb->query
							(
								$wpdb->prepare
								(
									"UPDATE ".customersTable()." SET CustomerMobile = %s WHERE CustomerId = %d",
									$uxEditMobileNumber,
									$CustomerId
								)
							);	
							break;
							case 5:
							$wpdb->query
							(
								$wpdb->prepare
								(
									"UPDATE ".customersTable()." SET CustomerTelephone = %s WHERE CustomerId = %d",
									$uxEditTelephoneNumber,
									$CustomerId
								)
							);	
							$customerPhone = $uxEditTelephoneNumber;
							break;
							case 6:
							$wpdb->query
							(
								$wpdb->prepare
								(
									"UPDATE ".customersTable()." SET CustomerAddress1 = %s WHERE CustomerId = %d",
									$uxEditAddress1,
									$CustomerId
								)
							);	
							break;
							case 7:
							$wpdb->query
							(
								$wpdb->prepare
								(
									"UPDATE ".customersTable()." SET CustomerAddress2 = %s WHERE CustomerId = %d",
									$uxEditAddress2,
									$CustomerId
								)
							);	
							break;
							case 8:
							$wpdb->query
							(
								$wpdb->prepare
								(
									"UPDATE ".customersTable()." SET CustomerCity = %s WHERE CustomerId = %d",
									$uxEditCity,
									$CustomerId
								)
							);	
							break;
							case 9:
							$wpdb->query
							(
								$wpdb->prepare
								(
									"UPDATE ".customersTable()." SET CustomerZipCode = %s WHERE CustomerId = %d",
									$uxEditPostalCode,
									$CustomerId
								)
							);	
							break;
							case 10:
							$wpdb->query
							(
								$wpdb->prepare
								(
									"UPDATE ".customersTable()." SET CustomerCountry = %d WHERE CustomerId = %d",
									$uxEditCountry,
									$CustomerId
								)
							);	
							break;
							case 11:
							$wpdb->query
							(
								$wpdb->prepare
								(
									"UPDATE ".customersTable()." SET CustomerSkypeId = %s WHERE CustomerId = %d",
									$uxEditSkypeId,
									$CustomerId
								)
							);	
							break;
						}
					}
				}
			}
			die();
		}
		else if($_REQUEST['target'] == "DeleteCustomer")
		{
			$customerId = intval($_REQUEST['uxcustomerId']);
			$countBooking = $wpdb->get_var('SELECT count(BookingId) FROM ' . bookingTable() . ' where CustomerId ='. $customerId);
			if($countBooking != 0)
			{
				echo _e( "bookingExist", booking_engine );
			}
			else
			{
				$wpdb->query
				(
					$wpdb->prepare
					(
						"DELETE FROM ".customersTable()." WHERE CustomerId = %d",
						$customerId
					)
				);
			}
			die();
		}
		else if($_REQUEST['target']== 'customerBooking')
		{
			?>
			<thead>
				<tr>
					<th><?php _e( "Service", bookings_engine ); ?></th>
					<th><?php _e( "Date", bookings_engine ); ?></th>
					<th><?php _e( "Time Slot", bookings_engine ); ?></th>
					<th><?php _e( "Status", bookings_engine ); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
			$customerId  = intval($_REQUEST['customerId']);
			$customerNameReturn = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT CustomerFirstName,CustomerLastName  FROM ".customersTable()." where CustomerId = %d ",
					$customerId
				)
			);
			$customerBookingDetail = $wpdb->get_results
			(
				$wpdb->prepare
				(
					"SELECT ". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceColorCode, ". servicesTable(). ".ServiceFullDay,  ". servicesTable(). ".ServiceStartTime,  ". servicesTable(). ".ServiceEndTime, 
					".bookingTable().".BookingDate,". bookingTable().".TimeSlot,". bookingTable().".BookingId,". bookingTable().".Comments,". bookingTable().".CustomerId,". bookingTable().".DateofBooking,
					". bookingTable().".BookingStatus,". bookingTable().".BookingId from ".bookingTable()." LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().
					".CustomerId= ".customersTable().".CustomerId ". " LEFT OUTER JOIN " .servicesTable()." ON ".bookingTable().
					".ServiceId=".servicesTable().".ServiceId where ".bookingTable().".CustomerId =  %d
					ORDER BY ".bookingTable().".BookingDate asc",
					$customerId
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
			$timeFormats = $wpdb->get_var
			(
				$wpdb->prepare
				(
					"SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = %s",
					'default_Time_Format'
				)
			);
			for($flag = 0; $flag < count($customerBookingDetail); $flag++)
			{
			$multipleBookings = $wpdb->get_results
			(
				$wpdb->prepare
				(
					"Select ".multiple_bookingTable().".bookingDate from ".multiple_bookingTable()." join 
					". bookingTable() ." on ".multiple_bookingTable().".bookingId = ". bookingTable() .".BookingId where ". bookingTable() .".CustomerId = %d 
					and ". bookingTable() .".BookingId = %d
					ORDER BY ".multiple_bookingTable().".bookingDate asc",
					$customerBookingDetail[$flag]->CustomerId,
					$customerBookingDetail[$flag]->BookingId
				)
			);
			$allocatedMultipleDates = "<div id=\"tags1_tagsinput\" class=\"tagsinput\" style=\"width: 100%; min-height: auto; height: auto;\">";
			for($MBflag=0; $MBflag < count($multipleBookings); $MBflag++)
			{
				
				if($dateFormat == 0)
				{
					$dateFormat =  date("M d, Y", strtotime($multipleBookings[$MBflag]->bookingDate));
				}
				else if($dateFormat == 1)
				{
					$dateFormat =  date("Y/m/d", strtotime($multipleBookings[$MBflag]->bookingDate));
				}	
				else if($dateFormat == 2)
				{
					$dateFormat = date("m/d/Y", strtotime($multipleBookings[$MBflag]->bookingDate));
				}
				else if($dateFormat == 3)
				{
					$dateFormat =  date("d/m/Y", strtotime($multipleBookings[$MBflag]->bookingDate));
				}	
				$allocatedMultipleDates .= "<span style=\"margin-left:5px;background-color:".$customerBookingDetail[$flag]->ServiceColorCode.";color:#fff;border:solid 1px ".$customerBookingDetail[$flag]->ServiceColorCode . "\" class=\"tag\"><span>" . $dateFormat . "</span></span>";
			}
				
			$allocatedMultipleDates.= "</div>";
			?>
			<tr>
				<td><?php echo $customerBookingDetail[$flag]->ServiceName; ?></td>
				<?php
					if($customerBookingDetail[$flag]->ServiceFullDay  == 1)
					{
					?>
						<td><?php echo $allocatedMultipleDates;?></td>
					<?php
					}
					else
					{
						if($dateFormat == 0)
						{
							?>
							<td><?php echo date("M d, Y", strtotime($customerBookingDetail[$flag]->BookingDate));?></td>
							<?php
						}
						else if($dateFormat == 1)
						{
						?>
							<td><?php echo date("Y/m/d", strtotime($customerBookingDetail[$flag]->BookingDate));?></td>
						<?php
						}	
						else if($dateFormat == 2)
						{
						?>
							<td><?php echo date("m/d/Y", strtotime($customerBookingDetail[$flag]->BookingDate));?></td>
						<?php
						}	
						else if($dateFormat == 3)
						{
						?>
							<td><?php echo date("d/m/Y", strtotime($customerBookingDetail[$flag]->BookingDate));?></td>
						<?php
						}
					}
					?>
					<?php
						$getHours_bookings = floor(($customerBookingDetail[$flag] -> ServiceStartTime)/60);
						$getMins_bookings = ($customerBookingDetail[$flag] -> ServiceStartTime) % 60;
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
						$getHours_bookings = floor(($customerBookingDetail[$flag] -> ServiceEndTime)/60);
						$getMins_bookings = ($customerBookingDetail[$flag] -> ServiceEndTime) % 60;
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
						if($customerBookingDetail[$flag]->ServiceFullDay == 0)
						{
						?>
							<td><?php echo $time_in_12_hour_format_bookings."-".$time_in_12_hour_format_bookings_End ?></td>
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
					<?php echo $customerBookingDetail[$flag]->BookingStatus; ?>
				</td>
				<td>
					<a class="icon-trash" onclick="deleteCustomerBooking(<?php echo $customerBookingDetail[$flag]->BookingId; ?>)"></a>
				</td>
			</tr>
			  </tbody>
			<?php
			}
			?>
			<input id="customerNameForBooking" type="hidden" value="<?php echo $customerNameReturn->CustomerFirstName . " ". $customerNameReturn->CustomerLastName ; ?>" />
			<script>
				oTable = jQuery('#data-table-customer-bookings').dataTable
				({
					"bJQueryUI": false,
					"bAutoWidth": true,
					"bDestroy": true,
					"sPaginationType": "full_numbers",
					"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
					"oLanguage": 
					{
						"sLengthMenu": "_MENU_"
					}
				});		
			</script>
			<?php
			die();
		}			
		else if($_REQUEST['target'] == 'updateCustomersComments')
		{
			$bookingId = intval($_REQUEST['bookingId']);
			$uxCustomerComments = html_entity_decode($_REQUEST['uxCustomerComments']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".bookingTable()." SET Comments  = %s WHERE BookingId = %d",
					$uxCustomerComments,
					$bookingId
				)
			);
			die();
		}
		else if($_REQUEST['target'] == 'customerBookingCommentsId')
		{
			$bookingId = intval($_REQUEST['bookingId']);
			echo $CustomerComments = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT Comments FROM ' . bookingTable() . ' where BookingId = %d',
					$bookingId
				)
			);
			die();
		}
		else if($_REQUEST['target'] == 'deleteCustomerBookings')
		{
			$bookingId = intval($_REQUEST['bookingId']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"DELETE from ".bookingTable()." where 	BookingId = %d",
					$bookingId
				)
			);
			die();
		}
		else if($_REQUEST['target'] == "frontendService")
		{
			$serviceId  = intval($_REQUEST['serviceId']);
			$service = $wpdb->get_row
			(
				$wpdb->prepare
				(
					'SELECT Type,ServiceCost,ServiceFullDay,MaxDays FROM '.servicesTable().'  WHERE ServiceId = %d ',
					$serviceId
				)
			);
			if($service->Type == 0)
			{
				$type = "Single Booking";
			}
			else
			{
				$type = "Multiple Booking";
			}
			echo $type .",".$service->ServiceCost.",".$service->ServiceFullDay;
			
			die();
		}	
		else if($_REQUEST['target'] == "frontendCalender")
		{
			$serviceId  = intval($_REQUEST['serviceId']);
			$currentdate = date("Y-m-d");
			$service = $wpdb->get_row
			(
				$wpdb->prepare
				(
					 'SELECT ServiceFullDay,ServiceMaxBookings,Type,MaxDays FROM '.servicesTable().'  WHERE ServiceId = %d ',
					 $serviceId
				)
			);
			$AllBlockOuts = $wpdb->get_results
			(
				$wpdb->prepare
				(
					 'SELECT * FROM '.block_outs().'  WHERE ServiceId = %d and FullDayBlockOuts =%d ',
					 $serviceId,
					 "1"
				)
			);
			$bookingCount = $wpdb->get_results
			(
				$wpdb->prepare
				(
					'SELECT CountTotal FROM '.bookingsCountTable() .' where ServiceId = %d and BookingDate > "%s"',
					$serviceId,
					$currentdate
				)
			);
			$allBookings =  $wpdb->get_results
			(
				$wpdb->prepare
				(
					'SELECT Distinct ('.bookingTable().'.BookingDate),'.bookingTable().'.serviceId,COUNT(*) as Total from '.bookingTable().' 
					 where '.bookingTable().'.BookingDate > "%s"  
					and  '.bookingTable().'.serviceId = %d GROUP BY  '.bookingTable().'.BookingDate',
					$currentdate,
					$serviceId
				)
			);
			$totalCountBookings = $wpdb->get_results
			(
				$wpdb->prepare
				(
					'Select * from ' . bookingsCountTable() . ' where ServiceId = %d',
					$serviceId
				)
			);
			//Array Initilization						
			$BookingCountTotal = array();
			$bookingDatesArray = array();
			$blockDatesArray = array();
			$weekDays = array();
			$WeekName = array();
			$dynamic = "";
			for($flagCount = 0 ;$flagCount < count($bookingCount); $flagCount++)
			{
				array_push($BookingCountTotal,$bookingCount[$flagCount]->CountTotal); 
			}
			for($flag = 0; $flag < count($totalCountBookings); $flag++)
			{
				if($totalCountBookings[$flag]->CountTotal > $service->ServiceMaxBookings)
				{
					array_push($bookingDatesArray,$allBookings[$flag]->BookingDate); 
				}
			}
			for($flagBlock = 0 ;$flagBlock < count($AllBlockOuts); $flagBlock++)
			{
				$dailyCase = $AllBlockOuts[$flagBlock]->Repeats;
				 
				// code for endate check
				if($AllBlockOuts[$flagBlock]->EndDate == 0)
				{
					$blockOutEndDate = date('Y-m-d',strtotime(date("Y-12-25", mktime()) . " + 1 year"));
				}
				else
				{
					$blockOutEndDate = $AllBlockOuts[$flagBlock]->EndDate;
				}
				$start_date = $AllBlockOuts[$flagBlock]->StartDate;
				// code for weekdays/daily case
				if($dailyCase == 0)
				{
					for($loopDate = $start_date; $loopDate < $blockOutEndDate ; $loopDate = date("Y-m-d", strtotime("+ ".$AllBlockOuts[$flagBlock]->RepeatEvery." day", strtotime($loopDate))))
					{
						array_push($blockDatesArray,$loopDate); 
					}
				}
				else 
				{
					$StartweekNumber = date("W", strtotime($start_date)); 
					$EndweekNumber = date("W", strtotime($blockOutEndDate));
					for( $Startweek = $StartweekNumber; $Startweek <= $EndweekNumber; $Startweek += $AllBlockOuts[$flagBlock]->RepeatEvery)
					{
					   array_push($weekDays,$Startweek); 
					}
					array_push($WeekName,$AllBlockOuts[$flagBlock]->RepeatDays);
				} 
			}
			$dynamic ='
				<script>jQuery("#calBindingMultiple").multiDatesPicker
				({
					altField: "#altField",
					beforeShowDay: disableSpecificWeekDays';
			if($service->ServiceFullDay == 1)
			{
				$MaxPicks = $service->MaxDays;
				if($service->MaxDays == "Unlimited" || $service->MaxDays == null)
				{
					 $dynamic .= ",
					numberOfMonths :3,
					fullDay:true
				});";
				}
				else 
				{
					$dynamic .= ",
					numberOfMonths:3,
					maxPicks: '$MaxPicks',
					changeMonth: false,
					fullDay:true
				});";
				}
			}
			else
			{
				$dynamic .= ",fullDay:false,addDisabledDates: []});";
			}
			$dynamic .='function disableSpecificWeekDays(date) 
						{
							var day = date.getDay();
							var yyyy = date.getFullYear().toString();
							var mm = (date.getMonth()+1).toString(); // getMonth() is zero-based
							var dd  = date.getDate().toString();
							var finalDate = yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
							var temp = new Date(date.getFullYear(),0,1);					
							var Sun = 0, Mon= 1, Tue = 2, Wed = 3, Thu = 4, Fri = 5, Sat = 6;
							var weekNow =  Math.ceil((((date - temp) / 86400000) + temp.getDay()+1)/7);
							var daysToDisable = [';
							for($loop = 0; $loop < count($blockDatesArray);$loop++)
							{
								if($loop < (count($blockDatesArray)- 1))
								{
									$dynamic.= strtotime($blockDatesArray[$loop]).",";
								}
								else 
								{
									$dynamic.= strtotime($blockDatesArray[$loop]);
								}
							}
							if($service->ServiceFullDay == 1)
							{
								if($service->Type == 1)
								{
									if(count($blockDatesArray) > 0 && count($bookingDatesArray) > 0)
									{
										$dynamic .= ",";
									}
									for($loop = 0; $loop < count($bookingDatesArray); $loop++)
									{
										if($loop < (count($bookingDatesArray)- 1))
										{
											$dynamic.= strtotime($bookingDatesArray[$loop]).",";
										}
										else 
										{
											$dynamic.= strtotime($bookingDatesArray[$loop]);
										}
									}
								}
								else
								{
									if(count($blockDatesArray) > 0 && count($totalCountBookings) > 0)
									{
										$dynamic .= ",";
									}
									for($loop = 0; $loop < count($totalCountBookings); $loop++)
									{
										if($loop < (count($totalCountBookings)- 1))
										{
											$dynamic.= strtotime($totalCountBookings[$loop]->BookingDate).",";
										}
										else 
										{
											$dynamic.= strtotime($totalCountBookings[$loop]->BookingDate);
										}
									}
								}
							}
							$dynamic .= "];";
							$dynamic .= "var weeksToBlock = [";
							for($loop = 0; $loop < count($weekDays);$loop++)
							{
								if($loop < (count($weekDays)- 1))
								{
									$dynamic.= $weekDays[$loop].",";											
								}
								else 
								{
									$dynamic.= $weekDays[$loop];
								}
							}
							$dynamic .= "];";
							$dynamic .= "var weekDays = [";
							for($weekN = 0; $weekN < count($WeekName); $weekN++)
							{
								if($weekN <  (count($WeekName)- 1))
								{
									$dynamic.= $WeekName[$weekN].",";
								}
								else 
								{
									$dynamic.= $WeekName[$weekN];
								}
							}
							$dynamic .='];';
							
							$dynamic .= 'if(daysToDisable.length > 0) 
										{
											if(jQuery.inArray(new Date(finalDate).valueOf() / 1000, daysToDisable) != -1)
											{
												return [false];
											 }
										}
										if(weeksToBlock.length > 0) 
										{
										 	if(jQuery.inArray(weekNow, weeksToBlock) != -1)
										 	{
										 		if(jQuery.inArray(day, weekDays) != -1)
												{
													return [false];
												}
												return [true];
											}
										}
										return [true];
									}';
							$dynamic .='</script>';
					echo $dynamic;
			die();
		}
		else if($_REQUEST['target'] == "frontEndMutipleDates")
		{
			$serviceId  = intval($_REQUEST['serviceId']);
			$uxCouponCode = esc_attr($_REQUEST['uxCouponCode']);
			$uxNotes = esc_attr($_REQUEST['uxNotes']);
			$altField = esc_attr($_REQUEST['altField']);
			$dates = explode(",", $altField);
			$bookingTime  = intval($_REQUEST['bookingTime']);
			$customerLastId = intval($_REQUEST['customerId']);
			$Status = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT GeneralSettingsValue FROM '.generalSettingsTable() .' where GeneralSettingsKey = %s',
					"auto-approve-enable"
				)
			);
			for($flagDates = 0; $flagDates < count($dates); $flagDates++)
			{
				$bookingCount = $wpdb->get_row
				(
					$wpdb->prepare
					(
						'SELECT count(bookingCountId),CountTotal FROM '. bookingsCountTable() .' where ServiceId = %d and BookingDate = "%s"',
						$serviceId,
						$dates[$flagDates]
					)
				);
				if($bookingCount->CountTotal == null)
				{
					$countTotals = 1;
					$wpdb->query
					(
						$wpdb->prepare
						(
							"INSERT INTO ".bookingsCountTable()."(ServiceId,BookingDate,CountTotal)
							VALUES(%d, '%s', %d)",
							$serviceId,
							$dates[$flagDates],
							$countTotals
						)
					);
				}
				else 
				{
					$countTotals = $bookingCount->CountTotal + 1;
					$wpdb->query
					(
						$wpdb->prepare
						(
							"Update ".bookingsCountTable()." SET ServiceId = %d, CountTotal = %d where ServiceId = %d and BookingDate = '%s' ", 
							$serviceId,
							$countTotals,
							$serviceId,
							$dates[$flagDates]
						)
					); 
				}
			}
			if($Status == "1")
			{
				$bookingStatus = "Approved";
			}
			else
			{
				$bookingStatus = "Pending Approval";
			}
			$serviceType = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT ServiceFullDay FROM '. servicesTable() .' where ServiceId = %d',
					$serviceId
				)
			);
			if($serviceType == 1)
			{
				$wpdb->query
				(
					$wpdb->prepare
					(
						"INSERT INTO ".bookingTable()."(CustomerId,ServiceId,BookingDate ,BookingStatus,couponCode,Comments,DateofBooking) 
						VALUES(%d, %d, '%s', %s, %s, %s, CURDATE())",
						$customerLastId,
						$serviceId,
						$dates[0],
						$bookingStatus,
						$uxCouponCode,
						$uxNotes
					)
				);
				$BookingId = $wpdb->insert_id;
				for($flag = 0; $flag < count($dates); $flag++)
				{
					$wpdb->query
					(
						$wpdb->prepare
						(
							"INSERT INTO ".multiple_bookingTable()."(bookingId,bookingDate) VALUES(%d, '%s')",
							$BookingId,
							$dates[$flag]
						)
					);
				}
				include_once 'mails.php';
				$payenable= $wpdb->get_var
				(
					$wpdb->prepare
					(
						'SELECT PaymentGatewayValue FROM ' . payment_Gateway_settingsTable() .' where PaymentGatewayKey = %s',
						"paypal-enabled"
					)
				);
				if($payenable == 1)
				{
					MailManagement($BookingId,"notification");
				}
				else 
				{
					if($Status == 1)
					{
						MailManagement($BookingId,"approved");
					}
					else
					{
						MailManagement($BookingId,"approval_pending");
					}
					MailManagement($BookingId,"admin");
				}
			}
			else
			{
				$wpdb->query
				(
					$wpdb->prepare
					(
						"INSERT INTO ".bookingTable()."(CustomerId,ServiceId,BookingDate ,BookingStatus,TimeSlot,couponCode,Comments,DateofBooking) VALUES(%d, %d, '%s', %s, %d, %s, %s, CURDATE())",
						$customerLastId,
						$serviceId,
						$dates[0],
						$bookingStatus,
						$bookingTime,
						$uxCouponCode,
						$uxNotes
					)
				);
				$BookingId = $wpdb->insert_id;
				include_once 'mails.php';
				$payenable= $wpdb->get_var
				(
					$wpdb->prepare
					(
						'SELECT PaymentGatewayValue FROM ' . payment_Gateway_settingsTable() .' where PaymentGatewayKey = %s',
						"paypal-enabled"
					)
				);
				if($payenable == 1)
				{
					MailManagement($BookingId,"notification");
				}
				else 
				{
					if($Status == 1)
					{
						MailManagement($BookingId,"approved");
					}
					else
					{
						MailManagement($BookingId,"approval_pending");
					}
					MailManagement($BookingId,"admin");
				}
			}
			die(); 
		}
		else if($_REQUEST['target'] == "getCouponCount")
		{
			$counting = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(couponId) FROM '. coupons(),''
				)
			);
			echo $counting;
			die();
		}
		else if($_REQUEST['target'] == 'recentBookings')
		{
			$currentdate = date("Y-m-d"); 
			$uxRecentBookings = $wpdb->get_results
			(
				$wpdb->prepare
				(
					"SELECT  ".customersTable().".CustomerFirstName as ClientName,
					". bookingTable().".BookingStatus from ".bookingTable()." LEFT OUTER JOIN " .customersTable()." ON 
					".bookingTable().".CustomerId= ".customersTable().".CustomerId ".
					"where ".bookingTable().".BookingDate  = '%s' ORDER BY ".bookingTable().".BookingId DESC LIMIT 5",
					$currentdate
				)
			);
			for($flag = 0; $flag < count($uxRecentBookings); $flag++)
			{
				if($uxRecentBookings[$flag]->BookingStatus == "Approved")
				{
				?>
				<li>
					<?php echo $uxRecentBookings[$flag]->ClientName; ?>
					<div class="info green">
					<span><?php echo $uxRecentBookings[$flag]->BookingStatus; ?></span>
					</div>
				</li>
				<?php
				}
				else if($uxRecentBookings[$flag]->BookingStatus == "Pending Approval")
				{
				?>
				<li>
					<?php echo $uxRecentBookings[$flag]->ClientName; ?>
					<div class="info blue">
					<span><?php echo $uxRecentBookings[$flag]->BookingStatus; ?></span>
					</div>
				</li>
				<?php
				}
				else if($uxRecentBookings[$flag]->BookingStatus == "Cancelled")
				{
				?>
				<li>
					<?php echo $uxRecentBookings[$flag]->ClientName; ?>
					<div class="info red">
					<span><?php echo $uxRecentBookings[$flag]->BookingStatus; ?></span>
					</div>
				</li>
				<?php
				}
				else if($uxRecentBookings[$flag]->BookingStatus == "Disapproved")
				{
				?>
				<li>
					<?php echo $uxRecentBookings[$flag]->ClientName; ?>
					<div class="info red">
					<span><?php echo $uxRecentBookings[$flag]->BookingStatus; ?></span>
					</div>
				</li>
				<?php
				}
			}
			die();
		}
		else if($_REQUEST['target'] == 'emailCustomerContent')
		{
			$customerId  = intval($_REQUEST['customerId']);
			$customerNameReturn = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT CustomerFirstName,CustomerLastName,CustomerEmail FROM ".customersTable()." where CustomerId = %d",
					$customerId
				)
			);
			?>
			<input id="hiddencustomerName" name="hiddencustomerName" type="hidden" value="<?php echo $customerNameReturn->CustomerFirstName . "". $customerNameReturn->CustomerLastName ; ?>" />
			<input id="hiddencustomerEmail" name="hiddencustomerEmail" type="hidden" value="<?php echo $customerNameReturn->CustomerEmail  ; ?>" />
			<?php
			die();
		}
		else if($_REQUEST['target'] == 'getBookings')
		{
			$ServiceId = $_REQUEST['ServiceId'];
			$status1 = $_REQUEST['status1'];
			$status2 = $_REQUEST['status2'];
			$status3 = $_REQUEST['status3'];
			$status4 = $_REQUEST['status4'];
			$status5 = $_REQUEST['status5'];
			$query = "";
			if($status1 == "true")
			{
				$query .= "( ". bookingTable().".BookingStatus = 'Pending Approval'  ";
			}
			if($status2 == "true")
			{
				if($status1 == "true")
				{
					$query .= " or ";
				}
				else 
				{
					$query .= "( ";
				}
				$query  .= bookingTable().".BookingStatus = 'Approved' ";
			}
			if($status3 == "true")
			{
				if($status1 == "true" || $status2 == "true")
				{
					$query .= " or ";
				}
				else 
				{
					$query .= "( ";
				}			
				$query  .= bookingTable().".BookingStatus = 'Disapproved' ";
			}
			if($status4 == "true")
			{
				if($status1 == "true" || $status2 == "true" || $status3 == "true")
				{
					$query .= " or ";
				}
				else 
				{
					$query .= "( ";
				}			
				$query  .= bookingTable().".BookingStatus = 'Cancelled' ";
			}
			if($status1 == "true" || $status2 == "true" || $status3 == "true"  || $status4 == "true")
			{
				$query .= " )";
			}
			$ServiceType = $wpdb->get_var
			(
				$wpdb->prepare
				(
					"SELECT ServiceFullDay FROM ".servicesTable()." where ServiceId = %d",
					$ServiceId
				)
			);
			if($ServiceId == "allServices")
			{
				$allBookings =  $wpdb->get_results
				(
					$wpdb->prepare
					(
						"SELECT  ". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceColorCode,". servicesTable(). ".ServiceFullDay,
						". servicesTable(). ".ServiceTotalTime, " .bookingTable().".BookingDate,
						CONCAT(".customersTable().".CustomerFirstName ,'  ',". customersTable(). ".CustomerLastName) as ClientName, 
						" .customersTable().".CustomerMobile,". bookingTable().".BookingId,". bookingTable().".TimeSlot, 
						" . bookingTable().".BookingStatus from ".bookingTable()." LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().
						".CustomerId= ".customersTable().".CustomerId ". " JOIN " .servicesTable()." ON ".bookingTable().
						".ServiceId=".servicesTable().".ServiceId  where ".$query." and ". bookingTable().".TimeSlot != 0 UNION ALL SELECT ". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceColorCode,
						". servicesTable(). ".ServiceFullDay,". servicesTable(). ".ServiceTotalTime," .multiple_bookingTable().".bookingDate,
						CONCAT(".customersTable().".CustomerFirstName ,' ',". customersTable(). ".CustomerLastName) as ClientName,
						" .customersTable().".CustomerMobile,". bookingTable().".BookingId,". bookingTable().".TimeSlot,
						" . bookingTable().".BookingStatus from ".bookingTable()." JOIN " .multiple_bookingTable()." on " .bookingTable().".BookingId = " .multiple_bookingTable().".bookingId
						LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().".CustomerId= ".customersTable().".CustomerId ". " 
						JOIN " .servicesTable()." ON ".bookingTable().".ServiceId=".servicesTable().".ServiceId  where ".$query,""  
					)
				);
			}
			else 
			{
				if($ServiceType == 1)
				{
					$allBookings =  $wpdb->get_results
					(
						$wpdb->prepare
						(
							"SELECT ". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceColorCode," .multiple_bookingTable().".bookingDate,CONCAT(".customersTable().".CustomerFirstName ,'  ',". customersTable(). ".CustomerLastName) as ClientName,".customersTable().".CustomerMobile,
							". bookingTable().".BookingId,". bookingTable().".BookingStatus from ".bookingTable()." LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().
							".CustomerId= ".customersTable().".CustomerId ". " JOIN " .servicesTable()." ON ".bookingTable().
							".ServiceId=".servicesTable().".ServiceId LEFT OUTER JOIN " .multiple_bookingTable()." ON ".bookingTable().
							".BookingId=".multiple_bookingTable().".bookingId where ".bookingTable().".ServiceId = %d and ".$query,
							$ServiceId
						)
					);
				}
				else 
				{
					$allBookings =  $wpdb->get_results
					(
						$wpdb->prepare
						(
							"SELECT ". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceTotalTime,". servicesTable(). ".ServiceColorCode," .bookingTable().".BookingDate,CONCAT(".customersTable().".CustomerFirstName ,'  ',". customersTable(). ".CustomerLastName) as ClientName,".customersTable().".CustomerMobile,
							". bookingTable().".TimeSlot,". bookingTable().".BookingId,". bookingTable().".BookingStatus from ".bookingTable()." LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().
							".CustomerId= ".customersTable().".CustomerId ". " JOIN " .servicesTable()." ON ".bookingTable().
							".ServiceId=".servicesTable().".ServiceId where ".bookingTable().".ServiceId = %d and ".$query." ORDER BY ".bookingTable().".BookingDate ASC",
							$ServiceId
						)
					);
				}
			}
			$dynamicCalendar = "<script>jQuery('#calendar').fullCalendar( 'destroy' );jQuery('#calendar').fullCalendar
			({
				disableDragging: true,
				header: 
				{
					left: 'prev,next',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				editable: false,
			 events: [";
			 for($start = 0; $start<count($allBookings);$start++)
			 {
			 	if($ServiceId == "allServices")
				{
					$bookingDate = date("Y-m-d", strtotime($allBookings[$start]->BookingDate));
					$bdate = (explode("-",$bookingDate));
					
					$getHours = floor(($allBookings[$start]->TimeSlot)/60);
					$getEndHours = floor(($allBookings[$start]->TimeSlot + $allBookings[$start]->ServiceTotalTime))/60;
					if($getHours%60!=0)
					{
						$getMins = ($allBookings[$start]->TimeSlot) % 60;
					}
					else
					{
						$getMins = 0;
					}
					if($getEndHours%60!=0)
					{
						$getEndMins = ($allBookings[$start]->TimeSlot + $allBookings[$start]->ServiceTotalTime) % 60;
					}
					else
					{
						$getEndMins = 0;
					}
					if($allBookings[$start]->ServiceFullDay == 1)
					{
						if($start == count($allBookings) -1)
						{
							$dynamicCalendar .= "{
							title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
							bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
							status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
							clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
							clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
							start: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
							end: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
							url:'#EditBooking',
							allDay: true
							}";
						}
						else
						{
							$dynamicCalendar .= "{
							title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
							bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
							status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
							clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
							clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
							start: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
							end: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
							url:'#EditBooking',
							allDay: true
							},";
						}
					}
					else
					{
						if($start == count($allBookings) -1)
						{
							$dynamicCalendar .= "{
							title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
							bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
							status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
							clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
							clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
							start: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getHours, $getMins),
							end: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getEndHours, $getEndMins),
							url:'#EditBooking',
							allDay: false
							}";
						}
						else 
						{
							$dynamicCalendar .= "{
							title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
							bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
							status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
							clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
							clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
							start: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getHours, $getMins),
							end: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getEndHours, $getEndMins),
							url:'#EditBooking',
							allDay: false
							},";
						}	
					}
				}
				else
				{
					if($ServiceType == 1)
					{
						$bookingDate = date("Y-m-d", strtotime($allBookings[$start]->bookingDate));
						$bdate = (explode("-",$bookingDate));
					
						if($start == count($allBookings) -1)
						{
							$dynamicCalendar .= "{
							title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
							bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
							status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
							clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
							clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
							start: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
							end: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
							url:'#EditBooking',
							allDay: true
							}";
						}
						else 
						{
							$dynamicCalendar .= "{
							title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
							bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
							status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
							clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
							clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
							start: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
							end: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
							url:'#EditBooking',
							allDay: true
							},";
						}
					}
					else
					{
						$bookingDate = date("Y-m-d", strtotime($allBookings[$start]->BookingDate));
						$bdate = (explode("-",$bookingDate));
						
						$getHours = floor(($allBookings[$start]->TimeSlot)/60);
						$getEndHours = floor(($allBookings[$start]->TimeSlot + $allBookings[$start]->ServiceTotalTime))/60;
						if($getHours%60!=0)
						{
							$getMins = ($allBookings[$start]->TimeSlot) % 60;
						}
						else {
							$getMins = 0;
						}
						if($getEndHours%60!=0)
						{
							$getEndMins = ($allBookings[$start]->TimeSlot + $allBookings[$start]->ServiceTotalTime) % 60;
						}
						else 
						{
							$getEndMins = 0;
						}
						if($start == count($allBookings) -1)
						{
							$dynamicCalendar .= "{
							title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
							bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
							status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
							clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
							clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
							start: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getHours, $getMins),
							end: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getEndHours, $getEndMins),
							url:'#EditBooking',
							allDay: false
							}";
						}
						else 
						{
							$dynamicCalendar .= "{
							title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
							bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
							status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
							clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
							clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
							start: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getHours, $getMins),
							end: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getEndHours, $getEndMins),
							url:'#EditBooking',
							allDay: false
							},";
						}
					}
				}
			}
			$dynamicCalendar .= "]});jQuery('.popover-test').popover({
			placement: 'left'
			});";
			$dynamicCalendar .= "</script><style type=\"text/css\">";
			 for($start = 0; $start<count($allBookings);$start++)
			 {
			 
				$dynamicCalendar .=".fc-event".$allBookings[$start]->BookingId . "{border: 1px solid ". $allBookings[$start]->ServiceColorCode."; color: white !important; display: block; font-size: 11px;
				background: ". $allBookings[$start]->ServiceColorCode." url(../images/elements/ui/progress_overlay.png);
				background: url(".$url."/images/elements/ui/progress_overlay.png), -moz-linear-gradient(top, ". $allBookings[$start]->ServiceColorCode." 0%, ". $allBookings[$start]->ServiceColorCode." 100%);
				background: url(".$url."/images/elements/ui/progress_overlay.png), -webkit-gradient(linear, left top, left bottom, color-stop(0%,". $allBookings[$start]->ServiceColorCode."), color-stop(100%,". $allBookings[$start]->ServiceColorCode."));
				background: url(".$url."/images/elements/ui/progress_overlay.png), -webkit-linear-gradient(top,  ". $allBookings[$start]->ServiceColorCode." 0%,". $allBookings[$start]->ServiceColorCode." 100%);
				background: url(".$url."/images/elements/ui/progress_overlay.png), -o-linear-gradient(top, ". $allBookings[$start]->ServiceColorCode." 0%,". $allBookings[$start]->ServiceColorCode." 100%);
				background: url(".$url."/images/elements/ui/progress_overlay.png), -ms-linear-gradient(top, ". $allBookings[$start]->ServiceColorCode." 0%,". $allBookings[$start]->ServiceColorCode." 100%);
				background: url(".$url."/images/elements/ui/progress_overlay.png), linear-gradient(to bottom, ". $allBookings[$start]->ServiceColorCode." 0%,". $allBookings[$start]->ServiceColorCode." 100%);
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='". $allBookings[$start]->ServiceColorCode."', endColorstr='". $allBookings[$start]->ServiceColorCode."',GradientType=0 );
				-moz-border-radius: 2px;
				-webkit-border-radius: 2px;
				border-radius: 2px;
				box-sizing: border-box;
				-ms-box-sizing: border-box;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;	
				-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;	
				-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;
				}"; 
			 }
			 echo $dynamicCalendar . "</style>";
			die();
		}
		else if($_REQUEST['target'] == 'defaultSettingsArea')
		{
			$currency_sel = $wpdb -> get_var
			(
				$wpdb->prepare
				(
					"SELECT CurrencySymbol FROM ".currenciesTable(). " where CurrencyUsed = %d",
					1
				)
			);
			?>
			<li>
				<?php _e( "Default Currency", bookings_engine ); ?>
				<div class="info black">
					<span><?php echo $currency_sel?></span>
				</div>
			</li>
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
			<li>
				<?php _e( "Date Format", bookings_engine ); ?>
				<?php
				$date = date('j'); 
				$monthName = date('F');
				$monthNumeric = date('m');
				$year = date('Y');
				if($dateFormat == 0)
				{
					?>	
					<div class="info blue">
						<span><?php echo  $monthName ." ".$date.",  ".$year; ?></span>
					</div>
					<?php
				}
				else if($dateFormat == 1)
				{
				?>
					<div class="info blue">
						<span><?php echo  $year ."/".$monthNumeric."/".$date; ?></span>
					</div>
				<?php
				}
				else if($dateFormat == 2)
				{
				?>
					<div class="info blue">
						<span><?php echo  $monthNumeric ."/".$date."/".$year; ?></span>
					</div>
				<?php
				}
				else 
				{
				?>
					<div class="info blue">
						<span><?php echo $date ."/".$monthNumeric."/".$year;  ?></span>
					</div>
				<?php
				}
			?>	
			</li>
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
			<li>
				<?php _e( "Time Format", bookings_engine ); ?>
				<?php
				if($timeFormat == 0)
				{
				?>
					<div class="info blue">
						<span><?php _e( "12 Hours", bookings_engine ); ?></span>
					</div>
				<?php
				}
				else 
				{
				?>
					<div class="info blue">
						<span><?php _e( "24 Hours", bookings_engine ); ?></span>
					</div>
				<?php
				}
				?>
			</li>
			<?php
			$paypalStatus = $wpdb -> get_var
			(
				$wpdb->prepare
				(
					'SELECT PaymentGatewayValue FROM ' . payment_Gateway_settingsTable() . ' where PaymentGatewayKey  = %s',
					"paypal-enabled"
				)
			);
			?>
			<li>
				<?php _e( "Paypal Status", bookings_engine ); ?>
				<?php
				if($paypalStatus == 1)
				{
				?>
					<div class="info green">
						<span><?php _e( "On", bookings_engine );?>	</span>
					</div>
				<?php
				}
				else
				{
				?>
					<div class="info red">
						<span><?php _e( "Off", bookings_engine );?></span>
					</div>
				<?php
				}
				
				?>
			</li>	
				<?php
				$facebookStatus = $wpdb->get_var
				(
					$wpdb->prepare
					(
						'SELECT SocialMediaValue FROM ' . social_Media_settingsTable() . ' where SocialMediaKey = %s',
						"facebook-connect-enable"
					)
				);
				?>
			<li>
				<?php _e( "Facebook Settings", bookings_engine ); ?>
				<?php
				if($facebookStatus == 1)
				{
				?>
					<div class="info green">
						<span><?php _e( "On", bookings_engine );?>	</span>
					</div>	
			<?php
				}
				else
				{
			?>
					<div class="info red">
						<span><?php _e( "Off", bookings_engine );?></span>
					</div>
			<?php
				}
			?>
			</li>
			<?php
			$autoResponderStatus = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT AutoResponderValue FROM ' . auto_Responders_settingsTable() . ' where AutoResponderKey  = %s',
					"mail-chimp-enabled"
				)
			);	
			?>
			<li>
				<?php _e( "Mailchimp Settings", bookings_engine ); ?>
				<?php
				if($autoResponderStatus == 1)
				{
				?>
					<div class="info green">
						<span><?php _e( "On", bookings_engine );?>	</span>
					</div>
				<?php
				}
				else 
				{
				?>
					<div class="info red">
						<span><?php _e( "Off", bookings_engine );?></span>
					</div>
				<?php
				
				}
				?>	
			</li>
			<?php
				$ReminderStatus = $wpdb->get_var
				(
					$wpdb->prepare
					(
						'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
						"reminder-settings"
					)
				);	
			?>
			<li>
				<?php _e( "Reminder Settings", bookings_engine ); ?>
				<?php
				if($ReminderStatus == 1)
				{
				?>
					<div class="info green">
						<span><?php _e( "On", bookings_engine );?>	</span>
					</div>
					<?php
						$ReminderStatusInterval = $wpdb->get_var
						(
							$wpdb->prepare
							(
								'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
								"reminder-settings-interval"
							)
						);
					?>
					<li>
						<?php _e( "Reminder Interval", bookings_engine ); ?>
						<div class="info black">
						<span><?php echo $ReminderStatusInterval;?></span>
						</div>
					</li>
				<?php
				}
				else
				{
					?>
						<div class="info red">
							<span><?php _e( "Off", bookings_engine );?>	</span>
						</div>
					<?php
				}
				?>
			</li>
			<?php
				$AutoApprove = $wpdb->get_var
				(
					$wpdb->prepare
					(
						'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where   GeneralSettingsKey = %s',
						"auto-approve-enable"
					)
				);
				?>
			<li>
				<?php _e( "Auto Approve: ", bookings_engine ); ?>
				<?php
				if($AutoApprove == 1)
				{
				?>
					<div class="info green">
						<span><?php _e( "On", bookings_engine );?>	</span>
					</div>
				<?php
				}
				else 
				{
				?>
					<div class="info red">
						<span><?php _e( "Off", bookings_engine );?>	</span>
					</div>
				<?php
				}
				?>	
			</li>
			<?php
			die();
		}
		else if($_REQUEST['target'] == "getBlockOutsCount")
		{
			$count = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(RepeatId) FROM ' . block_outs(),''
				)
			);
			echo $count;
			die();
		}
		else if($_REQUEST['target'] == "bookingTiming")
		{
			function find_closest ( $needle, $haystack ) 
			{ 
			    //sort the haystack 
				sort($haystack); 
			    //get the size to be used later 
			    $haystack_size = count($haystack); 
			    //pre-check, is the needle less than the lowest array value 
			    if ( $needle < $haystack[0] ) 
			    { 
			        return $haystack[0]; 
			    } 
			    //loop through the haystack 
			    foreach ( $haystack AS $key => $val ) 
			    { 
			        //if we have a match with the current value, return it 
			        if ( $needle == $val ) 
			        { 
			            return $val; 
			        } 
			         
			        //if we've hit the end of the array, return the max value 
			        if ( $key == $haystack_size - 1 ) 
			        { 
			            return $val; 
			        } 
			         
			        //now do the "between" check 
			        if ( $needle > $val && $needle < $haystack[$key+1] ) 
			        { 
			            //find the closest.  If they're equidistant, the higher value gets precedence 
			            if ( $needle - $val < $haystack[$key+1] - $needle ) 
			            { 
			                return $val; 
			            } 
			            else  
			            { 
			                return $haystack[$key]; 
			            } 
			        } 
			    } 
			}
			$serviceId  = intval($_REQUEST['serviceId']);
			$BookingDate = $_REQUEST['bookingDates'];
			if($BookingDate == "")
			{
				$BookingDate = date('Y-m-d');
			}	
			$ServiceTableData = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT ServiceFullDay,ServiceStartTime,ServiceEndTime,ServiceTotalTime,ServiceMaxBookings,Type FROM ".servicesTable()." where ServiceId = %d",
					$serviceId
				)
			);
			$CurrentBookingDay =  date('D',strtotime($BookingDate));
			$CurrentBookingWeek =  date('W',strtotime($BookingDate));
			
			$checkMultipleBookingsCount = $wpdb->get_results
			(
				$wpdb->prepare
				(
						"SELECT TimeSlot, COUNT(*) as Total FROM " .bookingTable(). " join " . servicesTable() ." on " .bookingTable().".ServiceId = ".servicesTable().".ServiceId 
						where ". bookingTable() . ".BookingDate = '%s' and ". bookingTable() . ".ServiceId = %d  GROUP BY TimeSlot",
						$BookingDate,
						$serviceId
				)
			);
			$checkBookings = $wpdb->get_results
			(
				$wpdb->prepare
				(
						"SELECT TimeSlot FROM " .bookingTable(). " join " . servicesTable() ." on " .bookingTable().".ServiceId = ".servicesTable().".ServiceId 
						where ". bookingTable() . ".BookingDate = '%s' and ". bookingTable() . ".ServiceId = %d",
						$BookingDate,
						$serviceId
				)
			);
			$AllBlockOuts = $wpdb->get_results
	       	(
				$wpdb->prepare
				(
					 'SELECT * FROM '.block_outs().'  WHERE ServiceId = %d and FullDayBlockOuts =%d ',
					 $serviceId,
					 "0"
				)
			);
			$MultiplebookingTimesArray = array();
			$bookingTimesArray = array();
			$blockOutTimeArray = array();
			$blockDatesArray = array();
			
			$new_array1 = array();
			
			for($flag = 0; $flag < count($checkMultipleBookingsCount); $flag++)
			{
				
				if($checkMultipleBookingsCount[$flag]->Total >= $ServiceTableData->ServiceMaxBookings)
				{
					array_push($MultiplebookingTimesArray,$checkMultipleBookingsCount[$flag]->TimeSlot); 
				}
			}
			
			for($flag = 0; $flag < count($checkBookings); $flag++)
			{
				array_push($bookingTimesArray,$checkBookings[$flag]->TimeSlot); 						
			}
			for($timeOff = $ServiceTableData->ServiceStartTime; $timeOff <= $ServiceTableData->ServiceEndTime; $timeOff += $ServiceTableData->ServiceTotalTime)
			{
				array_push($new_array1,$timeOff); 
			}
			
			for($flagBlock = 0 ;$flagBlock < count($AllBlockOuts); $flagBlock++)
			{
					
				$dailyCase = $AllBlockOuts[$flagBlock]->Repeats;
				 
				// code for endate check
				if($AllBlockOuts[$flagBlock]->EndDate == 0)
				{
					$blockOutEndDate = date('Y-m-d',strtotime(date("Y-12-25", mktime()) . " + 1 year"));
				}
				else
				{
					$blockOutEndDate = $AllBlockOuts[$flagBlock]->EndDate;
				}
				$start_date = $AllBlockOuts[$flagBlock]->StartDate;
				// code for weekdays/daily case
				if($dailyCase == 0)
				{
					for($loopDate = $start_date; $loopDate <= $blockOutEndDate ; $loopDate = date("Y-m-d", strtotime("+ ".$AllBlockOuts[$flagBlock]->RepeatEvery." day", strtotime($loopDate))))
					{
						if($loopDate == $BookingDate)
						{									
							for($flagLoop = $AllBlockOuts[$flagBlock]->StartTime; $flagLoop < $AllBlockOuts[$flagBlock]->EndTime; $flagLoop += $ServiceTableData->ServiceTotalTime)
							{
								$value = find_closest($flagLoop,$new_array1);
							
								if(!in_array($value,$blockOutTimeArray))
								{
									
									array_push($blockOutTimeArray,$value);
								} 
							}
							break;
						}
					}
				}
				else 
				{
					$WeekDays = explode(',', $AllBlockOuts[$flagBlock]->RepeatDays);
					$StartweekNumber = date("W", strtotime($start_date)); 
					$EndweekNumber = date("W", strtotime($blockOutEndDate));
					for( $Startweek = $StartweekNumber; $Startweek <= $EndweekNumber; $Startweek += $AllBlockOuts[$flagBlock]->RepeatEvery)
					{
						if($Startweek == $CurrentBookingWeek)
						{
							for($flag = 0; $flag<count($WeekDays);$flag++)
							{
								if($WeekDays[$flag] == $CurrentBookingDay)
								{
									for($flagLoop = $AllBlockOuts[$flagBlock]->StartTime; $flagLoop < $AllBlockOuts[$flagBlock]->EndTime; $flagLoop += $ServiceTableData->ServiceTotalTime)
									{
										$value = find_closest($flagLoop,$new_array1);
									
										if(!in_array($value,$blockOutTimeArray))
										{
											
											array_push($blockOutTimeArray,$value);
										} 
									}
									break;
								}
							}
							
						}
					   
					 }						
				} 
			}					
			$timeFormats = $wpdb->get_var
			 (
			 	$wpdb->prepare
			 	(
			 		"SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = %s",
			 		'default_Time_Format'
			 	)
			);
			if($ServiceTableData->ServiceFullDay == 0)
			{
				for($timeOff = $ServiceTableData->ServiceStartTime; $timeOff <= $ServiceTableData->ServiceEndTime; $timeOff += $ServiceTableData->ServiceTotalTime)
				{
					
					$getHours = floor($timeOff / 60) ;
					$getMins = $timeOff % 60 ;
					$hourFormat = $getHours . ":" . $getMins;
					if($timeFormats == 0)
					{
						$time_in_12_hour_format  = DATE("h:iA", STRTOTIME($hourFormat));
					}
					else 
					{
						$time_in_12_hour_format  = DATE("H:i", STRTOTIME($hourFormat));
					}
					if($ServiceTableData->Type == 1)
					{
						if((!in_array($timeOff,$MultiplebookingTimesArray)) && (!in_array($timeOff,$blockOutTimeArray)))
						{
							
							?>
							
							<a value="<?php echo $timeOff; ?>" href="#" class="timeCol hovertip" data-placement="top"><?php echo $time_in_12_hour_format; ?></a>
							<?php
					
						}
						else
						{
								?>
							<span value="<?php echo $timeOff; ?>" class="timeCol-blocked hovertip" data-placement="top"><?php echo $time_in_12_hour_format; ?></span>
							<?php
						}
					}
					else
					{
						
						if((!in_array($timeOff,$bookingTimesArray)) && (!in_array($timeOff,$blockOutTimeArray)))
						{
							
							?>
							
							<a value="<?php echo $timeOff; ?>" href="#" class="timeCol hovertip" data-placement="top"><?php echo $time_in_12_hour_format; ?></a>
							<?php
					
						}
						else
						{
								?>
							<span value="<?php echo $timeOff; ?>" class="timeCol-blocked hovertip" data-placement="top"><?php echo $time_in_12_hour_format; ?></span>
							<?php
						}
					}
				}
				?>
					<input type="hidden" value="" id="hdTimeControl"/>
					<input type="hidden" value="" id="hdTimeControlValue"/>
				<?php
			}
			else
			{
				echo "fullday";
			}	
			
			?>
		
			<?php
			die();	
		}										
		else if($_REQUEST['target'] == 'addCustomers')
		{
		    $uxCustomerFirstName = esc_attr($_REQUEST['uxFirstName']);
			$uxCustomerLastName = esc_attr($_REQUEST['uxLastName']);
			$CustomerEmail = esc_attr($_REQUEST['uxEmailAddress']);
			$CustomerTelephone = esc_attr($_REQUEST['uxTelephoneNumber']);
			$CustomerMobile = esc_attr($_REQUEST['uxMobileNumber']);
			$CustomerAddress1 = esc_attr($_REQUEST['uxAddress1']);
			$CustomerAddress2 = esc_attr($_REQUEST['uxAddress2']);
			$CustomerCity = esc_attr($_REQUEST['uxCity']);
			$CustomerPostalCode = esc_attr($_REQUEST['uxPostalCode']);
			$CustomerCountry = intval($_REQUEST['uxCountry']);
			$CustomerComments = esc_attr($_REQUEST['uxComments']);
			$uxSkypeId = esc_attr($_REQUEST['uxSkypeId']);
			$wpdb->query
		    (
	          	$wpdb->prepare
	            (
                   "INSERT INTO ".customersTable()."(CustomerFirstName,CustomerLastName,CustomerEmail,CustomerTelephone,
                   CustomerMobile,CustomerAddress1,CustomerAddress2,CustomerCity,CustomerZipCode,CustomerCountry,CustomerSkypeId,CustomerComments,
                   DateTime) VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %d, %s, %s, CURDATE())",
                   $uxCustomerFirstName,
                   $uxCustomerLastName,
                   $CustomerEmail,
                   $CustomerTelephone,
                   $CustomerMobile,
                   $CustomerAddress1,
                   $CustomerAddress2,
                   $CustomerCity,
                   $CustomerPostalCode,
                   $CustomerCountry,
                   $uxSkypeId,
                   $CustomerComments
	            )
		     );
			 echo $lastid = $wpdb->insert_id;
			 die();	
		}
		else if($_REQUEST['target'] == 'checkForUpdateCustomer')
		{
			$uxEmailAddress = esc_attr($_REQUEST['uxEmailAddress']);
			$customerId = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT CustomerId FROM ' . customersTable(). ' where CustomerEmail  = %s',
					 $uxEmailAddress
				)
			);
			if($customerId != 0)
			{
				echo $customerId;
			}
			else 
			{
				echo $returnEmployeeEmailCountCheck = "newCustomerEmail";		
			}
			die();
		}
		else if($_REQUEST['target'] == 'getExistingCustomerData')
		{
			$uxEmailAddress = esc_attr($_REQUEST['uxEmailAddress']);
			$customerId = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT CustomerId FROM ' . customersTable(). ' where CustomerEmail  = %s',
					$uxEmailAddress
				)
			);
			if($customerId == 0)
			{
				echo $returnEmployeeEmailCountCheck = "newCustomer";
			}
			else 
			{
				$customer = $wpdb->get_row
			    (
			       $wpdb->prepare
			       (
			    	    "SELECT * FROM ".customersTable()." join ".bookingTable()." on ".customersTable().".CustomerId = ".bookingTable().".CustomerId where ".bookingTable().".CustomerId = %d",
			        	$customerId
			       )
			    );
				
				$requiredFields1 = $wpdb->get_results
				(
					$wpdb->prepare
					(
						"SELECT * FROM ".bookingFormTable()." where status = %d and required = %d",
						"1",
						"1"
					)
				);
				$faceboookEnable = $wpdb->get_var
				(
					$wpdb->prepare
					(
						'SELECT SocialMediaValue FROM '.social_Media_settingsTable().' where SocialMediaKey = %s',
						"facebook-connect-enable"
					)
				);
				?>
				<script type="text/javascript">
				<?php
				for($flagField = 0; $flagField < count($requiredFields1); $flagField++)
				{
					switch("uxTxtControl".$requiredFields1[$flagField]->BookingFormId)
					{
						case "uxTxtControl2":
							?>
							
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerFirstName; ?>");
							<?php
						break;
						case "uxTxtControl3":
							?>
							
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerLastName; ?>");
							<?php
						break;
						case "uxTxtControl4":
							?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerMobile; ?>");
							<?php
						break;
						case "uxTxtControl5":
							?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerTelephone; ?>");
							<?php
						break;
						case "uxTxtControl6":
							?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerSkypeId; ?>");
							<?php
						break;
						case "uxTxtControl7":
							?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerAddress1; ?>");
							<?php
						break;	
						case "uxTxtControl8":
							?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerAddress2; ?>");
							<?php
						break;
						case "uxTxtControl9":
							?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerCity; ?>");
							<?php
						break;
						case "uxTxtControl10":
							?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerZipCode ; ?>");
							<?php
						break;	
						case "uxTxtControl11":
							?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->couponCode; ?>");
							<?php
						break;
						case "uxTxtAreaControl13":
							?>
							jQuery('#uxTxtAreaControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->Comments; ?>");
							<?php
						break;
					}
				}
				?>
				jQuery('#uxDdlControl12').val("<?php echo $customer->CustomerCountry; ?>");
				</script>
				<?php
			}
			die();
		}
		else if($_REQUEST['target'] == 'getServiceFullDay')
		{
			$serviceId = intval($_REQUEST['serviceId']);
			$checkServiceFullDay = $wpdb->get_var
			(
				$wpdb->prepare
				(
					"SELECT ServiceFullDay FROM ".servicesTable()." where 	ServiceId = %d",
					$serviceId
				)
			);
			echo $checkServiceFullDay;
			die();	
		}
		else if($_REQUEST['target'] == "updatebooking")
		{
			$bookingId = intval($_REQUEST['bookingId']);
			$bookingDetail = $wpdb->get_row
			(
			 	$wpdb->prepare
			 	(
					"SELECT ".customersTable().".CustomerFirstName,".customersTable().".CustomerLastName,".customersTable().".CustomerEmail,".customersTable().".CustomerMobile,".servicesTable(). ".ServiceId,"
					.servicesTable(). ".ServiceName,".servicesTable(). ".ServiceTotalTime,".servicesTable(). ".ServiceColorCode,".bookingTable().".BookingDate,".bookingTable().".TimeSlot,".bookingTable().".PaymentStatus,".bookingTable().".BookingStatus,".bookingTable().".TransactionId,"
					.bookingTable().".PaymentDate, ".bookingTable().".BookingId from ".bookingTable()." LEFT OUTER JOIN " 
					.customersTable()." ON ".bookingTable().".CustomerId= ".customersTable().".CustomerId "." LEFT OUTER JOIN " .servicesTable()." ON ".bookingTable().".ServiceId=" 
					.servicesTable().".ServiceId where ".bookingTable().".BookingId =  %d",
					$bookingId." ORDER BY ".bookingTable().".BookingDate asc"
				)
		 	);
			$paypalEnable = $wpdb->get_var
			(
				$wpdb->prepare
				(
					"SELECT PaymentGatewayValue FROM ".payment_gateway_settingsTable()." where PaymentGatewayKey = %s",'paypal-enabled'
				)
			);
			$ServiceFullDay = $wpdb->get_var
			( 					
				$wpdb->prepare
				(
					"SELECT ServiceFullDay FROM ".servicesTable()." where ServiceId = %d",
					$bookingDetail->ServiceId
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
			if($ServiceFullDay == 1)
			{
				$bookingDates = $wpdb->get_results
				(
					$wpdb->prepare
					(
						"SELECT * FROM ".multiple_bookingTable()." where bookingId = %d",
						$bookingDetail->BookingId
					)
				);
			}
			?>
			<div class="well-smoke block"  style="margin-top:10px">
	 	   		<div class="row"> 
	 	   				<label style="top:10px;">
							<?php _e( "Client Name :", bookings_engine ); ?>
						</label>
					<div class="right">
						<span>
						<?php echo $bookingDetail->CustomerFirstName." ".$bookingDetail->CustomerLastName; ?>
						&nbsp;
						</span>
					</div>
				</div>	
				<div class="row"> 
					<label style="top:10px;">
						<?php _e( "Email :", bookings_engine ); ?>
					</label>
					<div class="right">
						<span>		
						<?php echo $bookingDetail->CustomerEmail; ?>
						&nbsp;
						</span>
					</div>
				</div>
				<div class="row"> 
					<label style="top:10px;">
							<?php _e( "Mobile :", bookings_engine ); ?>
					</label>
					<div class="right">
						<span>
						<?php echo $bookingDetail->CustomerMobile; ?>	
						&nbsp;		</span>
					</div>
				</div>		
				<div class="row"> 
					<label style="top:10px;">
							<?php _e( "Service Booked :", bookings_engine ); ?>
					</label>
					<div class="right">
						<span>
						<?php echo $bookingDetail->ServiceName; ?>&nbsp;
						</span>
					</div>
				</div>
				<div class="row"> 
					<label>
						<?php _e( "Booking Date :", bookings_engine ); ?>
					</label>
					<div class="right">
					<?php
					$dateFormat = $wpdb->get_var
					(
						$wpdb->prepare
						(
							'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s ',
							"default_Date_Format"
						)
					);	
					if($ServiceFullDay == 1)
					{
						if($dateFormat == 0)
						{
							$dateFormat1 =  date("M d, Y", strtotime($bookingDetail->BookingDate));
						}
						else if($dateFormat == 1)
						{
							$dateFormat1 =  date("Y/m/d", strtotime($bookingDetail->BookingDate));
						}	
						else if($dateFormat == 2)
						{
							$dateFormat1 = date("m/d/Y", strtotime($bookingDetail->BookingDate));
						}	
						else if($dateFormat == 3)
						{
							$dateFormat1 =  date("d/m/Y", strtotime($bookingDetail->BookingDate));
						}
						$allocatedMultipleDates = "<div id=\"tags1_tagsinput\" class=\"tagsinput\" style=\"width: 100%; min-height: auto; height: auto; \">";
						for($MBflag=0; $MBflag < count($bookingDates); $MBflag++)
						{
							if($dateFormat == 0)
							{
								$dateFormat =  date("M d, Y", strtotime($bookingDates[$MBflag]->bookingDate));
							}
							else if($dateFormat == 1)
							{
								$dateFormat =  date("Y/m/d", strtotime($bookingDates[$MBflag]->bookingDate));
							}
							else if($dateFormat == 2)
							{
								$dateFormat = date("m/d/Y", strtotime($bookingDates[$MBflag]->bookingDate));
							}
							else if($dateFormat == 3)
							{
							$dateFormat =  date("d/m/Y", strtotime($bookingDates[$MBflag]->bookingDate));
							}
							$allocatedMultipleDates .= "<span style=\"margin-left:5px;background-color:".$bookingDetail->ServiceColorCode.";color:#fff;border:solid 1px ".$bookingDetail->ServiceColorCode . "\" class=\"tag\"><span>" . $dateFormat .''. "</span></span>";
						}
						$allocatedMultipleDates.= "</div>";
						echo $allocatedMultipleDates;
					}	
					else
					{
						$allocatedSingleDates = "<div id=\"tags1_tagsinput\" class=\"tagsinput\" style=\"width: 100%; min-height: auto; height: auto; \">";
							
							if($dateFormat == 0)
							{
								 $SingleDate = date("M d, Y", strtotime($bookingDetail->BookingDate));
							}
							else if($dateFormat == 1)
							{
								 $SingleDate = date("Y/m/d",strtotime($bookingDetail->BookingDate));
							}	
							else if($dateFormat == 2)
							{
								$SingleDate = date("m/d/Y", strtotime($bookingDetail->BookingDate));
							}
							else if($dateFormat == 3)
							{
								$SingleDate =  date("d/m/Y", strtotime($bookingDetail->BookingDate));
							}
							$allocatedSingleDates .= "<span style=\"margin-left:5px;background-color:".$bookingDetail->ServiceColorCode.";color:#fff;border:solid 1px ".$bookingDetail->ServiceColorCode . "\" class=\"tag\"><span>" . $SingleDate .''. "</span></span></div>";
							echo $allocatedSingleDates;
					}
					?>
					</div>
				</div>
				<?php
				if($ServiceFullDay == 0)
				{
					?>
					<div class="row">
						<label style="top:10px;">
							<?php _e( "Time Slot :", bookings_engine ); ?>
						</label>
						<div class="right">	
							<span>
							<?php
							if($ServiceFullDay == 0)
							{
								$getHours_bookings = floor(($bookingDetail->TimeSlot)/60);
								$getMins_bookings = ($bookingDetail->TimeSlot) % 60;
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
								$totalBookedTime = $bookingDetail->TimeSlot + $bookingDetail->ServiceTotalTime;
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
								echo $time_in_12_hour_format_bookings ." - ". $time_in_12_hour_format_bookings_End;
							}
							?>
							</span>&nbsp;
						</div>
					</div>
					<?php
				}
				if($paypalEnable == 1)
				{
					?>
					<div class="row"> 
						<label style="top:10px;">
							<?php _e( "Payment Status:", bookings_engine ); ?>
						</label>
						<div class="right">		
							<span>
								<?php echo $bookingDetail->PaymentStatus ; ?></span>&nbsp;
						</div>
					</div>
					<div class="row"> 
						<label style="top:10px;">
								<?php _e( "Transaction ID :", bookings_engine ); ?>
						</label>
						<div class="right">
							<span>
								<?php echo $bookingDetail->TransactionId; ?></span>&nbsp;
						</div>
					</div>
					<div class="row"> 
						<label style="top:10px;">
							<?php _e( "Payment Date :", bookings_engine ); ?>
						</label>
						<div class="right">
							<span>
								<?php echo $bookingDetail->PaymentDate; ?></span>&nbsp;
						</div>
					</div>
					<?php
				}
				?>
				<input type="hidden" id="bookingHideId" value="<?php echo $bookingId; ?>" />
				<div class="row">
					<label>
						<?php _e( "Booking Status :", bookings_engine ); ?>
					</label>
					<div class="right">
						<select name="uxBookingStatus" class="style required" id="uxBookingStatus" style="width:200px;">
						<?php
						if($bookingDetail->BookingStatus =="Pending Approval")
						{
						?>
							<option value="<?php echo $bookingDetail->BookingStatus; ?>" selected="selected" ><?php echo $bookingDetail->BookingStatus; ?></option> 
							<option value="Approved" ><?php _e( "Approved", bookings_engine ); ?></option>
							<option value="Disapproved" ><?php _e( "Disapproved", bookings_engine ); ?></option>
							<option value="Cancelled" ><?php _e( "Cancelled", bookings_engine ); ?></option>
							<option value="Completed" ><?php _e( "Completed", bookings_engine ); ?></option>
						<?php
						}
						elseif($bookingDetail->BookingStatus =="Approved")
						{
						?>
							<option value="Pending Approval" ><?php _e( "Pending Approval", bookings_engine ); ?></option>
							<option value="<?php echo $bookingDetail->BookingStatus; ?>" selected="selected" ><?php echo $bookingDetail->BookingStatus; ?></option>
							<option value="Disapproved" ><?php _e( "Disapproved", bookings_engine ); ?></option>
							<option value="Cancelled" ><?php _e( "Cancelled", bookings_engine ); ?></option>
							<option value="Completed" ><?php _e( "Completed", bookings_engine ); ?></option>
						<?php
						}
						elseif($bookingDetail->BookingStatus =="Disapproved")
						{
						?>
							<option value="Pending Approval"><?php _e( "Pending Approval", bookings_engine ); ?></option>
							<option value="Approved" ><?php _e( "Approved", bookings_engine ); ?></option>
							<option value="<?php echo $bookingDetail->BookingStatus; ?>" selected="selected" ><?php echo $bookingDetail->BookingStatus; ?></option>
							<option value="Cancelled" ><?php _e( "Cancelled", bookings_engine ); ?></option>
							<option value="Completed" ><?php _e( "Completed", bookings_engine ); ?></option>
						<?php
						}
						elseif($bookingDetail->BookingStatus =="Cancelled")
						{
						?>
							<option value="Pending Approval"><?php _e( "Pending Approval", bookings_engine ); ?></option>
							<option value="Approved" ><?php _e( "Approved", bookings_engine ); ?></option>
							<option value="Disapproved" ><?php _e( "Disapproved", bookings_engine ); ?></option>
							<option value="<?php echo $bookingDetail->BookingStatus; ?>" selected="selected" ><?php echo $bookingDetail->BookingStatus; ?></option> 
							<option value="Completed" ><?php _e( "Completed", bookings_engine ); ?></option>
						<?php
						}
						elseif($bookingDetail->BookingStatus =="Completed")
						{
						?>
							<option value="Pending Approval" ><?php _e( "Pending Approval", bookings_engine ); ?></option>
							<option value="Approved" ><?php _e( "Approved", bookings_engine ); ?></option>
							<option value="Disapproved" ><?php _e( "Disapproved", bookings_engine ); ?></option>
							<option value="Cancelled" ><?php _e( "Cancelled", bookings_engine ); ?></option>
								<option value="<?php echo $bookingDetail->BookingStatus; ?>" selected="selected" ><?php echo $bookingDetail->BookingStatus; ?></option>																					  
						<?php
						}
						?>
					</select>
				</div>
			</div>
		</div>
		<?php
		die();	
		}
		else if($_REQUEST['target'] == "updateBookingStatus")
		{
			$bookingId = intval($_REQUEST['bookingHideId']);
			$uxBookingStatus = esc_attr($_REQUEST['uxBookingStatus']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".bookingTable()." SET BookingStatus = %s WHERE BookingId = %d", 
					$uxBookingStatus,
					$bookingId
				)
			);
			include_once 'mails.php';
			if($uxBookingStatus == "Pending Approval")
			{
				MailManagement($bookingId,"approval_pending"); 
				MailManagement($bookingId,"admin");   
			}
			else if($uxBookingStatus == "Approved")
			{
				MailManagement($bookingId,"approved");
			}
			else if($uxBookingStatus == "Disapproved")
			{
				MailManagement($bookingId,"disapproved");  
			}
			die();
		}
		else if($_REQUEST['target'] == "checkForCouponExist")
		{
			$uxCouponCode = esc_attr($_REQUEST['uxCouponCode']);
			$serviceId = intval($_REQUEST['serviceId']);
			$currentDate = date('Y-m-d');
			$serviceAmount = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT ServiceCost FROM ' . servicesTable() . ' WHERE ServiceId = %d',
					 $serviceId
				)
			);
			$requiredFields = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".bookingFormTable()." where BookingFormId = %d ",
					"11"
				)
			);
			if($requiredFields->required == 1) 
			{
				if($serviceAmount != 0)
				{
					$countMatchCouponName = $wpdb->get_row
					(
						$wpdb->prepare
						(
							'SELECT count(couponId) as countTotal,couponId FROM ' . coupons() . ' WHERE couponName = %s',
							 $uxCouponCode
						)
					);
					if($countMatchCouponName->countTotal == 1)
					{
						$allDateCoupon = $wpdb->get_row
						(
							$wpdb->prepare
							(
								'SELECT * FROM ' . coupons() . ' WHERE couponId = %d',
								 $countMatchCouponName->couponId
							)
						);
						if($allDateCoupon->couponApplicable == 1)
						{
							if($allDateCoupon->couponValidFrom <= $currentDate && $allDateCoupon->couponValidUpto >= $currentDate)
							{
								if($allDateCoupon->amountType == 0)
								{
									echo $cost = $serviceAmount - $allDateCoupon->Amount;
								}
								else 
								{
									$discountPercent = $serviceAmount * $allDateCoupon->Amount / 100;
									echo $cost = $serviceAmount - $discountPercent;
								}
							}
							else 
							{
								echo "CouponNotValid";
							}
						}
						else
						{
							$dataCouponProducts = $wpdb->get_results
							(
								$wpdb->prepare
								(
									'SELECT * FROM ' . coupons_products() . ' JOIN ' . coupons() . ' ON ' . coupons_products() . '.couponId = ' . coupons() . '.couponId  WHERE ' . coupons_products() . '.couponId = %d and ' . coupons_products() . '.ServiceId = %d',
									 $countMatchCouponName->couponId,
									 $serviceId
								)
							);
							for($flag = 0; $flag < count($dataCouponProducts); $flag++)
							{
								
								if($allDateCoupon->couponValidFrom <= $currentDate && $allDateCoupon->couponValidUpto >= $currentDate)
								{
									if($allDateCoupon->amountType == 0)
									{
										echo $cost = $serviceAmount - $allDateCoupon->Amount;
									}
									else 
									{
										$discountPercent = $serviceAmount * $allDateCoupon->Amount / 100;
										echo $cost = $serviceAmount - $discountPercent;
									}
								}
								else 
								{
									echo "CouponNotValid";
								}
							}
						}
					}
					else 
					{
						echo "CouponNotValid";
					}
				}
			}
			else 
			{
				echo "leaveBlank";
			}
		die();
		}
		else if($_REQUEST['target'] == "checkExistingCoupons")
		{
			$uxDefaultCoupon = esc_attr($_REQUEST['uxDefaultCoupon']);
			$countName = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(couponId) FROM ' . coupons() . ' WHERE couponName = %s',
					 $uxDefaultCoupon
				)
			);
			echo $countName;
			die();
		}
	}
}
?>