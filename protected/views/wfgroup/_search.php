<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Workflow Name</span>
    <span class="cell"><input type="text" name="search_wfname" id="search_wfname"></span>
</div>	
<div class="rowdata">
	<span class="cell">Workflow Description</span>
    <span class="cell"><input type="text" name="search_wfdesc" id="search_wfdesc"></span>
</div>
<div class="rowdata">
	<span class="cell">Workflow Min Status</span>
    <span class="cell"><input type="text" name="search_wfminstat" id="search_wfminstat"></span>
</div>
<div class="rowdata">
	<span class="cell">Workflow Max Status</span>
    <span class="cell"><input type="text" name="search_wfmaxstat" id="search_wfmaxstat"></span>
</div>
<div class="rowdata">
	<span class="cell">Group Acess</span>
    <span class="cell"><input type="text" name="search_group" id="search_group"></span>
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
                        "wfname": $("#search_wfname").val(),
						"wfdesc": $("#search_wfdesc").val(),
						"groupname": $("#search_groupname").val(),
						"wfminstat": $("#search_wfminstat").val(),
						"wfmaxstat": $("#search_wfmaxstat").val(),
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