<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Company Listing
        <small>List of proposing companies</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Company List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>companyListing" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>Id</th>
                      <th>Company Name</th>
                      <th>Website</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Address</th>
                    </tr>
                    <?php
                    if(!empty($rawRecords))
                    {
                        foreach($rawRecords as $record)
                        {
                    ?>
                    <tr>
                      <td><?php echo $record->comp_id; ?></td>
                      <td><?php echo $record->comp_name; ?></td>
                      <td>
                      	<a href="<?php echo $record->comp_url; ?>" target="_blank">
                      		<?php echo $record->comp_url; ?>
                      	</a>
                      </td>
                      <td><?php echo $record->contact; ?></td>
                      <td><?php echo $record->comp_email; ?></td>
                      <td><?php echo $record->address; ?></td>
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
            jQuery("#searchList").attr("action", baseURL + "companyListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>