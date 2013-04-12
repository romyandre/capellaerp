<?php

class IdentitytypeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'identitytype';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
		$model=new Identitytype;

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
				'identitytypeid'=>$model->identitytypeid,
				'identitytypename'=>$model->identitytypename,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Identitytype'], $_POST['Identitytype']['identitytypeid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Identitytype']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Identitytype']['identitytypename'],'emptyidentitytypename','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Identitytype'];
		if ((int)$_POST['Identitytype']['identitytypeid'] > 0)
		{
		  $model=$this->loadModel($_POST['Identitytype']['identitytypeid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->identitytypename = $_POST['Identitytype']['identitytypename'];
		  $model->recordstatus = $_POST['Identitytype']['recordstatus'];
		}
		else
		{
		  $model = new Identitytype();
		  $model->attributes=$_POST['Identitytype'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Identitytype']['identitytypeid']);
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
    $model = Identitytype::model()->findByPk($data->identitytypeid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
    $model=new Identitytype('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Identitytype']))
			$model->attributes=$_GET['Identitytype'];
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
				from company a  ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.identitytypeid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Identity Type';
		$this->pdf->AddPage('P');

		$this->pdf->colalign=array('C','C','C','C','C','C');
		$this->pdf->setwidths(array(40,60,20,20,20,20));
		$this->pdf->colheader =array('Identity Type Name');
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['identitytypename']));
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
		$model=Identitytype::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='identitytype-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
