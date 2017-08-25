<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">GST Sales Report</span>
		</div>
		<div class="actions">
			
		</div>
		
	
	<div class="portlet-body form">
		<form method="GET" >
			<table width="50%" class="table table-condensed">
				<tbody>
					<tr>
						<td width="12%">
							<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From" value="<?php echo @date('d-m-Y', strtotime($From));  ?>"  data-date-format="dd-mm-yyyy">
						</td>	
						<td width="12%">
							<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To" value="<?php echo @date('d-m-Y', strtotime($To));  ?>"  data-date-format="dd-mm-yyyy" >
						</td>
						
						<td width="15%">
								<?php echo $this->Form->input('item_name', ['empty'=>'---Items---','options' => $Items,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category','value'=> h(@$item_name) ]); ?>
						</td>
						<td width="15%">
								<?php echo $this->Form->input('item_category', ['empty'=>'---Category---','options' => $ItemCategories,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category','value'=> h(@$item_category) ]); ?>
						</td>
						<td width="15%">
							<div id="item_group_div">
							<?php echo $this->Form->input('item_group_id', ['empty'=>'---Group---','options' =>$ItemGroups,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Group','value'=> h(@$item_group)]); ?></div>
						</td>
						<td width="15%">
							<div id="item_sub_group_div">
							<?php echo $this->Form->input('item_sub_group_id', ['empty'=>'---Sub-Group---','options' =>$ItemSubGroups,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Sub-Group','value'=> h(@$item_sub_group)]); ?></div>
						</td>
					
						<td width="10%">
							<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
						</td>
					</tr>
				</tbody>
			</table>
			</form>
		<!-- BEGIN FORM-->
		<div class="row ">
		
		
		<div class="col-md-12">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<td colspan="11" align="center"  valign="top">
							<h4 class="caption-subject font-black-steel uppercase">Sales Invoice</h4>
						</td>
					</tr>
					<tr>
						<th>Sr.No.</th>
						<th>Invoice No</th>
						<th>Date</th>
						<th>Customer</th>
						<th style="text-align:right;">Sales @ 12 % GST</th>
						<th style="text-align:right;">GST @ 12 % </th>
						<th style="text-align:right;">Sales @ 18 % GST</th>
						<th style="text-align:right;">GST @ 18 % </th>
						<th style="text-align:right;">Sales @ 28 % GST</th>
						<th style="text-align:right;">GST @ 28 % </th>
					</tr>
				</thead>
				<?php $i=1;  $salesTotal12=0; $salesTotal18=0; $salesTotal28=0;
							$salesTotalGST12=0; $salesTotalGST18=0; $salesTotalGST28=0; 
				foreach ($invoices as $invoice):  
					$salesGstRowTotal12=0; $salesGstRowTotal18=0; $salesGstRowTotal28=0; $salesGst12=0; $salesGst18=0; $salesGst28=0;
					foreach($invoice->invoice_rows as $invoice_row){
						if($invoice_row['cgst_percentage']==8 && $invoice_row['sgst_percentage']==11){
								$salesGst12=$salesGst12+($invoice_row->cgst_amount+$invoice_row->sgst_amount);
								 $salesGstRowTotal12=$salesGstRowTotal12+$invoice_row->row_total;
						}else if($invoice_row['cgst_percentage']==9 && $invoice_row['sgst_percentage']==12){
								$salesGst18=$salesGst18+($invoice_row->cgst_amount+$invoice_row->sgst_amount);
								 $salesGstRowTotal18=$salesGstRowTotal18+$invoice_row->row_total;
							}
						else if($invoice_row['cgst_percentage']==10 && $invoice_row['sgst_percentage']==13){
								$salesGst28=$salesGst28+($invoice_row->cgst_amount+$invoice_row->sgst_amount);
								 $salesGstRowTotal28=$salesGstRowTotal28+$invoice_row->row_total;
							}
						}	
				?>
				<tbody>
					<tr>
						<td><?php echo $i; ?></td>
						<td>
							<?php echo $this->Html->link( $invoice->in1.'/IN-'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4,[
							'controller'=>'Invoices','action' => 'gstConfirm',$invoice->id],array('target'=>'_blank')); ?>
						</td>
						<td><?php echo date("d-m-Y",strtotime($invoice->date_created)); ?></td>
						<td><?php echo $invoice->customer->customer_name.'('.$invoice->customer->alias.')'?></td>
						<td align="right">
							<?php  	if($salesGstRowTotal12 > 0){
										echo $salesGstRowTotal12;
										$salesTotal12=$salesTotal12+$salesGstRowTotal12;
									}else{
										echo "-";
									}
							?>
						</td>
						<td align="right">
							<?php  if($salesGst12 > 0){
										echo $salesGst12;
										$salesTotalGST12=$salesTotalGST12+$salesGst12;
								}else{
									echo "-";
								} ?>
						</td>
						<td align="right">
							<?php  
									if($salesGstRowTotal18 > 0){
										echo $salesGstRowTotal18;
										$salesTotal18=$salesTotal18+$salesGstRowTotal18;
									}else{
										echo "-";
									} 
							?>
						</td>
						<td align="right">
							<?php  
									if($salesGst18 > 0){
										echo $salesGst18;
										$salesTotalGST18=$salesTotalGST18+$salesGst18;
									}else{
										echo "-";
									} 
							?>
						</td>
						<td align="right">
						<?php  if($salesGstRowTotal28 > 0){
							 echo $salesGstRowTotal28;
							  $salesTotal28=$salesTotal28+$salesGstRowTotal28;
						}else{
							echo "-";
						}?>
						</td>
						<td align="right">
							<?php  if($salesGst28 > 0){
										echo $salesGst28;
										$salesTotalGST28=$salesTotalGST28+$salesGst28;
								}else{
									echo "-";
								} ?>
						</td>
					</tr>
				<?php $i++; endforeach; ?>
					<tr>
						<td colspan="4"></td>
						<td align="right"><?php echo $this->Number->format($salesTotal12,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotalGST12,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotal18,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotalGST18,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotal28,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotalGST28,['places'=>2]); ?></td>
						
					</tr>
				</tbody>
			</table>
				
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<td colspan="11" align="center"  valign="top">
							<h4 class="caption-subject font-black-steel uppercase">Sales Inter State</h4>
						</td>
					</tr>
					<tr>
						<th>Sr.No.</th>
						<th>Invoice No</th>
						<th>Date</th>
						<th>Customer</th>
						<th style="text-align:right;">Sales @ 12 % IGST</th>
						<th style="text-align:right;">IGST @ 12 % </th>
						<th style="text-align:right;">Sales @ 18 % IGST</th>
						<th style="text-align:right;">IGST @ 18 % </th>
						<th style="text-align:right;">Sales @ 28 % IGST</th>
						<th style="text-align:right;">IGST @ 28 % </th>
					</tr>
				</thead>
				<?php $i=1;  $salesTotal12=0; $salesTotal18=0; $salesTotal28=0;
							$salesTotalIGST12=0; $salesTotalIGST18=0; $salesTotalIGST28=0; 
				foreach ($interStateInvoice as $invoice):  
					$salesIGstRowTotal12=0; $salesIGstRowTotal18=0; $salesIGstRowTotal28=0; $salesIGst12=0; $salesIGst18=0; $salesIGst28=0;
					foreach($invoice->invoice_rows as $invoice_row){
						if($invoice_row['igst_percentage']==14){
								$salesIGst12=$salesIGst12+($invoice_row->igst_amount);
								 $salesIGstRowTotal12=$salesIGstRowTotal12+$invoice_row->row_total;
						}else if($invoice_row['igst_percentage']==15){
								$salesIGst18=$salesIGst18+($invoice_row->igst_amount);
								 $salesIGstRowTotal18=$salesIGstRowTotal18+$invoice_row->row_total;
							}
						else if($invoice_row['igst_percentage']==16){
								$salesIGst28=$salesIGst28+($invoice_row->igst_amount);
								 $salesIGstRowTotal28=$salesIGstRowTotal28+$invoice_row->row_total;
							}
						}	
				?>
				<tbody>
					<tr>
						<td><?php echo $i; ?></td>
						<td>
							<?php echo $this->Html->link( $invoice->in1.'/IN-'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4,[
							'controller'=>'Invoices','action' => 'gstConfirm',$invoice->id],array('target'=>'_blank')); ?>
						</td>
						<td><?php echo date("d-m-Y",strtotime($invoice->date_created)); ?></td>
						<td><?php echo $invoice->customer->customer_name.'('.$invoice->customer->alias.')'?></td>
						<td align="right">
							<?php  	if($salesIGstRowTotal12 > 0){
										echo $salesIGstRowTotal12;
										$salesTotal12=$salesTotal12+$salesIGstRowTotal12;
									}else{
										echo "-";
									}
							?>
						</td>
						<td align="right">
							<?php  if($salesIGst12 > 0){
										echo $salesIGst12;
										$salesTotalIGST12=$salesTotalIGST12+$salesIGst12;
								}else{
									echo "-";
								} ?>
						</td>
						<td align="right">
							<?php  	if($salesIGstRowTotal18 > 0){
										echo $salesIGstRowTotal18;
										$salesTotal18=$salesTotal18+$salesIGstRowTotal18;
									}else{
										echo "-";
									}
							?>
						</td>
						<td align="right">
							<?php  if($salesIGst18 > 0){
										echo $salesIGst18;
										$salesTotalIGST18=$salesTotalIGST18+$salesIGst18;
								}else{
									echo "-";
								} ?>
						</td>
						<td align="right">
							<?php  	if($salesIGstRowTotal28 > 0){
										echo $salesIGstRowTotal28;
										$salesTotal28=$salesTotal28+$salesIGstRowTotal28;
									}else{
										echo "-";
									}
							?>
						</td>
						<td align="right">
							<?php  if($salesIGst28 > 0){
										echo $salesIGst28;
										$salesTotalIGST28=$salesTotalIGST28+$salesIGst28;
								}else{
									echo "-";
								} ?>
						</td>
					</tr>
				<?php $i++; endforeach; ?>
					<tr>
						<td colspan="4"></td>
						<td align="right"><?php echo $this->Number->format($salesTotal12,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotalIGST12,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotal18,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotalIGST18,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotal28,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotalIGST28,['places'=>2]); ?></td>
						
					</tr>
				</tbody>
			</table>
				
			
		
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<td colspan="11" align="center"  valign="top">
							<h4 class="caption-subject font-black-steel uppercase">Purchase</h4>
						</td>
					</tr>
					<tr>
						<th>Sr.No.</th>
						<th>Invoice Booking No</th>
						<th>Date</th>
						<th>Supplier</th>
						<th style="text-align:right;">Purchase @ 12 % GST</th>
						<th style="text-align:right;">GST @ 12 % </th>
						<th style="text-align:right;">Purchase @ 18 % GST</th>
						<th style="text-align:right;">GST @ 18 % </th>
						<th style="text-align:right;">Purchase @ 28 % GST</th>
						<th style="text-align:right;">GST @ 28 % </th>
					</tr>
				</thead>
				<?php  $salesTotalGst12=0; $salesTotalGst18=0; $salesTotalGst28=0; $salesTotal12=0; $salesTotal18=0; $salesTotal28=0; $i=0;
				foreach ($invoiceBookings as $invoiceBooking):   ?>
				<tbody>
				<?php $salesGstRowTotal12=0; $salesGstRowTotal18=0; $salesGstRowTotal28=0; $salesGst12=0; $salesGst18=0; $salesGst28=0; 
					if(!empty($invoiceBooking->invoice_booking_rows)){  $i++;
						foreach($invoiceBooking->invoice_booking_rows as $invoice_booking_row)
						{ 
							if($invoice_booking_row['cgst_per']==17 && $invoice_booking_row['sgst_per']==18){
							$salesGst12=$salesGst12+($invoice_booking_row->cgst+$invoice_booking_row->sgst);
							$salesGstRowTotal12=$salesGstRowTotal12+$invoice_booking_row->total;
								
							}else if($invoice_booking_row['cgst_per']==19 && $invoice_booking_row['sgst_per']==20){
								$salesGst18=$salesGst18+($invoice_booking_row->cgst+$invoice_booking_row->sgst);
								$salesGstRowTotal18=$salesGstRowTotal18+$invoice_booking_row->total;
								
							}else if($invoice_booking_row['cgst_per']==21 && $invoice_booking_row['sgst_per']==22){
								$salesGst28=$salesGst28+($invoice_booking_row->cgst+$invoice_booking_row->sgst);
								$salesGstRowTotal28=$salesGstRowTotal28+$invoice_booking_row->total;
							}
						}
						
				?>
					<tr>
						<td><?php echo $i; ?></td>
						<td>
						<?php echo $this->Html->link( $invoiceBooking->ib1.'/IB-'.str_pad($invoiceBooking->ib2, 3, '0', STR_PAD_LEFT).'/'.$invoiceBooking->ib3.'/'.$invoiceBooking->ib4,[
							'controller'=>'InvoiceBookings','action' => 'gst-invoice-booking-view',$invoiceBooking->id],array('target'=>'_blank')); ?>
						</td>
						<td><?php echo date("d-m-Y",strtotime($invoiceBooking->created_on)); ?></td>
						<td><?php echo $invoiceBooking->vendor->company_name; ?></td>
						<td align="right">
						<?php  if($salesGstRowTotal12 >0){
							 echo $salesGstRowTotal12;
							 $salesTotal12=$salesTotal12+$salesGstRowTotal12;
						}else{
							echo "-";
						}?>
						</td>
						<td align="right">
							<?php  if($salesGst12 >0){
										echo $salesGst12;
										$salesTotalGst12=$salesTotalGst12+$salesGst12;
								}else{
									echo "-";
								} ?>
						</td>
						<td align="right">
						<?php  if($salesGstRowTotal18 >0){
							 echo $salesGstRowTotal18;
							 $salesTotal18=$salesTotal18+$salesGstRowTotal18;
						}else{
							echo "-";
						}?>
						</td>
						<td align="right">
							<?php  if($salesGst18 >0){
										echo $salesGst18;
										$salesTotalGst18=$salesTotalGst18+$salesGst18;
								}else{
									echo "-";
								} ?>
						</td>
						<td align="right">
						<?php  if($salesGstRowTotal28 >0){
							 echo $salesGstRowTotal28;
							 $salesTotal28=$salesTotal28+$salesGstRowTotal28;
						}else{
							echo "-";
						}?>
						</td>
						<td align="right">
							<?php  if($salesGst28 >0){
										echo $salesGst28;
										$salesTotalGst28=$salesTotalGst28+$salesGst28;
								}else{
									echo "-";
								} ?>
						</td>

						
					</tr>
				<?php }   endforeach; ?>
					<tr>
						<td colspan="4"></td>
						<td align="right"><?php echo $this->Number->format($salesTotal12,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotalGst12,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotal18,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotalGst18,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotal28,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotalGst28,['places'=>2]); ?></td>
						
					</tr>
				</tbody>
				
				</table>
				
		
			
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<td colspan="11" align="center"  valign="top">
							<h4 class="caption-subject font-black-steel uppercase">Purchase Inter State</h4>
						</td>
					</tr>
					<tr>
						<th>Sr.No.</th>
						<th>Invoice Booking No</th>
						<th>Date</th>
						<th>Supplier</th>
						<th style="text-align:right;">Purchase @ 12 % IGST</th>
						<th style="text-align:right;">IGST @ 12 % </th>
						<th style="text-align:right;">Purchase @ 18 % IGST</th>
						<th style="text-align:right;">IGST @ 18 % </th>
						<th style="text-align:right;">Purchase @ 28 % IGST</th>
						<th style="text-align:right;">IGST @ 28 % </th>
					</tr>
				</thead>
				<?php $salesTotalGst12=0; $salesTotalGst18=0; $salesTotalGst28=0; $salesTotal12=0; $salesTotal18=0; $salesTotal28=0; $i=0;
				foreach ($invoiceBookingsInterState as $invoiceBooking):   ?>
				<tbody>
					<?php $salesGstRowTotal12=0; $salesGstRowTotal18=0; $salesGstRowTotal28=0; $salesGst12=0; $salesGst18=0; $salesGst28=0; 
					if(!empty($invoiceBooking->invoice_booking_rows)){  $i++;
						foreach($invoiceBooking->invoice_booking_rows as $invoice_booking_row)
						{ 
							if($invoice_booking_row['igst_per']==23){
							$salesGst12=$salesGst12+($invoice_booking_row->igst);
							$salesGstRowTotal12=$salesGstRowTotal12+$invoice_booking_row->total;
								
							}else if($invoice_booking_row['igst_per']==24){
								$salesGst18=$salesGst18+($invoice_booking_row->igst);
								$salesGstRowTotal18=$salesGstRowTotal18+$invoice_booking_row->total;
								
							}else if($invoice_booking_row['igst_per']==25){
								$salesGst28=$salesGst28+($invoice_booking_row->igst);
								$salesGstRowTotal28=$salesGstRowTotal28+$invoice_booking_row->total;
							}
						}
						
				?>
					<tr>
						<td><?php echo $i; ?></td>
						<td>
						<?php echo $this->Html->link( $invoiceBooking->ib1.'/IB-'.str_pad($invoiceBooking->ib2, 3, '0', STR_PAD_LEFT).'/'.$invoiceBooking->ib3.'/'.$invoiceBooking->ib4,[
							'controller'=>'InvoiceBookings','action' => 'gst-invoice-booking-view',$invoiceBooking->id],array('target'=>'_blank')); ?>
						</td>
						<td><?php echo date("d-m-Y",strtotime($invoiceBooking->created_on)); ?></td>
						<td><?php echo $invoiceBooking->vendor->company_name; ?></td>
												<td align="right">
						<?php  if($salesGstRowTotal12 >0){
							 echo $salesGstRowTotal12;
							 $salesTotal12=$salesTotal12+$salesGstRowTotal12;
						}else{
							echo "-";
						}?>
						</td>
						<td align="right">
							<?php  if($salesGst12 >0){
										echo $salesGst12;
										$salesTotalGst12=$salesTotalGst12+$salesGst12;
								}else{
									echo "-";
								} ?>
						</td>
						<td align="right">
						<?php  if($salesGstRowTotal18 >0){
							 echo $salesGstRowTotal18;
							 $salesTotal18=$salesTotal18+$salesGstRowTotal18;
						}else{
							echo "-";
						}?>
						</td>
						<td align="right">
							<?php  if($salesGst18 >0){
										echo $salesGst18;
										$salesTotalGst18=$salesTotalGst18+$salesGst18;
								}else{
									echo "-";
								} ?>
						</td>
						<td align="right">
						<?php  if($salesGstRowTotal28 >0){
							 echo $salesGstRowTotal28;
							 $salesTotal28=$salesTotal28+$salesGstRowTotal28;
						}else{
							echo "-";
						}?>
						</td>
						<td align="right">
							<?php  if($salesGst28 >0){
										echo $salesGst28;
										$salesTotalGst28=$salesTotalGst28+$salesGst28;
								}else{
									echo "-";
								} ?>
						</td>

						
					</tr>
				<?php }   endforeach; ?>
					<tr>
						<td colspan="4"></td>
						<td align="right"><?php echo $this->Number->format($salesTotal12,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotalGst12,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotal18,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotalGst18,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotal28,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotalGst28,['places'=>2]); ?></td>
						
					</tr>
				</tbody>
				
				</table>
		
				
			</div>
		</div>
	</div>
</div>


<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>



<script>
$(document).ready(function() {

	$('select[name="item_category"]').on("change",function() { 
		$('#item_group_div').html('Loading...');
		var itemCategoryId=$('select[name="item_category"] option:selected').val();
		var url="<?php echo $this->Url->build(['controller'=>'ItemGroups','action'=>'ItemGroupDropdown']); ?>";
		url=url+'/'+itemCategoryId,
		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
			$('#item_group_div').html(response);
			$('select[name="item_group_id"]').select2();
		});
	});	
	//////
	$('select[name="item_group_id"]').die().live("change",function() {
		$('#item_sub_group_div').html('Loading...');
		var itemGroupId=$('select[name="item_group_id"] option:selected').val();
		var url="<?php echo $this->Url->build(['controller'=>'ItemSubGroups','action'=>'ItemSubGroupDropdown']); ?>";
		url=url+'/'+itemGroupId,
		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
			$('#item_sub_group_div').html(response);
			$('select[name="item_sub_group_id"]').select2();
		});
	});
});
</script>