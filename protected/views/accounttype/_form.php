<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'absrule-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'accounttypeid'); ?>
	<div id="tabledialog">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'accounttypename'); ?></span>
		<span class="cellcontent"><?php echo $form->textField($model,'accounttypename'); ?></span>
	</div>

    <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'parentaccounttypeid'); ?>
		<?php echo $form->hiddenField($model,'parentaccounttypeid'); ?></span>
   <span class="cell"> <input type="text" name="parentaccounttypename" id="parentaccounttypename" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'parentaccounttype_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Account Type'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'parentaccounttype-grid',
        'dataProvider'=>$parentaccounttype->searchwstatus(),
        'filter'=>$parentaccounttype,
			'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#parentaccounttype_dialog\").dialog(\"close\");
          $(\"#parentaccounttypename\").val(\"$data->accounttypename\");
          $(\"#Accounttype_parentaccounttypeid\").val(\"$data->accounttypeid\");"))',
          ),
	array('name'=>'accounttypeid', 'visible'=>false,
        'value'=>'$data->accounttypeid','htmlOptions'=>array('width'=>'1%')),
          'accounttypename',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#parentaccounttype_dialog").dialog("open"); return false;',
                       ))
    ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
    <span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
	</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('accounttype/write'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
toastr.info(x.div);			}
else
			{
				toastr.error(x.div);
			}
     }')); ?><?php echo CHtml::ajaxSubmitButton('Cancel',
		array('accounttype/cancelwrite'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
toastr.info(x.div);			}
else
			{
				toastr.error(x.div);
			}
        }')); ?></span>
</div>
</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
