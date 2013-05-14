<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Invoice No</span>
    <span class="cell"><input type="text" name="search_invoiceno" id="search_invoiceno"></span>
</div>
<div class="rowdata">
	<span class="cell">Invoice Date</span>
    <span class="cell"><?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'name'=>'search_startdate',
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+0'
              ),
          ));?>-<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'name'=>'search_enddate',
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+0'
              ),
          ));?></span>
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
                        "invoiceno": $("#search_invoiceno").val(),
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