<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customer-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'addressbookid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'fullname'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'fullname',array('size'=>50,'maxlength'=>50)); ?></span>
	</div>

    <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'taxno'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'taxno',array('size'=>50,'maxlength'=>50)); ?></span>
	</div>

    <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'acchutangid'); ?>
<?php echo $form->hiddenField($model,'acchutangid'); ?></span>
          <span class="cell"><input type="text" name="acchutangname" id="acchutangname" readonly >
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'account_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Address Type'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));
$account = new Account('searchwstatus');
	  $account->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
		$account->attributes=$_GET['Account'];
          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'account-grid',
            'dataProvider'=>$account->Searchwstatus(),
            'filter'=>$account,
				'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("V",
                array("name" => "send_addresstype",
                "id" => "send_addresstype",
                "onClick" => "$(\"#account_dialog\").dialog(\"close\"); $(\"#acchutangname\").val(\"$data->accountname\"); $(\"#Customer_acchutangid\").val(\"$data->accountid\");"))',
                ),
              'accountid',
              'accountcode',
                'accountname',
              ),
          ));

          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#account_dialog").dialog("open"); return false;',
                             ));?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
		<span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
		</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('customer/write'),
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
		array('customer/cancelwrite'),
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
		'Address' => array('content' => $this->renderPartial('indexaddress',
			array('customeraddress'=>$customeraddress),true)),
		'Contact' => array('content' => $this->renderPartial('indexcontact',
			array('customercontact'=>$customercontact),true)),
	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>
</div><!-- form -->
