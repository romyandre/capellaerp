<?php
$this->breadcrumbs=array(
	'repposummarys',
);
$yearfrom=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultYearFrom']);
$yearto=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultYearTo']);
?>
<script type="text/javascript">
function helpdata(value) {
	jQuery.ajax({
        'url': 'index.php?r=repposummary/help',
        'data': {
            'id': value
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            if (data.status == 'success') {
				document.getElementById('divhelp').innerHTML = data.div;
                $('#helpdialog').dialog('open');
            } else {
                document.getElementById('messages').innerHTML = data.div;
            }
        },
        'cache': false
    });;
    return false;
}
</script>
<script type="text/javascript">
function showdetail() {
    $.fn.yiiGridView.update('datagrid', {
                    data: {
                        'repposummary[accountid]': $('#accountid').val()
                    }
                });
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'helpdialog',
    'options'=>array(
        'title'=>'Help',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divhelp"></div>
<?php $this->endWidget();?>
<h1>Report: PO Summary</h1>
<div id="toolbar">
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(1)}",
   'title'=>Yii::t('app','help')
));?></div>
<form action="index.php?r=repposummary/index" method="POST">
Date : <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'startperiod',
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeYear'=>true,
				  'changeMonth'=>true
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
- <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'endperiod',
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeYear'=>true,
				  'changeMonth'=>true
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
<br/>
Header Note: <input type="text" name="headernote" id="headernote" >
<br/>
Item Note: <input type="text" name="itemtext" id="itemtext" >
<br/><button name="submit" type="submit">Submit</button>
</form>


