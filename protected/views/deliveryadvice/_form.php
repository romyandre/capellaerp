<div class="form">
<?php
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'genjournal-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php echo $form->hiddenField($model,'deliveryadviceid');?>
<div id="tabledialog">
		<div class="rowdata">
          <span class="cell"><?php echo $form->labelEx($model,'dadate'); ?></span>
<span class="cellcontent"><?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'dadate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
             'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'-10:+10'
              ),
          ));?> </span>
        </div>
	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'slocid'); ?>
<?php echo $form->hiddenField($model,'slocid'); ?></span>
        <span class="cellcontent"><input type="text" name="description" id="description" style="width: 200px" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'sloc_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Storage Location'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'sloc-grid',
      'dataProvider'=>$sloc->searchwstatus(),
      'filter'=>$sloc,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#sloc_dialog\").dialog(\"close\"); $(\"#description\").val(\"$data->description\"); $(\"#Deliveryadvice_slocid\").val(\"$data->slocid\");
		  "))',
          ),
	array('name'=>'slocid', 'visible'=>false,'value'=>'$data->slocid','htmlOptions'=>array('width'=>'1%')),
        'sloccode',
		'description'
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#sloc_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
			  <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'headernote'); ?></span>
		<span class="cellcontent"><?php echo $form->textArea($model,'headernote',array('rows'=>6, 'cols'=>50)); ?></span>
	</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('deliveryadvice/write'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
				$.fn.yiiGridView.update("datagrid");
				$("#createdialog").dialog("close");
				toastr.info(x.div);
			}
			else
			{
				toastr.error(x.div);
			}
        }')); ?><?php echo CHtml::ajaxSubmitButton('Cancel',
		array('deliveryadvice/cancelwrite'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
				$.fn.yiiGridView.update("datagrid");			  
				$("#createdialog").dialog("close");
				toastr.info(x.div);
			}
			else
			{
				toastr.error(x.div);
			}
        }')); ?></span>
</div>
</div>
<?php $this->endWidget(); ?>
	<?php
	$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs' => array(
		'Detail' => array('content' => $this->renderPartial('indexdetail',
				  array('deliveryadvicedetail'=>$deliveryadvicedetail,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'requestedby'=>$requestedby),true)),
	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>
</div><!-- form -->