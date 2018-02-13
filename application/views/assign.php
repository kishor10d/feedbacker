<div class="content-wrapper">    
    <section class="content-header">
      <h1>
        Assign Customers
        <small>Assign customers to executives</small>
      </h1>
    </section>
    <br>
    <?php $this->load->helper('form'); ?>
    <section class="content">
        <?php echo form_open('unassignCustomers', array("id"=>"unassignCustomers")); ?>
        <div class="row">
            <div class="col-md-3">                
                <select id="country" name="country" class="form-control">
                    <option value="">Select Country</option>
                    <?php
                    foreach ($countries as $cs) {
                        ?>
                        <option value="<?php echo $cs->registrant_country; ?>"
                            <?php if($country == $cs->registrant_country) { echo "selected='selected'"; } ?> >
                         <?php echo $cs->registrant_country; ?></option>
                        <?php
                    }
                    ?>                    
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" maxlength="20" name="searchText" id="searchText" class="form-control"
            	value="<?php echo $searchText; ?>"  placeholder="Search Text" />
			</div>
            <div class="col-md-1">
                <?php
                
                $attributes = array(
                        'name'          => 'page',
                        'id'            => 'noOfRecords',
                        'value'         => $page,
                        'maxlength'     => '3',
                        'class'         => 'form-control',
                        'placeholder'   => 'Records'
                );
                echo form_input($attributes); ?>
            </div>
            <div class="col-md-1">
            <?php
                $attributes = array(
                    'name' => 'submitSeach',
                    'id' => 'submitSeach',
                    'type' => 'submit',
                    'class' => "btn btn-primary btn-md",
                    'value' => 'Search'
                );

                echo form_submit($attributes);                
            ?>
            </div>
        </div>
        <?php echo form_close(); ?>
        <br>

        <?php 
            $formAttr = array("class"=>"form", "id"=>"assignCustomers", "role"=>"form");
            echo form_open('assignCustomers', $formAttr);
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title" >Unassigned Customers List</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                      <table class="table table-hover">
                        <tr>
                            <th><input type="checkbox" id="checkAll" /></th>
                            <th>Domain Name</th>
                            <th>Email</th>
                            <th>Country</th>
                            <th>Phone</th>
                            <th>Desktop</th>
                            <th>Mobile</th>
                        </tr>
                        <?php
                        if(!empty($rawRecords))
                        {
                            foreach($rawRecords as $record)
                            {
                                $httpDomain = $record->domain_name;
                                if (!preg_match("~^(?:f|ht)tps?://~i", $record->domain_name)) {
                                    $httpDomain = "http://" . $record->domain_name;
                                }
                        ?>
                        <tr>
                            <td class="alignLeft"><input type="checkbox" name="isChecked[]"
                                value="<?php echo $record->cust_id ?>"/></td>
                            <td class="alignLeft td-wrap">
                                <a target="_blank" href="<?php echo $httpDomain ?>"><?php echo $record->domain_name ?></a>
                            </td>
                            <td class="alignLeft td20 td-wrap"><?php echo $record->registrant_email ?></td>
                            <td class="alignLeft td10"><?php echo $record->registrant_country; ?></td>
                            <td class="td10"><?php echo $record->registrant_phone ?></td>
                            <td class="td20">
                                <a href="<?php echo base_url().WEBSITE_CAPTURE.BROWSER.$record->scr_img_desk ?>" target="_blank">
                                <img class="img-thumbnail max-height" alt="<?php echo $record->domain_name; ?>"
                                src="<?php echo base_url().WEBSITE_CAPTURE.BROWSER.$record->scr_img_desk ?>" /></a>
                            </td>
                            <td class="td20">
                                <a href="<?php echo base_url().WEBSITE_CAPTURE.MOBILE.$record->scr_img_desk ?>" target="_blank">
                                <img class="img-thumbnail max-height" alt="<?php echo $record->domain_name; ?>"
                                src="<?php echo base_url().WEBSITE_CAPTURE.MOBILE.$record->scr_img_mobile ?>" /></a>
                            </td>                          
                        </tr>
                        <?php
                            }
                        }
                        ?>
                      </table>
                    </div>
                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(!empty($rawRecords))
        {
        ?>
        <div class="row">
            <div class="col-md-3">
                <select id="executive" name="executive" class="form-control">
                    <option value="">Select Executive</option>
                    <?php
                    foreach ($executives as $es) {
                        ?>
                        <option value="<?php echo $es->userId; ?>"><?php echo $es->name; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <?php
                $attributes = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'type' => 'submit',
                    'class' => "btn btn-primary btn-md",
                    'value' => 'Assign'
                );

                echo form_submit($attributes);
                ?>
            </div>
        </div>
        <?php } ?>
        <?php echo form_close(); ?>
    </section>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
    	jQuery('ul.pagination li a').click(function (e) {        	
    		e.preventDefault();
    		console.log(jQuery("#unassignCustomers"));
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#unassignCustomers").attr("action", baseURL + "unassignCustomers/" + value);
            jQuery("#unassignCustomers").submit();
        });
    });
</script>