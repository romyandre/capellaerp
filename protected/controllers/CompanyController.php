<?php

class CompanyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	protected $menuname = 'company';
    public $currency;

	public function lookupdata()
	{
	  $this->currency=new Currency('searchwstatus');
	  $this->currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$this->currency->attributes=$_GET['Currency'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
      parent::actionCreate();
      $this->lookupdata();
      $model=new Company;

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
      $this->lookupdata();
	  $model=$this->loadModel($_POST['id']);
      if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $_POST['id']) == false) 
        {
          $this->InsertLock($this->menuname, $_POST['id']);
          echo CJSON::encode(array(
                'status'=>'success',
				'companyid'=>$model->companyid,
				'companyname'=>$model->companyname,
				'address'=>$model->address,
				'city'=>$model->city,
				'zipcode'=>$model->zipcode,
				'taxno'=>$model->taxno,
				'faxno'=>$model->faxno,
				'webaddress'=>$model->webaddress,
				'email'=>$model->email,
				'phoneno'=>$model->phoneno,
                'currencyid'=>$model->currencyid,
                'currencyname'=>($model->currency!==null)?$model->currency->currencyname:"",
				'recordstatus'=>$model->recordstatus,
				'leftlogofile'=>$model->leftlogofile,
				'rightlogofile'=>$model->rightlogofile,
				));
            Yii::app()->end();
        }
      }
	}	

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Company'], $_POST['Company']['companyid']);
    }	

	public function actionWrite()
	{
      parent::actionWrite();
	  if(isset($_POST['Company']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Company']['companyname'],'emptycompanyname','emptystring'),
            array($_POST['Company']['address'],'emptyaddressname','emptystring'),
            array($_POST['Company']['city'],'emptycity','emptystring'),
            array($_POST['Company']['zipcode'],'emptyzipcode','emptystring'),
            array($_POST['Company']['currencyid'],'emptycurrency','emptystring'),
            )
        );
        if ($messages == '') {
          if ((int)$_POST['Company']['companyid'] > 0)
          {
            $model=$this->loadModel($_POST['Company']['companyid']);
			$this->olddata = $model->attributes;
			$this->useraction='update';
            $model->companyname = $_POST['Company']['companyname'];
            $model->address = $_POST['Company']['address'];
            $model->city = $_POST['Company']['city'];
            $model->zipcode = $_POST['Company']['zipcode'];
            $model->taxno = $_POST['Company']['taxno'];
            $model->currencyid = $_POST['Company']['currencyid'];
            $model->recordstatus = $_POST['Company']['recordstatus'];
            $model->faxno = $_POST['Company']['faxno'];
            $model->webaddress = $_POST['Company']['webaddress'];
            $model->phoneno = $_POST['Company']['phoneno'];
            $model->email = $_POST['Company']['email'];
          }
          else
          {
            $model = new Company();
            $model->attributes=$_POST['Company'];
			$this->olddata = $model->attributes;
			$this->useraction='new';
			
          }
		  $this->newdata = $model->attributes;
          try
          {
            if($model->save())
            {
				$this->InsertTranslog();
				$this->DeleteLock($this->menuname, $_POST['Company']['companyid']);
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
    $model = Company::model()->findByPk($data->companyid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		parent::actionIndex();
                $this->lookupdata();
    $model=new Company('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Company']))
			$model->attributes=$_GET['Company'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
                    'currency'=>$this->currency
		));
	}	

	public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select companyname, address, city, zipcode, taxno, b.currencyname,a.faxno,a.phoneno,a.webaddress,a.email,a.taxno,a.leftlogofile,a.rightlogofile
				from company a 
				left join currency b on b.currencyid = a.currencyid ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.companyid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Company';
		$this->pdf->AddPage('L');

		$this->pdf->colalign=array('C','C','C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(40,60,20,20,20,20,25,40,40));
		$this->pdf->colheader =array('Company Name','Address','City','Zip Code','Tax No','Currency','Phone No','Email','Web Address');
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['companyname'],$row1['address'],$row1['city'],$row1['zipcode']
		  ,$row1['taxno'],$row1['currencyname'],$row1['phoneno'],$row1['email'],$row1['webaddress']));
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
		$model=Company::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='company-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
