<?php

class TranslogController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	protected $menuname = 'translog';
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
	parent::actionDelete();
		  $model=$this->loadModel($_POST['id']);
		  $model->delete();
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}
	
	public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select *
				from translog a ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.translogid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Transaction Log List';
		$this->pdf->AddPage('P');

		$this->pdf->colalign=array('C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(20,20,50,50,30,20,30));
		$this->pdf->colheader=array('User Name','User Action','New Data','Old Data','Menu Name','Created Date');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign=array('L','L','L','L','L','L','L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['username'],$row1['useraction'],$row1['newdata'],
			$row1['olddata'],$row1['menuname'],$row1['createddate']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	
	protected function gridData($data,$row)
  {     
    $model = Translog::model()->findByPk($data->translogid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	parent::actionIndex();
    $model=new Translog('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Translog']))
			$model->attributes=$_GET['Translog'];
			if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Translog::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='translog-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
