<?php
global $wpdb;
$requiredFields = $wpdb->get_results
(
	$wpdb->prepare
	(
		"SELECT * FROM ".bookingFormTable()." where status = 1 ",''
	)
); 

$requiredFields1 = $wpdb->get_results
(
	$wpdb->prepare
	(
		"SELECT * FROM ".bookingFormTable()." where status = 1 ",''
	)
);
?>
 <div class="section">					
	<div class="box" style="padding:0px 10px;margin-bottom:10px;">
		 <form id="uxFrondendBookingForm" class="form-horizontal" method="post" action="">
			<div class="content">
				<div class="form-wizard">
	        	<ul>
					<li  style="float:left;width:25%;text-align:center">
	                	<a id="tab1" class="step active">
	                    	<span class="number">1</span>
	                        <div><?php _e("Choose Service", bookings_engine); ?></div>   
	                    </a>
	                </li>
	                <li style="float:left;width:25%;text-align:center">
	                	<a id="tab2" class="step">
	                    	<span class="number">2</span>
	                    	<div><?php _e("Choose Availability", bookings_engine); ?></div>
	                       	
	                    </a>
	                </li>
	                <li style="float:left;width:25%;text-align:center">
	                	<a id="tab3" class="step">
		                    <span class="number">3</span>
		                    <div><?php _e("Fill in Information", bookings_engine); ?></div>
		                   
	                    </a>
	                </li>
	                <li style="float:left;width:25%;text-align:center">
	                	<a id="tab4" class="step">
		                    <span class="number">4</span>
		                    <div><?php _e("Confirm Booking", bookings_engine); ?></div>   
	                    </a>
	                </li>                
				</ul>
	        	</div> 
	  		<div class="progressbar-normal blue  ui-progressbar ui-widget ui-widget-content ui-corner-all" value="75%" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="75" style="width:660px;float:left;">
				<div class="ui-progressbar-value ui-widget-header ui-corner-left" id="progressBar" style="width: 25%;"></div>
			</div>
			<div id="serviceGrid" style="display:block;">
				<table class="table table-striped" id="data-table">
	 				<thead>
		     			<tr>
		     				<th style="width:55% !important"><?php _e( "Service", bookings_engine ); ?></th>
		        			<th style="width:15% !important"><?php _e( "Cost", bookings_engine ); ?></th>
		        			<th style="width:30% !important"><?php _e( "Type", bookings_engine ); ?></th>
		        		</tr>
					</thead>
		  			<tbody>
				    <?php
					   	$service = $wpdb->get_results
					    (
							$wpdb->prepare
							(
								 'SELECT * FROM '.servicesTable().'  ORDER BY ' . servicesTable() . '.ServiceDisplayOrder ASC',''
							)
						);
						
						$costIcon = $wpdb->get_var
						(
							$wpdb->prepare	
							(
								"SELECT CurrencySymbol FROM ".currenciesTable()." where CurrencyUsed = %d",
								"1"
							)
						);
						$defaultServiceDisplay =  $wpdb->get_var
						(
							$wpdb->prepare	
							(
								"SELECT GeneralSettingsValue  FROM ".generalSettingsTable()." where GeneralSettingsKey = %s",
								"default_Service_Display"
							)
						);
						 
						if($defaultServiceDisplay == 0)
						{
							for($flag = 0; $flag < count($service); $flag++)
							{
								$serviceColor = $service[$flag]->ServiceColorCode;
								$hrs = floor(($service[$flag] -> ServiceTotalTime) / 60);
								$mins = ($service[$flag] -> ServiceTotalTime) % 60;
								?>
									
									<tr id="recordsArray_<?php echo $service[$flag] -> ServiceId ; ?>">
									<td>									
										<input id="radioService<?php echo $flag;?>"   name="radioservice" type="radio" title="<?php echo $service[$flag] -> ServiceName;?>" value="<?php echo $service[$flag] -> ServiceId;?>"/>&nbsp;&nbsp;<?php echo $service[$flag] -> ServiceName;?>
									</td>
									<td><?php echo ($costIcon).$service[$flag] -> ServiceCost;?></td>
									<td>
									<?php 
									if($service[$flag]->Type == 0)
									{
										echo _e( "Single Booking", bookings_engine );
									}
									else 
									{
										echo "Group Bookings (".$service[$flag] -> ServiceMaxBookings .")";
									}
									?>
									</td>
									<input type="hidden" value="<?php echo $service[$flag]->ServiceFullDay; ?>" id="hdServiceType_<?php echo $service[$flag] -> ServiceId ; ?>" />
									</tr>
									<?php
							 }
						}
						else
						{
							for($flag = 0; $flag < count($service); $flag++)
							{
								$serviceColor = $service[$flag]->ServiceColorCode;
								$hrs = floor(($service[$flag] -> ServiceTotalTime) / 60);
								$mins = ($service[$flag] -> ServiceTotalTime) % 60;
								
								?>
									
									<tr id="recordsArray_<?php echo $service[$flag] -> ServiceId ; ?>">
										<td>									
											<select id="allService" class="required" name="allService"'" onchange="servicesOnchange()" style="width:95%">
												<option value="0"><?php _e( "Please choose Service", bookings_engine ); ?></option>
												<?php
												for($flag=0; $flag < count($service); $flag++)
												{
												?>
													<option value="<?php echo $service[$flag] -> ServiceId ; ?>"><?php echo $service[$flag] -> ServiceName ; ?></option>
												<?php
												}
												?>
											</select>
										</td>
										<td>
											<label id="SC" name="SC"></label>
										</td>
										<td>
											<label id="ST" name="ST"></label>
										</td>
										 <input type="hidden" value="" id="hdServiceTypeDDL" />
									</tr>
									<?php
							}
						}	
							?>
					</tbody>
	          	</table>
	        </div>
          	<div id="calendarGrid" style="display:none;float:left;">
         		<div id="calBindingMultiple" style="float:left;width:38% !important"></div>	
         		<div id="timingSlot" style="float:left;width:56% !important;padding:5px;border:solid 1px #ECECEC;">
	         		<div id="timingsGrid"></div>
	         	</div>
	         	<input type="text" id="altField" value="" style="display:none"/>
	      	</div>
      	 	<div id="customerGrid" style="display:none;padding:10px;">
      	 		 
      	 	  <div class="body">
				<div class="block well" style="float:left;width:100%">					
					<div class="box">
						<div class="content">
      	 					<div id="scriptExistingCustomer"></div>
         				<?php
		    			$bookingFeild = $wpdb->get_results
						(
							$wpdb->prepare
							(
								"SELECT * FROM ".bookingFormTable()." where status = 1",""
							)
						);
						for($flagField = 0; $flagField < count($bookingFeild); $flagField++)
						{
							if($bookingFeild[$flagField]->type == "textbox")
							{
							?>
								<div class="row" name="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>">
									<label><?php _e($bookingFeild[$flagField]->BookingFormField, bookings_engine ); ?>
									<?php
									if($bookingFeild[$flagField]->required == 1)
									{
									?>
										<span class="req" style="color:red">*</span>
									<?php
									}
									?>
									</label>
									<div class="right">
										<input type="text"  name="uxTxtControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxTxtControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" value=""/>	
									</div>
								</div>
							<?php
							}
							else if($bookingFeild[$flagField]->type == "textarea")
							{
							?>
								<div class="row" name="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>">
									<label><?php _e($bookingFeild[$flagField]->BookingFormField, bookings_engine ); ?>
									<?php
									if($bookingFeild[$flagField]->required == 1)
									{
									?>
										<span class="req" style="color:red">*</span>
									<?php
									}
									?>
									</label>
									<div class="right">
										<textarea rows="4" cols="120" id="uxTxtAreaControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>"></textarea>
									</div>
								</div>
								<?php
							}
							else if($bookingFeild[$flagField]->type == "dropdown")
							{
							?>
								<div class="row" name="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>">
									<label><?php echo $bookingFeild[$flagField]->BookingFormField;?>
									<?php
									if($bookingFeild[$flagField]->required == 1)
									{
									?>
										<span class="req">*</span>
									<?php
									}
									?>					               					
									</label>
									<div class="right">
										<select name="uxDdlControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxDdlControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" class="style required">					                 					
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
												'SELECT CountryName FROM '. countriesTable() .' where CountryUsed = %d',
												"1"
											)
										);
										for ($flagCountry = 0; $flagCountry < count($country); $flagCountry++)
										{
											if ($sel_country == $country[$flagCountry]->CountryName)
											{
											?>
												<option value="<?php echo $country[$flagCountry]->CountryId;?>" selected='selected'><?php echo $country[$flagCountry]->CountryName;?></option>
											<?php 
											}
											else
											{
											?>
												<option value="<?php echo $country[$flagCountry]->CountryId;?>"><?php echo $country[$flagCountry]->CountryName;?></option>
											<?php 
											}
										}
										?>                      		 	
										</select>	
									</div>
								</div>
							<?php	
							}
							if($bookingFeild[$flagField]->validation == "email")
							{
							?>
								<script>jQuery("#uxTxtControl1").attr("onBlur","checkExistingCustomerBooking();");</script> 
							<?php
							}	
						}
		    			?> 
  						</div>
  					</div>
      	 	    </div>
      	 	</div>
      	 	</div>
      	 	 <div id="confirmGrid" style="display:none;width:100%;float:left;">
	        	<div class="span8 well" style="border:none;background:none">
					<div class="row-fluid form-horizontal">
		    			<div class="row">
				       		<label style="top:10px;"> <?php _e( "Booking Details :", bookings_engine ) ?>
			       			</label>
			       			<div class="right">
				             	<span id="uxLblControlApp" value=""></span>
							</div>
						</div>
		    	 		<?php
		    			$bookingFeild = $wpdb->get_results
						(
							$wpdb->prepare
							(
								"SELECT * FROM ".bookingFormTable()." where status = 1",""
							)
						);
						for($flagField = 0; $flagField < count($bookingFeild); $flagField++)
						{
							?>
				   			<div class="row" name="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>">
				   	   			<label style="top:10px;"><?php _e($bookingFeild[$flagField]->BookingFormField, bookings_engine ); ?>
				   				</label>
				       			<div class="right">
				       				<span id="uxLblControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" value=""></span>
					 			</div>
								<input type="hidden" id="hiddeninputname" name="hiddeninputname" value="" />
				    		</div>
					   		<?php										
						}
		    			?>
  			       	</div>		         	 		
	          	</div>
	         </div> 
	         <div style="float:left">
					<button type="submit" id="buttonBackStep" class="blue" style="margin-top:10px;margin-bottom:10px;display:none">
		   				<span><?php _e( "Previous Step", bookings_engine ); ?></span>
		   			</button>
		   	 </div>
		   	 <div style="float:right">
		   			<button type="button" id="buttonNextStep" class="blue" style="margin-top:10px;margin-bottom:10px">
		   				<span><?php _e( "Next Step", bookings_engine ); ?></span>
		   			</button>
		   	 </div>
		   	
  
        </div>
       	 </form>				
	</div>
</div> 
<script type="text/javascript">
	<?php
	$defaultServicedisplay = $wpdb->get_var
	(
		$wpdb->prepare
		(
			"select GeneralSettingsValue from ". generalSettingsTable()." where GeneralSettingsKey = %s",
			'default_Service_Display'
		)
	);
	
	?>
	var defaultServiceDisplaySetting = "<?php echo $defaultServicedisplay; ?>";
	jQuery('.timeCol').live('click',function()
	{
		jQuery(".timeCol").each(function()
		{
			jQuery(this).attr('style','');
		});
		jQuery(this).attr('style','background-color:#5cadea !important;color:#fff !important');
		jQuery('#hdTimeControl').val(jQuery(this).html());
		jQuery('#hdTimeControlValue').val(jQuery(this).attr('value'));
	});
	jQuery('#buttonNextStep').live('click',function()
	{
		var block = 'block';
		var step1Action = jQuery('#serviceGrid').css('display');
		var step2Action = jQuery('#calendarGrid').css('display');
		var step3Action = jQuery('#customerGrid').css('display');
		var step4Action = jQuery('#confirmGrid').css('display');
		switch(block)
		{
			case step1Action:
				if(defaultServiceDisplaySetting == 0)
				{
					var serviceId =  jQuery('input:radio[name=radioservice]:checked').val();
				}
				else
				{
					  var serviceId = jQuery("#allService").val();
				}
				if(serviceId != undefined && serviceId != "")
				{
					jQuery('#serviceGrid').css('display','none');
					jQuery('#progressBar').css('width','50%');			
					jQuery('#tab2').addClass('active');
					var hdServiceType = jQuery('#hdServiceType_' + serviceId).val();
					jQuery('#buttonBackStep').css('display','block');
					Showcalender();
					
					if(hdServiceType == 0)
					{
						showTimingGrid();
					}
					else
					{
						jQuery('#timingSlot').css('visibility','hidden');
					}
				}
				else
				{
					bootbox.alert('<?php _e( "Please choose atleast one Service", bookings_engine ); ?>');
				}					
				break;
			case step2Action:
				if(defaultServiceDisplaySetting == 0)
				{
					var serviceId =  jQuery('input:radio[name=radioservice]:checked').val();
				}
				else
				{
					  var serviceId = jQuery("#allService").val();
				}
				var hdServiceType = jQuery('#hdServiceType_' + serviceId).val();
				if(hdServiceType == 1)
				{
					var BookingDate = jQuery("#altField").val();
					if(BookingDate != "")
					{
						ShowClients();
						jQuery('#tab3').addClass("active");
						jQuery('#progressBar').css('width','75%');	
					}
					else
					{
						bootbox.alert('<?php _e( "Please choose Booking date", bookings_engine ); ?>');
					}
				}
				else
				{
					var BookingDate = jQuery("#altField").val();
					var hdTimeControlValue = jQuery("#hdTimeControlValue").val();
					if(BookingDate != "" && hdTimeControlValue != "")
					{
						ShowClients();
						jQuery('#tab3').addClass("active");
						jQuery('#progressBar').css('width','75%');	
					}
					else
					{
						bootbox.alert('<?php _e( "Please choose Booking date and time", bookings_engine ); ?>');
					}
				}
				break;
			case step3Action:
				_validator  = jQuery("#uxFrondendBookingForm").valid();   
				if(_validator)
				{	
					CheckCoupons();
				}
				break;
				case step4Action:				
					insertCustomer();	
				break;
		}
		return false;				
	});
	jQuery('#buttonBackStep').live('click',function()
	{
		var block = 'block';
		var step1Action = jQuery('#serviceGrid').css('display');
		var step2Action = jQuery('#calendarGrid').css('display');
		var step3Action = jQuery('#customerGrid').css('display');
		var step4Action = jQuery('#confirmGrid').css('display');
		switch(block)
		{
			case step2Action:
				jQuery('#serviceGrid').css('display','block');
				jQuery('#calendarGrid').css('display','none');
				jQuery('#buttonBackStep').css('display','none');
				jQuery('#progressBar').css('width','25%');	
				jQuery('#tab1').addClass('active');
				jQuery('#tab2').removeClass('active');
				jQuery("#calBindingMultiple").datepicker("destroy");
				break;
			case step3Action:
			
				jQuery('#calendarGrid').css('display','block');
				jQuery('#customerGrid').css('display','none');
				jQuery('#progressBar').css('width','50%');	
				jQuery('#tab2').addClass('active');
				jQuery('#tab3').removeClass('active');
				break;
			case step4Action:
				jQuery('#customerGrid').css('display','block');
				jQuery('#confirmGrid').css('display','none');
				jQuery('#progressBar').css('width','75%');	
				jQuery('#tab3').addClass('active');
				jQuery('#tab4').removeClass('active');
				break;
		}
		return false;	
	});
	jQuery("#uxFrondendBookingForm").validate
	({
		rules: 
		{
			<?php
				
				$dynamic = "";
				for($flagField = 0; $flagField < count($requiredFields); $flagField++)
				{

					if($requiredFields[$flagField]->type == "textbox")
					{
						if($requiredFields[$flagField]->required == 1)
						{
							$dynamic .= 'uxTxtControl' . $requiredFields[$flagField]->BookingFormId . ':{ required :true';
							if($requiredFields[$flagField]->validation == "email")
							{
								$dynamic .= ", email : true }";
							}
							else
							{
								$dynamic .= "}";
							}
						}
						else 
						{
							$dynamic .= 'uxTxtControl' . $requiredFields[$flagField]->BookingFormId . ':{ required :false}';
						}
						if(count($requiredFields) > 1 && $flagField < count($requiredFields) - 1)
						{
							$dynamic .= ",";	
						}
					}
					else 
					{
						$dynamic .= "";	
					}
					
						
				}
				
				echo $dynamic;
			 ?>																					
		},				
		highlight: function(label) 
		{	    	
		
		},
		success: function(label) 
		{
			label
		    			.text('Success!').addClass('valid')
				<?php
				for($flagField = 0; $flagField < count($requiredFields1); $flagField++)
				{
					if($requiredFields[$flagField]->type == "textbox")
					{					
					?>					
						jQuery('#uxLblControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').html(jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val());
					<?php
	
					}
					else if($requiredFields1[$flagField]->type == "textarea")
					{
					?>		
						jQuery('#uxLblControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').html(jQuery('#uxTxtAreaControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val());		
						
					<?php
					}
					else if($requiredFields1[$flagField]->type == "dropdown")
					{
					?>		
						jQuery('#uxLblControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').html(jQuery('#uxDdlControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val());		
						
					<?php
					}
					else if($requiredFields1[$flagField]->type == "file")
					{
					?>		
						jQuery('#uxLblControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').html(jQuery('#hiddeninputname').val());		
						
					<?php
					}
				}
				?>
					var formattedDate = jQuery('#altField').val();
					var time = jQuery('#hdTimeControl').val();
					if(defaultServiceDisplaySetting == 0)
					{
						var serviceId =  jQuery('input:radio[name=radioservice]:checked').val();
						var serviceName = jQuery('input:radio[name=radioservice]:checked').attr('title');
						var hdServiceType = jQuery('#hdServiceType_' + serviceId).val();
					}
					else
					{
						  var serviceId = jQuery("#allService").val();
						  var serviceName =  jQuery("#allService option[value="+serviceId+"]").text()
						  var hdServiceType = jQuery('#hdServiceTypeDDL').val();
					}
	    			
	    			if(hdServiceType == 1)
					{
						jQuery('#uxLblControlApp').html("For <b>" + serviceName + "</b> on <b>" + formattedDate + "</b>");
					}
					else
					{
						jQuery('#uxLblControlApp').html("For <b>" + serviceName + "</b> on <b>" + formattedDate + "</b> at <b>" + time + "</b>");
					}
	  	},
		submitHandler: function(form)
		{
		
		}
	});	
	function servicesOnchange() 
	{		
		if(defaultServiceDisplaySetting == 0)
		{
			var serviceId =  jQuery('input:radio[name=radioservice]:checked').val();
		}
		else
		{
			  var serviceId = jQuery("#allService").val();
		}
	  	jQuery.ajax
		({
			type: "POST",
			data: "serviceId="+serviceId+"&target=frontendService&action=AjaxExecuteCalls",
			url:  ajaxurl,
			success: function(data) 
			{
				var dat = data.split(',');
				jQuery("#ST").html(dat[0]);
				jQuery("#SC").html(dat[1]);	
				jQuery("#SF").html(dat[2]);		
				jQuery("#hdServiceTypeDDL").val(dat[2]);	
			}
		});  	
	}
	function Showcalender()
	{
		if(defaultServiceDisplaySetting == 0)
		{
			var serviceId =  jQuery('input:radio[name=radioservice]:checked').val();
		}
		else
		{
			var serviceId = jQuery("#allService").val();
		}
		jQuery.ajax
		({
			type: "POST",
			data: "serviceId="+serviceId+"&target=frontendCalender&action=AjaxExecuteCalls",
			url:  ajaxurl,
			success: function(data) 
			{
				
				var dat = data.trim();
				jQuery("#calBindingMultiple").html(dat);
			}
		}); 
		jQuery("#serviceGrid").css('display','none');
		jQuery("#calendarGrid").css('display','block');
	}
	function ShowClients()
	{
			jQuery("#serviceGrid").css('display','none');
			jQuery("#calendarGrid").css('display','none');
			jQuery("#customerGrid").css('display','block');
	}
	function CheckCoupons()
	{
		if(defaultServiceDisplaySetting == 0)
		{
		   	var serviceId = jQuery('input:radio[name=radioservice]:checked').val();
		}
		else
		{
		    var serviceId = jQuery("#allService").val();
		}
		var uxCouponCode = jQuery('#uxTxtControl1').val() == undefined ? "" : jQuery('#uxTxtControl11').val();
		
		jQuery.ajax
		({
			type: "POST",
			data: "uxCouponCode="+uxCouponCode+"&serviceId="+serviceId+"&target=checkForCouponExist&action=AjaxExecuteCalls",
			url:  ajaxurl,
			success: function(data) 
			{  	
				
				if(data != "CouponNotValid" && data != "leaveBlank")
				{
					jQuery("#ActulaServiceAmount").val(data);
					jQuery('#confirmGrid').css('display','block');
					jQuery('#customerGrid').css('display','none');
					jQuery('#progressBar').css('width','100%');	
					jQuery('#tab4').addClass("active");
				}
				else if(data == "leaveBlank")
				{
					jQuery('#confirmGrid').css('display','block');
					jQuery('#customerGrid').css('display','none');
					jQuery('#progressBar').css('width','100%');	
					jQuery('#tab4').addClass("active");
				}
				else
				{
					bootbox.alert('<?php _e( "Coupon is not valid", bookings_engine ); ?>')
				}
			}
		});
	}
	function insertCustomer()
	{
		var uxEmailAddress = jQuery('#uxTxtControl1').val();
		var uxFirstName = jQuery('#uxTxtControl2').val();
	    var uxLastName = jQuery('#uxTxtControl3').val() == undefined ? "" : jQuery('#uxTxtControl3').val();
		var uxMobileNumber = jQuery('#uxTxtControl4').val() == undefined ? "" : jQuery('#uxTxtControl4').val();
		var uxTelephoneNumber = jQuery('#uxTxtControl5').val() == undefined ? "" : jQuery('#uxTxtControl5').val();
		var uxSkypeId = jQuery('#uxTxtControl6').val() == undefined ? "" : jQuery('#uxTxtControl6').val();
		var uxAddress1 = jQuery('#uxTxtControl7').val() == undefined ? "" : jQuery('#uxTxtControl7').val();
		var uxAddress2 = jQuery('#uxTxtControl8').val() == undefined ? "" : jQuery('#uxTxtControl8').val();
		var uxCity = jQuery('#uxTxtControl9').val() == undefined ? "" : jQuery('#uxTxtControl9').val();
		var uxPostCode = jQuery('#uxTxtControl10').val() == undefined ? "" : jQuery('#uxTxtControl10').val();
		var uxCouponCode = jQuery('#uxTxtControl11').val() == undefined ? "" : jQuery('#uxTxtControl1').val();
		var uxCountry = jQuery('#uxDdlControl12').val() == undefined ? "" : jQuery('#uxDdlControl12').val();
		var uxComments = jQuery('#uxComments').val() == undefined ? "" : jQuery('#uxComments').val();
		var uxNotes = jQuery('#uxTxtAreaControl13').val() == undefined ? "" : jQuery('#uxTxtAreaControl13').val();
		jQuery.ajax
		({
			type: "POST",
			data: "uxEmailAddress="+uxEmailAddress+"&target=checkForUpdateCustomer&action=AjaxExecuteCalls",
			url:  ajaxurl,
			success: function(data) 
			{  	
				
				if(jQuery.trim(data) == "newCustomerEmail")
				{
					jQuery.ajax
					({
						type: "POST",
						data: "uxFirstName="+uxFirstName+"&uxLastName="+uxLastName+"&uxEmailAddress="+uxEmailAddress+"&uxTelephoneNumber="+uxTelephoneNumber+
						"&uxMobileNumber="+uxMobileNumber+"&uxAddress1="+uxAddress1+"&uxAddress2="+uxAddress2+"&uxCity="+uxCity+"&uxPostalCode="+uxPostCode+
						"&uxCountry="+uxCountry+"&uxComments="+uxComments+"&uxSkypeId="+uxSkypeId+"&target=addCustomers&action=AjaxExecuteCalls",
						url:  ajaxurl,
						success: function(data) 
						{  			 
							var customerId = jQuery.trim(data);
							submitandsave(customerId);
						}   
					});
				}
				else
				{
					var customerId = jQuery.trim(data);
					jQuery.ajax
			        ({
			        	type: "POST",
			        	data: "uxEditCustomerId="+customerId+"&uxEditFirstName="+uxFirstName+"&uxEditLastName="+uxLastName+"&uxEditEmailAddress="+uxEmailAddress+
			        	"&uxEditTelephoneNumber="+uxTelephoneNumber+"&uxEditMobileNumber="+uxMobileNumber+"&uxEditAddress1="+uxAddress1+
			        	"&uxEditAddress2="+uxAddress2+"&uxEditCity="+uxCity+"&uxEditPostalCode="+uxPostCode+"&uxEditCountry="+uxCountry+
			        	"&uxEditSkypeId="+uxSkypeId+"&target=updatecustomers&comment=no&action=AjaxExecuteCalls",
			        	url:  ajaxurl,
			        	success: function(data) 
			       		{  
			       			submitandsave(customerId);
			            }   
			        }); 
				}
			}
		}); 
	}
	function submitandsave(customerId)
	{
		if(defaultServiceDisplaySetting == 0)
		 {
		   	var serviceId =  jQuery('input:radio[name=radioservice]:checked').val();
		 }
		 else
		 {
		    var serviceId = jQuery("#allService").val();
		 }
		 var altField = jQuery("#altField").val();
		 var uxNotes = jQuery('#uxTxtAreaControl13').val() == undefined ? "" : jQuery('#uxTxtAreaControl13').val();
		 var uxCouponCode = jQuery('#uxTxtControl11').val() == undefined ? "" : jQuery('#uxTxtControl1').val();
		 var bookingTime =  jQuery('#hdTimeControlValue').val();
		 jQuery.ajax
		 ({
			type: "POST",
			data: "altField="+altField+"&serviceId="+serviceId+"&customerId="+customerId+"&uxCouponCode="+uxCouponCode+"&uxNotes="+uxNotes+
				"&bookingTime="+bookingTime+"&target=frontEndMutipleDates&action=AjaxExecuteCalls",
				url:  ajaxurl,
				success: function(data) 
				{
				
					window.location.reload();
				}
		  }); 
	}
	function showTimingGrid()
	{
		if(defaultServiceDisplaySetting == 0)
		{
			var serviceId =  jQuery('input:radio[name=radioservice]:checked').val();
		}
		else
		{
			  var serviceId = jQuery("#allService").val();
		}
		var bookingDates = jQuery("#altField").val();
		
		jQuery.ajax
		({
			type: "POST",
			data: "serviceId="+serviceId+"&bookingDates="+bookingDates+"&target=bookingTiming&action=AjaxExecuteCalls",
			url:  ajaxurl,
			success: function(data) 
			{	
				
				var dat = data.trim();
				if(dat != "fullday")
				{
					jQuery('#timingSlot').css('display','block');
					jQuery('#timingSlot').css('visibility','visible');
					jQuery('#timingsGrid').html(dat);
				}
			
			}
		});
	}
	function checkExistingCustomerBooking()
	{
		var uxEmailAddress = jQuery('#uxTxtControl1').val();
		jQuery.ajax
		({
			type: "POST",
			data: "uxEmailAddress="+uxEmailAddress+"&target=getExistingCustomerData&action=AjaxExecuteCalls",
			url:  ajaxurl,
			success: function(data) 
			{
				
				if(jQuery.trim(data) != "newCustomer")
				{
					var dataa = data.trim();
					jQuery("#scriptExistingCustomer").html(dataa);
		        }
		        else
		        {		        	
		        	jQuery('#uxTxtControl1').val(uxEmailAddress);
		        }
			}
		});
	}
	oTable = jQuery('#data-table').dataTable
	({
		"bJQueryUI": false,
		"bAutoWidth": true,
		"bFilter": false,
		"sPaginationType": "full_numbers",
		"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
		"oLanguage": 
		{
			"sLengthMenu": "_MENU_"
		}
	});
	
</script>