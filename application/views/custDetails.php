<?php
$cust_id = 0;
$domain = "";
$create_date = "";
$expiry_date = "";
$domain_registrar_name = "";
$registrant_name = "";
$registrant_company = "";
$registrant_address = "";
$registrant_city = "";
$registrant_state = "";
$registrant_zip = "";
$registrant_country = "";
$registrant_email = "";
$registrant_phone = "";
$registrant_alt_email = "";
$registrant_alt_phone = "";
$registrant_fax = "";
$scr_img_mobile = "";
$scr_img_desk = "";
$status = 0;

if (! empty ( $rawCustomer )) {
	foreach ( $rawCustomer as $raw ) {
		$httpDomain = $raw->domain_name;
		if (! preg_match ( "~^(?:f|ht)tps?://~i", $raw->domain_name )) {
			$httpDomain = "http://" . $raw->domain_name;
		}
		
		$cust_id = $raw->cust_id;
		$domain = $raw->domain_name;
		$create_date = $raw->create_date;
		$expiry_date = $raw->expiry_date;
		$domain_registrar_name = $raw->domain_registrar_name;
		$registrant_name = $raw->registrant_name;
		$registrant_company = $raw->registrant_company;
		$registrant_address = $raw->registrant_address;
		$registrant_city = $raw->registrant_city;
		$registrant_zip = $raw->registrant_zip;
		$registrant_country = $raw->registrant_country;
		$registrant_email = $raw->registrant_email;
		$registrant_phone = $raw->registrant_phone;
		$registrant_alt_email = $raw->registrant_alt_email;
		$registrant_alt_phone = $raw->registrant_alt_phone;
		$registrant_fax = $raw->registrant_fax;
		$scr_img_mobile = $raw->scr_img_mobile;
		$scr_img_desk = $raw->scr_img_desk;
		$status = $raw->status;
	}
}

$rem_summary = "";
$cust_cost = "";
$estimated_cost = "";

if (! empty ( $reqCustomer )) {
	foreach ( $reqCustomer as $rc ) {
		$rem_summary = $rc->rem_summary;
		$cust_cost = $rc->cust_cost;
		$estimated_cost = $rc->estimated_cost;
	}
}

?>

<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Customer Details <small>All details of customer</small>
		</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
                <?php
				$this->load->helper ( 'form' );
				$error = $this->session->flashdata ( 'error' );
				if ($error) {
				?>
                <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert"
						aria-hidden="true">×</button>
                	<?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php
					$success = $this->session->flashdata ( 'success' );
					if ($success) {
					?>
                <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert"
						aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
					<div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-warning">
					<div class="box-header">
						<h3 class="box-title">
							Domain : <strong> <a target="_blank"
								href="<?php echo $httpDomain ?>"><?php echo $domain; ?></a>
							</strong>
						</h3>
                        <?php
							switch ($status) {
								case RAW : ?><span class="label label-default">RAW</span><?php break;
								case FINALS : ?><span class="label label-success">FINALS</span><?php break;
								case DEAD : ?><span class="label label-danger">DEAD</span><?php break;
								case PROCESSED : ?><span class="label label-info">PROCESSED</span><?php break;
								default : ?><span class="label label-default">RAW</span><?php 
							}
						?>
                        <div class="box-tools">
                        	<a class="btn btn-warning btn-lg" href="<?php  echo base_url()."seo/generateSeoReport/".str_replace("/","-",$domain); ?>"><i class="fa fa-flag"></i> SEO</a>
                        	<button class="btn btn-warning btn-lg" id="refresh" data-custId="<?php echo $cust_id ?>" data-domainName="<?php echo $httpDomain ?>"> 
                        		<i id="refreshSpinner" class="fa fa-refresh fa-fw"></i></button>
							<button class="btn btn-default btn-lg" data-toggle="modal"
								data-target="#sendPort">
								<i class="fa fa-send"></i> SEND
							</button>
						</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-4">
										<label>Registrant Name </label>
									</div>
									<div class="col-md-8">
                                        <?php echo $registrant_name; ?>
                                    </div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<label>Create Date </label>
									</div>
									<div class="col-md-8">
                                        <?php echo $create_date; ?>
                                    </div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<label>Expiry Date </label>
									</div>
									<div class="col-md-8">
                                        <?php echo $expiry_date; ?>
                                    </div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<label>Registrar Name </label>
									</div>
									<div class="col-md-8">
                                        <?php echo $domain_registrar_name; ?>
                                    </div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<label>Company </label>
									</div>
									<div class="col-md-8">
                                        <?php echo $registrant_company; ?>
                                    </div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<label>Address </label>
									</div>
									<div class="col-md-8" id="mapAddress">
                                        <?php echo $registrant_address.", ".$registrant_city.", ".$registrant_state.", ".$registrant_country.", ".$registrant_zip; ?>
                                    </div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<label>Email </label>
									</div>
									<div class="col-md-8">
                                        <?php echo $registrant_email; ?>
                                    </div>
								</div>								
								<div class="row">
									<div class="col-md-4">
										<label>Phone </label>
									</div>
									<div class="col-md-8">
                                        <?php echo (strpos($registrant_phone, "+") == false)?"+".$registrant_phone:$registrant_phone; ?>
                                    </div>
								</div>
								<div class="row">
									<input type="hidden" value="<?php echo $cust_id; ?>"
										id="customerId" />
									<div class="col-md-4">
										<label>Alternate Email </label>
									</div>
									<div class="col-md-8" id="rAltEmail">
                                        <?php echo $registrant_alt_email; ?>
                                    </div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<label>Alternate Phone </label>
									</div>
									<div class="col-md-8" id="rAltPhone">
                                        <?php echo $registrant_alt_phone; ?>
                                    </div>
								</div>		
								<!-- <div class="row">
									<div class="col-md-4">
										<label>Current Time </label>
									</div>
									<div class="col-md-8" id="currTime"></div>
								</div> -->						
							</div>
							<div class="col-md-3">
								<div class="row">
									<div class="col-md-12">
										<label>Desktop Image </label> <a id="browserImgHref"
											href="<?php echo base_url().WEBSITE_CAPTURE.BROWSER.$scr_img_desk ?>"
											target="_blank"> <img class="img-thumbnail max-height2" id="browserImg"
											alt="<?php echo $domain; ?>"
											src="<?php echo base_url().WEBSITE_CAPTURE.BROWSER.$scr_img_desk ?>" /></a>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="row">
									<div class="col-md-12">
										<label>Mobile Image </label> <a id="mobileImgHref"
											href="<?php echo base_url().WEBSITE_CAPTURE.MOBILE.$scr_img_mobile ?>"
											target="_blank"> <img class="img-thumbnail max-height2" id="mobileImg"
											alt="<?php echo $domain; ?>"
											src="<?php echo base_url().WEBSITE_CAPTURE.MOBILE.$scr_img_mobile ?>" /></a>
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-3 timeConversionDiv displayNone">
								<div class="row form-group">
									<div class="col-md-12">
										<div class="input-group date">
											<div class="input-group-addon forceOpenPicker"><i class="fa fa-calendar"></i></div>
											<input type="text" name="conversionDate" id="conversionDate" class="form-control pull-right">
										</div>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-12">
										<div class="input-group bootstrap-timepicker timepicker">
											<div class="input-group-addon forceOpenTimePicker"><i class="fa fa-clock-o"></i></div>
											<input type="text" name="conversionTime" id="conversionTime" class="form-control pull-right">
										</div>
									</div>
								</div>
							</div>							
							<div class="col-md-3 timeConversionDiv displayNone">
								<div class="row">
									<div class="col-md-12 digitalLineHeight alignCenter">
										<span class="alignCenter timezone">Converted Time</span>
										<a id="btnTimeConversionComplete" href="javascript:void(0)"><i class="fa fa-close fa-2x"></i></a>
										<br>
										<span id="convertedDate" class="digitalDate"></span><br>
										<span id="convertedTime" class="digitalTime"></span>
									</div>
								</div>
							</div>
							
							<div class="col-md-6" id="btnTimeConversionDiv">
								<a id="btnTimeConversion" href="javascript:void(0)" class="btn btn-sm btn-info pull-left">Time Conversion for zones</a>
							</div>
							<div class="col-md-3">
								<div class="col-md-12 digitalLineHeight alignCenter">
									<span class="alignCenter timezone"><?php echo ucwords(strtolower($registrant_country)); ?> Time</span><br>
									<span id="digitalDate" class="digitalDate"></span><br>
									<span id="digitalTime" class="digitalTime"></span>
								</div>
							</div>
							<!-- 
							<div class="col-md-3 alignCenter">
								<span class="alignCenter timezone">Time</span><br>
								<canvas id="world" class=""></canvas>
							</div>
							 -->
							<div class="col-md-3">
								<div class="col-md-12 digitalLineHeight alignCenter">
									<span class="alignCenter timezone">Local Time</span><br>
									<span id="localDigitalDate" class="digitalDate"></span><br>
									<span id="localDigitalTime" class="digitalTime"></span>
								</div>
							</div>
							<!--
							<div class="col-md-3 alignCenter">
								<span class="alignCenter timezone">Local Time</span><br>
								<canvas id="local" class="CoolClock::60::"></canvas>
							</div>
							 -->
						</div>
					</div>
                    <?php
					if (! empty ( $fupCustomer )) {
					?>
                    <div class="box-footer">
						<form id="statusForm" name="statusForm"
							action="<?php echo base_url();?>updateCustomerStatus"
							method="POST">
							<div class="row">
								<div class="col-md-2">
									<input type="hidden" name="custId"
										value="<?php echo $cust_id; ?>" /> <select id="custStatus"
										name="custStatus" class="form-control input-sm">
										<option
											<?php if($status == RAW) { echo "selected='selected'"; } ?>
											value="<?php echo RAW; ?>">Raw</option>
										<option
											<?php if($status == PROCESSED) { echo "selected='selected'"; } ?>
											value="<?php echo PROCESSED; ?>">Processed</option>
										<option
											<?php if($status == FINALS) { echo "selected='selected'"; } ?>
											value="<?php echo FINALS; ?>">Finals</option>
										<option
											<?php if($status == DEAD) { echo "selected='selected'"; } ?>
											value="<?php echo DEAD; ?>">Dead</option>
									</select>
								</div>
								<div class="col-md-2">
									<input type="submit" class="btn btn-warning btn-sm"
										value="Change status" />
								</div>
							</div>
						</form>
					</div>
                    <?php } ?>
                </div>
			</div>
		</div>


		<div class="row">
			<div class="col-md-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#followTab" data-toggle="tab"
							aria-expanded="true">Record New Followup</a></li>
						<li class=""><a href="#reqTab" data-toggle="tab"
							aria-expanded="false">Requirement</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="followTab">
							<div class="box box-solid box-info">
								<div class="box-body">
									<form action="<?php echo base_url(); ?>recordNewFollowup"
										method="POST" id="followUp">
										<div class="row">
											<div class="col-md-4">
												<div class="row form-group">
													<div class="col-md-12">
														<label>Feedback Type <span class="asterisk">*</span></label>
														<select id="fbType" name="fbType" class="form-control">
															<option value="">Select Feedback Type</option>
                                                            <?php
																foreach ( $fbTypes as $ft ) {																																													?>
                                                                <option value="<?php echo $ft->fbt_id; ?>"><?php echo $ft->fbt_name; ?></option>
                                                                <?php } ?>                    
                                                        </select>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label>Next Call Date</label>
														<div class="input-group date">
															<div class="input-group-addon forceOpenPicker">
																<i class="fa fa-calendar"></i>
															</div>
															<input type="text" name="nextCallDate" id="nextCallDate"
																class="form-control pull-right">
														</div>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label>Next Call Time</label>
														<div class="input-group bootstrap-timepicker timepicker">
															<div class="input-group-addon forceOpenTimePicker">
																<i class="fa fa-clock-o"></i>
															</div>
															<input type="text" name="nextCallTime" id="nextCallTime"
																class="form-control pull-right">
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-8">
												<div class="row form-group">
													<div class="col-md-12">
														<label>Call Summary <span class="asterisk">*</span></label>
														<input type="hidden" name="custId" id="custId"
															value="<?php echo $cust_id; ?>" />
														<textarea id="callSummary" name="callSummary"
															class="form-control"></textarea>
													</div>
												</div>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-md-6">
												<small><span class="asterisk">*</span> mandatory fields</small>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<input type="submit" class="btn btn-primary btn-lg"
													value="Save">
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="table-responsive">
								<table id="customer_followup_data" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th width="20%">Feedback Type</th>
											<th width="20%">Next Call DateTime</th>
											<th width="60%">Call Summary</th>
										</tr>
									</thead>
								</table>
							</div>
                            <?php
							if (! empty ( $fupCustomer )) {
							?>
                            <div class="row">
								<div class="col-md-12">
									<h3>Followup timeline</h3>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<ul class="timeline">
                                    <?php
									foreach ( $fupCustomer as $fup ) {
										
										$date = NULL;
										$time = NULL;
										$ndate = NULL;
										$ntime = NULL;
										
										if (! empty ( $fup->fp_dtm )) {
											$dtm = new DateTime ( $fup->fp_dtm );
											$date = $dtm->format ( 'd M Y' );
											$time = $dtm->format ( 'H:i' );
										}
										
										if (! empty ( $fup->fp_next_call )) {
											$ndtm = new DateTime ( $fup->fp_next_call );
											$ndate = $ndtm->format ( 'd M Y' );
											$ntime = $ndtm->format ( 'H:i' );
										}
										?>
                                    
                                        <li class="time-label"><span
											class="bg-red"><?php echo $date; ?></span></li>
										<li>
                                        	<?php if($fup->fp_type == "EMAIL") {?><i
											class="fa fa-envelope-o bg-blue"></i><?php } else { ?><i
											class="fa fa-phone bg-blue"></i><?php }?>
                                            <div class="timeline-item">
												<span class="time"><i class="fa fa-clock-o"></i> <?php echo $time; ?></span>
												<h3 class="timeline-header"><?php echo $fup->fbt_name; ?></h3>
												<div class="timeline-body">
                                                    <?php echo $fup->fp_summary; ?>
                                                </div>
												<div class="timeline-footer">
                                                    Next Call :
                                                    <?php if ($ndate == NULL) {
														?><strong><i class="fa fa-calendar"></i> Not specified!</strong>
														<?php } else { ?>
                                                    	<strong><i class="fa fa-calendar"></i> <?php echo $ndate; ?> - 
                                                    <i class="fa fa-clock-o"></i> <?php echo $ntime; ?></strong>
                                                    <?php } ?>
                                                </div>
											</div>
										</li>
                                    <?php } ?>
                                    </ul>
								</div>
							</div>
                            <?php } ?>
                        </div>
						<div class="tab-pane" id="reqTab">
							<form action="<?php echo base_url(); ?>recordRequirement"
								method="POST" id="recRem">
								<div class="row">
									<div class="col-md-12">
										<div class="row form-group">
											<div class="col-md-6">
												<label>Customer Cost </label> <input type="hidden"
													name="reqCustId" id="reqCustId"
													value="<?php echo $cust_id; ?>" /> <input type="text"
													id="custCost" name="custCost" class="form-control"
													maxlength="40"
													placeholder="Mention cost with currency i.e. $ 100 or Rs. 100"
													value="<?php echo $cust_cost; ?>" />
											</div>
											<div class="col-md-6">
												<label>Estimated Cost </label> <input type="text"
													id="estimatedCost" name="estimatedCost"
													class="form-control" maxlength="40"
													placeholder="Mention cost with currency i.e. $ 100 or Rs. 100"
													value="<?php echo $estimated_cost; ?>" />
											</div>
										</div>
										<div class="row form-group">
											<div class="col-md-12">
												<label>Requirement Details <span class="asterisk">*</span></label>
												<textarea id="reqSummary" name="reqSummary"
													class="form-control">
                                                <?php echo $rem_summary; ?></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<input type="submit" class="btn btn-primary btn-lg"
											value="Save">
									</div>

								</div>
							</form>
							<form action="<?php echo base_url(); ?>reqExportAsPDF"
								method="POST">
								<div class="row">
									<div class="col-md-12 text-right">
										<input type="hidden" name="custId"
											value="<?php echo $cust_id; ?>" />
										<button class="btn btn-info btn-sm">Export as PDF</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<div class="modal" id="sendPort">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true"><i class="fa fa-times"></i></span>
				</button>
				<h4 class="modal-title">
					<i class="fa fa-pencil"></i> Compose New Message
				</h4>
			</div>
			<form id="emailPortfolioForm" enctype="multipart/form-data"
				name="emailPortfolioForm"
				action="<?php echo base_url();?>emailPortfolio" method="POST">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6 form-group">
							<input type="hidden" name="custId"
								value="<?php echo $cust_id; ?>" /> <select class="form-control"
								id="companyList" name="companyList">
								<option value="">Select Company</option>	  					
	  					<?php foreach($companyList as $cl){ ?>
	  					<option value="<?php echo $cl->comp_id ?>"><?php echo $cl->comp_name; ?></option>
	  					<?php } ?>
	  				</select>
						</div>
						<div class="col-md-6 form-group">
							<select class="form-control" id="typeList" name="typeList">
								<option value="">Select Type</option>
	  					<?php
	  					foreach ( $typeList as $tl ) {
							?><option value="<?php echo $tl->at_type_id ?>"><?php echo $tl->at_type; ?></option><?php
						}
						?>
	  				</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 form-group">
							<input class="form-control" placeholder="To:" name="email"
								id="email" />
						</div>
						<div class="col-md-6 form-group">
							<input class="form-control" placeholder="Subject:" name="subject"
								id="subject" />
						</div>
					</div>
					<div class="form-group">
						<textarea id="emailHTML" name="emailHTML" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<label>Attachment</label> <input type="file" id="extraAttFile"
							name="extraAttFile" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left"
						data-dismiss="modal">
						<i class="fa fa-times"></i> Close
					</button>
					<button type="button" id="emailSendSubmit" class="btn btn-primary">
						<i class="fa fa-envelope-o"></i> Send Email
					</button>
					<!-- <input type="submit" class="btn btn-primary" value="Send Email" /> -->
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<script type="text/javascript" src="<?php echo base_url().PLUGINS_FULL."datatables/jquery.dataTables.min.js?".VER;?>"></script>
<script type="text/javascript" src="<?php echo base_url().PLUGINS_FULL."datatables/dataTables.bootstrap.min.js?".VER;?>"></script>
<script	type="text/javascript">
var offset = "<?php echo $timeZone["rawOffset"]; ?>";
var dstOffset = "<?php echo $timeZone["dstOffset"]; ?>";

$(document).ready(function(){		
	setInterval(function(){
		var hisDateTime = new Date( new Date().getTime() + (offset) * 1000 + parseInt(dstOffset)).toUTCString().replace( / GMT$/, "" );
		var splitter = hisDateTime.split(" "),
			hisDate = splitter[1]+" "+splitter[2]+" "+splitter[3],
			hisTime = splitter[4];
		$("#digitalDate").html(hisDate);
		$("#digitalTime").html(hisTime);
	}, 1000);

	setInterval(function(){
		var localDateTime = new Date(),
			localDateTime = localDateTime.toString().replace( / GMT$/, "" );		
		var splitter2 = localDateTime.split(" "),
			hisDate2 = splitter2[1]+" "+splitter2[2]+" "+splitter2[3],
			hisTime2 = splitter2[4];
		$("#localDigitalDate").html(hisDate2);
		$("#localDigitalTime").html(hisTime2);
	}, 1000);
	
	/* var coolClass = "CoolClock::60::"+( offset / (60*60));
	$("#world").addClass(coolClass); */
	var dataTable = $("#customer_followup_data").DataTable({
        "processing": true,
        "serverSide":true, 
        "order": [],
        "ajax": {
            url : "<?php echo base_url(). 'getCustomerFollowupData'?>",
            type : "POST"
        },
        "columnDefs" : [
            {
                "targets": [2],
                "orderable" : false
            }
        ]
    });
});
</script>