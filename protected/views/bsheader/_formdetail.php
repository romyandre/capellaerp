<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bsdetail-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(4)}",
));  ?>
<?php echo $form->hiddenField($model,'bsdetailid'); ?>
<?php echo $form->hiddenField($model,'bsheaderid'); ?>
	

	<table>
		<tr>
			<td>
				<div class="row">
				<?php echo $form->labelEx($model,'productid'); ?>
				<?php echo $form->hiddenField($model,'productid'); ?>
				  <input type="text" name="account_name" id="productname" title="Account name" readonly >
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
				  'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
				  'columns'=>array(
					array(
					  'header'=>'',
					  'type'=>'raw',
					/* Here is The Button that will send the Data to The MAIN FORM */
					  'value'=>'CHtml::Button("+",
					  array("name" => "send_absschedule",
					  "id" => "send_absschedule",
					  "onClick" => "$(\"#product_dialog\").dialog(\"close\"); $(\"#productname\").val(\"$data->productname\"); $(\"#Bsdetail_productid\").val(\"$data->productid\");
					  "))',
					  ),
					  array('name'=>'productid', 'visible'=>false,
        'value'=>'$data->productid','htmlOptions'=>array('width'=>'1%')),
					'productname',
					),
				));

				$this->endWidget('zii.widgets.jui.CJuiDialog');
				echo CHtml::Button('...',
									  array('onclick'=>'$("#product_dialog").dialog("open"); return false;',
								   ))?>		
					<?php echo $form->error($model,'productid'); ?>
				</div>
			</td>
			<td>
				<div class="row">
				<?php echo $form->labelEx($model,'quantity'); ?>
				<?php echo $form->textField($model,'quantity'); ?>
				<?php echo $form->error($model,'quantity'); ?>
				</div>
			</td>
			<td>
			<div class="row">
		<?php echo $form->labelEx($model,'unitofmeasureid'); ?>
		<?php echo $form->hiddenField($model,'unitofmeasureid'); ?>
	  <input type="text" name="account_name" id="uomcode" title="Account name" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'uom_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Unit of Measure'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'uom-grid',
      'dataProvider'=>$unitofmeasure->Searchwstatus(),
      'filter'=>$unitofmeasure,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#uom_dialog\").dialog(\"close\"); $(\"#uomcode\").val(\"$data->uomcode\"); $(\"#Bsdetail_unitofmeasureid\").val(\"$data->unitofmeasureid\");
		  "))',
          ),
		  array('name'=>'unitofmeasureid', 'visible'=>false,
        'value'=>'$data->unitofmeasureid','htmlOptions'=>array('width'=>'1%')),
        'uomcode',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#uom_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'unitofmeasureid'); ?>
	</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="row">
		<?php echo $form->labelEx($model,'slocid'); ?>
		<?php echo $form->hiddenField($model,'slocid'); ?>
	  <input type="text" name="account_name" id="sloccode" title="Account name" readonly >
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
      'id'=>'uom-grid',
      'dataProvider'=>$sloc->Searchwstatus(),
      'filter'=>$sloc,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#sloc_dialog\").dialog(\"close\"); $(\"#sloccode\").val(\"$data->description\"); $(\"#Bsdetail_slocid\").val(\"$data->slocid\");
		  "))',
          ),
		  array('name'=>'slocid', 'visible'=>false,
        'value'=>'$data->slocid','htmlOptions'=>array('width'=>'1%')),
        'sloccode',
          'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#sloc_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'sloccid'); ?>
	</div>
			</td>
			<td>
				<div class="row">
				<?php echo $form->labelEx($model,'buydate'); ?>
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'buydate',
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
          ));?>
				<?php echo $form->error($model,'buydate'); ?>
				</div>
			</td>
			<td>
				<div class="row">
				<?php echo $form->labelEx($model,'expiredate'); ?>
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'expiredate',
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
          ));?>
				<?php echo $form->error($model,'expiredate'); ?>
				</div>
			</td>
			<td>
				<div class="row">
				<?php echo $form->labelEx($model,'buyprice'); ?>
				<?php echo $form->textField($model,'buyprice'); ?>
				<?php echo $form->error($model,'buyprice'); ?>
				</div>
			</td>
			<td>
			<div class="row">
		<?php echo $form->labelEx($model,'currencyid'); ?>
		<?php echo $form->hiddenField($model,'currencyid'); ?>
	  <input type="text" name="account_name" id="currencyname" title="Account name" readonly >
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

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'currency-grid',
      'dataProvider'=>$currency->Searchwstatus(),
      'filter'=>$currency,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#currency_dialog\").dialog(\"close\"); $(\"#currencyname\").val(\"$data->currencyname\"); $(\"#Bsdetail_currencyid\").val(\"$data->currencyid\");
		  "))',
          ),
		  array('name'=>'currencyid', 'visible'=>false,
        'value'=>'$data->currencyid','htmlOptions'=>array('width'=>'1%')),
        'currencyname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#currency_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'currencyid'); ?>
	</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="row">
				<?php echo $form->labelEx($model,'itemnote'); ?>
				<?php echo $form->textField($model,'itemnote'); ?>
				<?php echo $form->error($model,'itemnote'); ?>
				</div>
			</td>
						<td>
			<div class="row">
				<?php echo $form->labelEx($model,'pono'); ?>
				<?php echo $form->textField($model,'pono'); ?>
				<?php echo $form->error($model,'pono'); ?>
				</div>
			</td>
			<td>
				<div class="row">
				<?php echo $form->labelEx($model,'serialno'); ?>
				<?php echo $form->textField($model,'serialno'); ?>
				<?php echo $form->error($model,'serialno'); ?>
				</div>
			</td>
		</tr>	
		<tr>
		<td>
				<div class="row">
				<?php echo $form->labelEx($model,'location'); ?>
				<?php echo $form->textField($model,'location'); ?>
				<?php echo $form->error($model,'location'); ?>
				</div>
			</td>
			<td>
				<div class="row">
				<?php echo $form->labelEx($model,'ownershipid'); ?>
				<?php echo $form->hiddenField($model,'ownershipid'); ?>
				  <input type="text" name="ownershipname" id="ownershipname" title="Account name" readonly >
				<?php
				  $this->beginWidget('zii.widgets.jui.CJuiDialog',
				   array(   'id'=>'ownership_dialog',
							// additional javascript options for the dialog plugin
							'options'=>array(
											'title'=>Yii::t('app','Ownership'),
											'width'=>'auto',
											'autoOpen'=>false,
											'modal'=>true,
											),
									));

				$this->widget('zii.widgets.grid.CGridView', array(
				  'id'=>'ownership-grid',
				  'dataProvider'=>$ownership->Searchwstatus(),
				  'filter'=>$ownership,
				  'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
				  'columns'=>array(
					array(
					  'header'=>'',
					  'type'=>'raw',
					/* Here is The Button that will send the Data to The MAIN FORM */
					  'value'=>'CHtml::Button("+",
					  array("name" => "send_absschedule",
					  "id" => "send_absschedule",
					  "onClick" => "$(\"#ownership_dialog\").dialog(\"close\"); $(\"#ownershipname\").val(\"$data->ownershipname\"); 
					  $(\"#Bsdetail_ownershipid\").val(\"$data->ownershipid\");
					  "))',
					  ),
					  array('name'=>'ownershipid', 'visible'=>false,
        'value'=>'$data->ownershipid','htmlOptions'=>array('width'=>'1%')),
					'ownershipname',
					),
				));

				$this->endWidget('zii.widgets.jui.CJuiDialog');
				echo CHtml::Button('...',
									  array('onclick'=>'$("#ownership_dialog").dialog("open"); return false;',
								   ))?>		
					<?php echo $form->error($model,'productid'); ?>
				</div>
			</td>
			<td>
				<div class="row">
				<?php echo $form->labelEx($model,'materialstatusid'); ?>
				<?php echo $form->hiddenField($model,'materialstatusid'); ?>
				  <input type="text" name="materialstatusname" id="materialstatusname" title="Account name" readonly >
				<?php
				  $this->beginWidget('zii.widgets.jui.CJuiDialog',
				   array(   'id'=>'materialstatus_dialog',
							// additional javascript options for the dialog plugin
							'options'=>array(
											'title'=>Yii::t('app','Material Status'),
											'width'=>'auto',
											'autoOpen'=>false,
											'modal'=>true,
											),
									));

				$this->widget('zii.widgets.grid.CGridView', array(
				  'id'=>'materialstatus-grid',
				  'dataProvider'=>$materialstatus->Searchwstatus(),
				  'filter'=>$materialstatus,
				  'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
				  'columns'=>array(
					array(
					  'header'=>'',
					  'type'=>'raw',
					/* Here is The Button that will send the Data to The MAIN FORM */
					  'value'=>'CHtml::Button("+",
					  array("name" => "send_absschedule",
					  "id" => "send_absschedule",
					  "onClick" => "$(\"#materialstatus_dialog\").dialog(\"close\"); $(\"#materialstatusname\").val(\"$data->materialstatusname\"); 
					  $(\"#Bsdetail_materialstatusid\").val(\"$data->materialstatusid\");
					  "))',
					  ),
					  array('name'=>'materialstatusid', 'visible'=>false,
        'value'=>'$data->materialstatusid','htmlOptions'=>array('width'=>'1%')),
					'materialstatusname',
					),
				));

				$this->endWidget('zii.widgets.jui.CJuiDialog');
				echo CHtml::Button('...',
									  array('onclick'=>'$("#materialstatus_dialog").dialog("open"); return false;',
								   ))?>		
					<?php echo $form->error($model,'productid'); ?>
				</div>
			</td>
		</tr>
	</table>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('bsheader/writedetail'),
	  array(
	  'success'=>'function(data1)
		{
			var x = eval("(" + data1 + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("detaildatagrid");
			  $("#createdialog1").dialog("close");
			document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
