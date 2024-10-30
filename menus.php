<div id="top">
	<h1 id="logo"></h1>
	<img src="<?php  echo plugins_url('/images/banner3.png', __FILE__);  ?>" style="margin-bottom:10px;margin-right:10px;float:right"/>
	<div id="menu">
		<ul class="sf-js-enabled"> 
			<li id="Dashboard">
				<a href="admin.php?page=baseFunction">
					<?php _e( "Dashboard", bookings_engine ); ?>
				</a>
			</li> 
			<li id="Bookings">
				<a href="admin.php?page=manageBookings" >
					<?php _e( "Bookings", bookings_engine ); ?>
				</a>
			</li> 
			<li id="Services" class="">
				<a href="admin.php?page=manageServices">
					<?php _e( "Services", bookings_engine ); ?>
				</a>
			</li>
			<li id="Coupons">
				<a href="admin.php?page=discountCoupons">
					<?php _e( "Coupons", bookings_engine ); ?>
				</a>
			</li>
			<li id="Customers">
				<a href="admin.php?page=manageClients">
					<?php _e( "Clients", bookings_engine ); ?>
				</a>
			</li>
			<li id="blockouts">
				<a href="admin.php?page=manageBlockOuts">
					<?php _e( "Block Outs", bookings_engine ); ?>
				</a>
			</li>
			<li id="BookingForm">
				<a href="admin.php?page=manageBookingForm">
					<?php _e( "Form Setup", bookings_engine ); ?>
				</a>
			</li>
			<li id="EmailTemplate">
				<a href="admin.php?page=manageEmailTemplate">
					<?php _e( "Email Templates", bookings_engine ); ?>
				</a>
			</li>
			<li id="ReportBug">
				<a href="admin.php?page=manageReportBug">
					<?php _e( "Report a Bug", bookings_engine ); ?>
				</a>
			</li>
		</ul>
	</div>
</div>
<div id="left">		
	<div class="box statics">
		<div class="content">
			<ul>
				<li>
					<h2><?php _e( "Overview Stats", bookings_engine ); ?></h2>
				</li>
				<li>
					<?php _e( "Total Bookings", bookings_engine ); ?>
					<div class="info red">
						<span id="uxDashboardBookingsCount"></span>
					</div>
				</li>
				<li>
					<?php _e( "Total Services", bookings_engine ); ?>
					<div class="info blue">
						<span id="uxDashboardServiceCount"></span>
					</div>
				</li>
				<li>
					<?php _e( "Total Clients", bookings_engine ); ?>
					<div class="info black">
						<span id="uxDashboardCustomersCount"></span>
					</div>
				</li>
				<li>
					<?php _e( "Total Coupons", bookings_engine ); ?>
					<div class="info green">
						<span id="uxDashboardCouponsCount"></span>
					</div>
				</li>												
				<li>
					<?php _e( "Total BlockOuts", bookings_engine ); ?>
					<div class="info red">
						<span id="uxDashboardBlockOutsCount"></span>
					</div>
				</li>						
			</ul>
		</div>
    </div>
	<div class="box statics">
	    <div class="content">
			<ul>
				<li>
					<h2><?php _e( "Default Settings", bookings_engine ); ?></h2>
				</li>
				<div id="defaultSettingsArea" >	
				</div>					
			</ul>
	    </div>
	</div>	
	<div class="box statics">
	    <div class="content">
			<ul>
				<li>
					<h2><?php _e( "Bookings Today", bookings_engine ); ?></h2>
				</li>
				<div id="resentBookingsContent" >	
				</div>					
			</ul>
	    </div>
	</div>				
</div>
<script type="text/javascript">
	jQuery.ajax
	({
		type: "POST",
		data: "target=getServiceCount&action=AjaxExecuteCalls",
		url:  ajaxurl,
		success: function(data) 
		{
			jQuery("#uxServiceCount").html(data);
			jQuery("#uxDashboardServiceCount").html(data);									
		}
	});
	jQuery.ajax
	({
		type: "POST",
		data: "target=getCustomerCount&action=AjaxExecuteCalls",
		url:  ajaxurl,
		success: function(data) 
		{
			jQuery("#uxCustomersCount").html(data);
			jQuery("#uxDashboardCustomersCount").html(data);									
		}
	});
	jQuery.ajax
	({
		type: "POST",
		data: "target=getBookingCount&action=AjaxExecuteCalls",
		url:  ajaxurl,
		success: function(data) 
		{
			jQuery("#uxBookingsCount").html(data);
			jQuery("#uxDashboardBookingsCount").html(data);
									
		}
	});
	jQuery.ajax
	({
		type: "POST",
		data: "target=getCouponCount&action=AjaxExecuteCalls",
		url:  ajaxurl,
		success: function(data)
		{
			jQuery("#uxCouponsCount").html(data);
			jQuery("#uxDashboardCouponsCount").html(data);
		}
	});
	jQuery.ajax
	({
		type: "POST",
		data: "target=recentBookings&action=AjaxExecuteCalls",
		url:  ajaxurl,
		success: function(data)
		{
			jQuery("#resentBookingsContent").html(data);

		}
	});
	jQuery.ajax
	({
		type: "POST",
		data: "target=defaultSettingsArea&action=AjaxExecuteCalls",
		url:  ajaxurl,
		success: function(data)
		{
			jQuery("#defaultSettingsArea").html(data);

		}
	});
	jQuery.ajax
	({
		type: "POST",
		data: "target=getBlockOutsCount&action=AjaxExecuteCalls",
		url:  ajaxurl,
		success: function(data) 
		{
			jQuery("#uxBlockOutsCount").html(data);
			jQuery("#uxDashboardBlockOutsCount").html(data);									
		}
	});
</script>
