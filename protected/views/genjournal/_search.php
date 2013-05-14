<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Journal No</span>
    <span class="cell"><input type="text" name="search_journalno" id="search_journalno"></span>
</div>
<div class="rowdata">
	<span class="cell">Reference No</span>
    <span class="cell"><input type="text" name="search_referenceno" id="search_referenceno"></span>
</div>
<div class="rowdata">
	<span class="cell">Start Date</span>
    <span class="cell"><?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'name'=>'search_startdate',
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+0'
              ),
          ));?>-<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'name'=>'search_enddate',
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+0'
              ),
          ));?></span>
</div>
<div class="rowdata">
	<span class="cell">Journal Note</span>
    <span class="cell"><input type="text" name="search_journalnote" id="search_journalnote"></span>
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
                        "journalno": $("#search_journalno").val(),
                        "referenceno": $("#search_referenceno").val(),
                        "journalnote": $("#search_journalnote").val(),
						"startdate": $("#search_startdate").val(),
						"enddate": $("#search_enddate").val(),
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