<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Attachment List
        <small>List of uploaded attachments for companies</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-8 col-xs-8"></div>
            <div class="col-md-4 col-xs-4 text-right">
                  <a class="btn btn-primary" href="<?php echo base_url(); ?>addAttachment">Add Attachment</a>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Attachment List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>attachmentListing" method="POST" id="searchList">
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
                      <th>Type</th>
                      <th>Attachment</th>
                      <th class="alignCenter">Actions</th>
                    </tr>
                    <?php
                    if(!empty($rawRecords))
                    {
                        foreach($rawRecords as $record)
                        {
                    ?>
                    <tr>
                      <td><?php echo $record->at_id; ?></td>
                      <td><?php echo $record->comp_name; ?></td>
                      <td><?php echo $record->at_type; ?></td>
                      <td>
                      	<a href="<?php echo base_url().ATTACHMENT_PATH.$record->at_path; ?>" target="_blank">
                      		<?php echo $record->at_path; ?>
                      	</a>
                      </td>
                      <td class="alignCenter">
                      	<a href="<?php echo base_url().'editAttachment/'.$record->at_id; ?>"><i class="fa fa-pencil"></i></a>
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
            jQuery("#searchList").attr("action", baseURL + "attachmentListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>