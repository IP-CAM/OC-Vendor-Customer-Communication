<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
    	<div class="container-fluid">
	      <div class="pull-right">
	      	<button type="submit" form="form" onclick="$('#form-tmdcommunication_setting').attr('action','<?php echo $staysave; ?>');$('#form-tmdcommunication_setting').submit(); " data-toggle="tooltip" title="<?php echo $button_stay; ?>" class="btn btn-primary"><i class="fa fa-save"></i><?php echo $button_stay; ?></button>	
	        <button type="submit" form="form-tmdcommunication_setting" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
	        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
	      <h1><?php echo $heading_title; ?></h1>
	      <ul class="breadcrumb">
	        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
	        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
	        <?php } ?>
	      </ul>
		</div>
	</div>
	<div class="modal fade" id="myModal">
		<div class="modal-dialog">
		  <div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
			  <h4 class="modal-title">Shortcuts</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
			 <ul class="list-unstyled">
				<li>{contact_name}   =  Contact Name</li>
				<li>{customername}   = Customer Name</li>
				<li>{product}        = Product Name</li>
				<li>{vendor}  		 = Vendor Name</li>
				<li>{message}		 = Message</li>
				<li>{date}           = Date</li>
			 </ul>
			</div>
		  </div>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
	    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
	      <button type="button" class="close" data-dismiss="alert">&times;</button>
	    </div>
	    <?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i><?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-tmdcommunication_setting" class="form-horizontal">
					<div class="form-group">
			            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
			            <div class="col-sm-10">
			              <select name="tmdcommunication_setting_status" id="input-status" class="form-control">
			                <?php if ($tmdcommunication_setting_status) { ?>
			                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
			                <option value="0"><?php echo $text_disabled; ?></option>
			                <?php }else { ?>
			                <option value="1"><?php echo $text_enabled; ?></option>
			                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
			                <?php } ?>
			              </select>
			            </div>
			        </div>
			        <div class="form-group">
			            <label class="col-sm-2 control-label" for="input-v_info"><?php echo $entry_v_info; ?></label>
			            <div class="col-sm-10">
			              <select name="tmdcommunication_setting_v_info" id="input-v_info" class="form-control">
			                <?php if ($tmdcommunication_setting_v_info) { ?>
			                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
			                <option value="0"><?php echo $text_no; ?></option>
			                <?php }else { ?>
			                <option value="1"><?php echo $text_yes; ?></option>
			                <option value="0" selected="selected"><?php echo $text_no; ?></option>
			                <?php } ?>
			              </select>
			            </div>
			        </div>
			        <div class="form-group">
			            <label class="col-sm-2 control-label" for="input-c_info"><?php echo $entry_c_info; ?></label>
			            <div class="col-sm-10">
			              <select name="tmdcommunication_setting_c_info" id="input-v_info" class="form-control">
			                <?php if ($tmdcommunication_setting_c_info) { ?>
			                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
			                <option value="0"><?php echo $text_no; ?></option>
			                <?php }else { ?>
			                <option value="1"><?php echo $text_yes; ?></option>
			                <option value="0" selected="selected"><?php echo $text_no; ?></option>
			                <?php } ?>
			              </select>
			            </div>
			        </div>
			        <div class="pull-right">
						<a class="btn btn-primary" title="<?php echo $button_shortcut; ?>" data-toggle="modal" data-target="#myModal"><?php echo $button_shortcut; ?></a>
					</div>
					<ul class="nav nav-tabs language" id="language">
						<?php foreach ($languages as $language) { ?>
				        <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code'] ; ?>/<?php echo $language['code'] ; ?>.png" title="<?php echo $language['name'] ; ?>" /><?php echo $language['name'] ; ?></a></li>
				        <?php } ?>
					</ul>
					<legend><i class="fa fa-cog" aria-hidden="true"></i><?php echo $tab_setting; ?></legend>
					<div class="tab-content">
						<?php foreach ($languages as $language) { ?>
						<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_subject; ?></label>
								<div class="col-sm-10">
					             <input type="text" name="tmdcommunication_setting_language[<?php echo $language['language_id']; ?>][v_subject]" value="<?php echo isset($tmdcommunication_setting_language[$language['language_id']]) ? $tmdcommunication_setting_language[$language['language_id']]['v_subject'] : ''; ?>" placeholder="<?php echo $entry_subject; ?>" class="form-control" />
					            </div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_admin_email; ?></label>
								<div class="col-sm-10">
									<textarea class="form-control summernote" name="tmdcommunication_setting_language[<?php echo $language['language_id']; ?>][v_message]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($tmdcommunication_setting_language[$language['language_id']]) ? $tmdcommunication_setting_language[$language['language_id']]['v_message'] : ''; ?></textarea>
								</div>
							</div>
							<legend><i class="fa fa-envelope" aria-hidden="true"></i><?php echo $tab_email; ?></legend>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_subject; ?></label>
								<div class="col-sm-10">
								    <input type="text" name="tmdcommunication_setting_language[<?php echo $language['language_id']; ?>][c_subject]" value="<?php echo isset($tmdcommunication_setting_language[$language['language_id']]) ? $tmdcommunication_setting_language[$language['language_id']]['c_subject'] : ''; ?>" placeholder="<?php echo $entry_subject; ?>" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_admin_email; ?></label>
								<div class="col-sm-10">
									<textarea class="form-control summernote" name="tmdcommunication_setting_language[<?php echo $language['language_id']; ?>][c_message]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($tmdcommunication_setting_language[$language['language_id']]) ? $tmdcommunication_setting_language[$language['language_id']]['c_message'] : ''; ?></textarea>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>		
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script> 
<script type="text/javascript"><!--
$('#language a:first').tab('show');</script>
<style>

#form-tmdcommunication_setting ul li.active > a,#form-tmdcommunication_setting ul li.active > a:hover,#form-tmdcommunication_setting ul li.active > a:focus{
	background: #00a4e4 none repeat scroll 0 0 !important;
	color:#fff;
}
#form-tmdcommunication_setting .nav-tabs li a{
	background:#E4E6EA;
}
#form-tmdcommunication_setting .nav-tabs > li.active > a, #form-tmdcommunication_setting .nav-tabs > li.active > a:hover,#form-tmdcommunication_setting .nav-tabs > li.active > a:focus{
	color:#fff;
}

</style>
<?php echo $footer; ?>
 