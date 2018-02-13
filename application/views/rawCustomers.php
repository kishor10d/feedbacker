<div class="content-wrapper">    
    <section class="content-header">
      <h1>
        Customers
        <small>List of customers</small>
      </h1>
    </section>
    <br>
    <section class="content">
        <form id="searchCustomerList" action="<?php echo base_url().$paginationUrl; ?>" method="POST">
            <div class="row">                
                <div class="col-md-3">                
                    <select id="searchStatus" name="searchStatus" class="form-control">
                        <option value="0">Select Status</option>
                        <option value="<?php echo RAW; ?>"
                            <?php if($searchStatus == RAW) { echo "selected='selected'"; } ?>>Raw</option>
                        <option value="<?php echo PROCESSED; ?>"
                            <?php if($searchStatus == PROCESSED) { echo "selected='selected'"; } ?>>Processed</option>
                        <option value="<?php echo FINALS; ?>"
                            <?php if($searchStatus == FINALS) { echo "selected='selected'"; } ?>>Finals</option>
                        <option value="<?php echo DEAD; ?>"
                            <?php if($searchStatus == DEAD) { echo "selected='selected'"; } ?>>Dead</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" maxlength="20" name="searchText" id="searchText" class="form-control"
                    value="<?php echo $searchText; ?>"  placeholder="Search Text" />
                </div>
                <div class="col-md-1">
                    <input type="text" maxlength="3" name="noOfRecords" id="noOfRecords" class="form-control"
                    value="<?php echo $noOfRecords; ?>"  placeholder="Records" />
                </div>
                <div class="col-md-1">
                    <button class="btn btn-md btn-primary searchList">Search</button>
                </div>
            </div>
        </form>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title" >Customers List</h3>
                        <div class="box-tools"></div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                      <table class="table table-hover">
                        <tr>
                            <th>Domain Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Country</th>
                            <th>Desktop</th>
                            <th>Mobile</th>
                            <th class="alignCenter">Actions</th>
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
                            <td class="alignLeft">
                                <a target="_blank" href="<?php echo $httpDomain ?>">
                                    <?php echo $record->domain_name ?>
                                </a>
                                <br>
                                <?php
                                    switch($record->status)
                                    {
                                        case RAW : ?><span class="label label-default">RAW</span><?php break;
                                        case FINALS : ?><span class="label label-success">FINALS</span><?php break;
                                        case DEAD : ?><span class="label label-danger">DEAD</span><?php break;
                                        case PROCESSED : ?><span class="label label-info">PROCESSED</span><?php break;
                                        default : ?><span class="label label-default">RAW</span><?php
                                    }
                                ?>
                            </td>
                            <td class="td15 alignLeft td-wrap"><?php echo $record->registrant_email ?></td>
                            <td class="alignLeft"><?php echo $record->registrant_phone ?></td>
                            <td class="alignLeft"><?php echo $record->registrant_country ?></td>
                            <td class="td20">
                                <a id="browserImgHref_<?php echo $record->cust_id ?>" href="<?php echo base_url().WEBSITE_CAPTURE.BROWSER.$record->scr_img_desk ?>" target="_blank">
                                <img id="browserImg_<?php echo $record->cust_id ?>" class="img-thumbnail max-height" alt="<?php echo $record->domain_name; ?>"
                                src="<?php echo base_url().WEBSITE_CAPTURE.BROWSER.$record->scr_img_desk ?>" /></a>
                            </td>
                            <td class="td20">
                                <a id="mobileImgHref_<?php echo $record->cust_id ?>" href="<?php echo base_url().WEBSITE_CAPTURE.MOBILE.$record->scr_img_desk ?>" target="_blank">
                                <img id="mobileImg_<?php echo $record->cust_id ?>" class="img-thumbnail max-height" alt="<?php echo $record->domain_name; ?>"
                                src="<?php echo base_url().WEBSITE_CAPTURE.MOBILE.$record->scr_img_mobile ?>" /></a>
                            </td>
                            <td class="alignCenter" style="vertical-align:middle">
                            	<a href="#" class="refreshIt" data-custId="<?php echo $record->cust_id ?>" data-domainName="<?php echo $httpDomain ?>">
                            		<i id="refreshSpinner_<?php echo $record->cust_id ?>" class="fa fa-refresh fa-fw"></i></a>
                            	&nbsp;&nbsp;
                                <a href="<?php echo base_url().'rawCustomer/'.$record->cust_id; ?>"><i class="fa fa-pencil"></i></a>
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
        <div class="row">
            <div class="col-md-1"><span class="label label-default">RAW</span></div>
            <div class="col-md-4"><span>Customers yet to served</span></div>
        </div>
        <div class="row">
            <div class="col-md-1"><span class="label label-info">PROCESSED</span></div>
            <div class="col-md-4"><span>Customers which are in process</span></div>
        </div>
        <div class="row">
            <div class="col-md-1"><span class="label label-success">FINALS</span></div>
            <div class="col-md-4"><span>Customers which purchased our services</span></div>
        </div>
        <div class="row">
            <div class="col-md-1"><span class="label label-danger">DEAD</span></div>
            <div class="col-md-4"><span>Customers which are not interested</span></div>
        </div>
    </section>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
		jQuery('ul.pagination li a').click(function (e) {            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);            
            jQuery("#searchCustomerList").attr("action", baseURL + "<?php echo $paginationUrl; ?>" + value);
            jQuery("#searchCustomerList").submit();
            e.preventDefault();
        });
    });
</script>