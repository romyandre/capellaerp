<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'journaldetail-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php echo $form->hiddenField($model,'journaldetailid'); ?>
<?php echo $form->hiddenField($model,'genjournalid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'accountid'); ?>
<?php echo $form->hiddenField($model,'accountid'); ?></span>
	  <span class="cellform"><input type="text" name="account_name" id="account_name" readonly >    
<?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'account_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Account'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$account=new Account('searchwstatus');
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
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#account_dialog\").dialog(\"close\"); $(\"#account_name\").val(\"$data->accountname\"); $(\"#Journaldetail_accountid\").val(\"$data->accountid\");
		  "))',
          ),
		  	array('name'=>'accountid', 'visible'=>false,'value'=>'$data->accountid','htmlOptions'=>array('width'=>'1%')),
        'accountcode',
        'accountname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#account_dialog").dialog("open"); return false;',
                       ))?>		</span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'debit'); ?></span>
		<span class="cellform"><?php echo $form->textField($model,'debit'); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'credit'); ?></span>
		<span class="cellform"><?php echo $form->textField($model,'credit'); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'currencyid'); ?>
<?php echo $form->hiddenField($model,'currencyid'); ?></span>
	  <span class="cellform"><input type="text" name="account_name" id="currencyname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'currency_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Currency'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$currency=new Currency('searchwstatus');
	  $currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$currency->attributes=$_GET['Currency'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'currency-grid',
      'dataProvider'=>$currency->Searchwstatus(),
      'filter'=>$currency,
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
          "onClick" => "$(\"#currency_dialog\").dialog(\"close\"); $(\"#currencyname\").val(\"$data->currencyname\"); $(\"#Journaldetail_currencyid\").val(\"$data->currencyid\");
		  "))',
          ),
		  	array('name'=>'currencyid', 'visible'=>false,'value'=>'$data->currencyid','htmlOptions'=>array('width'=>'1%')),
        'currencyname',
        'symbol',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#currency_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>

    	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'ratevalue'); ?></span>
		<span class="cellform"><?php echo $form->textField($model,'ratevalue'); ?></span>
	</div>

    	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'detailnote'); ?></span>
		<span class="cellform"><?php echo $form->textArea($model,'detailnote',array('cols'=>20,'rows'=>5)); ?></span>
	</div>


	<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('genjournal/writedetail'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
				$.fn.yiiGridView.update("detaildatagrid");
				$("#createdialog1").dialog("close");
				toastr.info(x.div);
			}
			else
			{
				toastr.error(x.div);
			}
        }')); ?></span><span class="cell"><?php echo CHtml::ajaxSubmitButton('Cancel',
		array('genjournal/cancelwritedetail'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
				$.fn.yiiGridView.update("detaildatagrid");			  
				$("#createdialog1").dialog("close");
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