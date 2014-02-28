<?php
class WarningsController extends AppController {	
	public $helpers = array (
			'Html',
			'Form',
			'Session' 
	);
	public $components = array (
			'Session',
	);
	var $name = 'Warnings';
	var $uses = array (
			'User',
			'Lesson',
			'Warning',
			'File',
			'Test',
			'Report' 
	);
	
	public function testfunc(){
		
	}
	
	public function warningList($WarnedUserID = null) {
		$sql = array (
				'fields' => array (
						'WarnTime',
						'WarnType',
						'Lesson.LessonName',
						'WarnContent' 
				),
				'conditions' => array (
						'WarnedPersonID' => $WarnedUserID 
				) 
		);
		Controller::loadModel ( 'Report' );
		$warnings = $this->Warning->find ( "all", $sql );
		$this->set ( 'warningnum', count ( $warnings ) );
		$this->set ( 'warnings', $warnings );
	}
	public function warnUser($WarnedPersonID = null, $WarnType = null,$WarnedLessonID = null) {
		$warnedperson = $this->User->findById ( $WarnedPersonID );
		$this->set ( 'warnedperson', $warnedperson );
		
		// Check report type to decide to get info from Lesson table or not
		Controller::loadModel ( 'Report' );
		switch ($WarnType) {
			case Report::$_TYPE_LESSON :
			case Report::$_TYPE_FILE :
			case Report::$_TYPE_TEST :
			case Report::$_TYPE_COMMENT :
				$warnedlesson = $this->Lesson->findById ( $WarnedLessonID );
				$this->set ( 'warnedlesson', $warnedlesson );
				break;
			// other type - no need to get info
			default :
				break;
		}
		// Wait the Warn input and save
		$this->set ( 'warntype', $WarnType );
		if ($this->request->is ( 'post' )) {
			$this->Warning->create ();
			if ($data = $this->request->data) {
				$data ['Warning'] ['WarnedLessonID'] = $WarnedLessonID;
				$data ['Warning'] ['WarnedPersonID'] = $WarnedPersonID;
				$data ['Warning'] ['WarnType'] = $WarnType;
				$data ['Warning'] ['WarnTime'] = '';	
				$this->_saveWarning($data,$warnedperson);
			}
			$this->Session->setFlash ( __ ( 'データベースに追加失敗' ) );
		}
	}
	
	//Lock lesson, file or test
	public function lockContent($LockType=null,$LockedObjectID=null){
		Controller::loadModel ( 'Report' );
		switch ($LockType) {
			case Report::$_TYPE_LESSON :
				$lockedobject = $this->Lesson->findById ( $LockedObjectID );
				$warnedperson = $this->User->findById ( $lockedobject['Lesson']['user_id'] );
				break;
			case Report::$_TYPE_FILE :
				$lockedobject = $this->File->findById ( $LockedObjectID );
				$warnedperson = $this->User->findById ( $lockedobject['File']['user_id'] );
				break;
			case Report::$_TYPE_TEST :
				$lockedobject = $this->Test->findById ( $LockedObjectID );
				$warnedperson = $this->User->findById ( $lockedobject['Test']['user_id'] );
				break;
			default :
				break;
		}
		$this->set ( 'lockedobject', $lockedobject );
		$this->set ( 'warnedperson', $warnedperson );
		
		// Wait the Warn input and save
		$this->set ( 'locktype', $LockType );
		if ($this->request->is ( 'post' )) {
			$this->Warning->create ();
			if ($data = $this->request->data) {
				switch ($LockType) {
					case Report::$_TYPE_LESSON :
						$lockedobject['Lesson']['Status']=Lesson::_STATUS_LOCKED;
						if ($this->Lesson->save ( $lockedobject, false )) {
							$this->Session->setFlash ( __ ( '授業ロック！' ) );
						} else
							$this->Session->setFlash ( __ ( 'データベース更新失敗' ) );
						$data ['Warning'] ['WarnedLessonID'] = $lockedobject['Lesson']['id'];
						break;
					case Report::$_TYPE_FILE :
						$lockedobject['File']['Status']=File::_STATUS_LOCKED;
						if ($this->File->save ( $lockedobject, false )) {
							$this->Session->setFlash ( __ ( 'ファイルロック！' ) );
						} else
							$this->Session->setFlash ( __ ( 'データベース更新失敗' ) );
						$data ['Warning'] ['WarnedLessonID'] = $lockedobject['File']['lesson_id'];
						break;
					case Report::$_TYPE_TEST :
						$lockedobject['Test']['Status']=Test::_STATUS_LOCKED;
						if ($this->Test->save ( $lockedobject, false )) {
							$this->Session->setFlash ( __ ( 'テストロック！' ) );
						} else
							$this->Session->setFlash ( __ ( 'データベース更新失敗' ) );
						$data ['Warning'] ['WarnedLessonID'] = $lockedobject['Test']['lesson_id'];
						break;
					default :
						break;
				}
				
				$data ['Warning'] ['WarnedPersonID'] = $warnedperson['User']['id'];
				$data ['Warning'] ['WarnType'] = $LockType;
				$data ['Warning'] ['WarnTime'] = '';
				$this->_saveWarning($data,$warnedperson);
			}
			$this->Session->setFlash ( __ ( 'データベースに追加失敗' ) );
		}
	}
	
	//Save the warning - parameter is the array of new Warning record and the array of the warned user info record
	protected function _saveWarning($data=null,$warnedperson=null)
	{
	if ($this->Warning->save ( $data )) {
			// if success
			$this->Session->setFlash ( __ ( '警告保存' ) );
			// Get the value of the maximum warning times
			Controller::loadModel ( 'SystemParam' );
			$params = $this->SystemParam->find ( "first", array (
					'fields' => array (
							'Value' 
					),
					'conditions' => array (
							'ParamName' => 'MAX_TIME_WARNING' 
					) 
			) );
			$MAX_TIME_WARNING = $params ['SystemParam'] ['Value'];
			// End get the value
			
			// Increase the Warning number, if it reaches the limit, lock him
			$warnedperson ['User'] ['WarnNum'] = $warnedperson ['User'] ['WarnNum'] + 1;
			if ($warnedperson ['User'] ['WarnNum'] >= $MAX_TIME_WARNING)
				$warnedperson ['User'] ['Status'] = User::_STATUS_LOGIN_LOCKED;
			if ($this->User->save ( $warnedperson, false )) {
				if ($warnedperson ['User'] ['WarnNum'] >= $MAX_TIME_WARNING)
					$this->Session->setFlash ( __ ( 'ユーザーの警告は限界を超えて、登録を剥奪!' ) );
			} else
				$this->Session->setFlash ( __ ( 'データベース更新失敗' ) );
				// End changing user status
			
			return $this->redirect ( array (
					'action' => 'warnUser',
					1,
					1,
					1 
			) );
		}
	}
}
?>