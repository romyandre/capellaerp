<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'purchinforec-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'purchinforecid'); ?>
		<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'addressbookid'); ?>
		<?php echo $form->hiddenField($model,'addressbookid'); ?></span>
         <span class="cell"><input type="text" name="addressbook_name" id="addressbook_name" readonly >
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'addressbook_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Supplier'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'addressbook-grid',
            'dataProvider'=>$supplier->Searchwstatus(),
            'filter'=>$supplier,
				'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_addressbook",
                "id" => "send_addressbook",
                "onClick" => "$(\"#addressbook_dialog\").dialog(\"close\"); $(\"#addressbook_name\").val(\"$data->fullname\"); $(\"#Purchinforec_addressbookid\").val(\"$data->addressbookid\");"))',
                ),
	array('name'=>'addressbookid', 'visible'=>false,'value'=>'$data->addressbookid','htmlOptions'=>array('width'=>'1%')),
              'fullname',
              ),
          ));

          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#addressbook_dialog").dialog("open"); return false;',
                             ));?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'productid'); ?>
		<?php echo $form->hiddenField($model,'productid'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="productname" title="Enter Schedule name" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'product_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Material Master'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'product-grid',
      'dataProvider'=>$product->Searchwstatus(),
      'filter'=>$product,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#product_dialog\").dialog(\"close\"); $(\"#productname\").val(\"$data->productname\"); $(\"#Purchinforec_productid\").val(\"$data->productid\");
		  "))',
          ),
	array('name'=>'productid', 'visible'=>false,'value'=>'$data->productid','htmlOptions'=>array('width'=>'1%')),
        'productname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#product_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'deliverytime'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'deliverytime'); ?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'purchasinggroupid'); ?>
		<?php echo $form->hiddenField($model,'purchasinggroupid'); ?></span>
	 <span class="cell"> <input type="text" name="sched_name" id="purchasinggroupcode" title="Enter Schedule name" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'purchasinggroupcode_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Purchasing Group'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'product-grid',
      'dataProvider'=>$purchasinggroup->Searchwstatus(),
      'filter'=>$purchasinggroup,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#purchasinggroupcode_dialog\").dialog(\"close\"); $(\"#purchasinggroupcode\").val(\"$data->purchasinggroupcode\"); $(\"#Purchinforec_purchasinggroupid\").val(\"$data->purchasinggroupid\");
		  "))',
          ),
	array('name'=>'purchasinggroupid', 'visible'=>false,'value'=>'$data->purchasinggroupid','htmlOptions'=>array('width'=>'1%')),
        'purchasinggroupcode',
		'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#purchasinggroupcode_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'price'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'price'); ?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'currencyid'); ?>
		<?php echo $form->hiddenField($model,'currencyid'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="currencyname" title="Enter Schedule name" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'currency_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Purchasing Group'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

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
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#currency_dialog\").dialog(\"close\"); $(\"#currencyname\").val(\"$data->currencyname\"); $(\"#Purchinforec_currencyid\").val(\"$data->currencyid\");
		  "))',
          ),
	array('name'=>'currencyid', 'visible'=>false,'value'=>'$data->currencyid','htmlOptions'=>array('width'=>'1%')),
        'currencyname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#currency_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'underdelvtol'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'underdelvtol'); ?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'overdelvtol'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'overdelvtol'); ?></span>
	</div>
        <div class="rowdata">
          <span class="cell"><?php echo $form->labelEx($model,'biddate'); ?></span>
          <span class="cell"><?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'biddate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
             'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                 'yearRange'=>'1900:+0'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?></span>
        </div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('purchinforec/write'),
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
		array('purchinforec/cancelwrite'),
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