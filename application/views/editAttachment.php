<?php

$atId = "";
$compId = "";
$atTypeId = "";
$atPath = "";
$atType = "";
$compName = "";

if(!empty($rawData))
{
    foreach ($rawData as $record)
    {
    	$atId = $record->at_id;
    	$compId = $record->comp_id;
    	$atTypeId = $record->at_type_id;
    	$atPath = $record->at_path;
    	$atType = $record->at_type;
    	$compName = $record->comp_name;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Attachment
        <small>You can update the attachement file</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Upload attachment</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" enctype="multipart/form-data" action="<?php echo base_url() ?>updateAttachment" method="post" id="editAttachment" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="compName">Company Name</label>
                                        <input type="text" class="form-control" id="compName" placeholder="Company Name" disabled="disabled" name="compName" value="<?php echo $compName; ?>" maxlength="128">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tempName">Attachment Type</label>
                                        <input type="text" class="form-control" id="atType" placeholder="Attachment Type" disabled="disabled" name="atType" value="<?php echo $atType; ?>" maxlength="128">
                                        <input type="hidden" value="<?php echo $atId; ?>" name="atId" />    
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                    	<label for="attFile">Attachment File <span class="asterisk">*</span></label>
                                    	<input type="file" class="required" id="attFile" name="attFile" />
                                    </div>
                                </div>                              
                            </div>
                        </div><!-- /.box-body -->
                            
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
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
        <!-- 
        <div class="row">
			<div class="col-md-8">
				<embed src="<?php echo base_url().ATTACHMENT_PATH.$atPath ?>" width="100%" height="800">
			</div>
		</div>
		 -->   
    </section>
</div>