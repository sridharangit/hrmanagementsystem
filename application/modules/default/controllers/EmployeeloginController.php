<?php
/********************************************************************************* 
 *  This file is part of Sentrifugo.
 *  Copyright (C) 2015 Sapplica
 *   
 *  Sentrifugo is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Sentrifugo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Sentrifugo.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  Sentrifugo Support <support@sentrifugo.com>
 ********************************************************************************/
class Default_EmployeeloginController extends Zend_Controller_Action
{
	private $options;
	public function preDispatch()
	{
		$auth = Zend_Auth::getInstance();
        if(!$auth->hasIdentity())
            $this->_redirect('default');
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
	}
	
    public function init()
    {
		$this->_options= $this->getInvokeArg('bootstrap')->getOptions();
    }

	public function indexAction()
	{
		$auth = Zend_Auth::getInstance();
		$loginUserId = $auth->getStorage()->read()->id;
		$Username    = $auth->getStorage()->read()->userfullname;
		$login_value = $this->getRequest()->getParam('login_value');
		$updateid    = $this->getRequest()->getParam('updateid');

		$Employeelogin_model = new Default_Model_Employeelogin();
		$date                = new Zend_Date();

		if($login_value==1)
		{
			$data = array(
				'login_id'    => $loginUserId,
				'createdby'   => $loginUserId,
				'emp_name'    => $Username,
				'check_in'    => date("H:i:s"),
				'c_date'      => date("Y-m-d"),
				'createddate' => date("Y-m-d H:i:s")
			);
			$id = $Employeelogin_model->SaveorUpdateEmployeelogin($data,"");
			if($id == 'update')
			{
				$messages['message'] = 'Asset has deleted successfully.';
				$messages['msgtype'] = 'success';
			}
			else
			{
				$messages['message'] = 'Check In Successfully.';
				$messages['msgtype'] = 'success';
			}
		}
		elseif ($login_value==2)
		{
			$data = array(
				'login_id'     => $loginUserId,
				'modifiedby'   => $loginUserId,
				'check_out'    => date("H:i:s"),
				'modifieddate' => date("Y-m-d H:i:s")
			);
			if($updateid!=""){
				$where = array("id=?"=>$updateid);  
			}
			$id = $Employeelogin_model->SaveorUpdateEmployeelogin($data,$where);
			if($id == 'update')
			{
				$messages['message'] = 'Check Out Successfully';
				$messages['msgtype'] = 'success';
			}
			else
			{
				$messages['message'] = 'Asset cannot be deleted.';
				$messages['msgtype'] = 'success';
			}
		}
	}

	public function addAction()
	{
		$auth = Zend_Auth::getInstance();
		$loginUserId = $auth->getStorage()->read()->id;
		$Username    = $auth->getStorage()->read()->userfullname;
		// $login_value = $this->getRequest()->getParam('login_value');
		// $updateid    = $this->getRequest()->getParam('updateid');

		$last_checkid    = $this->getRequest()->getParam('last_checkid');
		$reason_value    = $this->getRequest()->getParam('reason_value');
		$reason_comments = $this->getRequest()->getParam('reason_comments');

		$Employeelogin_model = new Default_Model_Employeelogin();
		$date                = new Zend_Date();

		$data_update = array(
			'modifiedby'      => $loginUserId,
			'reason_value'    => $reson_value,
			'reason_comment'  => $reason_comments,
			'check_out'       => date("H:i:s"),
			'modifieddate'    => date("Y-m-d H:i:s")
		);
		if($last_checkid!=''){
			$where_update = array("id=?"=>$last_checkid);
		}
		$Employeelogin_model->SaveorUpdateEmployeelogin($data_update,$where_update);

		$data = array(
			'login_id'    => $loginUserId,
			'createdby'   => $loginUserId,
			'emp_name'    => $Username,
			'check_in'    => date("H:i:s"),
			'c_date'      => date("Y-m-d"),
			'createddate' => date("Y-m-d H:i:s")
		);
		$id = $Employeelogin_model->SaveorUpdateEmployeelogin($data,"");
		if($id == 'update')
		{
			$messages['message'] = 'updated successfully.';
			$messages['msgtype'] = 'success';
		}
		else
		{
			$messages['message'] = 'Check In Successfully.';
			$messages['msgtype'] = 'success';
		}
	}

}//end of class