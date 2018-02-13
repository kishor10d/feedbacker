<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cache Management
        <small>Delete cache of pages</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Caching paths</h3>
                        <div class="box-tools">
                        	<a href="#" id="deleteAllCache"><i class="fa fa-refresh fa-fw fa-2x deleteAllCache"></i></a>
                        </div>
                    </div>
                     <div class="box-body table-responsive no-padding">
		                  <table class="table table-hover">
		                    <tr>
		                      <th>Id</th>
		                      <th>Page Name</th>
		                      <th>Page URL</th>
		                      <th class="alignCenter">Actions</th>
		                    </tr>
		                    <tr>
		                    	<td>1</td>
		                    	<td>Login</td>
		                    	<td>/login</td>
		                    	<td class="alignCenter"><a href="#" id="refreshSpinner_1" data-spinner="1" data-path="login" class="delCache"><i  class="fa fa-refresh fa-fw"></i></a></td>
		                    </tr>
		                    <tr>
		                    	<td>2</td>
		                    	<td>Dashboard</td>
		                    	<td>/dashboard</td>
		                    	<td class="alignCenter"><a href="#" id="refreshSpinner_2" data-spinner="2" data-path="dashboard" class="delCache"><i class="fa fa-refresh fa-fw"></i></a></td>
		                    </tr>
		                   </table>
                	</div>
            	</div>            
        	</div>
        </div>
    </section>
</div>