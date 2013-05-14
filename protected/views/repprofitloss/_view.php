<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->repprofitlossid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->repprofitlossid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Account Code</span>
    <span class="cell"><?php echo ($model->account!==null)?$model->account->accountcode:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Account Name</span>
    <span class="cell"><?php echo ($model->account!==null)?$model->account->accountname:'';?></span>
</div>
</div>