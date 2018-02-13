<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Employee wise Report
        <small>Generate employee wise report by date</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Select details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="employeeReportForm" action="<?php echo base_url() ?>generateEmployeeReport" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                    	<label>Employee</label>
                                        <select id="employees" name="employees" class="form-control">
						                    <option value="">Select Employee</option>
						                    <?php
						                    foreach ($activeEmployees as $ae) {
						                        ?>
						                        <option value="<?php echo $ae->userId; ?>"><?php echo $ae->name; ?></option>
						                        <?php
						                    }
						                    ?>                    
						                </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
										<label>Date</label>
										<div class="input-group date">
											<input type="text" name="reportDate" id="reportDate" class="form-control pull-left">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>            
        </div>
    </section>
</div>