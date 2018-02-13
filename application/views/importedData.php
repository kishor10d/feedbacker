<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Imported Data
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <br>
    <section class="content">
        <div class="row">
          <form action="<?php echo base_url() ?>import" method="POST" id="searchList">
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
              <input type="text" name="searchText" value="<?php echo $searchText ?>" class="form-control" placeholder="Search Text"/>
            </div>
            <div class="col-md-1">
				<input type="text" maxlength="3" name="noOfRecords" id="noOfRecords" class="form-control"
					value="<?php echo $noOfRecords; ?>"  placeholder="Records" />
			</div>
            <div class="col-md-1">
              <!-- <input type="submit" id="submit" name="submit" class="btn btn-primary btn-md" value="Search" /> -->
              <button class="btn btn-md btn-primary searchList">Search</button>
            </div>
            <div class="col-xs-4 text-right">              
                  <a class="btn btn-warning" href="<?php echo base_url(); ?>importExcel">Import New Customers</a>
            </div>
          </form>
        </div>
        <br>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Raw Customers List</h3>
                    <div class="box-tools">
                        
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>Domain Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Country</th>
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
                      <td class="td-wrap">
                        <a target="_blank" href="<?php echo $httpDomain ?>"><?php echo $record->domain_name ?></a>
                      </td>
                      <td class="td20 alignLeft td-wrap"><?php echo $record->registrant_email ?></td>
                      <td class="alignLeft"><?php echo $record->registrant_phone ?></td>
                      <td class="alignLeft"><?php echo $record->registrant_country ?></td>
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
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "import/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
