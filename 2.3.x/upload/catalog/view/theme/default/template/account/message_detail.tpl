<?php echo $header; ?>
<div id="account-message_detail" class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div id="success_msg"></div>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?> messagelist"><?php echo $content_top; ?>
      <div class="content msgsendform">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
              <td class="box1"><?php echo $entry_subject; ?> <?php echo $description; ?></td>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td>
                  <div style="overflow-x:hidden; max-height: 450px;">
                    <div class="box2">
                      <div class="comment-part box2">
                        <ul class="comment-section list">
                          <!-- All Message Start-->
                                <?php foreach ($tmdmessages as $result) { ?>
                                  <?php if (!$result['customer_id']) { ?>
                                    <li class="comment user-comment">
                                      <div class="info">
                                      </div>
                                      <p class="message" style="margin-bottom: -17px;border-radius: 30px;">
                                        <b><?php echo $result['message']; ?><span class="pull-right"><?php echo $result['data_added']; ?></span></b>
                                        <?php if ($result['filename']) { ?>
                                        <br/>
                                        <a href="<?php echo $result['hreflink']; ?>"><strong><?php echo $text_download; ?></strong> </a>
                                        <?php } ?> 
                                      </p>
                                    </li>
                                  <?php } else { ?> 
                                    <li class="comment author-comment">
                                      <div class="info">
                                      </div>
                                      <p class="message pull-right" style="margin-bottom: -17px;border-radius: 30px;">
                                        <b><?php echo $result['data_added']; ?><span class="pull-right"><?php echo $result['message']; ?>
                                        <?php if ($result['filename']) { ?>
                                        <br/>
                                        <a href="<?php echo $result['hreflink']; ?>"><strong><?php echo $text_download; ?></strong> </a>
                                        <?php } ?> 
                                        </span></b>
                                      </p>
                                    </li>
                                  <?php } ?> 
                                <?php } ?> 
                                <!-- All Message End-->                          
                        </ul>
                        
                      </div>
                    </div>
                    <div id="messagedetail"></div>
                  </div>
                
                </td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
         
      <div class="content msgsendform">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <td class="box1"><?php echo $entry_reply; ?></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <label><?php echo $entry_response; ?></label>
                  <textarea name="message" class="form-control" col="40"  rows="10" style=" width: 100%;" id="responsetext"></textarea>
                  <div id="errormessage"></div>
                  <input type="hidden" name="inquiry_id" value="<?php echo $inquiry_id; ?>">
                </td>
              </tr>
            </tbody>
          </table>
          <div class="col-sm-12">
            <div class="well">
              <div class="row">
                <div class="col-sm-3">
                  <div class="form-group">
                    <label class="control-label" for="input-upload"><?php echo $entry_upload; ?></label>
                    <input type="hidden" name="filename" value="" placeholder="<?php echo $entry_upload; ?>" id="input-filename" class="form-control" />
                    <span class="input-group-btn">
                    </span>
                    <button type="button" id="button-upload"   data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-upload"></i><?php echo $button_upload; ?></button>
                  </div>
                </div>
                <div class="button-group">
                   <input type="button" id="msgsend" style="margin-top:20px; margin-left:-40px;" value="<?php echo $button_send; ?>" class="button message col-sm-6" />
                </div>    
              </div>
            </div>
          </div>

	     </div>
      </div>

    <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/vendor/tmdmsg.css">
<?php echo $footer; ?>
<script>
$(document).on('click', '#msgsend',function(){
  var noti = ($('.msgsendform input[name=\'notify\']').prop('checked') ? 1 : 0);
  $.ajax({
  url:'index.php?route=account/message_detail/sendDetailMessage&notify='+noti,
  data: $('.msgsendform input[type=\'text\'], .msgsendform input[type=\'hidden\'],.msgsendform textarea,.msgsendform select'),
  type:'post',
  dataType:'json',

  beforeSend: function() {
    $('.success, .warning, .alert, .alert-danger').remove();

    $('#msgsend').attr('disabled', true);
    $('#msgsend').button('loading');

  },
  complete: function() {
    $('#msgsend').button('reset');
    $('#msgsend').attr('disabled', false);
    $('.attention').remove();
  },

  success: function(json) {

    if (json['error']) {
    $('#errormessage').html('<div class="alert alert-danger">' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');    
    }

    if (json['success']) {
      $('#success_msg').html('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');    
      messagedetail(json);
      $('.msgsendform select').val('');
      $('#errormessage').html('');
      $('.alert alert-success').html('');
      $('.msgsendform input[name=\'notify\']').attr('checked', false);
      $('#responsetext').val('');
    }
  }
});
});

function messagedetail(json){
  html='';
  html+='<div class="box2">';
  html+='<ul class="comment-section">';
  html+='<li class="comment author-comment">';
  html+='<div class="info">';
  html+='</div>';
  html+='<p class="message pull-right" style="margin-bottom: -17px;border-radius: 30px;margin-left: -100px;"><b>'+json['data_added']+'</b><span class="pull-right"><b>'+json['message']+'</b>';
  if(json['filename']) {
  html+='<br/>';
  html+='<a href="'+json['hreflink']+'"><strong><?php echo $text_download; ?></strong> </a>';
  }
  html+='</span></p>';
  html+='</li>';
  html+='</ul>';
  html+='</div>';
  $('#messagedetail').append(html);
}
</script>
<script type="text/javascript"><!--
$('#button-upload').on('click', function() {
	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=account/message_detail/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('#button-upload').button('loading');
				},
				complete: function() {
					$('#button-upload').button('reset');
				},
				success: function(json) {
					if (json['error']) {
						alert(json['error']);
					}

					if (json['success']) {
						alert(json['success']);
						$('input[name=\'filename\']').val(json['filename']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
	border:none;
}

element.style {
}
ul {
    list-style:none;
}
li.comment.vendor-comment {
    background: #337ab726;
    margin-right:15px;
    font-weight:bold; 
    padding-top:10px;
}
p {
    margin-left:10px;
    padding-right:10px;
} 
</style>

