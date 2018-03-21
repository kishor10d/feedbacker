<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
              <form method="post" action="<?php echo ($role == ROLE_ADMIN)?base_url()."rawCustomerListing":base_url()."rawListing"; ?>">
              	<a href="#" id="lnkDashRawListing" class="statusAnchor">              
	              <div class="small-box bg-yellow">
	                <div class="inner">
	                  <h3><?php echo $rawCount ?></h3>
	                  <p>Raw Customers</p>
	                </div>
	                <div class="icon">
	                  <i class="ion ion-person-add"></i>
	                </div>
	                <input type="hidden" name="searchStatus" value="1" />	
	                <span class="small-box-footer statusAnchor">More info <i class="fa fa-arrow-circle-right"></i></span>
	              </div>
	            </a>
              </form>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <form method="post" action="<?php echo ($role == ROLE_ADMIN)?base_url()."rawCustomerListing":base_url()."rawListing"; ?>">
              	<a href="#" id="lnkDashProcessedListing" class="statusAnchor">
	              <div class="small-box bg-aqua">
	                <div class="inner">
	                  <h3><?php echo $processedCount ?></h3>
	                  <p>Under Process</p>
	                </div>
	                <div class="icon">
	                  <i class="ion ion-stats-bars"></i>
	                </div>	                
	                <input type="hidden" name="searchStatus" value="2" />	                
	                <span class="small-box-footer statusAnchor">More info <i class="fa fa-arrow-circle-right"></i></span>
	              </div>
	              </a>
              </form>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">              
              <form method="post" action="<?php echo ($role == ROLE_ADMIN)?base_url()."rawCustomerListing":base_url()."rawListing"; ?>">
              	<a href="#" id="lnkDashFinalizeListing" class="statusAnchor">
	              <div class="small-box bg-green">
	                <div class="inner">
	                  <h3><?php echo $finalizeCount ?></h3>
	                  <p>Valued Customers</p>
	                </div>
	                <div class="icon">
	                  <i class="ion ion-bag"></i>
	                </div>                
	                <input type="hidden" name="searchStatus" value="3" />
	                <span class="small-box-footer statusAnchor">More info <i class="fa fa-arrow-circle-right"></i></span>
	              </div>
				</a>
              </form>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <form method="post" action="<?php echo ($role == ROLE_ADMIN)?base_url()."rawCustomerListing":base_url()."rawListing"; ?>">
              	<a href="#" id="lnkDashDeadListing" class="statusAnchor">
               	  <div class="small-box bg-red">
                	<div class="inner">
                  	<h3><?php echo $deadCount ?></h3>
                  	<p>Dead Leads</p>
                	</div>
                	<div class="icon">
                  		<i class="ion ion-pie-graph"></i>
                	</div>
                	<input type="hidden" name="searchStatus" value="4" />
                	<span class="small-box-footer statusAnchor">More info <i class="fa fa-arrow-circle-right"></i></span>
              	   </div>
              	</a>
              </form>
            </div>
          </div>
          
	<?php if($role == ROLE_ADMIN){ ?>
          <div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <div class="info-box">
				<span class="info-box-icon bg-green"><i class="ion ion-unlocked"></i></span>
				<div class="info-box-content">
				  <span class="info-box-text">Assigned Customers</span>
				  <span class="info-box-number"><?php echo $assignedCount; ?></span>
				</div>
				<!-- /.info-box-content -->
			  </div>
			  <!-- /.info-box -->
			</div>
			<!-- /.col -->
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <div class="info-box">
				<span class="info-box-icon bg-aqua"><i class="ion ion-locked"></i></span>
				<div class="info-box-content">
				  <span class="info-box-text">Not Assigned</span>
				  <span class="info-box-number"><?php echo $notAssignedCount; ?></span>
				</div>
				<!-- /.info-box-content -->
			  </div>
			  <!-- /.info-box -->
			</div>
			<!-- /.col -->
		
			<!-- fix for small devices only -->
			<div class="clearfix visible-sm-block"></div>
		
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <div class="info-box">
				<span class="info-box-icon bg-yellow"><i class="ion ion-filing"></i></span>
				<div class="info-box-content">
				  <span class="info-box-text">Total Customer</span>
				  <span class="info-box-number"><?php echo $totalCount; ?></span>
				  <span class="info-box-text"><sub>Except Dead</sub></span>
				</div>
				<!-- /.info-box-content -->
			  </div>
			  <!-- /.info-box -->
			</div>
			<!-- /.col -->
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <div class="info-box">
				<span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>		
				<div class="info-box-content">
				  <span class="info-box-text">Admin Users</span>
				  <span class="info-box-number"><?php echo $adminUserCount; ?></span>
				  <span class="info-box-text"><sub>Except SuperAdmin</sub></span>
				</div>
				<!-- /.info-box-content -->
			  </div>
			  <!-- /.info-box -->
			</div>
			<!-- /.col -->
		</div>
	<?php } ?>
		<div class="row">
			<div class="col-lg-3 col-xs-6">
			  <a id="lnkDashFollowCustomerListing" href="<?php echo ($role == ROLE_ADMIN)?base_url()."followCustomerListing":base_url()."followListing"; ?>">
	              <div class="small-box bg-blue">
	                <div class="inner">
	                  <h3><?php echo $followupCount; ?></h3>
	                  <p>Followup Today</p>
	                </div>
	                <div class="icon">
	                  <i class="ion ion-android-notifications-none"></i>
	                </div>
	                <span class="small-box-footer"> More info <i class="fa fa-arrow-circle-right"></i></span>
	              </div>
              </a>
            </div>
		</div>
    </section>
</div>