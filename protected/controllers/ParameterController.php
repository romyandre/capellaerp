<?php

class ParameterController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'parameter';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
      $model=new Parameter;

      if (Yii::app()->request->isAjaxRequest)
      {
        echo CJSON::encode(array(
            'status'=>'success',
            ));
        Yii::app()->end();
      };
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
	  parent::actionUpdate();
	  $model=$this->loadModel($_POST['id']);
      if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $_POST['id']) == false)
        {
          $this->InsertLock($this->menuname, $_POST['id']);
            echo CJSON::encode(array(
                'status'=>'success',
				'parameterid'=>$model->parameterid,
				'paramname'=>$model->paramname,
				'paramvalue'=>$model->paramvalue,
				'description'=>$model->description,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
	  $this->DeleteLockCloseForm($this->menuname, $_POST['Parameter'], $_POST['Parameter']['parameterid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Parameter']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Parameter']['paramname'],'emptyparamname','emptystring'),
            array($_POST['Parameter']['paramvalue'],'emptyparamvalue','emptystring'),
            array($_POST['Parameter']['description'],'emptydescription','emptystring'),
            )
        );
        if ($messages == '') {
          if ((int)$_POST['Parameter']['parameterid'] > 0)
          {
            $model=$this->loadModel($_POST['Parameter']['parameterid']);
			$this->olddata = $model->attributes;
			$this->useraction='update';
            $model->paramname = $_POST['Parameter']['paramname'];
            $model->paramvalue = $_POST['Parameter']['paramvalue'];
            $model->description = $_POST['Parameter']['description'];
            $model->recordstatus = $_POST['Parameter']['recordstatus'];
          }
          else
          {
            $model = new Parameter();
            $model->attributes=$_POST['Parameter'];
			$this->olddata = $model->attributes;
			$this->useraction='new';
          }
		  $this->newdata = $model->attributes;
          try
          {
            if($model->save())
            {
				$this->InsertTranslog();
				$this->DeleteLock($this->menuname, $_POST['Parameter']['parameterid']);
              $this->GetSMessage('insertsuccess');
            }
            else
            {
              $this->GetMessage($model->getErrors());
            }
          }
          catch (Exception $e)
          {
            $this->GetMessage($e->getMessage());
          }
        }
	  }
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
	  parent::actionDelete();
		$model=$this->loadModel($_POST['id']);
		  $model->recordstatus=0;
		  $model->save();
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}
	
	protected function gridData($data,$row)
  {     
    $model = Parameter::model()->findByPk($data->parameterid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
		$model=new Parameter('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Parameter']))
			$model->attributes=$_GET['Parameter'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}
		$this->render('index',array(
			'model'=>$model,
		));
	}

  public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select paramname,description,paramvalue
				from parameter a ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.parameterid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Parameter List';
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C');
		$this->pdf->setwidths(array(40,70,70));
		$this->pdf->colheader = array('Parameter Name','Description','Parameter Value');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['paramname'],$row1['description'],$row1['paramvalue']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Parameter::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='parameter-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
