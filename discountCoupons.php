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
							<?php _e( "COUPONS", bookings_engine ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="section">		
		<div class="box">
			<div class="title">
				<?php _e("COUPONS", bookings_engine); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<table class="table table-striped" id="data-table-Coupons">
					<thead>
						<tr>
							<th style="width:17%"><?php _e( "Discount Coupon", bookings_engine ); ?></th>
							<th style="width:15%"><?php _e( "Valid From", bookings_engine ); ?></th>
							<th style="width:15%"><?php _e( "Valid Upto", bookings_engine ); ?></th>
							<th style="width:12%"><?php _e( "Amount", bookings_engine ); ?></th>
							<th style="width:12%"><?php _e( "Amount Type", bookings_engine ); ?></th>
							<th style="width:12%"><?php _e( "Apply to All", bookings_engine ); ?></th>
							<th style="width:8%"><?php _e( "Status", bookings_engine ); ?></th>
							<th style="width:17%"><?php _e( "Service", bookings_engine ); ?></th>
							<th style="width:8%"></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$Coupon = $wpdb->get_results
							(
								$wpdb->prepare
								(
										"SELECT * FROM ".coupons()." order by couponName ASC",''
										
								)
							);
								$currency_sel = $wpdb->get_var
								(
								$wpdb->prepare
									(
										"SELECT CurrencySymbol FROM ".currenciesTable(). " where CurrencyUsed = %d",
												1
									)
								);
								for($flag=0; $flag < count($Coupon); $flag++)
								{
									$couponProducts = $wpdb->get_results
									(
										$wpdb->prepare
										(
											"SELECT * FROM ".coupons_products()." JOIN ".servicesTable()." ON ".coupons_products().".serviceId=".servicesTable().".ServiceId where ".coupons_products().".couponId = %d",
											$Coupon[$flag]->couponId
										)
									);
									?>
									<tr>
										<td><?php echo $Coupon[$flag] -> couponName;?></td>
										<?php
										$dateFormat = $wpdb->get_var
										(
											$wpdb->prepare
											(
												'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s ',
												"default_Date_Format"
											)
										);
										if($dateFormat == 0)
										{
											$dateFormat1 =  date("M d, Y", strtotime($Coupon[$flag] -> couponValidFrom));
										}
										else if($dateFormat == 1)
										{
											$dateFormat1 =  date("Y/m/d", strtotime($Coupon[$flag] -> couponValidFrom));
										}	
										else if($dateFormat == 2)
										{
											$dateFormat1 = date("m/d/Y", strtotime($Coupon[$flag] -> couponValidFrom));
										}	
										else if($dateFormat == 3)
										{
											$dateFormat1 =  date("d/m/Y", strtotime($Coupon[$flag] -> couponValidFrom));
										}	
										?>
										<td><?php echo $dateFormat1;?></td>
										<?php
										if($dateFormat == 0)
										{
											$dateFormat2 =  date("M d, Y", strtotime($Coupon[$flag] -> couponValidUpto));
										}
										else if($dateFormat == 1)
										{
											$dateFormat2 =  date("Y/m/d", strtotime($Coupon[$flag] -> couponValidUpto));
										}	
										else if($dateFormat == 2)
										{
											$dateFormat2 = date("m/d/Y", strtotime($Coupon[$flag] -> couponValidUpto));
										}	
										else if($dateFormat == 3)
										{
											$dateFormat2 =  date("d/m/Y", strtotime($Coupon[$flag] -> couponValidUpto));
										}	
										?>
										<td><?php echo $dateFormat2;?></td>
										<?php
										$couponAmount = $Coupon[$flag]->Amount;
										if($Coupon[$flag] -> amountType == 0)
										{
											?>
											<td><?php echo $currency_sel. "".$couponAmount;?></td>
											<?php
										}
										else
										{
											?>
											<td><?php echo $couponAmount . "%";?></td>
											<?php
										} ?>
										</td>
										<td><?php
										if($Coupon[$flag] -> amountType == 0)
										{
											echo _e( "Amount", bookings_engine ); 
										}
										else
										{
											echo _e( "Percentage", bookings_engine ); 
											
										}   ?>
										</td>
										<td><?php 
											if($Coupon[$flag] -> couponApplicable == 1)
											{
												echo _e( "Yes", bookings_engine ); 
											}
											else
											{
												echo _e( "No", bookings_engine );
											}
											?></td>
										<td><?php 
										if($Coupon[$flag] -> couponStatus == "1")
										{
											echo "Active";
										}
										else 
										{
											echo "InActive";
										}
										?></td>
										<td><?php
											$couponColor = "<div id=\"tags1_tagsinput\" class=\"tagsinput\" style=\"width: 100%; min-height: auto; height: auto; \">";
											
											for($flag1 = 0; $flag1 < count($couponProducts); $flag1++)
											{
												$couponColor .= "<span style=\"margin-left:5px;background-color:".$couponProducts[$flag1]->ServiceColorCode.";color:#fff;border:solid 1px ".$couponProducts[$flag1]->ServiceColorCode . "\" class=\"tag\"><span> " . $couponProducts[$flag1]->ServiceName .' '. "</span></span>";
												
											}
											echo $couponColor . " ";
										?></td>
										<td><a class="icon-trash hovertip"  data-toggle="modal" data-original-title="<?php _e("Delete Coupon", bookings_engine ); ?>" data-placement="top"   onclick="deleteCoupon(<?php echo $Coupon[$flag]->couponId;?>)"></a></td>
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
<script type="text/javascript">
	jQuery("#Coupons").attr("class","current");
	var uri = "<?php echo $url; ?>";      
	oTable = jQuery('#data-table-Coupons').dataTable
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
	function deleteCoupon(couponId)
	{
		bootbox.confirm("Are you sure you want to delete this Coupon?", function(confirmed)
		{
			console.log("Confirmed: "+confirmed);
			if(confirmed == true)
			{
				jQuery.ajax
				({
					type:"POST",
					data: "uxcouponId="+couponId+"&target=deleteCoupon&action=AjaxExecuteCalls",
					url: ajaxurl,
					success: function(data)
					{
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					}
				});
			}
		});
	}
</script>