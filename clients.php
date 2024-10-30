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
							<?php _e( "CLIENTS", bookings_engine ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="section">		
		<div class="box">
			<div class="title">
				<?php _e("Clients", bookings_engine); ?>
				<span class="hide">					
				</span>
			</div>
			<div class="content">
				<table class="table table-striped" id="data-table-clients">
                	<thead>
                    	<tr>
     	                	<th style="width:15%"><?php _e( "First Name", bookings_engine ); ?></th>
     	                   	<th style="width:15%"><?php _e( "Last Name", bookings_engine ); ?></th>
                           	<th style="width:15%"><?php _e( "Email Address", bookings_engine ); ?></th>
                           	<th style="width:15%"><?php _e( "Mobile", bookings_engine ); ?></th>
                           	<th style="width:10%"><?php _e( "City", bookings_engine ); ?></th>
		                   	<th style="width:15%"><?php _e( "Country", bookings_engine ); ?></th>
		                	<th style="width:18%"></th>
	                    </tr>
                    </thead>
  		 	        <tbody>
  		 		   	<?php
  		 		   		$paypalEnable = $wpdb->get_var('SELECT PaymentGatewayValue FROM '.payment_Gateway_settingsTable().' WHERE PaymentGatewayKey = "paypal-enabled"');
			      		$customers = $wpdb->get_results
				  		(
							$wpdb->prepare
						   	(
						    	"SELECT * FROM ".customersTable()." LEFT OUTER JOIN ".countriesTable()." on ".customersTable().".CustomerCountry = ".countriesTable().".CountryId","" 
						    )
				        );
				        for($flag=0; $flag < count($customers); $flag++)
				        {
				        ?>
							<tr>
								<td><?php echo $customers[$flag] -> CustomerFirstName;?></td>
							    <td><?php echo $customers[$flag] -> CustomerLastName;?></td>
							    <td><?php echo $customers[$flag] -> CustomerEmail;?></td>
							    <td><?php echo $customers[$flag] -> CustomerMobile;?></td>
							    <td><?php echo $customers[$flag] -> CustomerCity;?></td>
							    <td><?php echo $customers[$flag] -> CountryName;?></td>
								<td>								
							    	<a class="icon-edit" data-toggle="modal" data-original-title="<?php _e("Edit Client?", bookings_engine ); ?>" data-placement="top" href="#EditCustomer" onclick="editCustomers(<?php echo $customers[$flag]->CustomerId;?>);"></a>&nbsp;&nbsp;
							      	<a style="display: none;" class="icon-envelope hovertip" data-toggle="modal" data-original-title="<?php _e("Email Client?", bookings_engine ); ?>" data-placement="top" href="#customerEmail" onclick="emailCustomer(<?php echo $customers[$flag]->CustomerId;?>);" data-toggle="modal"></a>&nbsp;&nbsp;
							      	<?php
							      	if($paypalEnable == 1)
									{
									?>
									<a class="icon-shopping-cart hovertip" data-toggle="modal" data-original-title="<?php _e("Payment Details", bookings_engine ); ?>" data-placement="top" href="#paypalDetails" onclick="customerPaypalBookingdetails(<?php echo $customers[$flag]->CustomerId;?>)"></a>&nbsp;&nbsp;
									<?php
									}
									?>								                									                		
							       	<a class="icon-calendar hovertip" data-toggle="modal" data-original-title="<?php _e("Booking Details", bookings_engine ); ?>" data-placement="top"  href="#manageBookings" onclick="customerBookingdetails(<?php echo $customers[$flag]->CustomerId;?>)" ></a>&nbsp;&nbsp;							                		
							       	<a class="icon-trash hovertip"  data-toggle="modal" data-original-title="<?php _e("Delete Client", bookings_engine ); ?>" data-placement="top"   onclick="deleteCustomer(<?php echo $customers[$flag]->CustomerId;?>)"></a>							                									                		
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
<div id="EditCustomer" class="modal1 hide fade" role="dialog" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>		
	    <h3>
	    	<?php _e( "Edit Customer ", bookings_engine ); ?> - 
	    	<strong id="editCustomerName">	    		
	    	</strong>
	    </h3>
    </div>
    <div class="message green" id="UpdatesuccessMessage" style="display:none;margin-left:10px;">
		<span>
			<strong>
				<?php _e( "Success! The Customer has been Updated.", bookings_engine ); ?>	
			</strong>
		</span>
	</div>
	<form id="uxFrmEditCustomers" class="form-horizontal" method="post" action="#">
		<div class="block well" style="margin:10px">
        	<div class="body" id="bindEditCustomer"></div>
	    </div>
	    <input type="hidden" id="CustomerId" value="" />
	    <div style="padding:10px 10px 10px 0px;float:right">
	   		<button type="submit" class="red" style="margin-top:10px;">
	   			<span>
	   				<?php _e( "Submit & Save Changes", bookings_engine ); ?>	   			
	   			</span>
	   		</button>
	    </div>	    
	</form>
</div>	
<div id="manageBookings" class="modal1 hide fade" role="dialog" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>		
	    <h3>
	    	<?php _e( "Customer Bookings", bookings_engine ); ?> - 
	    	<strong id="CustomerBookingsSchedule">	    		
	    	</strong>
	    </h3>	    	
    </div>	
	<form id="uxFrmManageBookings" class="form-horizontal" method="post" action="#">
		<div class="block well" style="margin:10px">
        	<div class="body" style="padding:0px;">
				<div class="table-overflow">
					<table class="table table-striped" id="data-table-customer-bookings">		
					</table>
				</div>
	    	</div> 
	    </div>	      
	</form>
</div>
<div id="paypalDetails" class="modal1 hide fade" role="dialog" aria-hidden="true">
	<div class="modal-header">	
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>	
		<h3>
			<?php _e( "Payment Details", bookings_engine ); ?> -  
			<span id="CustomerPaymentSchedule">				
			</span>
		</h3>	    	
    </div>	
	<form id="uxFrmPaypalDetails" class="form-horizontal" method="post" action="#">
		<div class="block well" style="margin:10px">
        	<div class="body" style="padding:0px;">
				<div class="table-overflow">
					<table class="table table-striped" id="data-table-paypal-bookings">		
					</table>
				</div>
	    	</div>
	    </div>	      
	</form>
</div>
<div id="customerEmail" class="modal1 hide fade" role="dialog" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>		
	    <h3>
	    	<?php _e( "Email Customer ", bookings_engine ); ?> - 
	    	<strong id="CustomerSendEmail">	    		
	    	</strong>
	    </h3>
    </div>
    <div class="message green" id="customerEmailSuccessMessage" style="display:none;margin-left:10px;">
		<span>
			<strong>
				<?php _e( "Success! Email has been sent.", bookings_engine ); ?>				
			</strong>
		</span>
	</div>  
	<form id="uxFrmCustomerDirectEmail" class="form-horizontal" method="post" action="#">
		<div class="block well" style="margin:10px">
            <div class="body">
            	<div class="row">
					<label class="control-label">
						<?php _e( "Email Subject :", bookings_engine ); ?>
					</label>
					<div class="right">
						<input type="text" class="required" name="uxFrmCustomerEmailSubject" id="uxFrmCustomerEmailSubject"/>
					</div>
				</div>
				<div class="row">
					<label class="control-label">
						<?php _e( "Email Content :", bookings_engine ); ?>
					</label>
					<div class="right">
						<?php     				  		
    						wp_editor("", $id = 'uxFrmCustomerEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 2); 
    					?>
					</div>
				</div>            	
            </div>
	    </div>
	    <input type="hidden" id="CustomerId" value="" />
	    <div style="padding:0px 20px 10px 0px;float:right">
	   		<button type="submit" class="red" style="margin-top:10px;">
	   			<span>
	   				<?php _e( "Send Email", bookings_engine ); ?>
	   			</span>
	   		</button>
	    </div>	    
	</form>
	<style type="text/css">
		#uxFrmCustomerEmailTemplate_ifr{height:250px !important;}
	</style>
</div>
<script type="text/javascript">
	jQuery("#Customers").attr("class","current");
	jQuery('#btnEditClient').click(function ()
	{
		var btn = jQuery(this)
		btn.button('loading')
		setTimeout(function ()
		{
			btn.button('reset')
	    }, 1000);
	});
	var uri = "<?php echo $url; ?>";      
	oTable = jQuery('#data-table-clients').dataTable
	({
		"bJQueryUI": false,
		"bAutoWidth": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
		"oLanguage": 
		{
			"sLengthMenu": "_MENU_"
		}
	});
   	function editCustomers(CustomerId)
	{
		jQuery.ajax
		({
			type: "POST",
			data: "customerId="+CustomerId+"&target=editcustomers&action=AjaxExecuteCalls",
			url:  ajaxurl,
			success: function(data) 
			{  	
				jQuery("#bindEditCustomer").html(data);
	        	jQuery('#CustomerId').val(jQuery('#hiddenCustomerId').val());
	        	jQuery('#editCustomerName').html(jQuery('#hiddenCustomerName').val());
	        }
		});
	}
	jQuery("#uxFrmEditCustomers").validate
	({
		rules: 
		{
			uxEditFirstName: "required",
			uxEditLastName: "required",			
			uxEditEmailAddress: 
			{
				required:true,
				email:true
			},
			uxEditTelephoneNumber:
			{
				required:false
			},
			uxEditMobileNumber:
			{
				required:false
			},
			uxEditSkypeId:
			{
			required:false
			},
			uxEditAddress1:
			{
				required:false
			},
			uxEditAddress2:
			{
				required:false
			},
			uxEditCity:
			{
				required:false
			},
			uxEditPostalCode:
			{
				required:false
			},			
			uxEditCountry:
			{
				required:false
			},
			uxEditComments:
			{
				required:false
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
	        	var CustomerId = jQuery('#CustomerId').val();
		     	var uxEditFirstName = jQuery('#uxEditFirstName').val();
             	var uxEditLastName = jQuery('#uxEditLastName').val();
		     	var uxEditEmailAddress = jQuery('#uxEditEmailAddress').val();
		     	var uxEditTelephoneNumber = jQuery('#uxEditTelephoneNumber').val();
		     	var uxEditMobileNumber = jQuery('#uxEditMobileNumber').val();
		     	var uxEditAddress1 = jQuery('#uxEditAddress1').val();
		     	var uxEditAddress2 = jQuery('#uxEditAddress2').val();
		     	var uxEditSkypeId = jQuery('#uxEditSkypeId').val();
		     	var uxEditCity = jQuery('#uxEditCity').val();
		     	var uxEditPostalCode = jQuery('#uxEditPostalCode').val();
		     	var uxEditCountry = jQuery('#uxEditCountry').val();
		     	var uxEditComments = jQuery('#uxEditComments').val();		     
		     	jQuery.ajax
		        ({
		        	type: "POST",
		        	data: "uxEditCustomerId="+CustomerId+"&uxEditFirstName="+uxEditFirstName+"&uxEditLastName="+uxEditLastName+
		         	"&uxEditEmailAddress="+uxEditEmailAddress+
		        	"&uxEditTelephoneNumber="+uxEditTelephoneNumber+"&uxEditMobileNumber="+uxEditMobileNumber+"&uxEditAddress1="
		       		+uxEditAddress1+"&uxEditAddress2="+uxEditAddress2+"&uxEditSkypeId="+uxEditSkypeId+"&uxEditCity="+uxEditCity+"&uxEditPostalCode="+uxEditPostalCode
		       		+"&uxEditCountry="+uxEditCountry+"&uxEditComments="+uxEditComments+"&target=updatecustomers&action=AjaxExecuteCalls",
		        	url:  ajaxurl,
		        	success: function(data) 
		       		{   
		       			jQuery('#UpdatesuccessMessage').css('display','block');
		            	setTimeout(function() 
		            	{
		                	jQuery('#UpdatesuccessMessage').css('display','none');
		                	var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
		                }, 2000);	
		            }   
		        });  
		    }
	});
		function deleteCustomer(CustomerId) 
	 	{
			bootbox.confirm("Are you sure you want to delete this Client?", function(confirmed) 
			{
				console.log("Confirmed: "+confirmed);
				if(confirmed == true)
				{
					jQuery.ajax
			        ({
			        	type: "POST",
			        	data: "uxcustomerId="+CustomerId+"&target=DeleteCustomer&action=AjaxExecuteCalls",
				   		url:  ajaxurl,
				     	success: function(data) 
			        	{  
			        		var checkExist = jQuery.trim(data);
			        		if(checkExist == "bookingExist")
			        		{
			        			bootbox.alert('<?php _e( "You cannot delete this Customer until all Bookings have been deleted.", bookings_engine ); ?>');
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
		function customerBookingdetails(id)
		{
			jQuery.ajax
			({
				type: "POST",
				data: "customerId="+id+"&target=customerBooking&action=AjaxExecuteCalls",
				url:  ajaxurl,
				success: function(data) 
				{  									     		
					jQuery('#data-table-customer-bookings').html(data);
			    	jQuery('#CustomerBookingsSchedule').html(jQuery('#customerNameForBooking').val());
			    			    				    	
			    }
			});
		}
		function customerPaypalBookingdetails(id)
		{
			jQuery.ajax
			({
				type: "POST",
				data: "customerId="+id+"&target=customerPaypalBooking&action=AjaxExecuteCalls",
				url:  ajaxurl,
			 	success: function(data) 
				{ 
					jQuery('#data-table-paypal-bookings').html(data);
			    	jQuery('#CustomerPaymentSchedule').html(jQuery('#customerNamePayment').val());			    				
			    }
			});
		}			    	
		function deleteCustomerBooking(bookingId)
		{
			bootbox.confirm("Are you sure you want to delete this Booking?", function(confirmed) 
			{
				console.log("Confirmed: "+confirmed);
				if(confirmed == true)
				{
					jQuery.ajax
					({
						type: "POST",
						data: "bookingId="+bookingId+"&target=deleteCustomerBookings&action=AjaxExecuteCalls",
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
		function customerBookingComments(bookingId)
		{
			jQuery.ajax
			({
				type: "POST",
				data: "bookingId="+bookingId+"&target=customerBookingCommentsId&action=AjaxExecuteCalls",
				url:  ajaxurl,
				success: function(data) 
				{  
					jQuery('#hiddenBookingId').val(bookingId);
					jQuery('#uxCustomerComments').val(data);
				}
			});
		}		
		jQuery("#uxFrmcustomerComments").validate
		({
			rules: 
			{								
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
	        	var uxCustomerComments = jQuery('#uxCustomerComments').val();	            
	            var uxCustomerbookingComments  = encodeURIComponent(uxCustomerComments);
	            var bookingId = jQuery('#hiddenBookingId').val();
	           	jQuery.ajax
		        ({
		        	type: "POST",
		         	data: "uxCustomerComments="+uxCustomerbookingComments+"&bookingId="+bookingId+"&target=updateCustomersComments&action=AjaxExecuteCalls",
		        	url:  ajaxurl,
		        	success: function(data) 
		       		{  
		            	jQuery('#CustomerCommentsSuccess').css('display','block');
		            	setTimeout(function() 
		            	{
		                	jQuery('#CustomerCommentsSuccess').css('display','none');
		                	var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
		                }, 2000);		                		
		            }   
		        });  
		    }
		});
		function emailCustomer(id)
		{
			jQuery.ajax
		    ({
		    	type: "POST",
		       	data: "customerId="+id+"&target=emailCustomerContent&action=AjaxExecuteCalls",
		       	url:  ajaxurl,
		       	success: function(data) 
		    	{		    							
					jQuery("#bindEditCustomer").html(data);
		    		jQuery('#CustomerSendEmail').html(jQuery('#hiddencustomerName').val());
		    		jQuery('#CustomerEmailHidden').val(jQuery('#hiddencustomerEmail').val());		    		
		    	}
		    });  
		}
		jQuery("#uxFrmCustomerDirectEmail").validate
		({
			rules: 
			{
				uxFrmCustomerEmailSubject:"required",
				uxFrmCustomerEmailTemplate:"required"	
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
				var uxFrmCustomerEmailSubject =  encodeURIComponent(jQuery("#uxFrmCustomerEmailSubject").val());
				var uxFrmCustomerEmailTemplate = encodeURIComponent(tinyMCE.get('uxFrmCustomerEmailTemplate').getContent());
				//alert(uxFrmCustomerEmailTemplate);
				jQuery.ajax
			    ({
			    	type: "POST",
			       	data: "uxFrmCustomerEmailSubject="+uxFrmCustomerEmailSubject+"&uxFrmCustomerEmailTemplate="+uxFrmCustomerEmailTemplate+
			       	"&emailId="+jQuery('#CustomerEmailHidden').val()+"&target=dirctEmailCustomer&action=AjaxExecuteCalls",
			       	url:  ajaxurl,
			       	success: function(data) 
			    	{
			    		jQuery('#customerEmailSuccessMessage').css('display','block');
			    		setTimeout(function() 
			    		{
			        		jQuery('#customerEmailSuccessMessage').css('display','none');
			        		var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
			        	}, 2000);
			    	}
			    });		     	
			}
		});	
		
		oTable = jQuery('#services-table-grid2').dataTable
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
		function customerData(email)
		{		
			jQuery('#uxTxtControl1').val(email);
			jQuery('#uxTxtControl1').attr('disabled','disabled');
			checkExistingCustomerBooking();	
		}
</script>