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
							<?php _e( "SERVICES", bookings_engine ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="section">		
		<div class="box">
			<div class="title">
				<?php _e("SERVICES", bookings_engine); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<table class="table table-striped" id="data-table">
 					<thead>
     					<tr>
     						<th style="display:none;"><?php _e( "Service Display Order", bookings_engine ); ?></th>
     						<th style="width:5%"></th>
        					<th style="width:17%"><?php _e( "Service", bookings_engine ); ?></th>
        					<th style="width:8%"><?php _e( "Cost", bookings_engine ); ?></th>
        					<th style="width:15%"><?php _e( "Type", bookings_engine ); ?></th>
        					<th style="width:8%"><?php _e( "FullDay", bookings_engine ); ?></th>
        					<th style="width:12%"><?php _e( "Time", bookings_engine ); ?></th>
        					<th style="width:12%"><?php _e( "Business Hours", bookings_engine ); ?></th>
        					<th style="width:8%"></th>
						</tr>
					</thead>
  		 			<tbody>
		      			<?php
			       			$service = $wpdb->get_results
			       			(
								$wpdb->prepare
								(
									 'SELECT '.servicesTable().'.ServiceId, '.servicesTable().'.ServiceName, ' . servicesTable() . '.ServiceDisplayOrder,'.servicesTable().'.ServiceCost,
									 '.servicesTable().'.ServiceFullDay,'.servicesTable().'.ServiceMaxBookings, '.servicesTable().'.Type,'.servicesTable().'.ServiceStartTime,'.servicesTable().'.ServiceEndTime,
									 '.servicesTable().'.ServiceTotalTime,'.servicesTable().'.ServiceColorCode FROM '.servicesTable().'  ORDER BY ' . servicesTable() . '.ServiceDisplayOrder ASC',''
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
							for($flag=0; $flag < count($service); $flag++)
							{
								$serviceColor = $service[$flag]->ServiceColorCode;
								$hrs = floor(($service[$flag] -> ServiceTotalTime) / 60);
								$mins = ($service[$flag] -> ServiceTotalTime) % 60;
							?>
							<tr id="recordsArray_<?php echo $service[$flag] -> ServiceId ; ?>">
								<?php
									$serviceColorCode = "<div style=\"width:40px;height:15px;cursor:default;background-color:$serviceColor;color:$serviceColor\">";
								?>
								<td style="display: none;"><?php echo $service[$flag] -> ServiceDisplayOrder;?></td>
								<td><?php echo $serviceColorCode;?></td>
								<td><?php echo $service[$flag] -> ServiceName;?></td>
								<td><?php echo ($costIcon).$service[$flag] -> ServiceCost;?></td>
								<td><?php 
										if($service[$flag]->Type == 0)
										{
											echo "Single Booking";
										}
										else 
										{
											echo "Group Bookings (".$service[$flag] -> ServiceMaxBookings .")";
										}
									?>
								</td>
								<?php
									if($service[$flag] -> ServiceFullDay == 1)
									{
										$fullday = "Yes";
									}
									else
									{
										$fullday = "No";
									}
								?>
								<td><?php echo $fullday;?></td>
								<?php
									if($service[$flag] -> ServiceFullDay == 1)
									{
								?>
								<td>-</td>
								<?php
									}
									else
									{
								?>
								<td><?php
										if($hrs == 0)
										{
											echo $mins;
											_e( " Mins", bookings_engine ); 										
										}
										else if($mins == 0)
										{
											echo $hrs;
											_e( " Hrs", bookings_engine ); 
										}
										else 
										{
											echo $hrs; 
											_e( " Hrs ", bookings_engine );
											echo $mins;
											_e( " Mins", bookings_engine );
										}
									?>
								</td>
								<?php
									}		
									if($service[$flag] -> ServiceFullDay == 1)
									{
								?>
								<td>-</td>
								<?php
									}
									else
									{
								?>
								<td>
								<?php 
									$timeFormats = $wpdb->get_var
									(
									$wpdb->prepare
									(					
										"SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = %s",
										'default_Time_Format'
									)
									);
										$getHours = floor($service[$flag] -> ServiceStartTime / 60) ;
										$getMins = $service[$flag] -> ServiceStartTime % 60 ;
										$hourFormat = $getHours . ":" . $getMins;
										if($timeFormats == 0)
										{
											$time_in_12_hour_format  = DATE("g:i a", STRTOTIME($hourFormat));
										}
										else 
										{
											$time_in_12_hour_format  = DATE("H:i", STRTOTIME($hourFormat));
										}
										$getHours = floor($service[$flag] -> ServiceEndTime / 60) ;
										$getMins = $service[$flag] -> ServiceEndTime % 60 ;
										$hourFormat = $getHours . ":" . $getMins;
										if($timeFormats == 0)
										{
											$time_in_12_hour_format_End  = DATE("g:i a", STRTOTIME($hourFormat));
										}
										else 
										{
											$time_in_12_hour_format_End  = DATE("H:i", STRTOTIME($hourFormat));
										}
											echo $time_in_12_hour_format."-".$time_in_12_hour_format_End;
								?>
								</td>
								<?php
									}
								?>
								<td><a class="icon-edit  hovertip" data-toggle="modal" data-original-title="<?php _e("Edit Service?", bookings_engine ); ?>" data-placement="top" href="#editNewService" onclick="editServices(<?php echo $service[$flag]->ServiceId;?>);"></a>&nbsp;&nbsp;<a class="icon-remove hovertip" data-original-title="<?php _e("Delete Service?", bookings_engine ); ?>" data-placement="top"  href="#" onclick="deleteServices(<?php echo $service[$flag]->ServiceId;?>)"></a</td>
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
<div id="editNewService" class="modal hide fade" role="dialog" aria-hidden="true">
	<div class="modal-header"> 
 		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
 		<h3><?php _e( "Update Existing Service", bookings_engine ); ?></h3>  
    </div> 
 <form id="uxFrmEditServices" class="form-horizontal" method="post" action="#">
    <div class="body">
  		<div class="message green" id="editSuccessMessage" style="display:none;margin-left:10px;">
		<span>
      		<strong><?php _e( "Success! The Service has been updated Successfully.", bookings_engine ); ?></strong>
     	</span>
   		</div>
   		<div class="message red" id="errorMessageEditServices" style="display:none;margin-left:10px;">
   		<span>
   			<strong><?php _e( "Error! Max Bookings should be greater than 1", bookings_engine ); ?></strong>
   		</span>
   		</div>
   		<div class="message red" id="timeErrorEditMessage" style="display:none;margin-left:10px;">
   		<span>
			<strong>
				<?php _e( "Error! Please Enter the Valid Time.", bookings_engine ); ?>
			</strong>
		</span>
		</div>
         <div class="block well" style="margin-top:10px;">
             <div  id="bindEditControls"></div>                            
             <input type="hidden" id="serviceId" name="serviceId" value="" />
         </div>
         <div class="row" style="border-bottom:none">
			<label></label>
			<div class="right">
				<button type="submit" class="red" style="margin-top:10px;">
					<span>
						<?php _e( "Submit & Save Changes", bookings_engine ); ?>	   			
					</span>
				</button>
			</div>
		 </div>
 	</div>
 </form>
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
	jQuery("#Services").attr("class","current");
	var uri = "<?php echo $url; ?>"; 
	<?php
     $ResourcesEnable = $wpdb->get_var
	(
		$wpdb->prepare
		(
			"SELECT GeneralSettingsValue FROM ".generalSettingsTable()." where GeneralSettingsKey  = %s ",
			"resources-visible-enable"
		)
	);
     ?>	
		oTable = jQuery('#data-table').dataTable
		({
			"bJQueryUI": false,
			"bAutoWidth": true,
			"sPaginationType": "full_numbers",
			"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
			"oLanguage": 
			{
				"sLengthMenu": "_MENU_"
			},
			"aaSorting": [[ 0, "asc" ]],
			"aoColumnDefs": [{ "bSortable": false, "aTargets": [8] }]
	    });
	  
	function deleteServices(serviceId) 
	{
		bootbox.confirm('<?php _e("Are you sure you want to delete this Service", bookings_engine ); ?>', function(confirmed) 
		{
			console.log("Confirmed: "+confirmed);
			if(confirmed == true)
			{
				jQuery.ajax
			    ({
			    	type: "POST",
			    	data: "uxServiceId="+serviceId+"&target=deleteService&action=AjaxExecuteCalls",
			    	url:  ajaxurl,
			    	success: function(data) 
			        {  
			        	var checkAllocated = jQuery.trim(data);
			        	if(checkAllocated == "booked")
			        	{
			        			bootbox.alert('<?php _e("Unfortunately, this service could not be deleted until all bookings are deleted.", bookings_engine ); ?>');
			        	}
			        	else
			        	{
			        		var checkPage = "<?php echo $_REQUEST['page']; ?>";
						    window.location.href = "admin.php?page="+checkPage;
			        	}	
			        }
			    });
		    }
		});
	}    	
	jQuery.validator.addMethod("notEqualTo", function(value, element, param) 
	{
 		return this.optional(element) || value != param;
 	}, 
 	"This has to be different...");
 
	jQuery("#uxFrmEditServices").validate
	({
		rules: 
		{
			uxEditServiceName: "required",
			uxEditServiceCost: 
			{
				required: true,
				number: true
			},
			uxEditMaxBookings: 
			{
				required: true,
				digits: true
			},
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
	    	var serviceId = jQuery('#hiddenServiceId').val();
	    	var uxServiceNameEdit = jQuery('#uxEditServiceName').val();
	    	var uxEditServiceColorCode = jQuery('#uxEditServiceColorCode').val();
	    	var uxEditServiceName  = encodeURIComponent(uxServiceNameEdit);
			var uxEditServiceCost = jQuery('#uxEditServiceCost').val();
			var uxEditMaxBookings = jQuery('#uxEditMaxBookings').val();
			var uxEditServiceType = jQuery('input:radio[name=uxEditServiceType]:checked').val();
			var uxEditStartTimeHours = jQuery('#uxEditStartTimeHours').val();
			var uxEditStartTimeMins = jQuery('#uxEditStartTimeMins').val();
			var uxEditStartTimeAMPM = jQuery('#uxEditStartTimeAMPM').val();
			var uxEditEndTimeHours = jQuery('#uxEditEndTimeHours').val();
			var uxEditEndTimeMins = jQuery('#uxEditEndTimeMins').val();
			var uxEditEndTimeAMPM = jQuery('#uxEditEndTimeAMPM').val();
			var uxEditFullDay = jQuery("#uxEditFullDayService").prop("checked") == true ? 1 : 0;
			var uxEditServiceHours = jQuery('#uxEditServiceHours').val();
			var uxEditServiceMins = jQuery('#uxEditServiceMins').val();
			var uxEditMaxDays = jQuery('#uxEditMaxDays').val();
			var uxEditCostType = jQuery('input:radio[name=uxEditCostType]:checked').val();
			var uxEditTotalStartTime = parseInt(uxEditStartTimeHours * 60) + parseInt(uxEditStartTimeMins);
			var uxEditTotalEndTime = parseInt(uxEditEndTimeHours * 60) + parseInt(uxEditEndTimeMins);
			if(uxEditServiceType == 1 && uxEditMaxBookings > 1)
			{
				if((uxEditTotalStartTime >= uxEditTotalEndTime) && (uxEditStartTimeAMPM == uxEditEndTimeAMPM) && (uxEditFullDay == 0))
			   		{
			   			jQuery('#errorMessageEditServices').css('display','none');
			   			jQuery('#timeErrorEditMessage').css('display','block');
			   		}
		   			else if((uxEditStartTimeAMPM == "PM") && (uxEditEndTimeAMPM == "AM") && (uxEditFullDay == 0))
		   			{
		   				jQuery('#errorMessageEditServices').css('display','none');
		   				jQuery('#timeErrorEditMessage').css('display','block');
		   			}
		   			else
		   			{
		     			jQuery.ajax
					    ({
							type: "POST",
							data: "serviceId="+serviceId+"&uxEditServiceName="+uxEditServiceName+"&uxEditServiceCost="+uxEditServiceCost+"&uxEditServiceColorCode="+uxEditServiceColorCode+
							"&uxEditFullDay="+uxEditFullDay+"&uxEditStartTimeHours="+uxEditStartTimeHours+"&uxEditStartTimeMins="+uxEditStartTimeMins+
							"&uxEditStartTimeAMPM="+uxEditStartTimeAMPM+"&uxEditEndTimeHours="+uxEditEndTimeHours+"&uxEditEndTimeMins="+uxEditEndTimeMins+"&uxEditEndTimeAMPM="+uxEditEndTimeAMPM+
							"&uxEditMaxBookings="+uxEditMaxBookings+"&uxEditServiceType="+uxEditServiceType+"&uxEditServiceHours="+uxEditServiceHours+"&uxEditServiceMins="+uxEditServiceMins+
							"&uxEditMaxDays="+uxEditMaxDays+"&uxEditCostType="+uxEditCostType+"&target=updateServiceTable&action=AjaxExecuteCalls",
							url:  ajaxurl,
							success: function(data) 
						    { 
						    	jQuery('#timeErrorEditMessage').css('display','none');
						    	jQuery('#errorMessageEditServices').css('display','none');
						    	jQuery('#editSuccessMessage').css('display','block');
						    	setTimeout(function() 
					            {
					            	jQuery('#editSuccessMessage').css('display','none');
					            	var checkPage = "<?php echo $_REQUEST['page']; ?>";
									window.location.href = "admin.php?page="+checkPage;
					            }, 2000);
					        }
				   		});
				   	}
		   	}
		    else if(uxEditServiceType == 0)
			{
				if((uxEditTotalStartTime >= uxEditTotalEndTime) && (uxEditStartTimeAMPM == uxEditEndTimeAMPM) && (uxEditFullDay == 0))
			   		{
			   			jQuery('#errorMessageEditServices').css('display','none');
			   			jQuery('#timeErrorEditMessage').css('display','block');
			   		}
		   			else if((uxEditStartTimeAMPM == "PM") && (uxEditEndTimeAMPM == "AM") && (uxEditFullDay == 0))
		   			{
		   				jQuery('#errorMessageEditServices').css('display','none');
		   				jQuery('#timeErrorEditMessage').css('display','block');
		   			}
		   			else
		   			{
				   		jQuery.ajax
					    ({
							type: "POST",
							data: "serviceId="+serviceId+"&uxEditServiceName="+uxEditServiceName+"&uxEditServiceCost="+uxEditServiceCost+"&uxEditServiceColorCode="+uxEditServiceColorCode+
							"&uxEditFullDay="+uxEditFullDay+"&uxEditStartTimeHours="+uxEditStartTimeHours+"&uxEditStartTimeMins="+uxEditStartTimeMins+
							"&uxEditStartTimeAMPM="+uxEditStartTimeAMPM+"&uxEditEndTimeHours="+uxEditEndTimeHours+"&uxEditEndTimeMins="+uxEditEndTimeMins+"&uxEditEndTimeAMPM="+uxEditEndTimeAMPM+
							"&uxEditMaxBookings="+uxEditMaxBookings+"&uxEditServiceType="+uxEditServiceType+"&uxEditServiceHours="+uxEditServiceHours+"&uxEditServiceMins="+uxEditServiceMins+
							"&uxEditMaxDays="+uxEditMaxDays+"&uxEditCostType="+uxEditCostType+"&target=updateServiceTable&action=AjaxExecuteCalls",
							url:  ajaxurl,
							success: function(data) 
						    {
						    	jQuery('#timeErrorEditMessage').css('display','none');
						    	jQuery('#errorMessageEditServices').css('display','none');
						    	jQuery('#editSuccessMessage').css('display','block');
					        	setTimeout(function() 
					            {
					            	jQuery('#editSuccessMessage').css('display','none');
					            	var checkPage = "<?php echo $_REQUEST['page']; ?>";
									window.location.href = "admin.php?page="+checkPage;
					            }, 2000);
					        }
				   		});
				   	}
		   	}
		   	else
			{
				jQuery('#errorMessageEditServices').css('display','block');
			}  
	    }
	});
	function editServices(serviceId)
	{

		jQuery.ajax
		({
			type: "POST",
			data: "serviceId="+serviceId+"&target=editService&action=AjaxExecuteCalls",
			url:  ajaxurl,
		 	success: function(data) 
		    {  	
	        	jQuery("#bindEditControls").html(data);
	        	jQuery("#EditcolorPickerService").css('display','none');
	        }
		});
	}
	jQuery(document).ready(function()
	{ 
        	jQuery("#data-table tbody").sortable
        	({ 
        		opacity: 0.6,
        		cursor: 'move',
        		update: function()
        		{
	        		var order = jQuery(this).sortable("serialize")+'&target=updateRecordsListings&action=AjaxExecuteCalls';
	        		jQuery.ajax
					({
						type: "POST",
						data: order,
						url:  ajaxurl,
						success: function(data) 
						{
					
						}
					});
           		}								  
			});
			
	});
function singleBookingType()
{
	jQuery('#editMaxBooking').css('display','none');
}
function groupBookingType()
{
	jQuery('#editMaxBooking').css('display','block');
}
function divEditControlsShowHide()
{
	var uxFullDay = jQuery("#uxEditFullDayService").prop("checked");
	
	if(uxFullDay == 1)
 	{
 		jQuery("#divEditServiceTime").css('display','none');
		jQuery("#divEditStartTime").css('display','none');
		jQuery("#divEditEndTime").css('display','none');
		jQuery("#divEditMaxDays").css('display','block');
		jQuery("#divEditCostType").css('display','block');
	}
	else
	{
		jQuery("#divEditCostType").css('display','none');
		jQuery("#divEditMaxDays").css('display','none');
		jQuery("#divEditServiceTime").css('display','block');
		jQuery("#divEditStartTime").css('display','block');
		jQuery("#divEditEndTime").css('display','block');
	}
}
function colorFocus()
{
	jQuery("#EditcolorPickerService").css('display','block');
}
function colorHide()
{
	jQuery("#EditcolorPickerService").css('display','none');
}						
</script>