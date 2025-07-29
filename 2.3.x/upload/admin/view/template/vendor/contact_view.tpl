<?php echo $header; ?><?php echo $column_left; ?> 
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      </div>
      <h1><?php echo $heading_view; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
    <div class="container-fluid">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i><?php echo $text_view; ?></h3>
          </div>
          <div class="panel-body messagelist content msgsendform">
            <div class="box1"><?php echo $description; ?></div>
              <div style="overflow-x:hidden; max-height: 450px;">
                <div class="box2">
                  <div class="comment-part box2">

                    <!-- All Message -->
                    <ul class="comment-section list">
                      <?php foreach ($tmdmessages as $result) { ?>
                        <?php if ($result['customer_id']) { ?>
                        <li class="comment user-comment">
                          <div class="info">

                          </div>
                          <p class="message" style="margin-bottom: -17px;border-radius: 30px;">
                            <i class="fa fa-user" data-toggle="tooltip" title="Customer"></i> <b><?php echo $result['message']; ?><span class="pull-right"><?php echo $result['data_added']; ?></span></b>
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
                            <b><?php echo $result['data_added']; ?><span class="pull-right"><?php echo $result['message']; ?> <i class="fa fa-users" data-toggle="tooltip" title="Vendor"></i>
                              <br/>
                              <?php if ($result['filename']) { ?>
                              <a href="<?php echo $result['hreflink']; ?>"><strong><?php echo $text_download; ?></strong> </a>
                              <?php } ?>
                              </span>
                            </b>
                             
                          </p>
                        </li>
                        <?php } ?> 
                      <?php } ?>
                    </ul>
                    <!-- All Message -->
                    
                    </ul>
                  </div>
                </div>
              </div>
          </div>
      </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="view/stylesheet/tmdmsg.css">
<?php echo $footer; ?>