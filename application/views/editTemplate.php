<?php

$tempId = '';
$tempName = '';
$tempHTML = '';
$compName = '';

if(!empty($rawRecords))
{
    foreach ($rawRecords as $record)
    {
        $tempId = $record->temp_id;
        $tempName = $record->temp_name;
        $tempHTML = $record->temp_html;
        $compName = $record->comp_name;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Template
        <small>You can change the html content of template here</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Template HTML</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>updateEmailTemplate" method="post" id="editTemplate" role="form">
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
                                        <label for="tempName">Template Name</label>
                                        <input type="text" class="form-control" id="tempName" placeholder="Template Name" disabled="disabled" name="tempName" value="<?php echo $tempName; ?>" maxlength="128">
                                        <input type="hidden" value="<?php echo $tempId; ?>" name="tempId" />    
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="emailTemplate">Email HTML</label>
                                        <textarea id="emailTemplate" name="emailTemplate" class="form-control"><?php echo $tempHTML ?></textarea>
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
    </section>
</div>