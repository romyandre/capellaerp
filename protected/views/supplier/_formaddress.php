<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'address-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php echo $form->hiddenField($model,'addressid'); ?>
<?php echo $form->hiddenField($model,'addressbookid'); ?>
	<div id="tabledata">
    <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'addresstypeid'); ?>
<?php echo $form->hiddenField($model,'addresstypeid'); ?></span>
         <span class="cell"> <input type="text" name="addresstype_name" id="addresstype_name" readonly >
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'addresstype_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Address Type'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));
$addresstype = new Addresstype('searchwstatus');
	  $addresstype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Addresstype']))
		$addresstype->attributes=$_GET['Addresstype'];
          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'addresstype-grid',
            'dataProvider'=>$addresstype->Searchwstatus(),
            'filter'=>$addresstype,
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
                "onClick" => "$(\"#addresstype_dialog\").dialog(\"close\"); $(\"#addresstype_name\").val(\"$data->addresstypename\"); $(\"#Supplieraddress_addresstypeid\").val(\"$data->addresstypeid\");"))',
                ),
              'addresstypeid',
              'addresstypename',
              ),
          ));

          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#addresstype_dialog").dialog("open"); return false;',
                             ));?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'addressname'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'addressname',array('size'=>50,'maxlength'=>50)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'rt'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'rt',array('size'=>5,'maxlength'=>5)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'rw'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'rw',array('size'=>5,'maxlength'=>5)); ?></span>
	</div>
	
	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'cityid'); ?>
    <?php echo $form->hiddenField($model,'cityid'); ?></span>
        <span class="cell">  <input type="text" name="city_name" id="city_name" readonly >
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'city_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','City'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));
$city = new City('searchwstatus');
	  $city->unsetAttributes();  // clear any default values
	  if(isset($_GET['City']))
		$city->attributes=$_GET['City'];
          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'city-grid',
            'dataProvider'=>$city->Searchwstatus(),
            'filter'=>$city,
				'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("V",
                array("name" => "send_city",
                "id" => "send_city",
                "onClick" => "$(\"#city_dialog\").dialog(\"close\"); $(\"#city_name\").val(\"$data->cityname\"); $(\"#Supplieraddress_cityid\").val(\"$data->cityid\");"))',
                ),
              'cityid',
              'cityname',
              ),
          ));

          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#city_dialog").dialog("open"); return false;',
                             ));?></span>
	</div>
	
	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'kelurahanid'); ?>
<?php echo $form->hiddenField($model,'kelurahanid'); ?></span>
         <span class="cell"> <input type="text" name="kelurahan_name" id="kelurahan_name" readonly >
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'kelurahan_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Sub Subdistrict'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));
$kelurahan = new Kelurahan('searchwstatus');
	  $kelurahan->unsetAttributes();  // clear any default values
	  if(isset($_GET['Kelurahan']))
		$kelurahan->attributes=$_GET['Kelurahan'];
          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'kelurahan-grid',
            'dataProvider'=>$kelurahan->Searchwstatus(),
            'filter'=>$kelurahan,
				'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("V",
                array("name" => "send_kelurahan",
                "id" => "send_kelurahan",
                "onClick" => "$(\"#kelurahan_dialog\").dialog(\"close\"); $(\"#kelurahan_name\").val(\"$data->kelurahanname\"); $(\"#Supplieraddress_kelurahanid\").val(\"$data->kelurahanid\");"))',
                ),
              'kelurahanid',
              'kelurahanname',
              ),
          ));

          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#kelurahan_dialog").dialog("open"); return false;',
                             ));?></span>
	</div>
	
	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'subdistrictid'); ?>
<?php echo $form->hiddenField($model,'subdistrictid'); ?></span>
         <span class="cell"> <input type="text" name="subdistrict_name" id="subdistrict_name" readonly >
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
$subdistrict = new Subdistrict('searchwstatus');
	  $subdistrict->unsetAttributes();  // clear any default values
	  if(isset($_GET['Subdistrict']))
		$subdistrict->attributes=$_GET['Subdistrict'];
          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'subdistrict-grid',
            'dataProvider'=>$subdistrict->Searchwstatus(),
            'filter'=>$subdistrict,
				'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("V",
                array("name" => "send_subdistrict",
                "id" => "send_subdistrict",
                "onClick" => "$(\"#subdistrict_dialog\").dialog(\"close\"); $(\"#subdistrict_name\").val(\"$data->subdistrictname\"); $(\"#Supplieraddress_subdistrictid\").val(\"$data->subdistrictid\");"))',
                ),
              'subdistrictid',
              'subdistrictname',
              ),
          ));

          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#subdistrict_dialog").dialog("open"); return false;',
                             ));?></span>
	</div>

    	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'phoneno'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'phoneno'); ?></span>
	</div>

	    	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'faxno'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'faxno'); ?></span>
	</div>

	
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('supplier/writeaddress'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
				$.fn.yiiGridView.update("addressdatagrid");
				$("#createdialog1").dialog("close");
				toastr.info(x.div);
			}
			else
			{
				toastr.error(x.div);
			}
        }')); ?><?php echo CHtml::ajaxSubmitButton('Cancel',
		array('supplier/cancelwriteaddress'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
				$.fn.yiiGridView.update("addressdatagrid");			  
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
