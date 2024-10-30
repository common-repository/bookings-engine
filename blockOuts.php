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
							<?php _e( "BLOCKOUTS", bookings_engine ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="section">		
		<div class="box">
			<div class="title">
				<?php _e("Block Outs", bookings_engine); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<table class="table table-striped" id="data-table-blockOuts">
 					<thead>
     					<tr>
     						<th  style="width:25%">
     							<?php _e( "Service", bookings_engine ); ?>
 							</th>
     						<th>
     							<?php _e( "Block Outs", bookings_engine ); ?>
 							</th>
        					<th style="width:8%"></th>
						</tr>
					</thead>
  		 			<tbody>
  		 				<?php
  		 				$dateFormat = $wpdb->get_var
						(
							$wpdb->prepare
							(
								'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s ',
								"default_Date_Format"
							)
						);
						$timeFormats = $wpdb -> get_var
		            	(
							$wpdb->prepare
							(	
		            			'SELECT GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
		            			"default_Time_Format"
		            		)
						);		            		
	 					$blockouts = $wpdb->get_results
	 					(
	 						$wpdb->prepare
	 						(
								"SELECT * From ".block_outs() . " join " . servicesTable() . " on " .block_outs() .".ServiceId = " . servicesTable() . ".ServiceId",""
							)
						);
						for($flagBlock =0; $flagBlock < count($blockouts); $flagBlock++)
						{
						?>
						<tr>
							<td>
								<?php echo $blockouts[$flagBlock]->ServiceName; ?>
							</td>
							<td>
								<?php
								if($dateFormat == 0)
								{
									$StartDate = date("M d, Y", strtotime($blockouts[$flagBlock]->StartDate));
									$EndDate = date("M d, Y", strtotime($blockouts[$flagBlock]->EndDate));
								}
								else if($dateFormat == 1)
								{
									$StartDate = date("Y/m/d", strtotime($blockouts[$flagBlock]->StartDate));
									$EndDate = date("Y/m/d", strtotime($blockouts[$flagBlock]->EndDate));
								}	
								else if($dateFormat == 2)
								{
									$StartDate = date("m/d/Y", strtotime($blockouts[$flagBlock]->StartDate));
									$EndDate = date("m/d/Y", strtotime($blockouts[$flagBlock]->EndDate));
								}	
								else if($dateFormat == 3)
								{
									$StartDate = date("d/m/Y", strtotime($blockouts[$flagBlock]->StartDate));
									$EndDate = date("d/m/Y", strtotime($blockouts[$flagBlock]->EndDate));
								}
								if($blockouts[$flagBlock]->Repeats == 0)
								{
									if($blockouts[$flagBlock]->FullDayBlockOuts == 1)
									{
										if($blockouts[$flagBlock]->RepeatEvery == 1)
										{
											if($blockouts[$flagBlock]->EndDate == 0)
											{
												_e( "Daily with full day Block Outs from ", bookings_engine ) ._e($StartDate,'bookings_engine')."</br></br>";
											}
											else
											{
												_e( "Daily with full day Block Outs from ", bookings_engine ) ._e($StartDate,'bookings_engine').
												_e( " upto ", bookings_engine )._e($EndDate,'bookings_engine')."</br></br>";
											}
										}
										else
										{
											if($blockouts[$flagBlock]->EndDate == 0)
											{
												_e( "Every ", bookings_engine ). _e($blockouts[$flagBlock]->RepeatEvery,'bookings_engine') . 
												_e( " days with full day Block Outs from ", bookings_engine ) ._e($StartDate,'bookings_engine')."</br></br>";
											}
											else 
											{
												_e( "Every ", bookings_engine ). _e($blockouts[$flagBlock]->RepeatEvery,'bookings_engine') . 
												_e( " days with full day Block Outs from ", bookings_engine ) ._e($StartDate,'bookings_engine').
												_e( " upto ", bookings_engine )._e($EndDate,'bookings_engine')."</br></br>";
											}	
										}
									}
									else 
									{
										$getHours_block = floor(($blockouts[$flagBlock] -> StartTime)/60);
										$getMins_block = ($blockouts[$flagBlock] -> StartTime) % 60;
										$hourFormat_blockouts = $getHours_block . ":" . $getMins_block;
										if($timeFormats == 0)
										{
											$time_in_12_hour_format_blockouts  = DATE("h:iA", STRTOTIME($hourFormat_blockouts)); 
										}
										else 
										{
											$time_in_12_hour_format_blockouts  = DATE("H:i", STRTOTIME($hourFormat_blockouts));
										}
						           		$getHours_blockout = floor(($blockouts[$flagBlock] -> EndTime)/60);
										$getMins_blockout = ($blockouts[$flagBlock] -> EndTime) % 60;
										$hourFormat_blockout = $getHours_blockout . ":" . "00";
										if($timeFormats == 0)
										{
											$time_in_12_hour_format_blockout  = DATE("h:iA", STRTOTIME($hourFormat_blockout)); 
										}
										else 
										{
											$time_in_12_hour_format_blockout = DATE("H:i", STRTOTIME($hourFormat_blockout));
										}
										if($blockouts[$flagBlock]->RepeatEvery == 1)
										{
											if($blockouts[$flagBlock]->EndDate == 0)
											{
												_e( "Daily from ", bookings_engine ) . _e($StartDate,'bookings_engine').
												_e( " starting from ", bookings_engine )._e($time_in_12_hour_format_blockouts,'bookings_engine').
												_e( " till ", bookings_engine )._e($time_in_12_hour_format_blockout,'bookings_engine')."</br></br>";
											}
											else 
											{
												_e( "Daily from ", bookings_engine ) . _e($StartDate,'bookings_engine').
												_e( " upto ", bookings_engine )._e($EndDate,'bookings_engine').
												_e( " starting from ", bookings_engine )._e($time_in_12_hour_format_blockouts,'bookings_engine').
												_e( " till ", bookings_engine )._e($time_in_12_hour_format_blockout,'bookings_engine')."</br></br>";
											}
										}
										else
									    {
											if($blockouts[$flagBlock]->EndDate == 0)
											{
												_e( "Every ", bookings_engine ) ._e($blockouts[$flagBlock]->RepeatEvery,'bookings_engine')._e( " days from ", bookings_engine ).
												_e($StartDate,'bookings_engine')._e( " starting from ", bookings_engine )._e($time_in_12_hour_format_blockouts,'bookings_engine').
												_e( " till ", bookings_engine )._e($time_in_12_hour_format_blockout,'bookings_engine')."</br></br>";
											}
											else
											{
												_e( "Every ", bookings_engine ) ._e($blockouts[$flagBlock]->RepeatEvery,'bookings_engine')._e( " days from ", bookings_engine ).
												_e($StartDate,'bookings_engine')._e( " upto ", bookings_engine )._e($EndDate,'bookings_engine').
												_e( " starting from ", bookings_engine )._e($time_in_12_hour_format_blockouts,'bookings_engine').
												_e( " till ", bookings_engine )._e($time_in_12_hour_format_blockout,'bookings_engine')."</br></br>";
											}
										}											
									}									
								}
								if($blockouts[$flagBlock]->Repeats == 1)
								{
									if($blockouts[$flagBlock]->FullDayBlockOuts == 1)
									{
										if($blockouts[$flagBlock]->RepeatEvery == 1)
										{
											if($blockouts[$flagBlock]->EndDate == 0)
											{
												_e( "Weekly with full day Block Outs on ", bookings_engine ) ._e($blockouts[$flagBlock]->RepeatDays,'bookings_engine').
												_e( " from ", bookings_engine ) ._e($StartDate,'bookings_engine')."</br></br>";
											}
											else 
											{
												_e( "Weekly with full day Block Outs on ", bookings_engine ) ._e($blockouts[$flagBlock]->RepeatDays,'bookings_engine').
												_e( " from ", bookings_engine ) ._e($StartDate,'bookings_engine').
												_e( " upto ", bookings_engine )._e($EndDate,'bookings_engine')."</br></br>";
											}
										}
										else
										{
											if($blockouts[$flagBlock]->EndDate == 0)
											{
												_e( "Every ", bookings_engine ). _e($blockouts[$flagBlock]->RepeatEvery,'bookings_engine') . 
												_e( " weeks on ", bookings_engine ) ._e($blockouts[$flagBlock]->RepeatDays,'bookings_engine').
												_e( " with full day Block Outs from ", bookings_engine ) ._e($StartDate,'bookings_engine').
												"</br></br>";	
											}
											else
											{
												_e( "Every ", bookings_engine ). _e($blockouts[$flagBlock]->RepeatEvery,'bookings_engine') . 
												_e( " weeks on ", bookings_engine ) ._e($blockouts[$flagBlock]->RepeatDays,'bookings_engine').
												_e( " with full day Block Outs from ", bookings_engine ) ._e($StartDate,'bookings_engine').
												_e( " upto ", bookings_engine )._e($EndDate,'bookings_engine')."</br></br>";	
											}
										}
									}
									else 
									{
										$getHours_block = floor(($blockouts[$flagBlock] -> StartTime)/60);
										$getMins_block = ($blockouts[$flagBlock] -> StartTime) % 60;
										$hourFormat_blockouts = $getHours_block . ":" . $getMins_block;
										if($timeFormats == 0)
										{
											$time_in_12_hour_format_blockouts  = DATE("h:iA", STRTOTIME($hourFormat_blockouts));
										}
										else 
										{
											$time_in_12_hour_format_blockouts  = DATE("H:i", STRTOTIME($hourFormat_blockouts));
										}
										$getHours_blockout = floor(($blockouts[$flagBlock] -> EndTime)/60);
										$getMins_blockout = ($blockouts[$flagBlock] -> EndTime) % 60;
										$hourFormat_blockout = $getHours_blockout . ":" . $getMins_blockout;
										if($timeFormats == 0)
										{
											$time_in_12_hour_format_blockout  = DATE("h:iA", STRTOTIME($hourFormat_blockout));
										}
										else 
										{
											$time_in_12_hour_format_blockout = DATE("H:i", STRTOTIME($hourFormat_blockout));
										}
										if($blockouts[$flagBlock]->RepeatEvery == 1)
										{
											if($blockouts[$flagBlock]->RepeatDays == NULL)
											{
												if($blockouts[$flagBlock]->EndDate == 0)
												{
													_e( "Weekly from ", bookings_engine )._e($StartDate,'bookings_engine').
													_e( " starting from ", bookings_engine )._e($time_in_12_hour_format_blockouts,'bookings_engine').
													_e( " till ", bookings_engine )._e($time_in_12_hour_format_blockout,'bookings_engine')."</br></br>";
												}
												else 
												{
													_e( "Weekly from ", bookings_engine )._e($StartDate,'bookings_engine').
													_e( " upto ", bookings_engine )._e($EndDate,'bookings_engine').
													_e( " starting from ", bookings_engine )._e($time_in_12_hour_format_blockouts,'bookings_engine').
													_e( " till ", bookings_engine )._e($time_in_12_hour_format_blockout,'bookings_engine')."</br></br>";
												}
											}
											else
											{
												if($blockouts[$flagBlock]->EndDate == 0)
												{
													_e( "Weekly on ", bookings_engine ) ._e($blockouts[$flagBlock]->RepeatDays,'bookings_engine')._e( " from ", bookings_engine ).
													_e($StartDate,'bookings_engine')._e( " starting from ", bookings_engine )._e($time_in_12_hour_format_blockouts,'bookings_engine').
													_e( " till ", bookings_engine )._e($time_in_12_hour_format_blockout,'bookings_engine')."</br></br>";
												}
												else 
												{
													_e( "Weekly on ", bookings_engine ) ._e($blockouts[$flagBlock]->RepeatDays,'bookings_engine')._e( " from ", bookings_engine ).
													_e($StartDate,'bookings_engine') . _e( " upto ", bookings_engine )._e($EndDate,'bookings_engine').
													_e( " starting from ", bookings_engine )._e($time_in_12_hour_format_blockouts,'bookings_engine')._e( " till ", bookings_engine ).
													_e($time_in_12_hour_format_blockout,'bookings_engine')."</br></br>";
												}
											}											
										}
										else
										{											
											if($blockouts[$flagBlock]->RepeatDays == NULL)
											{
												if($blockouts[$flagBlock]->EndDate == 0)
												{
													_e( "Every ", bookings_engine ) ._e($blockouts[$flagBlock]->RepeatEvery,'bookings_engine')._e( " weeks from ", bookings_engine )._e($StartDate,'bookings_engine').
													_e( " starting from ", bookings_engine )._e($time_in_12_hour_format_blockouts,'bookings_engine').
													_e( " till ", bookings_engine )._e($time_in_12_hour_format_blockout,'bookings_engine')."</br></br>";
												}
												else
												{
													_e( "Every ", bookings_engine ) ._e($blockouts[$flagBlock]->RepeatEvery,'bookings_engine')._e( " weeks from ", bookings_engine )._e($StartDate,'bookings_engine').
													_e( " upto ", bookings_engine )._e($EndDate,'bookings_engine')._e( " starting from ", bookings_engine )._e($time_in_12_hour_format_blockouts,'bookings_engine').
													_e( " till ", bookings_engine )._e($time_in_12_hour_format_blockout,'bookings_engine')."</br></br>";
												}
											}
											else
											{
												if($blockouts[$flagBlock]->EndDate == 0)
												{
													_e( "Every ", bookings_engine ) ._e($blockouts[$flagBlock]->RepeatEvery,'bookings_engine')._e( " weeks on ", bookings_engine )._e($blockouts[$flagBlock]->RepeatDays,'bookings_engine').
													_e( " from ", bookings_engine ) ._e($StartDate,'bookings_engine').
													_e( " starting from ", bookings_engine )._e($time_in_12_hour_format_blockouts,'bookings_engine')._e( " till ", bookings_engine )._e($time_in_12_hour_format_blockout,'bookings_engine')."</br></br>";
												}
												else
												{
													_e( "Every ", bookings_engine ) ._e($blockouts[$flagBlock]->RepeatEvery,'bookings_engine')._e( " weeks on ", bookings_engine )._e($blockouts[$flagBlock]->RepeatDays,'bookings_engine').
													_e( " from ", bookings_engine ) ._e($StartDate,'bookings_engine')._e( " upto ", bookings_engine )._e($EndDate,'bookings_engine').
													_e( " starting from ", bookings_engine )._e($time_in_12_hour_format_blockouts,'bookings_engine')._e( " till ", bookings_engine )._e($time_in_12_hour_format_blockout,'bookings_engine')."</br></br>";
												}
											}
										}
									}
								}
								?>
							</td>
							<td>
								<a class="icon-trash hovertip"  data-toggle="modal" data-original-title="<?php _e("Delete Block Out", bookings_engine ); ?>" data-placement="top" onclick="deleteBlockOut(<?php echo $blockouts[$flagBlock]->RepeatId;?>)"></a>
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
		
			<?php _e( "Bookings Engine!", bookings_engine ); ?>
		</a>
	</div>
</div>
</div>
</div>
<script type="text/javascript">
	jQuery("#blockouts").attr("class","current"); 
	oTable = jQuery('#data-table-blockOuts').dataTable
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
	function deleteBlockOut(RepeatId)
	{
		bootbox.confirm("Are you sure you want to delete this Block Out?", function(confirmed)
		{
			console.log("Confirmed: "+confirmed);
			if(confirmed == true)
			{
				jQuery.ajax
				({
					type:"POST",
					data: "uxrepeatId="+RepeatId+"&target=deleteBlockOut&action=AjaxExecuteCalls",
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