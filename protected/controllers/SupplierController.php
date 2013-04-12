<?php

class SupplierController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'supplier';

	public $supplieraddress,$suppliercontact,$accpiutang;

		public function lookupdata()
	{
		$this->supplieraddress=new Supplieraddress('search');
	  $this->supplieraddress->unsetAttributes();  // clear any default values
	  if(isset($_GET['Supplieraddress']))
		$this->supplieraddress->attributes=$_GET['Supplieraddress'];

		$this->suppliercontact=new Suppliercontact('search');
	  $this->suppliercontact->unsetAttributes();  // clear any default values
	  if(isset($_GET['Suppliercontact']))
		$this->suppliercontact->attributes=$_GET['Suppliercontact'];

      $this->accpiutang=new Account('search');
	  $this->accpiutang->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
		$this->accpiutang->attributes=$_GET['Account'];

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
		$this->lookupdata();
		$model=new Supplier;
		$model->fullname='suppliername';
		$model->isvendor=1;
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

		$supplieraddress=new Supplieraddress;

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

		$suppliercontact=new Suppliercontact;

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
              'accpiutangid'=>$model->accpiutangid,
              'accountno'=>($model->accpiutang!==null)?$model->accpiutang->accountname:"",
			  ));
		  Yii::app()->end();
        }
	  }
	}

	public function actionUpdateaddress()
	{
	  $supplieraddress=$this->loadModeladdress($_POST['id']);

	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'addressid'=>$supplieraddress->addressid,
			'addressbookid'=>$supplieraddress->addressbookid,
			'fullname'=>($supplieraddress->addressbook!==null)?$supplieraddress->addressbook->fullname:"",
			'addresstypeid'=>$supplieraddress->addresstypeid,
			'addresstypename'=>($supplieraddress->addresstype!==null)?$supplieraddress->addresstype->addresstypename:"",
			'addressname'=>$supplieraddress->addressname,
			'rt'=>$supplieraddress->rt,
			'rw'=>$supplieraddress->rw,
			'cityid'=>$supplieraddress->cityid,
			'cityname'=>$supplieraddress->city->cityname,
			'kelurahanid'=>$supplieraddress->kelurahanid,
			'kelurahanname'=>($supplieraddress->kelurahan!==null)?$supplieraddress->kelurahan->kelurahanname:"",
			'subdistrictid'=>$supplieraddress->subdistrictid,
			'subdistrictname'=>($supplieraddress->subdistrict!==null)?$supplieraddress->subdistrict->subdistrictname:"",
              'phoneno'=>$supplieraddress->phoneno,
              'faxno'=>$supplieraddress->faxno,
			  ));
		  Yii::app()->end();
	  }
	}

	public function actionUpdatecontact()
	{
	  $id=$_POST['id'];
	  $suppliercontact=$this->loadModelcontact($id[0]);

	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'addresscontactid'=>$suppliercontact->addresscontactid,
			'addressbookid'=>$suppliercontact->addressbookid,
			'fullname'=>$suppliercontact->addressbook->fullname,
			'contacttypeid'=>$suppliercontact->contacttypeid,
			'contacttypename'=>$suppliercontact->contacttype->contacttypename,
			'addresscontactname'=>$suppliercontact->addresscontactname,
              'phoneno'=>$suppliercontact->phoneno,
              'mobilephone'=>$suppliercontact->mobilephone,
              'emailaddress'=>$suppliercontact->emailaddress,
			  ));
		  Yii::app()->end();
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Supplier'], $_POST['Supplier']['addressbookid']);
    }

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Supplier']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Supplier']['fullname'],'emptyfullname','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Supplier']['addressbookid'] > 0)
		{
		  $model=$this->loadModel($_POST['Supplier']['addressbookid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->fullname = $_POST['Supplier']['fullname'];
		  $model->taxno = $_POST['Supplier']['taxno'];
		  $model->accpiutangid = $_POST['Supplier']['accpiutangid'];
		  $model->fullname = $_POST['Supplier']['fullname'];
		  $model->recordstatus = $_POST['Supplier']['recordstatus'];
		}
		else
		{
		  $model = new Supplier();
		  $model->issupplier = 1;
		  $model->attributes=$_POST['Supplier'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Supplier']['addressbookid']);
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
	  if(isset($_POST['Supplieraddress']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Supplieraddress']['addresstypeid'],'mmpremptyaddresstypeid','emptystring'),
                array($_POST['Supplieraddress']['addressname'],'mmpremptyaddressname','emptystring'),
                array($_POST['Supplieraddress']['cityid'],'mmpremptycityid','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Supplieraddress']['addressid'] > 0)
		{
		  $model=Supplieraddress::model()->findbyPK($_POST['Supplieraddress']['addressid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->addressbookid = $_POST['Supplieraddress']['addressbookid'];
		  $model->addresstypeid = $_POST['Supplieraddress']['addresstypeid'];
		  $model->addressname = $_POST['Supplieraddress']['addressname'];
		  $model->rt = $_POST['Supplieraddress']['rt'];
		  $model->rw = $_POST['Supplieraddress']['rw'];
		  $model->cityid = $_POST['Supplieraddress']['cityid'];
		  $model->kelurahanid = $_POST['Supplieraddress']['kelurahanid'];
		  $model->subdistrictid = $_POST['Supplieraddress']['subdistrictid'];
		  $model->phoneno = $_POST['Supplieraddress']['phoneno'];
		  $model->faxno = $_POST['Supplieraddress']['faxno'];
		}
		else
		{
		  $model = new Supplieraddress();
		  $model->attributes=$_POST['Supplieraddress'];
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
	  if(isset($_POST['Suppliercontact']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Suppliercontact']['contacttypeid'],'mmpremptycontacttypeid','emptystring'),
                array($_POST['Suppliercontact']['addresscontactname'],'mmpremptyaddresscontactname','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Suppliercontact']['addresscontactid'] > 0)
		{
		  $model=Suppliercontact::model()->findbyPK($_POST['Suppliercontact']['addresscontactid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->addressbookid = $_POST['Suppliercontact']['addressbookid'];
		  $model->contacttypeid = $_POST['Suppliercontact']['contacttypeid'];
		  $model->addresscontactname = $_POST['Suppliercontact']['addresscontactname'];
		  $model->phoneno = $_POST['Suppliercontact']['phoneno'];
		  $model->mobilephone = $_POST['Suppliercontact']['mobilephone'];
		  $model->emailaddress = $_POST['Suppliercontact']['emailaddress'];
		}
		else
		{
		  $model = new Suppliercontact();
		  $model->attributes=$_POST['Suppliercontact'];
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
    $model = Supplier::model()->findByPk($data->addressbookid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	protected function gridAddress($data,$row)
  {     
    $model = Supplieraddress::model()->findByPk($data->addressid); 
    return $this->renderPartial('_viewaddress',array('model'=>$model),true); 
  }
  
  protected function gridContact($data,$row)
  {     
    $model = Suppliercontact::model()->findByPk($data->addresscontactid); 
    return $this->renderPartial('_viewcontact',array('model'=>$model),true); 
  }
  
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		parent::actionIndex();
		$this->lookupdata();
	  $model=new Supplier('searchwstatus');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Supplier']))
		  $model->attributes=$_GET['Supplier'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		  'model'=>$model,
		  'supplieraddress'=>$this->supplieraddress,
		  'suppliercontact'=>$this->suppliercontact,
                    'accpiutang'=>$this->accpiutang
	  ));
	}

	public function actionIndexaddress()
	{
		$this->lookupdata();
	  $this->renderPartial('indexaddress',
		array('supplieraddress'=>$this->supplieraddress));
	  Yii::app()->end();
	}

	public function actionIndexcontact()
	{
		$this->lookupdata();
	  $this->renderPartial('indexcontact',
		array('suppliercontact'=>$this->suppliercontact));
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

		$this->pdf->title='Supplier List';
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
		$model=Supplier::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeladdress($id)
	{
		$model=Supplieraddress::model()->findByPk((int)$id);
		//if($model===null)
		//	throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelcontact($id)
	{
		$model=Suppliercontact::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='Supplier-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
