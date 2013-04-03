<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Workflow</span>
    <span class="cell"><input type="text" name="search_workflow" id="search_workflow"></span>
	<span class="cell">Workflow Status Value</span>
    <span class="cell"><input type="text" name="search_wfstatus" id="search_wfstatus"></span>
</div>
<div class="rowdata">
	<span class="cell">Workflow Status Text</span>
    <span class="cell"><input type="text" name="search_wfstatusname" id="search_wfstatusname"></span>
</div>
<div class="rowdata">
<span class="cell">
<?php
$imgsearch=CHtml::image(Yii::app()->request->baseUrl.'/images/search.png');
echo CHtml::link($imgsearch,'#',array(
		   'style'=>'cursor: pointer; text-decoration: underline;',
		   'onclick'=>'{
				$.fn.yiiGridView.update("datagrid", {
                    data: {
                        "wfname": $("#search_workflow").val(),
						"wfstat": $("#search_wfstatus").val(),
						"wfstatusname": $("#search_wfstatusname").val(),
                    }
					});
				$("#searchdialog").dialog("close");
		   }',
			'id'=>'search',
			'title'=>Catalogsys::model()->getcatalog('searchdata')
		));
		?></span>
</div>
</div>   
<?php $this->endWidget(); ?>
</div><!-- form -->