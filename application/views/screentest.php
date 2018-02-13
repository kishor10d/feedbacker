<div class="content-wrapper">    
    <section class="content-header">
      <h1>
        Screen Test
        <small>Capture the screen </small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Website Details</h3>
                    </div>
                     <form role="form" id="importExcel" enctype="multipart/form-data" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="url">Site Url</label>
                                        <input type="url" class="form-control" name="url" placeholder="URL to screenshot">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="w">Width</label>
                                        <input type="number" value="1024" class="form-control" name="w" placeholder="1024">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="h">Height</label>
                                        <input type="number" value="768" class="form-control" name="h" placeholder="768">   
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
            <div class="col-md-8">
                <div id="screen-template">
                    <div class="thumbnail">
                        <div class="caption">
                            <h3 class="screen-url"></h3>
                            <p>
                                <a href="" class="btn btn-primary screen-src" download role="button">Download</a>
                                <a href="#" class="btn btn-default screen-src" role="button" target="_blank">View Image</a>
                            </p>
                        </div>
                        <img class="screen-src" src="" alt="Print-screen">
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
  $(document).ready(function () {
    
    $('form').submit(function (e) {
      // e.preventDefault();

     

      var imageUrl = "<?php echo base_url().'screenCapture?'; ?>";

      $(this).serializeArray().forEach(function (param) {
        if (param.value) {
          imageUrl += param.name + "=" + encodeURIComponent(param.value) + "&";
        }
      });

      var template = $($('#screen-template').html());

      template.removeAttr("style");

      template.find('.screen-url').html($('input[name=url]').val());
      template.find('a.screen-src').attr('href', imageUrl);
      template.find('img.screen-src').attr('src', imageUrl);

      $('.image-list').prepend(template);

        console.log(template.find('.screen-url'));
    });
  });
</script>