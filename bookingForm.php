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
							<?php _e( "FORM SETUP", bookings_engine ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="section">
		<div class="message green" id="SuccessReportBug" style="display:none;">
			<span>
				<strong>
					<?php _e("Success! The Email has been sent.", bookings_engine); ?>
				</strong>
			</span>
		</div>
		<div class="message green" id="bookingFieldsSuccessMessage" style="display:none;">
			<span>
				<strong>
					<?php _e( "Success! The Booking Fields has been updated.", bookings_engine ); ?>
				</strong>
			</span>
		</div>
		<div class="box">
			<div class="title">
				<?php _e("Form Setup", bookings_engine); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<form id="uxFrmbookingFormFields" class="form-horizontal" method="post" action="#">    
					<table cellspacing="0" cellpadding="0" border="0" id="table-grid"> 
						<thead> 
							<tr>
								<th  rowspan="1" colspan="1" style="width: 270px;">
									<?php _e("Field Name", bookings_engine); ?>
								</th>
								<th  rowspan="1" colspan="1" style="width: 176px;">
									<?php _e("Visibility", bookings_engine); ?>
								</th>
								<th  rowspan="1" colspan="1" style="width: 300px;">
									<?php _e("Validation", bookings_engine); ?>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$bookingFeild = $wpdb->get_results
								(
									$wpdb->prepare
									(
										"SELECT * FROM ".bookingFormTable(),""
									)
								);
								for ($flag = 0; $flag < count($bookingFeild); $flag++) 
								{
									$bookingFeildName = $bookingFeild[$flag]->BookingFormField ;
									$bookingStatus = $bookingFeild[$flag]->status;
									$BookingRequired = $bookingFeild[$flag]->required;
									$checked = "";
									$check = "";
									if ($bookingStatus == 1) 
									{
										$checked = "checked=\"checked\"";
									} 
									else 
									{
										$check = "checked=\"checked\"";
									}
									$check1 = "";
									$check0 = "";
									if ($BookingRequired == 1) 
									{
										$check1 = "checked=\"checked\"";
									} 
									else 
									{
										$check0 = "checked=\"checked\"";
									}
							?>
									<tr>
										<td>
											<?php _e($bookingFeildName, bookings_engine ); ?>
												<input type="hidden" id="bookingFeildNameHidden<?php echo $flag;?>" value="<?php echo $bookingFeildName;?>"/>
										</td>	
										<?php
											if($bookingFeildName != "First Name :" && $bookingFeildName != "Email :" )													
											{
										?>
												<td>
													<label class="radio">
														<input type="radio" id="bookingStatus_<?php echo $flag;?>" name="bookingStatusSaved<?php echo $flag;?>" class="style" onchange="setaction(this)" value="1" <?php echo $checked;?> />  <?php _e( "Visible", bookings_engine ); ?>
													</label>&nbsp;&nbsp;
													<label class="radio">
														<input type="radio" id="bookingStatus1_<?php echo $flag;?>" name="bookingStatusSaved<?php echo $flag;?>" class="style" onchange="setaction(this)" value="0" <?php echo $check;?> />  <?php _e( "Invisible", bookings_engine ); ?>
													</label>                                     		 									
												</td>
												<td>
										    		<label class="radio">
										        		<input type="radio" id="bookingRequiredOpen<?php echo $flag;?>" name="bookingRequiredSaved<?php echo $flag;?>" class="style" value="1"   <?php echo $check1;?> /> <?php _e( "Required", bookings_engine ); ?>
									            	</label>&nbsp;&nbsp;	
													<label class="radio">
														<input type="radio" id="bookingRequiredClose<?php echo $flag;?>" name="bookingRequiredSaved<?php echo $flag;?>" class="style" value="0" <?php echo $check0;?> /> <?php _e( "Not Required", bookings_engine ); ?>
													</label>
								        	    </td>
					                    <?php
				                    		}
											else 
											{
										?>
												<td>
										        	<label class="radio">
										           		<input type="radio" disabled="disabled" id="bookingStatus_<?php echo $flag;?>" name="bookingStatusSaved<?php echo $flag;?>" class="style" onchange="setaction(this)" value="1" <?php echo $checked;?> />  <?php _e( "Visible", bookings_engine ); ?>
										            </label>&nbsp;&nbsp;
													<label class="radio">
														<input type="radio" disabled="disabled"id="bookingStatus1_<?php echo $flag;?>" name="bookingStatusSaved<?php echo $flag;?>" class="style" onchange="setaction(this)" value="0" <?php echo $check;?> />  <?php _e( "Invisible", bookings_engine ); ?>
													</label>                                     		 									
												</td>
												<td>
						                 			<label class="radio">
							               				<input type="radio" disabled="disabled" id="bookingRequiredOpen<?php echo $flag;?>" name="bookingRequiredSaved<?php echo $flag;?>" class="style" value="1"   <?php echo $check1;?> /> <?php _e( "Required", bookings_engine ); ?>
							               			</label>&nbsp;&nbsp;	
													<label class="radio">
														<input type="radio" disabled="disabled" id="bookingRequiredClose<?php echo $flag;?>" name="bookingRequiredSaved<?php echo $flag;?>" class="style" value="0" <?php echo $check0;?> /> <?php _e( "Not Required", bookings_engine ); ?>
													</label>
										        </td>
												<?php
											}
							                ?>
									</tr>
									<?php
								}
									?>
						</tbody>
					</table>
					<button type="submit" class="red" style="margin-top:10px;">
						<span>
							<?php _e( "Submit & Save Changes", bookings_engine ); ?>							
						</span>
					</button>
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
	jQuery("#BookingForm").attr("class","current");
	jQuery("#uxFrmbookingFormFields").validate
	({
		rules:
		{
			
		},
		submitHandler: function(form) 
	    { 
			<?php $bookingFeilds = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(BookingFormId) FROM ' . bookingFormTable(),''
				)
		    );
		    ?>
			var countbBokingFields = "<?php echo $bookingFeilds;?>";
			for(var flag=0; flag<countbBokingFields; flag++)
			{
				var bookingRadioVisible;
				var bookingRadiooRequired;
				var radios = document.getElementsByName('bookingStatusSaved'+flag);
				for (var j = 0; j < radios.length; j++) 
				{
					if(radios[j].type == 'radio' && radios[j].checked)
					{
						bookingRadioVisible = radios[j].value;
						break;
					}
				}
				var radioss = document.getElementsByName('bookingRequiredSaved'+flag);
				for (var k = 0; k < radioss.length; k++) 
				{
					if (radioss[k].type == 'radio' && radioss[k].checked)
					{
						bookingRadiooRequired = radioss[k].value;
						break;
					}
				}	
				var fieldname= jQuery("#bookingFeildNameHidden"+flag).val();
				var field_name = encodeURIComponent(fieldname);
				jQuery.ajax
				({
					type: "POST",
					data: "fieldcompare="+field_name+"&bookingRadioVisible="+bookingRadioVisible+"&bookingRadiooRequired="+bookingRadiooRequired+"&target=savedBookingForm&action=AjaxExecuteCalls",
					url:  ajaxurl,
					success: function(data)
					{
						
					}
				});
				if(flag == (countbBokingFields -1))
				{
					jQuery('#bookingFieldsSuccessMessage').css('display','block');
					setTimeout(function() 
				    {
			    		jQuery('#bookingFieldsSuccessMessage').css('display','none');
			        }, 2000);
				}
			}		
		}
	});
	function setaction(e) 
	{
		var t = e.id;	
		var radioid = t.split("_");
		value = e.value;	
		if(value == 0) 
		{
			jQuery('#bookingRequiredClose' + radioid[1]).attr("checked", "checked");
			jQuery('#bookingRequiredOpen' + radioid[1]).removeAttr("checked");
		} 
		else if(value == 1)
		{		
			jQuery('#bookingRequiredClose' + radioid[1]).removeAttr("checked");
			jQuery('#bookingRequiredOpen' + radioid[1]).attr("checked", "checked");
		}
	}
	oTable = jQuery('#table-grid').dataTable
	({
		"bJQueryUI": false,
		"bAutoWidth": true,
		"sPaginationType": "full_numbers",
		"sDom": 't<"datatable-footer"ip>',
		"oLanguage": 
		{
			"sLengthMenu": "<span>Show entries:</span> _MENU_"
		},
		"aaSorting": [[ 3, "asc" ]]
	});
</script>