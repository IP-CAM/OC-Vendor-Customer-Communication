<?php echo $header; ?><?php echo $column_left; ?> 
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-review').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label" for="input-filter_enqname"><?php echo $column_name; ?></label>
							<input type="text" name="filter_enqname" value="<?php echo $filter_enqname; ?>" placeholder="<?php echo $column_name; ?>" id="input-filter_enqname" class="form-control" />
						</div>
						<div class="form-group">
							<label class="control-label" for="input-name"><?php echo $column_product; ?></label>
							<input type="text" name="filter_product" value="<?php echo $productname; ?>" placeholder="<?php echo $column_product; ?>" id="input-name" class="form-control" />
							<input type="hidden" name="product_id" value="<?php echo $filter_product; ?>"/>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label" for="input-filter_name"><?php echo $column_seller; ?></label>
							<input type="text" name="filter_name" value="<?php echo $sellername; ?>" placeholder="<?php echo $column_seller; ?>" id="input-filter_name" class="form-control" />
							<input type="hidden" name="vendor_id" value="<?php echo $filter_name; ?>" />
						</div>
						<div class="form-group">
							<label class="control-label" for="input-filter_customer"><?php echo $column_customer; ?></label>
							<input type="text" name="filter_customer" value="<?php echo $customername; ?>" placeholder="<?php echo $column_customer; ?>" id="input-filter_customer" class="form-control" />
							<input type="hidden" name="customer_id" value="<?php echo $filter_customer; ?>"/>
						</div>
					</div>
					<div class="col-sm-6 text-center">
						<button type="button" style="margin-top:2%;" id="button-filter" class="btn btn-primary col-sm-12"><i class="fa fa-filter"></i><?php echo $button_filter; ?></button>
					</div>
					<div class="col-sm-6 text-center">
						<a href="<?php echo $reset; ?>" style="margin-top:2%;" class="btn btn-danger col-sm-12"><i class="fa fa-refresh"></i><?php echo $button_reset; ?></a>
					</div>
				</div>
			</div>		  
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-review">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
							<td class="text-left"><?php if ($sort == 'name') { ?>
								<a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
								<?php } ?>
							</td>
							<td class="text-left"><?php if ($sort == 'email') { ?>
								<a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a>
								<?php } ?>
							</td>
							<td class="text-left"><?php if ($sort == 'product') { ?>
								<a href="<?php echo $sort_product; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_product; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_product; ?>"><?php echo $column_product; ?></a>
								<?php } ?>
							</td>
							<td class="text-left"><?php if ($sort == 'seller') { ?>
								<a href="<?php echo $sort_seller; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_seller; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_seller; ?>"><?php echo $column_seller; ?></a>
								<?php } ?>
							</td>
							
							<td class="text-left"><?php if ($sort == 'customer') { ?>
								<a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a>
								<?php } ?>
							</td>
							<td class="text-left hide"><?php if ($sort == 'status') { ?>
								<a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
								<?php } ?>
							</td>
							<td class="text-left">
								<?php echo $column_description; ?>
							</td>
							<td class="text-left"><?php if ($sort == 'date') { ?>
								<a href="<?php echo $sort_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_date; ?>"><?php echo $column_date; ?></a>
								<?php } ?>
							</td>

							<td class="text-center"><?php echo $column_action;?></td>
						</tr>
					</thead>
					<tbody>
						<?php if ($inquires) { ?>
						<?php foreach ($inquires as $inquiry) { ?>
						<tr>
							<td class="text-center"><?php if (in_array($inquiry['inquiry_id'], $selected)) { ?>
								<input type="checkbox" name="selected[]" value="<?php echo $inquiry['inquiry_id']; ?>" checked="checked" />
								<?php } else { ?>
								<input type="checkbox" name="selected[]" value="<?php echo $inquiry['inquiry_id']; ?>" />
								<?php } ?>
							</td>
							<td class="text-left"><?php echo $inquiry['name'];?></td>
							<td class="text-left"><?php echo $inquiry['email'];?></td>
							<td class="text-left"><a href="<?php echo $inquiry['producturl']; ?>" target="_blank"><?php echo $inquiry['pname'];?></a></td>
							<td class="text-left"><?php echo $inquiry['sname']; ?></td>
							<td class="text-left"><?php echo $inquiry['cname']; ?></td>
							<td class="text-left hide"><?php echo $inquiry['status']; ?></td>
							<td class="text-left"><?php echo $inquiry['description']; ?></td>
							<td class="text-left"><span style="font-size:12px;" class="label btn-info"> <i class="fa fa-clock-o" aria-hidden="true"></i><?php echo $inquiry['date_added']; ?></span></td>
							<td class="text-center">
								<?php if($inquiry['customer_id']) { ?>
								<a href="<?php echo $inquiry['view']; ?>" data-toggle="tooltip" target="_blank" title="<?php echo $button_view; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
								<?php } else { ?>
								<a href="javascript:void(0);" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
								<?php } ?>
							</td>
						</tr>
						<?php } ?>
						<?php } else { ?>
						<tr>
							<td class="text-center" colspan="9"><?php echo $text_no_results; ?></td>
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
</div>

<script type="text/javascript">
$('#button-filter').on('click', function() {
	var url = 'index.php?route=vendor/contact&token=<?php echo $token; ?>';
		
	var filter_customer = $('input[name=\'customer_id\']').val();

	if (filter_customer) {
		url += '&filter_customer=' + encodeURIComponent(filter_customer);
	}
	
	var filter_name = $('input[name=\'vendor_id\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_enqname = $('input[name=\'filter_enqname\']').val();

	if (filter_enqname) {
		url += '&filter_enqname=' + encodeURIComponent(filter_enqname);
	}
	
	var filter_product = $('input[name=\'product_id\']').val();
  
    if (filter_product) {
     url += '&filter_product=' + encodeURIComponent(filter_product);
    }
  
  location = url;
});
</script>

<script type="text/javascript">
$('input[name=\'filter_customer\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					customer_id: 0,
					name:'<?php echo $text_none; ?>'
				});

				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['customer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_customer\']').val(item['label']);
		$('input[name=\'customer_id\']').val(item['value']);
	}
});
</script>

<script type="text/javascript">
/* 05 02 2020 update vendorname firstname pe */  
$('input[name=\'filter_name\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=vendor/vendor/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					vendor_id: 0,
					vendorname:'<?php echo $text_none; ?>'
				});

				response($.map(json, function(item) {
					return {
						label: item['vendorname'],
						value: item['vendor_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_name\']').val(item['label']);
		$('input[name=\'vendor_id\']').val(item['value']);
	}
});
</script>

<script type="text/javascript">
$('input[name=\'filter_product\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					product_id: 0,
					name:'<?php echo $text_none; ?>'
				});

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

/* 12 02 2020 */
//Enquirer Name
$('input[name=\'filter_enqname\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=vendor/contact/autocomplete&token=<?php echo $token; ?>&filter_enqname=' +  encodeURIComponent(request),
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
$(document).bind('keypress', function(e) {
  if(e.keyCode==13){
    $('#button-filter').trigger('click');
  }
});
</script>
<?php echo $footer; ?>