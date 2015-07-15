<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <form action="" method="post">
    <label>Widget Id</label>&nbsp;
    <input type="text" name="clickdeskwidgetid" value="<?php echo $widgetid; ?>"/>&nbsp;&nbsp;&nbsp;
    <input type="submit" name="submit" value="Submit" />
  </form>
  <hr/>
  <iframe width="100%" border="0" height="1200px" src="<?php echo $iframeurl; ?>" scrolling="yes"></iframe>
</div>
<?php echo $footer; ?>
