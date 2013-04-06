<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'kelurahan-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'kelurahanid'); ?>
	<div id="tabledata">
	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'kelurahanname'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'kelurahanname',array('size'=>50,'maxlength'=>50)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'subdistrictid'); ?>
    <?php echo $form->hiddenField($model,'subdistrictid'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="subdistrictname" title="Enter Schedule name" readonly>
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'subdistrict_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Subdistrict'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'subdistrict-grid',
      'dataProvider'=>$subdistrict->Searchwstatus(),
      'filter'=>$subdistrict,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_subdistrict",
          "id" => "send_subdistrict",
          "onClick" => "$(\"#subdistrict_dialog\").dialog(\"close\"); $(\"#subdistrictname\").val(\"$data->subdistrictname\"); $(\"#Kelurahan_subdistrictid\").val(\"$data->subdistrictid\");
		  "))',
          ),
	array('name'=>'subdistrictid', 'visible'=>false,'value'=>'$data->subdistrictid','htmlOptions'=>array('width'=>'1%')),
        'subdistrictname',
        array(
          'class'=>'CCheckBoxColumn',
          'name'=>'recordstatus',
          'selectableRows'=>'0',
          'header'=>'Record Status',
          'checked'=>'$data->recordstatus'
        ),
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#subdistrict_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>

	<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
		<span class="cell"><?php echo $form->checkbox($model,'recordstatus'); ?></span>
	</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('kelurahan/write'),
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
		array('kelurahan/cancelwrite'),
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
</div><!-- form -->