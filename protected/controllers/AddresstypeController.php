<?php

class AddresstypeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	protected $menuname = 'addresstype';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $model=new Addresstype;

	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  ));
		  Yii::app()->end();
	  }
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
			  'addresstypeid'=>$model->addresstypeid,
			  'addresstypename'=>$model->addresstypename,
			  'recordstatus'=>$model->recordstatus,
			  ));
		  Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
	  if(isset($_POST['Addresstype']))
	  {
        if ((int)$_POST['Addresstype']['addresstypeid'] > 0)
        {
          $this->Deletelock($this->menuname,$_POST['Addresstype']['addresstypeid']);
          echo CJSON::encode(array(
                'status'=>'success',
				));
            Yii::app()->end();
        }
      }
    }

	public function actionWrite()
	{
	  if(isset($_POST['Addresstype']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Addresstype']['addresstypename'],'emptyaddresstypename','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Addresstype'];
		if ((int)$_POST['Addresstype']['addresstypeid'] > 0)
		{
		  $model=$this->loadModel($_POST['Addresstype']['addresstypeid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->addresstypename = $_POST['Addresstype']['addresstypename'];
		  $model->recordstatus = $_POST['Addresstype']['recordstatus'];
		}
		else
		{
		  $model = new Addresstype();
		  $model->attributes=$_POST['Addresstype'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Addresstype']['addresstypeid']);
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  $model=new Addresstype('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Addresstype']))
		  $model->attributes=$_GET['Addresstype'];
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
	  $sql = "select *
				from addresstype a ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.addresstypeid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Address Type List';
		$this->pdf->AddPage('P');

		$this->pdf->colalign = array('C');
		$this->pdf->setwidths(array(90));
		$this->pdf->colheader = array('Address Type Name');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['addresstypename']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	
	protected function gridData($data,$row)
  {     
    $model = Addresstype::model()->findByPk($data->addresstypeid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Addresstype::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='addresstype-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
