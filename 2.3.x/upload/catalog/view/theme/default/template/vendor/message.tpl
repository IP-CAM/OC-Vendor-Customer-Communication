<?php echo $header; ?><?php echo $column_left; ?> 
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
       <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i><?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-inquiry-id"><?php echo $entry_inquiry_id; ?></label>
                <input type="text" name="filter_inquiry_id " value="<?php echo $filter_inquiry_id; ?>" placeholder="<?php echo $entry_inquiry_id; ?>" id="input-inquiry-id" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_product; ?></label>
                <input type="text" name="filter_product" value="<?php echo $productname; ?>" placeholder="<?php echo $entry_product; ?>" id="input-name" class="form-control" />
                <input type="hidden" name="product_id" value="<?php echo $filter_product; ?>" />
              </div>
            </div>
            <div class="col-sm-4">
               <div class="form-group">
                <label class="control-label" for="input-author"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_enqname" value="<?php echo $filter_enqname; ?>" placeholder="<?php echo $entry_name; ?>" id="input-author" class="form-control" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_customer; ?></label>
                <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-name" class="form-control" />
              </div>
            </div>
             <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
            </div>
            <div class="col-sm-2">
              <button style="margin-top:37px;" type="button" id="button-filter" class="btn btn-primary pull-right col-sm-12" title="<?php echo $text_filter; ?>"><i class="fa fa-filter"></i><?php echo $text_filter; ?></button>
            </div>
            <div class="col-sm-2">
              <a style="margin-top:37px;" href="<?php echo $reset; ?>" id="button-filter" class="btn btn-danger pull-right col-sm-12" title="<?php echo $text_reset; ?>"><i class="fa fa-refresh"></i><?php echo $text_reset; ?></a>
            </div>
          </div>
        </div>
          <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-review">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <td class="text-left bgc1"><?php echo $column_inquiry_id; ?></td>
                    <td class="text-left bgc1"><?php echo $column_name; ?></td>
                    <td class="text-left bgc1"><?php echo $column_product; ?></td>
                    <td class="text-left bgc1"><?php echo $column_customer; ?></td>
                    <td class="text-left bgc1"><?php echo $column_description; ?></td>
                    <td class="text-left bgc1"><?php echo $column_date_added; ?></td>
                    <td class="text-center bgc1"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($enquires) { ?>
                <?php foreach ($enquires as $enquiry) { ?>
                <tr>
                  <td class="text-left"><?php echo $enquiry['inquiry_id'];?></td>
                  <td class="text-left"><?php echo $enquiry['name'];?></td>
                  <td class="text-left"><a href="<?php echo $enquiry['producturl'];?>" target="_blank"><?php echo $enquiry['pname'];?></a></td>
                  <td class="text-left">
                    <?php if($customer_info==1) { ?>
                      <?php echo $enquiry['cname']; ?><br/>
                      <?php echo $enquiry['email']; ?><br/>
                      <?php echo $enquiry['telephone']; ?>
                    <?php }else { ?>
                      <?php echo $enquiry['cname']; ?>
                    <?php  } ?>  
                  </td>
                  <td class="text-left hide"><?php echo $enquiry['status']; ?></td>
                  <td class="text-left"><?php echo $enquiry['description']; ?></td>
                  <td class="text-left"><span style="font-size:12px;" class="label btn-info"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo $enquiry['date_added']; ?></span></td>
                  <td class="text-center">
                    
                    <?php if (!$enquiry['customer_id']) { ?>
                    <a href="javascript:void(0);!" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                    <?php } else { ?>
                    <a href="<?php echo $enquiry['view']; ?>" data-toggle="tooltip" target="_blank" title="<?php echo $button_view; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                    <?php } ?>
                  </td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
</div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  url = 'index.php?route=vendor/message';

  var filter_inquiry_id = $('#input-inquiry-id').val();
  if (filter_inquiry_id) {
    url += '&filter_inquiry_id=' + encodeURIComponent(filter_inquiry_id);
  }
        
  var filter_product = $('input[name=\'product_id\']').val();
  
  if (filter_product) {
    url += '&filter_product=' + encodeURIComponent(filter_product);
  }
  
  var filter_customer = $('input[name=\'filter_customer\']').val();
  
  if (filter_customer) {
    url += '&filter_customer=' + encodeURIComponent(filter_customer);
  }
  
  var filter_enqname = $('input[name=\'filter_enqname\']').val();
  
  if (filter_enqname) {
    url += '&filter_enqname=' + encodeURIComponent(filter_enqname);
  }
  
  /* 12 02 2020 */    
  var filter_date_added = $('input[name=\'filter_date_added\']').val();
  
  if (filter_date_added) {
    url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
  }

  location = url;
});

$(document).bind('keypress', function(e) {
  if(e.keyCode==13){
    $('#button-filter').trigger('click');
  }
});
//--></script> 
  <script type="text/javascript"><!--
$('.date').datetimepicker({
  pickTime: false
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'filter_product\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=vendor/product/autocomplete&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['product_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_product\']').val(item['label']);
    $('input[name=\'product_id\']').val(item['value']);
  }
});

$('input[name=\'filter_customer\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=vendor/message/autocomplete&filter_enqname=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['inquiry_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_customer\']').val(item['label']);
    $('input[name=\'inquiry_id\']').val(item['value']);
  }
});
/* add new function 12 02 2020 */
//Enquirer Name
$('input[name=\'filter_enqname\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=vendor/message/autocomplete&filter_enqname=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['inquiry_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_enqname\']').val(item['label']);
    $('input[name=\'inquiry_id\']').val(item['value']);
  }
});
/* add new function 12 02 2020 */
</script></div>
<style>
.bgc1{background: #48c0f0;color: #fff;padding: 12px;}
</style>
<?php echo $footer; ?>