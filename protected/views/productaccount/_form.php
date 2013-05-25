<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'productplant-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'productaccountid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell">
		<?php echo $form->labelEx($model,'productid'); ?>
		<?php echo $form->hiddenField($model,'productid'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="productname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'product_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Material Master / Service'),
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
          'value'=>'CHtml::Button("V",
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#product_dialog\").dialog(\"close\"); $(\"#productname\").val(\"$data->productname\"); $(\"#Productaccount_productid\").val(\"$data->productid\");
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
		<span class="cell"><?php echo $form->labelEx($model,'expenseaccount'); ?>
	  <?php echo $form->hiddenField($model,'expenseaccount'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="expenseaccountno" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'expenseaccount_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Account'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'expenseaccount-grid',
      'dataProvider'=>$expenseaccount->Searchwstatus(),
      'filter'=>$expenseaccount,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#expenseaccount_dialog\").dialog(\"close\"); $(\"#expenseaccountno\").val(\"$data->accountname\"); $(\"#Productaccount_expenseaccount\").val(\"$data->accountid\");
		  "))',
          ),
	array('name'=>'accountid', 'visible'=>false,'value'=>'$data->accountid','htmlOptions'=>array('width'=>'1%')),
        'accountcode',
        'accountname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#expenseaccount_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'salesaccount'); ?>
	  <?php echo $form->hiddenField($model,'salesaccount'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="salesaccountno" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'salesaccount_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Account'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'salesaccount-grid',
      'dataProvider'=>$salesaccount->Searchwstatus(),
      'filter'=>$salesaccount,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#salesaccount_dialog\").dialog(\"close\"); $(\"#salesaccountno\").val(\"$data->accountname\"); $(\"#Productaccount_salesaccount\").val(\"$data->accountid\");
		  "))',
          ),
	array('name'=>'accountid', 'visible'=>false,'value'=>'$data->accountid','htmlOptions'=>array('width'=>'1%')),
        'accountcode',
        'accountname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#salesaccount_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
	    <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'salesretaccount'); ?>
	  <?php echo $form->hiddenField($model,'salesretaccount'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="salesretaccountno" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'salesretaccount_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Account'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'salesretaccount-grid',
      'dataProvider'=>$salesretaccount->Searchwstatus(),
      'filter'=>$salesretaccount,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#salesretaccount_dialog\").dialog(\"close\"); $(\"#salesretaccountno\").val(\"$data->accountname\"); $(\"#Productaccount_salesretaccount\").val(\"$data->accountid\");
		  "))',
          ),
	array('name'=>'accountid', 'visible'=>false,'value'=>'$data->accountid','htmlOptions'=>array('width'=>'1%')),
        'accountcode',
        'accountname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#salesretaccount_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'salesitemaccount'); ?>
	  <?php echo $form->hiddenField($model,'salesitemaccount'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="salesitemaccountno" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'salesitemaccount_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Account'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'salesitemaccount-grid',
      'dataProvider'=>$salesitemaccount->Searchwstatus(),
      'filter'=>$salesitemaccount,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#salesitemaccount_dialog\").dialog(\"close\"); $(\"#salesitemaccountno\").val(\"$data->accountname\"); $(\"#Productaccount_salesitemaccount\").val(\"$data->accountid\");
		  "))',
          ),
	array('name'=>'accountid', 'visible'=>false,'value'=>'$data->accountid','htmlOptions'=>array('width'=>'1%')),
        'accountcode',
        'accountname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#salesitemaccount_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'purcretaccount'); ?>
	  <?php echo $form->hiddenField($model,'purcretaccount'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="purcretaccountno" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'purcretaccount_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Account'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'purcretaccount-grid',
      'dataProvider'=>$salesitemaccount->Searchwstatus(),
      'filter'=>$salesitemaccount,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#purcretaccount_dialog\").dialog(\"close\"); $(\"#purcretaccountno\").val(\"$data->accountname\"); $(\"#Productaccount_purcretaccount\").val(\"$data->accountid\");
		  "))',
          ),
	array('name'=>'accountid', 'visible'=>false,'value'=>'$data->accountid','htmlOptions'=>array('width'=>'1%')),
        'accountcode',
        'accountname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#purcretaccount_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'unbilledaccount'); ?>
	  <?php echo $form->hiddenField($model,'unbilledaccount'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="unbilledaccountno" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'unbilledaccount_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Account'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'unbilledaccount-grid',
      'dataProvider'=>$unbilledaccount->Searchwstatus(),
      'filter'=>$unbilledaccount,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#unbilledaccount_dialog\").dialog(\"close\"); $(\"#unbilledaccountno\").val(\"$data->accountname\"); $(\"#Productaccount_unbilledaccount\").val(\"$data->accountid\");
		  "))',
          ),
	array('name'=>'accountid', 'visible'=>false,'value'=>'$data->accountid','htmlOptions'=>array('width'=>'1%')),
        'accountcode',
        'accountname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#unbilledaccount_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
    	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'isactiva'); ?></span>
		<span class="cell"><?php echo $form->checkBox($model,'isactiva'); ?></span>
	</div>

	<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('productaccount/write'),
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
		array('productaccount/cancelwrite'),
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