<?php

class CustomerController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'customer';

	public $customeraddress,$customercontact,$acchutang;

		public function lookupdata()
	{
		$this->customeraddress=new Customeraddress('search');
	  $this->customeraddress->unsetAttributes();  // clear any default values
	  if(isset($_GET['Customeraddress']))
		$this->customeraddress->attributes=$_GET['Customeraddress'];

		$this->customercontact=new Customercontact('search');
	  $this->customercontact->unsetAttributes();  // clear any default values
	  if(isset($_GET['Customercontact']))
		$this->customercontact->attributes=$_GET['Customercontact'];

      $this->acchutang=new Account('search');
	  $this->acchutang->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
		$this->acchutang->attributes=$_GET['Account'];

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
		$this->lookupdata();
		$model=new Customer;
		$model->fullname='customername';
		$model->iscustomer=1;
		$model->recordstatus=0;
		if (Yii::app()->request->isAjaxRequest)
        {
        if ($model->save()) {
            echo CJSON::encode(array(
                'status'=>'success',
                'addressbookid'=>$model->addressbookid,
				));
            Yii::app()->end();
        }
        }
	}

	public function actionCreateaddress()
	{
		parent::actionCreate();
		$this->lookupdata();

		$customeraddress=new Customeraddress;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				));
            Yii::app()->end();
        }
	}

	public function actionCreatecontact()
	{
		parent::actionCreate();
		$this->lookupdata();

		$customercontact=new Customercontact;

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
		$this->lookupdata();
	  if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $_POST['id']) == false)
        {
          $this->InsertLock($this->menuname, $_POST['id']);
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'addressbookid'=>$model->addressbookid,
			  'fullname'=>$model->fullname,
			  'taxno'=>$model->taxno,
			  'recordstatus'=>$model->recordstatus,
              'acchutangid'=>$model->acchutangid,
              'accountno'=>($model->acchutang!==null)?$model->acchutang->accountname:"",
			  ));
		  Yii::app()->end();
        }
	  }
	}

	public function actionUpdateaddress()
	{
	  $customeraddress=$this->loadModeladdress($_POST['id']);

	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'addressid'=>$customeraddress->addressid,
			'addressbookid'=>$customeraddress->addressbookid,
			'fullname'=>($customeraddress->addressbook!==null)?$customeraddress->addressbook->fullname:"",
			'addresstypeid'=>$customeraddress->addresstypeid,
			'addresstypename'=>($customeraddress->addresstype!==null)?$customeraddress->addresstype->addresstypename:"",
			'addressname'=>$customeraddress->addressname,
			'rt'=>$customeraddress->rt,
			'rw'=>$customeraddress->rw,
			'cityid'=>$customeraddress->cityid,
			'cityname'=>$customeraddress->city->cityname,
			'kelurahanid'=>$customeraddress->kelurahanid,
			'kelurahanname'=>($customeraddress->kelurahan!==null)?$customeraddress->kelurahan->kelurahanname:"",
			'subdistrictid'=>$customeraddress->subdistrictid,
			'subdistrictname'=>($customeraddress->subdistrict!==null)?$customeraddress->subdistrict->subdistrictname:"",
              'phoneno'=>$customeraddress->phoneno,
              'faxno'=>$customeraddress->faxno,
			  ));
		  Yii::app()->end();
	  }
	}

	public function actionUpdatecontact()
	{
	  $id=$_POST['id'];
	  $customercontact=$this->loadModelcontact($id[0]);

	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'addresscontactid'=>$customercontact->addresscontactid,
			'addressbookid'=>$customercontact->addressbookid,
			'fullname'=>$customercontact->addressbook->fullname,
			'contacttypeid'=>$customercontact->contacttypeid,
			'contacttypename'=>$customercontact->contacttype->contacttypename,
			'addresscontactname'=>$customercontact->addresscontactname,
              'phoneno'=>$customercontact->phoneno,
              'mobilephone'=>$customercontact->mobilephone,
              'emailaddress'=>$customercontact->emailaddress,
			  ));
		  Yii::app()->end();
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Customer'], $_POST['Customer']['addressbookid']);
    }

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Customer']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Customer']['fullname'],'emptyfullname','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Customer']['addressbookid'] > 0)
		{
		  $model=$this->loadModel($_POST['Customer']['addressbookid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->fullname = $_POST['Customer']['fullname'];
		  $model->taxno = $_POST['Customer']['taxno'];
		  $model->acchutangid = $_POST['Customer']['acchutangid'];
		  $model->fullname = $_POST['Customer']['fullname'];
		  $model->recordstatus = $_POST['Customer']['recordstatus'];
		}
		else
		{
		  $model = new Customer();
		  $model->iscustomer = 1;
		  $model->attributes=$_POST['Customer'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Customer']['addressbookid']);
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

	public function actionWriteaddress()
	{
		parent::actionWrite();
	  if(isset($_POST['Customeraddress']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Customeraddress']['addresstypeid'],'mmpremptyaddresstypeid','emptystring'),
                array($_POST['Customeraddress']['addressname'],'mmpremptyaddressname','emptystring'),
                array($_POST['Customeraddress']['cityid'],'mmpremptycityid','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Customeraddress']['addressid'] > 0)
		{
		  $model=Customeraddress::model()->findbyPK($_POST['Customeraddress']['addressid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->addressbookid = $_POST['Customeraddress']['addressbookid'];
		  $model->addresstypeid = $_POST['Customeraddress']['addresstypeid'];
		  $model->addressname = $_POST['Customeraddress']['addressname'];
		  $model->rt = $_POST['Customeraddress']['rt'];
		  $model->rw = $_POST['Customeraddress']['rw'];
		  $model->cityid = $_POST['Customeraddress']['cityid'];
		  $model->kelurahanid = $_POST['Customeraddress']['kelurahanid'];
		  $model->subdistrictid = $_POST['Customeraddress']['subdistrictid'];
		  $model->phoneno = $_POST['Customeraddress']['phoneno'];
		  $model->faxno = $_POST['Customeraddress']['faxno'];
		}
		else
		{
		  $model = new Customeraddress();
		  $model->attributes=$_POST['Customeraddress'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
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

	public function actionWritecontact()
	{
		parent::actionWrite();
	  if(isset($_POST['Customercontact']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Customercontact']['contacttypeid'],'mmpremptycontacttypeid','emptystring'),
                array($_POST['Customercontact']['addresscontactname'],'mmpremptyaddresscontactname','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Customercontact']['addresscontactid'] > 0)
		{
		  $model=Customercontact::model()->findbyPK($_POST['Customercontact']['addresscontactid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->addressbookid = $_POST['Customercontact']['addressbookid'];
		  $model->contacttypeid = $_POST['Customercontact']['contacttypeid'];
		  $model->addresscontactname = $_POST['Customercontact']['addresscontactname'];
		  $model->phoneno = $_POST['Customercontact']['phoneno'];
		  $model->mobilephone = $_POST['Customercontact']['mobilephone'];
		  $model->emailaddress = $_POST['Customercontact']['emailaddress'];
		}
		else
		{
		  $model = new Customercontact();
		  $model->attributes=$_POST['Customercontact'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
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

	public function actionDeleteaddress()
	{
		$model=$this->loadModel($_POST['id']);
		  $model->delete();
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}

	public function actionDeletecontact()
	{
		$model=$this->loadModel($_POST['id']);
		  $model->delete();
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}
	
	protected function gridData($data,$row)
  {     
    $model = Customer::model()->findByPk($data->addressbookid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	protected function gridAddress($data,$row)
  {     
    $model = Customeraddress::model()->findByPk($data->addressid); 
    return $this->renderPartial('_viewaddress',array('model'=>$model),true); 
  }
  
  protected function gridContact($data,$row)
  {     
    $model = Customercontact::model()->findByPk($data->addresscontactid); 
    return $this->renderPartial('_viewcontact',array('model'=>$model),true); 
  }
  
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		parent::actionIndex();
		$this->lookupdata();
	  $model=new Customer('searchwstatus');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Customer']))
		  $model->attributes=$_GET['Customer'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		  'model'=>$model,
		  'customeraddress'=>$this->customeraddress,
		  'customercontact'=>$this->customercontact,
                    'acchutang'=>$this->acchutang
	  ));
	}

	public function actionIndexaddress()
	{
		$this->lookupdata();
	  $this->renderPartial('indexaddress',
		array('customeraddress'=>$this->customeraddress));
	  Yii::app()->end();
	}

	public function actionIndexcontact()
	{
		$this->lookupdata();
	  $this->renderPartial('indexcontact',
		array('customercontact'=>$this->customercontact));
	  Yii::app()->end();
	}

	public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select a.addressbookid,a.fullname,a.taxno,a.abno,c.accountcode
				from addressbook a 
				left join account c on c.accountid = a.acchutangid
				where isvendor=1 ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "and a.addressbookid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Customer List';
		$this->pdf->AddPage('L');
		// definisi font
		$this->pdf->setFont('Arial','B',8);

		foreach($dataReader as $row)
		{
			$this->pdf->colalign = array('C','C','C');
			$this->pdf->setwidths(array(90,40,30));
			$this->pdf->colheader = array('Name','NPWP','Account Hutang');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L','L','L');
			$this->pdf->row(array($row['fullname'],$row['taxno'],$row['accountcode']));
		  
			$sql1 = "select a.addressname,a.rt,a.rw,b.cityname,c.addresstypename,d.kelurahanname,e.subdistrictname,a.phoneno
				from address a 
				left join city b on b.cityid = a.cityid
				left join addresstype c on c.addresstypeid = a.addresstypeid
				left join kelurahan d on d.kelurahanid = a.kelurahanid
				left join subdistrict e on e.subdistrictid = a.subdistrictid
				where addressbookid= ".$row['addressbookid'];
			$command1=$this->connection->createCommand($sql1);
			$dataReader1=$command1->queryAll();			
			
			$this->pdf->SetY($this->pdf->GetY()+10);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(30,80,20,20,30,30,30,30));
			$this->pdf->colheader = array('Address Type','Address','RT','RW','Sub Subdistrict','Subdistrict','City','Phone No');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L');
			
			foreach($dataReader1 as $row1)
			{
				$this->pdf->row(array($row1['addresstypename'],$row1['addressname'],$row1['rt'],$row1['rw'],
					$row1['kelurahanname'],$row1['subdistrictname'],$row1['cityname'],$row1['phoneno']));
			}
			$this->pdf->AddPage('L');
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
		$model=Customer::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeladdress($id)
	{
		$model=Customeraddress::model()->findByPk((int)$id);
		//if($model===null)
		//	throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelcontact($id)
	{
		$model=Customercontact::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='Customer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
