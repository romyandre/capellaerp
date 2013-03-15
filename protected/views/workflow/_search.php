<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Description</span>
    <span class="cell"><input type="text" name="search_desc" id="search_desc"></span>
	<span class="cell">Workflow Name</span>
    <span class="cell"><input type="text" name="search_wfname" id="search_wfname"></span>
</div>
<div class="rowdata">
	<span class="cell">Min Status</span>
    <span class="cell"><input type="text" name="search_minstat" id="search_minstat"></span>
	<span class="cell">Max Status</span>
    <span class="cell"><input type="text" name="search_maxstat" id="search_maxstat"></span>
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
                        "wfdesc": $("#search_desc").val(),
						"wfname": $("#search_wfname").val(),
						"wfminstat": $("#search_minstat").val(),
						"wfmaxstat": $("#search_maxstat").val(),
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