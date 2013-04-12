<?php

class AddressbookController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'addressbook';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $model=new Addressbook;
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
			'addressbookid'=>$model->addressbookid,
			'fullname'=>$model->fullname,
			'iscustomer'=>$model->iscustomer,
			'isemployee'=>$model->isemployee,
			'isapplicant'=>$model->isapplicant,
			'isvendor'=>$model->isvendor,
			'isinsurance'=>$model->isinsurance,
			'isbank'=>$model->isbank,
			'ishospital'=>$model->ishospital,
			'iscatering'=>$model->iscatering,
			'recordstatus'=>$model->recordstatus,
            'taxno'=>$model->taxno,
            'abno'=>$model->abno,
            'accpiutangid'=>$model->accpiutangid,
            'acchutangid'=>$model->acchutangid,
			));
		Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Addressbook'], $_POST['Addressbook']['addressbookid']);
    }


	public function actionWrite()
	{
	  if(isset($_POST['Addressbook']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Addressbook']['fullname'],'emptyfullname','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Addressbook'];
		if ((int)$_POST['Addressbook']['addressbookid'] > 0)
		{
		  $model=$this->loadModel($_POST['Addressbook']['addressbookid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->fullname = $_POST['Addressbook']['fullname'];
		  $model->iscustomer = $_POST['Addressbook']['iscustomer'];
		  $model->isemployee = $_POST['Addressbook']['isemployee'];
		  $model->isapplicant = $_POST['Addressbook']['isapplicant'];
		  $model->isvendor = $_POST['Addressbook']['isvendor'];
		  $model->isinsurance = $_POST['Addressbook']['isinsurance'];
		  $model->isbank = $_POST['Addressbook']['isbank'];
		  $model->ishospital = $_POST['Addressbook']['ishospital'];
		  $model->iscatering = $_POST['Addressbook']['iscatering'];
		  $model->recordstatus = $_POST['Addressbook']['recordstatus'];
		}
		else
		{
		  $model = new Addressbook();
		  $model->attributes=$_POST['Addressbook'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Addressbook']['addressbookid']);
              $this->GetSMessage('coabinsertsuccess');
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
    $model = Addressbook::model()->findByPk($data->addressbookid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  $model=new Addressbook('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Addressbook']))
			$model->attributes=$_GET['Addressbook'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		'model'=>$model
	  ));
	}

	public function actionDownload()
  {
  parent::actionDownload();
     $sql = "select *
				from addressbook a  ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.addressbookid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Address Book';
		$this->pdf->AddPage('P');

		$this->pdf->colalign=array('C','C','C','C','C','C');
		$this->pdf->setwidths(array(60,20,20,20,20,20,20,20,20));
		$this->pdf->colheader =array('Full Name','Is Customer','Is Employee','Is Applicant','Is Vendor','Is Insurance');
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['fullname'],($row1['iscustomer']=='1')?'V':'',($row1['isemployee']=='1')?'V':'',
		  ($row1['isapplicant']=='1')?'V':'',($row1['isvendor']=='1')?'V':'',($row1['isinsurance']=='1')?'V':''));
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
		$model=Addressbook::model()->findByPk((int)$id);
		//if($model===null)
		//	throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='addressbook-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
