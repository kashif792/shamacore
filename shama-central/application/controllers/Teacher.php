<?php 


/**
 * Invantage Controller
 *
 * This class responsible for inventage.
 */
class Teacher extends MY_Controller

{
	/**
	 * @var array
	 */
	var $data = array();
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		
		if (isset($_SESSION))
		{
			if ($this->session->userdata('attempt') == 1)
			{
				parent::redirectUrl('passChange');
			}
		}

		if ($this->session->userdata('id'))
		{

			// parent::redirectUrl('signin');

		}
	}

	/**
	 * Check user login or not
	 */
	function isUserLoginOrNot()
	{/*
		if ($this->uri->segment(1) != 'signin')
		{
			if (!($this->session->userdata('id')))
			{
				parent::redirectUrl('signin');
			}
		}

		if ($this->uri->segment(1) == 'login')
		{
			if ($this->session->userdata('id'))
			{
				parent::redirectUrl('controlldashboard');
			}
		}
		*/
	}

	// ----------------------------------------------------------------------

	/**
	 * Load controll dashboard
	 *
	 * @access private
	 * @load view
	 */
	function dashboard()
	{

		$this->load->view('teacher/dashboard', $this->data);
		
	}

	/**
	 * Load controll dashboard
	 *
	 * @access private
	 * @load view
	 */
	function savelesson()
	{
		if (!($this->session->userdata('id')))
		{
			parent::redirectUrl('signin');
		}

		if ($this->uri->segment(2) AND $this->uri->segment(2) != "page")
		{
			$this->data['lesson_single'] = $this->operation->GetRowsByQyery("Select * from lessons where id= " . $this->uri->segment(2));
			$result['title'] = (parent::GetLessonMeta($this->uri->segment(2) , 'title') != false ? parent::GetLessonMeta($this->uri->segment(2) , 'title') : '');
			$result['description'] = (parent::GetLessonMeta($this->uri->segment(2) , 'description') != false ? parent::GetLessonMeta($this->uri->segment(2) , 'description') : '');
			$result['lesson_type'] = (parent::GetLessonMeta($this->uri->segment(2) , 'lesson_type') != false ? parent::GetLessonMeta($this->uri->segment(2) , 'lesson_type') : '');
			$this->data['result'] = $result;
		}

		$this->operation->table_name = "subjects";
		$subjectslist = $this->operation->GetRows();
		$subjects = array();
		if (count($subjectslist))
		{
			foreach($subjectslist as $key => $value)
			{
				$subjects[] = array(
					'subid' => $value->id,
					'name' => $value->subject_name,
					'class' => parent::getClass($value->class_id) ,
				);
			}
		}

		$this->data['subjects'] = $subjects;
		if ($this->session->userdata('type') == 'p')
		{
			$classlist = $this->operation->GetRowsByQyery("SELECT  * FROM classes c");
		}
		else
		if ($this->session->userdata('type') == 't')
		{

			// code...

			$classlist = $this->operation->GetRowsByQyery("select cl.id, cl.grade FROM schedule sch INNER JOIN classes cl on sch.class_id=cl.id where sch.teacher_uid=" . $this->session->userdata('id'));
		}

		$this->data['classlist'] = $classlist;
		$this->data['sectionlist'] = $this->operation->GetRowsByQyery("SELECT  * FROM sections where class_id =" . $classlist[0]->id);

		// $this->data['lesson_type_list']=$this->operation->GetRowsByQyery("SELECT lesson_type FROM lessons");

		$this->load->view('teacher/save_lessons', $this->data);
	}

	function SaveNewLesson()
	{
		$result['message'] = false;
		$this->form_validation->set_rules('inputLesson', 'Title Required', 'trim|required|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('inputSubject', 'Description Required', 'trim');
		if ($this->form_validation->run() == FALSE)
		{
			$result['message'] = false;
		}
		else
		{
			if ($this->input->post('serial'))
			{
				$lesson = array(
					'title' => $this->input->post('inputLesson') ,
					'teacher_id' => $this->session->userdata('id') ,
					'description' => $this->input->post('editor') ,
					'created' => date("Y-m-d") ,
					'last_update' => date("Y-m-d H:i") ,
				);
				$this->operation->table_name = 'lessons';
				$id = $this->operation->Create($lesson, $this->input->post('serial'));
				if (count($_POST['classlist']))
				{
					$this->db->query("DELETE FROM lesson_read where lessonid = " . $this->input->post('serial'));
					foreach($_POST['sectionslist'] as $key => $value)
					{
						if ($value != '')
						{
							$lesson_read = array(
								'lesson_id' => $id,
								'classid' => $this->input->post('inputclass') ,
								'sectionid' => $value,
								'subjectid' => $this->input->post('inputSubject') ,
							);
							$this->operation->table_name = 'lesson_read';
							$this->operation->primary_key = 'lessonid';
							$ann = $this->operation->Create($lesson_read, $this->input->post('serial'));
						}
					}
				}

				parent::update_lesson_meta($id, 'subject', $this->input->post('inputSubject'));
				$result['message'] = true;
			}
			else
			{
				$lesson = array(
					'title' => $this->input->post('inputLesson') ,
					'teacher_id' => $this->session->userdata('id') ,
					'description' => $this->input->post('editor') ,
					'lesson_type' => $this->input->post('inputType') ,
					'appvideo_url' => $this->input->post('inputUrl') ,
					'created' => date("Y-m-d") ,
					'last_update' => date("Y-m-d H:i") ,
				);
				$this->operation->table_name = 'lessons';
				$id = $this->operation->Create($lesson);
				foreach($_POST['sectionslist'] as $key => $value)
				{
					if ($value != '')
					{
						$lesson_read = array(
							'lesson_id' => $id,
							'classid' => $this->input->post('inputclass') ,
							'sectionid' => $value,
							'created' => date("Y-m-d") ,
							'subjectid' => $this->input->post('inputSubject') ,
						);
						$this->operation->table_name = 'lesson_read';
						$ann = $this->operation->Create($lesson_read);
					}
				}

				$result['message'] = true;
				$result['lessonid'] = $id;
			}
		}

		echo json_encode($result);
	}

	function upload()
	{
		$result['message'] = false;
		if (isset($_FILES) == 1)
		{

			// Save in database

			foreach($_FILES as $key => $value)
			{
				$valid_formats = array(
					"jpg",
					"png",
					"gif",
					"bmp",
					"jpeg",
					"JPG",
					"PNG",
					"GIF",
					"BMP",
					"doc",
					"DOC",
					"PDF",
					"pdf",
					"DOCX",
					"docx",
					"xls",
					"XLS",
					"XLSX",
					"txt"
				);
				if (strlen($value['name']))
				{
					list($txt, $ext) = explode(".", $value['name']);
					if (in_array(strtolower($ext) , $valid_formats))
					{
						if ($value["size"] < 5000000)
						{
							$filename = time() . trim(basename($value['name']));
							$lesson = array(
								'uploadname' => $filename,
								'upload_url' => $filename,
							);
							$this->operation->table_name = 'lessons';
							$id = $this->operation->Create($lesson, $_POST['lessonid']);
							if ($id)
							{
								if (is_uploaded_file($value['tmp_name']))
								{
									$path = $_SERVER['DOCUMENT_ROOT'] . "/invantage/wc/learninginvantage/v1/upload/media/";
									$filename = $path . $filename;
									if (move_uploaded_file($value['tmp_name'], $filename))
									{
										$result['message'] = true;
									}
								}
							}
						}
					}
				}
			}
		}

		echo json_encode($result);
	}

	public

	function show_lessons_list()
	{
		if ($this->session->userdata('type') == 'p')
		{
			$this->data['less0n_list'] = $this->operation->GetRowsByQyery("SELECT ls.id, title,description,upload_url,subject_name,grade,status,section_name from lesson_read lr inner JOIN lessons ls on lr.lesson_id=ls.id inner JOIN subjects sb on lr.subjectid=sb.id inner join classes cl on lr.classid=cl.id inner join sections sc on lr.sectionid=sc.id");
		}
		else
		if ($this->session->userdata('type') == 't')
		{

			// code...

			$this->data['less0n_list'] = $this->operation->GetRowsByQyery("select ls.id, ls.upload_url,ls.title,sb.subject_name,cl.grade,sc.section_name, lr.status from lesson_read lr INNER join lessons ls on lr.lesson_id=ls.id INNER join classes cl on lr.classid=cl.id inner join sections sc on lr.sectionid=sc.id inner join subjects sb on lr.subjectid=sb.id where ls.teacher_id=" . $this->session->userdata('id'));
		}

		$this->load->view('principal/show_lesson_list', $this->data);
	}

	function removeLesson()
	{
		$result['message'] = false;
		$removeLesson = $this->db->query("Delete from lessons where id = " . $this->input->get('id'));
		if ($removeLesson == TRUE):
			$result['message'] = true;
		endif;
		echo json_encode($result);
	}

	/**
	 * Get section by class
	 */
	function GetSectionsByClass()
	{
		$sections = array();
		if (!empty($this->input->get('inputclassid')))
		{
			$roles = $this->session->userdata('roles');
			if ($roles[0]['role_id'] == 3)
			{
				$is_student_found = $this->operation->GetRowsByQyery("SELECT  s.*,ass.id as sid FROM sections s INNER JOIN assignsections ass on ass.sectionid = s.id  where ass.status = 'a' AND ass.classid = " . $this->input->get('inputclassid'));
			}

			if ($roles[0]['role_id'] == 4)
			{
				$is_student_found = $this->operation->GetRowsByQyery("SELECT s.*,ass.id as sid  FROM schedule sc INNER JOIN sections s On s.id = sc.section_id INNER JOIN assignsections ass on ass.sectionid = s.id   where sc.teacher_uid = " . $this->session->userdata('id') . " AND ass.status = 'a' AND sc.class_id = " . $this->input->get('inputclassid') . " Group BY s.id");
			}

			if (count($is_student_found))
			{
				foreach($is_student_found as $key => $value)
				{
					$sections[] = array(
						'id' => $value->id,
						'name' => $value->section_name,
					);
				}
			}
		}

		echo json_encode($sections);
	}

	function GetSubjectListByClass()
	{
		$subjects = array();
		$active_session = parent::GetUserActiveSession();
		$active_semester = parent::GetCurrentSemesterData($active_session[0]->id);
		/*if (!empty($this->input->get('inputclassid')))
		{
			$is_student_found = $this->operation->GetRowsByQyery("Select s.* from subjects s INNER JOIN schedule sc On sc.subject_id = s.id where sc.class_id = " . $this->input->get('inputclassid') . " AND sc.teacher_uid =" . $this->session->userdata('id') . " AND s.session_id = " . $active_session[0]->id . " AND s.semesterid = " . $active_semester[0]->semester_id);

			// echo $this->db->last_query();

			if (count($is_student_found))
			{
				foreach($is_student_found as $key => $value)
				{
					$subjects[] = array(
						'id' => $value->id,
						'name' => $value->subject_name . ' ( ' . $value->subject_code . ' )',
						'subject' => $value->subject_name
					);
				}
			}
		}*/// commented because duplicating code below

		$roles = $this->session->userdata('roles');
		$active_session = parent::GetUserActiveSession();
		$active_semester = parent::GetCurrentSemesterData($active_session[0]->id);
		$classid = $this->input->get('inputclassid');
		if($this->input->get('sinputclassid') != ''){
			$classid = $this->input->get('sinputclassid');
		}

		if ($classid != '')
		{
			if ($roles[0]['role_id'] == 3)
			{
				$is_student_found = $this->operation->GetRowsByQyery("Select s.* from subjects s  where s.class_id = " . $classid . " AND s.session_id = " . $active_session[0]->id . " AND s.semesterid = " . $active_semester[0]->semester_id);
			}
			else
			if ($roles[0]['role_id'] == 4)
			{
				$is_student_found = $this->operation->GetRowsByQyery("Select s.* from subjects s INNER JOIN schedule sc On sc.subject_id = s.id where sc.class_id = " . $classid . " AND sc.teacher_uid =" . $this->session->userdata('id') . " AND s.session_id = " . $active_session[0]->id . " AND s.semesterid = " . $active_semester[0]->semester_id);
			}

			if (count($is_student_found))
			{
				foreach($is_student_found as $key => $value)
				{
					$subjects[] = array(
						'id' => $value->id,
						'name' => $value->subject_name . ' ( ' . $value->subject_code . ' )',
						'subject' => $value->subject_name
					);
				}
			}
		}

		echo json_encode($subjects);
	}


	function GetAllSubjectsByClass()
	{
		$subjects = array();
		$active_session = parent::GetUserActiveSession();
		$active_semester = parent::GetCurrentSemesterData($active_session[0]->id);
		if (!empty($this->input->get('inputclassid')))
		{
			$is_student_found = $this->operation->GetRowsByQyery("Select s.* from subjects s  where s.class_id = " . $this->input->get('inputclassid') . " AND s.session_id = " . $active_session[0]->id . " AND s.semesterid = " . $active_semester[0]->semester_id);

			// echo $this->db->last_query();

			if (count($is_student_found))
			{
				foreach($is_student_found as $key => $value)
				{
					$subjects[] = array(
						'id' => $value->id,
						'name' => $value->subject_name . ' ( ' . $value->subject_code . ' )',
						'subject' => $value->subject_name
					);
				}
			}
		}

		echo json_encode($subjects);
	}


	function GetSubjectLessonsByClass()
	{
		$sections = array();
		$active_session = parent::GetUserActiveSession();
		$active_semester = parent::GetCurrentSemesterData($active_session[0]->id);
		$classid = $this->input->get('inputclassid');
		$subjectid = $this->input->get('inputsubjectid');

		if (!empty($classid) && !empty($subjectid))
		{
			$is_lesson_found = $this->operation->GetRowsByQyery("SELECT * FROM defaultlessonplan WHERE subjectid= " . $subjectid . " AND classid=".$classid);
			// echo $this->db->last_query();

			if (count($is_lesson_found))
			{
				foreach($is_lesson_found as $key => $value)
				{
					$lessons[] = array(
						'id' => $value->id,
						'concept' => $value->concept,
						'topic' => $value->topic,
						'lesson' => $value->lesson
					);
				}
			}
		}

		echo json_encode($lessons);
	}
/*
	function GetGradePlanUnits()
	{
		$sections = array();
		$active_session = parent::GetUserActiveSession();
		$active_semester = parent::GetCurrentSemesterData($active_session[0]->id);
		$classid = $this->input->get('sinputclassid');
		$subjectid = $this->input->get('sinputsubjectid');

		$units = array();
		if (!empty($classid) && !empty($subjectid))
		{
			
			$data = $this->operation->GetRowsByQyery("SELECT DISTINCT concept, id FROM grade_lesson_plan WHERE classid=" . $classid . " AND semesterid =" . $active_semester[0]->semester_id . " AND sessionid =" . $active_session[0]->id . " AND subjectid=" . $subjectid);

			// echo $this->db->last_query();

			if (count($data))
			{
				foreach($data as $key => $value)
				{
					$units[] = array(
						'id' => $value->id,
						'concept' => $value->concept,
					);
				}
			}
		}

		echo json_encode($units);
	}*/

	function savePrereq()
	{
		$result['message'] = false;

		$unitid = $this->input->get('sinputunitid');
		$prereqid = $this->input->get('sinputprereqid');

		if (!empty($unitid) && !empty($prereqid))
		{
			$this->operation->table_name = 'grade_lesson_plan';
			$this->operation->primary_key = 'id';
			$array = array(
				'prereq_id' => $prereq_id
			);
			$status = $this->operation->Create($array, $unitid);
			if ($status){
				$result['message'] = true;
			}
		}
		echo json_encode($result);
	}

	function removeSchedule()
	{
		$result['message'] = false;
		$removeSubject = $this->db->query("Delete from schedule where id =" . trim($_GET['id']));
		if ($removeSubject == TRUE):
			$result['message'] = true;
		endif;
		echo json_encode($result);
	}

	public

	function isread()
	{
		$id = $this->input->post("id");
		$check = $this->input->post("checkinput");
		$this->operation->table_name = 'lesson_read';
		$this->operation->primary_key = 'lesson_id';
		$array = array(
			'status' => $check
		);
		$status = $this->operation->Create($array, $id);
	}

	public function markquiz()
	{
		$id = $this->input->post("id");
		echo $check = $this->input->post("checkinput");
		$this->operation->table_name = 'quize';
		$this->operation->primary_key = 'id';
		$array = array(
			'isdone' => $check
		);
		$status = $this->operation->Create($array, $id);
	}

	function removeQuestion()
	{
		if (!($this->session->userdata('id')))
		{
			parent::redirectUrl('signin');
		}

		$result['message'] = false;
		$removeSubject = $this->db->query("Delete from quizequestions where id =" . trim($_GET['id']));
		if ($removeSubject == TRUE):
			$result['message'] = true;
		endif;
		echo json_encode($result);
	}

	function grade_lesson_plan_form()
	{
		if (!($this->session->userdata('id')))
		{
			parent::redirectUrl('signin');
		}
		
		$this->data['session_id'] = $this->session->userdata('default_session_id');
		$this->data['school_id'] = $this->session->userdata('default_school_id');
		$this->data['user_id'] = $this->session->userdata('id');
		
		$this->load->view('teacher/grade_lesson_plan', $this->data);
	}

	function semester_lesson_plan_form()
	{
		
		$this->load->view('teacher/semester_lesson_plan');
		
	}

	public	function removePlan()
	{
		if (!($this->session->userdata('id')))
		{
			parent::redirectUrl('signin');
		}

		$id = $_POST['data'];
		foreach($id as $key => $value)
		{
			$iid = $value[7];
			if ($iid != "")
			{
				$this->db->query("delete from semester_lesson_plan where id=" . $iid);
				echo $this->db->last_query();
			}

			$result = true;
		}

		echo json_encode($result);
	}

	public function Savedata()
	{
		try
		{
			if (!($this->session->userdata('id')))
			{
				parent::redirectUrl('signin');
			}

			$data = json_decode(stripslashes($_POST['data']));
			$result['message'] = false;
			$newrec = array();
			$classid = $_POST['classid'];
			$subjectid = $_POST['subjectid'];
			$sectionid = $_POST['sectionid'];
			$semesterid = $_POST['semesterid'];
			$lesson = $this->operation->GetRowsByQyery("select * from semester_lesson_plan where classid=" . $classid . " and subjectid=" . $subjectid . " and sectionid=" . $sectionid . " and semesterid=" . $semesterid);
			$id = 0;
			$active_session = parent::GetUserActiveSession();
			$active_semester = parent::GetSemsterDates($semesterid);
			foreach($data as $key => $value)
			{
				$read_date = $value[0];
				$concept = trim($value[1]);
				$topic = trim($value[2]);
				$lesson = trim($value[3]);
				$type = trim($value[4]);
				$content = trim($value[5]);
				$preference = $value[6];
				$lid = $value[7];
				if (is_null($lid) && !is_int($lid))
				{
					$newrec = array(
						'read_date' => $read_date,
						'concept' => $concept,
						'topic' => $topic,
						'lesson' => $lesson,
						'type' => $type,
						'content' => $content,
						'classid' => $_POST['classid'],
						'sectionid' => $_POST['sectionid'],
						'subjectid' => $_POST['subjectid'],
						'uniquecode' => uniqid() ,
						'last_update' => date("Y-m-d H:i") ,
						'created' => date("Y-m-d H:i") ,
						'preference' => $preference,
						'sessionid' => $active_session[0]->id,
						'semesterid' => $semesterid
					);
					$result = $newrec;
					$this->operation->table_name = 'semester_lesson_plan';
					$id = $this->operation->Create($newrec);
				}
				else
				{
					$newrec = array(
						'read_date' => date("Y-m-d", strtotime($read_date)) ,
						'concept' => $concept,
						'topic' => $topic,
						'lesson' => $lesson,
						'type' => $type,
						'content' => $content,
						'last_update' => date("Y-m-d H:i") ,
						'preference' => $preference,
					);
					$this->operation->table_name = 'semester_lesson_plan';
					$id = $this->operation->Create($newrec, $lid);
					if (count($id))
					{
						$result['message'] = true;
					}
				}
			}

			echo json_encode($result);
		}

		catch(Exception $e)
		{
		}
	}


	public function exportGradeLessonPlan()
	{
		if (!($this->session->userdata('id')))
		{
			parent::redirectUrl('signin');
		}

		$active_session = parent::GetUserActiveSession();

		ob_end_clean();
		ob_start();

		$single = $this->operation->GetRowsByQyery("SELECT * FROM grade_lesson_plan WHERE classid=" . $_POST['classid'] . " AND sessionid=" . $active_session[0]->id . " AND semesterid =" . $this->input->post('semesterid'));

		$classname = $this->operation->GetRowsByQyery("select grade from classes Where id=" . $_POST['classid']);
		
		require (APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel.php');

		require (APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

		$objectPHPExcel = new PHPExcel();
		$objectPHPExcel->getProperties()->setCreator("");
		$objectPHPExcel->getProperties()->setLastModifiedBy("");
		$objectPHPExcel->getProperties()->setTitle("");
		$objectPHPExcel->getProperties()->setSubject("");
		$objectPHPExcel->getProperties()->setDescription("");
		$objectPHPExcel->setActiveSheetIndex(0);
		$objectPHPExcel->getActiveSheet()->SetCellValue('A1', 'Grade lesson plan ');
		$objectPHPExcel->getActiveSheet()->SetCellValue('B1', $classname[0]->grade);

		$objectPHPExcel->getActiveSheet()->SetCellValue('A2', 'Unit');
		$objectPHPExcel->getActiveSheet()->SetCellValue('B2', 'Subject');
		$objectPHPExcel->getActiveSheet()->SetCellValue('C2', 'Prereq Unit');
		$objectPHPExcel->getActiveSheet()->SetCellValue('D2', 'Subject');
		
		$rows = 3;
		foreach($single as $key => $value)
		{
			$subject = '';
			$is_subject = parent::getSubject($value->subjectid);
			if($is_subject){
				$subject = $is_subject[0]->subject_name;
			}

			$prereq_concept = $prereq_subject = '';
			if($value->prereq_id){
				$prereq = $this->operation->GetRowsByQyery("SELECT * FROM grade_lesson_plan WHERE id=" . $value->prereq_id);
				if(count($prereq)){
					$prereq_concept = $prereq[0]->concept;
					$is_prereq_subject = parent::getSubject($prereq[0]->subjectid);
					if($is_prereq_subject){
						$prereq_subject = $is_prereq_subject[0]->subject_name;
					}
				}
			}

			$objectPHPExcel->getActiveSheet()->SetCellValue('A' . $rows, $value->concept);
			$objectPHPExcel->getActiveSheet()->SetCellValue('B' . $rows, $subject);
			$objectPHPExcel->getActiveSheet()->SetCellValue('C' . $rows, $prereq_concept);
			$objectPHPExcel->getActiveSheet()->SetCellValue('D' . $rows, $prereq_subject);

			$rows++;
		}

		$filename = 'grade plan' . " ." . 'csv';
		$objectPHPExcel->getActiveSheet()->setTitle("Project Overview");
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename=' . $filename);
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed

		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		$xlsData = ob_get_contents();
		ob_end_clean();
		$response = array(
			'op' => 'ok',
			'class' => $classname,
			'semester' => $semesterid,
			'date' => date('M-d-Y') ,
			'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
		);
		die(json_encode($response));
		exit;
	}


	public function saveGradePlan()
	{
		try
		{
			if (!($this->session->userdata('id')))
			{
				parent::redirectUrl('signin');
			}

			$data = json_decode($_POST['data']);
			$result['message'] = false;
			$newrec = array();
			$classid = $_POST['classid'];
			$semesterid = $_POST['semesterid'];


			$locations = $this->session->userdata('locations');
			$schoolid = $locations[0]['school_id'];

			$active_session = parent::GetUserActiveSession();

			$subjectNameIds = array();
			$is_subjects = $this->operation->GetRowsByQyery("SELECT s.* FROM subjects s WHERE s.class_id = " . $classid . " AND s.session_id = " . $active_session[0]->id . " AND s.semesterid = " . $semesterid);

			if (count($is_subjects))
			{
				foreach($is_subjects as $key => $value)
				{
					$subjectNameIds[$value->subject_name] = array(
						'id' => $value->id,
						'subject' => $value->subject_name
					);
				}
			}
			
			$loop = 0;
			$seqChanged = false;
			$rowIdMap = array();

			foreach($data as $key => $value){
				$concept = trim($value[0]);
				$subject = trim($value[1]);
				$subjectid = null;
				if(!empty($subject))
					$subjectid = $subjectNameIds[$subject]['id'];
			
				$unitid = $value[5];
				$prid = $value[6];

				if(!is_numeric($subjectid)){
					continue;
				}

				if (is_null($unitid) && !is_numeric($unitid))
				{// Add new unit
					// Assign seq
					$seq = 0;

					// Get max seq 
					$seqMax = 1000;
					$this->operation->table_name = 'grade_lesson_plan';
					$res = $this->operation->GetRowsByQyery("SELECT d.seq FROM grade_lesson_plan d WHERE d.classid=" . $classid . " AND d.semesterid = " . $semesterid . " AND d.sessionid = " . $active_session[0]->id . " AND d.schoolid =" . $schoolid . " ORDER BY d.seq DESC");

					if (count($res)) $seqMax = $res[0]->seq + 1;

					$prvUnit = null;
					$iloop = $loop-1;
					while($iloop>=0){
						if(is_numeric($data[$iloop][5])) {
							$prvUnit = $data[$iloop];
							break;
						}
						$iloop--;
					}

					$nextUnit = null;
					$iloop = $loop+1;
					while($iloop<count($data)){
						if(is_numeric($data[$iloop][5])){
							$nextUnit = $data[$iloop];
							break;
						}
						$iloop++;
					}

					if($loop == 0){// new entry at start
						if($nextUnit!=null){
							$this->operation->table_name = 'grade_lesson_plan';
							$res = $this->operation->GetRowsByQyery("SELECT seq FROM grade_lesson_plan WHERE id=" . $nextUnit[5]);
							if (count($res))
							{
								$seq = $res[0]->seq - 1;
								$this->db->query("UPDATE grade_lesson_plan SET seq=seq+1 WHERE classid=" . $classid . " AND semesterid = " . $semesterid . " AND sessionid = " . $active_session[0]->id . " AND schoolid =" . $schoolid . " AND seq>" . $res[0]->seq);
							}
						}
					}else if($loop == count($data)-1){// new entry at end
						if($prvUnit!=null){
							$this->operation->table_name = 'grade_lesson_plan';
							$res = $this->operation->GetRowsByQyery("SELECT seq FROM grade_lesson_plan WHERE id=" . $prvUnit[5]);
							if (count($res))
							{
								$seq = $res[0]->seq + 1;
								$this->db->query("UPDATE grade_lesson_plan SET seq=seq+1 WHERE classid=" . $classid . " AND semesterid = " . $semesterid . " AND sessionid = " . $active_session[0]->id . " AND schoolid =" . $schoolid . " AND seq>" . $res[0]->seq);
							}
						}
					}else if($loop>0 && $loop < (count($data)-1)){// new entry after start and before end
						if($prvUnit!=null){
							$this->operation->table_name = 'grade_lesson_plan';
							$res = $this->operation->GetRowsByQyery("SELECT seq FROM grade_lesson_plan WHERE id=" . $prvUnit[5]);
							if (count($res))
							{
								$seq = $res[0]->seq + 1;
								$this->db->query("UPDATE grade_lesson_plan SET seq=seq+1 WHERE classid=" . $classid . " AND semesterid = " . $semesterid . " AND sessionid = " . $active_session[0]->id . " AND schoolid =" . $schoolid . " AND seq>" . $res[0]->seq);
							}
						}else if($nextUnit!=null){
							$this->operation->table_name = 'grade_lesson_plan';
							$res = $this->operation->GetRowsByQyery("SELECT seq FROM grade_lesson_plan WHERE id=" . $nextUnit[5]);
							if (count($res))
							{
								$seq = $res[0]->seq - 1;
								$this->db->query("UPDATE grade_lesson_plan SET seq=seq+1 WHERE classid=" . $classid . " AND semesterid = " . $semesterid . " AND sessionid = " . $active_session[0]->id . " AND schoolid =" . $schoolid . " AND seq>" . $res[0]->seq);
							}
						}
					}
					
					if($seq == 0){
						$seq = $seqMax + 1;
					}

					$newdata = array(
						'concept' => ucfirst($concept) ,
						'uniquecode' => uniqid() ,
						'classid' => $classid,
						'subjectid' => $subjectid,
						'semesterid' => $semesterid,
						'sessionid' => $active_session[0]->id,
						'schoolid' => $schoolid,
						'seq' => $seq ,
						'last_update' => date("Y-m-d H:i") ,
						'created' => date("Y-m-d H:i")
					);

					$idSeqMap = array();

					$this->operation->table_name = 'grade_lesson_plan';
					$id = $this->operation->Create($newdata);

					$data[$key][4]='data-row-id ="' . $loop . '"';
					$data[$key][5]=$id;
					//print_r($newdata);
				}
				else
				{
					// Update unit seq if changed
					$useq = null;
					$row = null;
					
					if(!empty($value[4]))
						$row = $this->between('data-row-id ="', '"', $value[4]);
					
					if(!$seqChanged && is_numeric($row) && $loop != $row){
						$seqChanged = true;
					}
					if($seqChanged){
						if(count($idSeqMap)==0){
							$idSeqMap = array();
							foreach ($data as $keyi => $valuei) {
								if(is_numeric($valuei[5])){
									$this->operation->table_name = 'grade_lesson_plan';
									$res = $this->operation->GetRowsByQyery("SELECT seq FROM grade_lesson_plan WHERE id=" . $valuei[5]);
									if (count($res)) $idSeqMap[$valuei[5]] = $res[0]->seq;
								}
							}
						}
						if(count($rowIdMap)==0){
							$rowIdMap = array();
							foreach ($data as $keyi => $valuei) {
								if(is_numeric($valuei[5])){
									$rowi = $this->between('data-row-id ="', '"', $valuei[4]);
									if (is_numeric($rowi)) $rowIdMap[$rowi] = $valuei[5];
								}
							}
						}

						$uid = $rowIdMap[$loop];
						$useq = $idSeqMap[$uid];
					}

					// Update unit
					$newdata = array(
						'concept' => $concept,
						'subjectid' => $subjectid,
						'prereq_id' => is_numeric($prid)?$prid:null,
						'last_update' => date("Y-m-d H:i")
					);

					if(is_numeric($useq)){
						$newdata['seq'] = $useq;
					}

					$this->operation->table_name = 'grade_lesson_plan';
					$id = $this->operation->Create($newdata, $unitid);
					//print_r($newdata);
				}

				if (count($id))
				{
					$result['message'] = true;
				}
				$loop++;
			}
			echo json_encode($result);
		}

		catch(Exception $e)
		{
			print_r($e);
		}
	}

	function before ($t, $inthat)
    {
        return substr($inthat, 0, strpos($inthat, $t));
    }

    function after ($t, $inthat)
    {
        if (!is_bool(strpos($inthat, $t)))
        return substr($inthat, strpos($inthat,$t)+strlen($t));
    }
    
    function between ($t, $that, $inthat)
    {
        return $this->before ($that, $this->after($t, $inthat));
    }


	public	function removeGradePlan()
	{
		if (!($this->session->userdata('id')))
		{
			parent::redirectUrl('signin');
		}

		$id = $_POST['data'];
		foreach($id as $key => $value)
		{
			if ($value != "")
			{
				$this->db->query("DELETE FROM grade_lesson_plan WHERE id=" . $value);
				//echo $this->db->last_query();
			}

			$result = true;
		}

		echo json_encode($result);
	}

	function GetSessionList()
	{
		$this->operation->table_name = 'sessions';
		$sessionarray = array();
		if ($this->input->get('inputsessionid'))
		{
			$sessionlist = $this->operation->GetByWhere(array(
				'id' => $this->input->get('inputsessionid')
			));
			if (count($sessionlist))
			{
				foreach($sessionlist as $key => $value)
				{
					$sessionarray = array(
						'id' => $value->id,
						'from' => date('m/d/Y', strtotime($value->datefrom)) ,
						'to' => date('m/d/Y', strtotime($value->dateto)) ,
						'status' => $value->status,
					);
				}
			}
		}
		else
		{
			$sessionlist = $this->operation->GetRows();
			if (count($sessionlist))
			{
				foreach($sessionlist as $key => $value)
				{
					$sessionarray[] = array(
						'id' => $value->id,
						'from' => date('m/d/Y', strtotime($value->datefrom)) ,
						'to' => date('m/d/Y', strtotime($value->dateto)) ,
						'status' => $value->status,
					);
				}
			}
		}

		echo json_encode($sessionarray);
	}

	function CurrentSessionStartDate()
	{
		$this->operation->table_name = 'semester_dates';
		return $this->operation->GetByWhere(array(
			'status' => 'a'
		));
	}

	function HolidayStatus($id)
	{
		$this->operation->table_name = 'holiday_type';
		return $this->operation->GetByWhere(array(
			'id' => $id
		));
	}

	function GetHolidays()
	{
		try
		{
			$this->operation->table_name = 'holiday';
			$locations = $this->session->userdata('locations');
			$holidays = $this->operation->GetByWhere(array(
				'school_id' => $locations[0]['school_id']
			));
			$semester_holidays = array();
			$i = 0;
			$single = true;
			if (count($holidays))
			{
				foreach($holidays as $key => $value)
				{

					// $holidaystatus = $this->HolidayStatus($value->event_id);

					if ($value->all_day == 'y' && $value->apply == 'y')
					{

						// check single holiday

						if (date('Y-m-d', strtotime($value->start_date)) == date('Y-m-d', strtotime($value->end_date)))
						{
							$semester_holidays[$i] = date('Y-m-d', strtotime($value->start_date));
							$i++;
						}
						else
						{

							// multi dats

							$date = date('Y-m-d', strtotime($value->start_date));

							// End date

							$end_date = date('Y-m-d', strtotime($value->end_date));
							while (strtotime($date) <= strtotime($end_date))
							{
								$semester_holidays[$i] = $date;
								$date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
								$i++;
							}
						}
					}
				}
			}

			return $semester_holidays;
		}

		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}

	function CheckWeekend($date)
	{
		if (date('D', strtotime($date)) == 'Sat' || date('D', strtotime($date)) == 'Sun')
		{
			return true;
		}

		return false;
	}

	function FindNextMonday($date)
	{
		$date = date('Y-m-d', strtotime("next monday", strtotime($date)));
		$date = new DateTime($date);
		$date = $date->format('Y-m-d');
		return $date;
	}

	function CheckCurrentDayIsHoliday($holidays, $date)
	{
		if (in_array($date, $holidays))
		{
			return true;
		}

		return false;
	}

	function CheckCurrentDayFound($date)
	{
		date_default_timezone_set("Asia/Karachi");
		return $this->operation->GetRowsByQyery("select * from holiday where apply = 'y' AND all_day = 'n' AND '" . $date . "' between date(start_date) and date(end_date)");
	}

	function Checkholidays($holidays, $date)
	{
		try
		{
			if (!empty($date))
			{
				$check_weekend = $this->CheckWeekend($date);
				if ($check_weekend)
				{
					if ($this->FindNextMonday($date))
					{
						$current_day_status = $this->CheckCurrentDayIsHoliday($holidays, $this->FindNextMonday($date));
						if ($current_day_status)
						{

							// current monday is holiday

							$date = date("Y-m-d", strtotime("+1 day", strtotime($this->FindNextMonday($date))));
							if ($date)
							{
								while ($this->CheckCurrentDayIsHoliday($holidays, $date))
								{
									$date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
								}

								return $date;
							}
						}
						else
						{

							// current day is not holiday

							return $this->FindNextMonday($date);
						}
					}
				}
				else
				{
					$current_day_status = $this->CheckCurrentDayIsHoliday($holidays, $date);
					if ($current_day_status)
					{

						// move to next day

						$date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
						$check_weekend = $this->CheckWeekend($date);
						if ($check_weekend || $this->CheckCurrentDayIsHoliday($holidays, $date))
						{

							// weekend

							if ($check_weekend)
							{
								$date = $this->FindNextMonday($date);
							}

							// holiday

							while ($this->CheckCurrentDayIsHoliday($holidays, $date))
							{
								$date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
							}

							return $date;
						}
						else
						{
							return $date;
						}
					}
					else
					{
						return $date;
					}
				}
			}
		}

		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}

	function testdates()
	{
		try
		{
			$holidays = $this->GetHolidays();
			$current_semesterdate = $this->CurrentSessionStartDate();
			$start_date = date('Y-m-d', strtotime($current_semesterdate[0]->start_date));
			$end_date = date('Y-m-d', strtotime($current_semesterdate[0]->end_date));
			echo $start_date . "\n";
			echo $end_date . "\n\n";
			$current_lesson_day = array();
			$dublicate_dates = array();
			$i = 0;
			$Defaultlessonfromdb = $this->operation->GetRowsByQyery("select * from defaultlessonplan where classid=82 and subjectid=222 and semesterid =1");
			foreach($Defaultlessonfromdb as $key => $value)
			{
				$is_next_day = false;
				if (strtotime($start_date) <= strtotime($end_date))
				{
					if (count($current_lesson_day) == false || !in_array(str_replace(" ", "-", strtolower($value->day)) , $current_lesson_day))
					{
						array_push($current_lesson_day, str_replace(" ", "-", strtolower($value->day)));
						$is_next_day = true;
					}

					$is_holiday = false;
					if ($is_next_day)
					{
						$temp_date = $this->Checkholidays($holidays, $start_date);
						if (!is_null($temp_date))
						{

							// find status of holiday

							if (count($this->CheckCurrentDayFound($temp_date)))
							{
								$check_date = $this->CheckCurrentDayFound($temp_date);

								// if this lesson day check is current period avaible

								$subject_time = $this->GetClassPeriodTime($classid, $sectionid, $subjectid, $locations[0]['school_id'], $semesterid, $current_semesterdate[0]->session_id);
								if (count($subject_time))
								{
									$is_period_time_skiped = $this->MatchPeriodHours($subject_time[0]->start_time, $subject_time[0]->end_time, $holiday_start_time, $holiday_end_time);
									if ($is_period_time_skiped)
									{
										$date = date("Y-m-d", strtotime("+1 day", strtotime($temp_date)));
										$temp_date = $this->Checkholidays($holidays, $date);
									}
								}
							}

							$dublicate_dates[$value->day] = $temp_date;
							$start_date = date("Y-m-d", strtotime("+1 day", strtotime($temp_date)));
						}
					}
					else
					{
						echo "dublicates day" . $value->day . " " . $dublicate_dates[$value->day] . "\n";
					}
				}
			}
		}

		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}

	function GetClassPeriodTime($classid, $sectionid, $subjectid, $location, $semesterid, $sessionid)
	{
		$this->operation->table_name = 'schedule';
		return $this->operation->GetByWhere(array(
			'class_id' => $classid,
			'section_id' => $sectionid,
			'subject_id' => $subjectid,
			'semesterid' => $semesterid,
			'sessionid' => $sessionid,
		));
	}

	function MatchPeriodHours($subject_star_time, $subject_end_time, $holiday_start_time, $holiday_end_time)
	{
		date_default_timezone_set("Asia/Karachi");

		// check current period hours
		// &&  date('H:i',strtotime($holiday_end_time)) <= date('H:i',$subject_end_time)

		if (date('H:i', strtotime($holiday_start_time)) >= date('H:i', $subject_star_time) && date('H:i', $subject_end_time) <= date('H:i', strtotime($holiday_end_time)))
		{
			return false;
		} //else if(date('H:i',$subject_star_time) >= date('H:i',strtotime($holiday_start_time)) &&  date('H:i',$subject_end_time)<= date('H:i',strtotime($holiday_end_time))){

		// 	return true;
		// }

		return true;
	}



	public function loaddatafromdab()
	{
		date_default_timezone_set("Asia/Karachi");
		if (!($this->session->userdata('id')))
		{
			parent::redirectUrl('signin');
		}

		$classid = $this->input->post('classid');
		$sectionid = $this->input->post('sectionid');
		$subjectid = $this->input->post('subjectid');
		$semesterid = $this->input->post('semesterid');
		$recordstatus = $this->input->post('recordstatus');
		$active_session = parent::GetUserActiveSession();
		$this->operation->table_name = 'semester_dates';
		$active_semester = $this->operation->GetByWhere(array(
			'session_id' => $active_session[0]->id,
			'status' => 'a'
		));
		$Defaultlessonfromdb = $this->operation->GetRowsByQyery("select * from defaultlessonplan where classid=" . $classid . " and subjectid=" . $subjectid . " and semesterid =" . $active_semester[0]->semester_id . " AND sessionid =" . $active_session[0]->id);
		$Semesterlessonfromdb = $this->operation->GetRowsByQyery("select * from semester_lesson_plan where classid=" . $classid . " AND sectionid = " . $sectionid . " and semesterid =" . $active_semester[0]->semester_id . " AND sessionid =" . $active_session[0]->id . " and subjectid=" . $subjectid . " ORDER BY preference ASC");
		$data = array();
		$semester_plan_updated = false;
		$locations = $this->session->userdata('locations');
		if (!count($Semesterlessonfromdb) && count($Defaultlessonfromdb))
		{
			$current_semesterdate = $this->CurrentSessionStartDate();
			if (count($current_semesterdate))
			{
				$start_date = date('Y-m-d', strtotime($current_semesterdate[0]->start_date));
				$end_date = date('Y-m-d', strtotime($current_semesterdate[0]->end_date));
				$holidays = $this->GetHolidays(); // find holidays dates
				$current_semesterdate = $this->CurrentSessionStartDate(); // find current session
				$start_date = date('Y-m-d', strtotime($current_semesterdate[0]->start_date)); // find semester start date
				$end_date = date('Y-m-d', strtotime($current_semesterdate[0]->end_date)); // find semester end date
				$current_lesson_day = array();
				$dublicate_dates = array();
				$i = 0;
				$subject_time = $this->GetClassPeriodTime($classid, $sectionid, $subjectid, $locations[0]['school_id'], $semesterid, $current_semesterdate[0]->session_id);
				foreach($Defaultlessonfromdb as $key => $value)
				{
					$is_next_day = false;
					if (strtotime($start_date) <= strtotime($end_date))
					{
						if (count($current_lesson_day) == false || !in_array(str_replace(" ", "-", strtolower($value->day)) , $current_lesson_day))
						{
							array_push($current_lesson_day, str_replace(" ", "-", strtolower($value->day)));
							$is_next_day = true;
						}

						$is_holiday = false;
						if ($is_next_day)
						{
							$temp_date = $this->Checkholidays($holidays, $start_date);
							if (!is_null($temp_date))
							{

								// find status of holiday

								if (count($this->CheckCurrentDayFound($temp_date)))
								{
									$check_date = $this->CheckCurrentDayFound($temp_date);

									// if this lesson day check is current period avaible

									if (count($subject_time))
									{
										$is_period_time_skiped = $this->MatchPeriodHours($subject_time[0]->start_time, $subject_time[0]->end_time, $check_date[0]->start_date, $check_date[0]->end_date);
										if ($is_period_time_skiped == false)
										{
											$date = date("Y-m-d", strtotime("+1 day", strtotime($temp_date)));
											$temp_date = $this->Checkholidays($holidays, $date);
										}
									}
								}

								$dublicate_dates[$value->day] = $temp_date;
								$start_date = date("Y-m-d", strtotime("+1 day", strtotime($temp_date)));
							}
						}
						else
						{
							$temp_date = $dublicate_dates[$value->day];
						}
					}

					$newdata = array(
						'concept' => ucfirst($value->concept) ,
						'topic' => ucfirst($value->topic) ,
						'lesson' => ucfirst($value->lesson) ,
						'classid' => $classid,
						'type' => $value->type,
						'content' => $value->content,
						'sectionid' => $sectionid,
						'subjectid' => $subjectid,
						'uniquecode' => $value->uniquecode,
						'last_update' => date("Y-m-d H:i") ,
						'created' => date("Y-m-d H:i") ,
						'semesterid' => $active_semester[0]->semester_id,
						'sessionid' => $active_session[0]->id,
						'read_date' => $temp_date
					);
					$this->operation->table_name = 'semester_lesson_plan';
					$id = $this->operation->Create($newdata);
					$semester_plan_updated = true;
				}
			}
		}

		if (count($Semesterlessonfromdb) || $semester_plan_updated == true)
		{
			$lesson = $this->operation->GetRowsByQyery("select d.* from semester_lesson_plan d   where d.classid=" . $classid . " AND d.sectionid = " . $_POST['sectionid'] . " AND semesterid = " . $active_semester[0]->semester_id . " and d.subjectid=" . $subjectid . " AND d.sessionid = " . $active_session[0]->id . " ORDER BY read_date ASC");
			if (count($lesson))
			{
				foreach($lesson as $key => $value)
				{
					if ($value->topic == null && $value->topic == null && $value->day == null && $value->concept == null)
					{
					}
					else
					{
						$data[] = array(
							'id' => $value->id,
							'topic' => $value->topic,
							'read_date' => $value->read_date,
							'content' => $value->content,
							'concept' => $value->concept,
							'lesson' => $value->lesson,
							'type' => $value->type,
							'currentday' => ($value->read_date == date('Y-m-d') ? true : false) ,
							'preference' => $value->preference,
						);
					}
				}
			}
		}

		echo json_encode($data);
	}

	public function exportdata()
	{
		if (!($this->session->userdata('id')))
		{
			parent::redirectUrl('signin');
		}

		ob_end_clean();
		ob_start();
		$single = $this->operation->GetRowsByQyery("select * from semester_lesson_plan where classid=" . $_POST['classid'] . " and subjectid=" . $_POST['subjectid'] . " and sectionid=" . $_POST['sectionid'] . " and semesterid =" . $this->input->post('semesterid'));
		$classname = $this->operation->GetRowsByQyery("select grade from classes Where id=" . $_POST['classid']);
		$subjectname = $this->operation->GetRowsByQyery("select subject_name from subjects Where id=" . $_POST['subjectid']);
		$sectionname = $this->operation->GetRowsByQyery("select section_name from sections Where id=" . $_POST['sectionid']);
		require (APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel.php');

		require (APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

		$objectPHPExcel = new PHPExcel();
		$objectPHPExcel->getProperties()->setCreator("");
		$objectPHPExcel->getProperties()->setLastModifiedBy("");
		$objectPHPExcel->getProperties()->setTitle("");
		$objectPHPExcel->getProperties()->setSubject("");
		$objectPHPExcel->getProperties()->setDescription("");
		$objectPHPExcel->setActiveSheetIndex(0);
		$objectPHPExcel->getActiveSheet()->SetCellValue('A1', $classname[0]->grade);
		$objectPHPExcel->getActiveSheet()->SetCellValue('B1', $sectionname[0]->section_name);
		$objectPHPExcel->getActiveSheet()->SetCellValue('C1', $subjectname[0]->subject_name);
		$objectPHPExcel->getActiveSheet()->SetCellValue('D1', 'Semester lesson plan ');
		$objectPHPExcel->getActiveSheet()->SetCellValue('A2', 'Date');
		$objectPHPExcel->getActiveSheet()->SetCellValue('B2', 'Concept');
		$objectPHPExcel->getActiveSheet()->SetCellValue('C2', 'Topic');
		$objectPHPExcel->getActiveSheet()->SetCellValue('D2', 'Lesson');
		$objectPHPExcel->getActiveSheet()->SetCellValue('E2', 'Type');
		$objectPHPExcel->getActiveSheet()->SetCellValue('F2', 'Content');
		$rows = 3;
		foreach($single as $key => $value)
		{
			$objectPHPExcel->getActiveSheet()->SetCellValue('A' . $rows, $value->read_date);
			$objectPHPExcel->getActiveSheet()->SetCellValue('B' . $rows, $value->concept);
			$objectPHPExcel->getActiveSheet()->SetCellValue('C' . $rows, $value->topic);
			$objectPHPExcel->getActiveSheet()->SetCellValue('D' . $rows, $value->lesson);
			$objectPHPExcel->getActiveSheet()->SetCellValue('E' . $rows, $value->type);
			$objectPHPExcel->getActiveSheet()->SetCellValue('F' . $rows, $value->content);
			$rows++;
		}

		$filename = 'task exported on' . " ." . 'csv';
		$objectPHPExcel->getActiveSheet()->setTitle("Project Overview");
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename=' . $filename);
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed

		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		$xlsData = ob_get_contents();
		ob_end_clean();
		$response = array(
			'op' => 'ok',
			'class' => $classname,
			'subject' => $subjectname,
			'date' => date('M-d-Y') ,
			'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
		);
		die(json_encode($response));
		exit;
	}

	public function UpdateLessonProgress()
	{
		$debug = '';
		$result['message'] = false;
		try
		{
			if (!($this->session->userdata('id')))
			{
				parent::redirectUrl('signin');
				return;
			}

			//	$parts = explode('_', $key);
			//	$type = $parts[0];

			$lesson_read = $_POST['isread'];
			$lessonid = $_POST['lessonid'];
			$studentid = $_POST['studentid'];

			// echo print_r($_POST);

			if ($lessonid && $studentid)
			{
				$is_student_found = $this->operation->GetRowsByQyery("Select * from invantageuser where id= '" . $studentid . "'");

				// echo print_r($is_student_found);

				if (count($is_student_found))
				{
					$this->operation->table_name = 'lessonprogress';
					$data_lesson_read = $this->operation->GetRowsByQyery("Select * from lessonprogress where lessonid = " . $lessonid . " AND studentid =" . $studentid);
					$is_lesson_found = $this->operation->GetRowsByQyery("Select * from semester_lesson_plan where id = " . $lessonid);
					if (count($data_lesson_read) == 0 && count($is_lesson_found))
					{
						$lesson_progress = array(
							'studentid' => $studentid,
							'lessonid' => $lessonid,
							'status' => ($lesson_read == 1 ? 'read' : 'unread') ,
							'count' => 1,
							'last_updated' => date('Y-m-d h:i:s')
						);
						$this->operation->table_name = 'lessonprogress';
						$is_value_saved = $this->operation->Create($lesson_progress);
						$debug.= "," . $this->db->last_query();
					}
					else
					{
						$student_progress = array(
							'status' => ($lesson_read == 1 ? 'read' : 'unread') ,
							'count' => ($lesson_read == 1 ? $data_lesson_read[0]->count : 0) ,
							'last_updated' => date('Y-m-d h:i:s') ,
						);
						$is_value_saved = $this->operation->Create($student_progress, $data_lesson_read[0]->id);
						$debug.= "," . $this->db->last_query();
					}

					if (count($is_value_saved))
					{
						$result['message'] = true;
						$result['status'] = ($lesson_read == 1 ? 'read' : 'unread');
						$result['lessonid'] = $lessonid;
						$result['studentid'] = $studentid;
					}
				}
			}
		}

		catch(Exception $e)
		{
		}

		// $result['debug'] = $debug;
		// echo $result['message'];

		echo json_encode($result);
	}

	public function UpdateSemesterLessonProgress()
	{
		$debug = '';
		$result['message'] = false;
		try
		{
			if (!($this->session->userdata('id')))
			{
				parent::redirectUrl('signin');
				return;
			}

			// $data = $_POST;
			// $debug .= var_export($data, true);

			foreach($_POST as $key => $lesson_read)
			{
				$parts = explode('_', $key);
				$type = $parts[0];
				$lessonid = $parts[1];
				$studentid = $parts[2];
				if ($lessonid > 0 && $studentid > 0 && $type == "prog")
				{
					$is_student_found = $this->operation->GetRowsByQyery("Select * from invantageuser where id= '" . $studentid . "'");
					if (count($is_student_found))
					{
						$this->operation->table_name = 'lessonprogress';
						$data_lesson_read = $this->operation->GetRowsByQyery("Select * from lessonprogress where lessonid = " . $lessonid . " AND studentid =" . $studentid);
						$is_lesson_found = $this->operation->GetRowsByQyery("Select * from semester_lesson_plan where id = " . $lessonid);
						if (count($data_lesson_read) == 0 && count($is_lesson_found))
						{
							$lesson_progress = array(
								'studentid' => $studentid,
								'lessonid' => $lessonid,
								'status' => ($lesson_read == 1 ? 'read' : 'unread') ,
								'count' => 1,
								'last_updated' => date('Y-m-d h:i:s')
							);
							$this->operation->table_name = 'lessonprogress';
							$is_value_saved = $this->operation->Create($lesson_progress);

							// $debug .= "," . $this->db->last_query();

						}
						else
						{
							$student_progress = array(
								'status' => ($lesson_read == 1 ? 'read' : 'unread') ,
								'count' => ($lesson_read == 1 ? $data_lesson_read[0]->count : 0) ,
								'last_updated' => date('Y-m-d h:i:s') ,
							);
							$is_value_saved = $this->operation->Create($student_progress, $data_lesson_read[0]->id);

							// $debug .= "," . $this->db->last_query();

						}

						if (count($is_value_saved))
						{
							$result['message'] = true;
						}
					}
				}
			}
		}

		catch(Exception $e)
		{
		}

		// $result['debug'] = $debug;

		echo $result['message'];
	}


	public function UpdateGradeLessonPlan()
	{
		if (!($this->session->userdata('id')))
		{
			parent::redirectUrl('signin');
		}

		$classid = $_POST['classid'];
		$semesterid = $_POST['semesterid'];


		$locations = $this->session->userdata('locations');
		$schoolid = $locations[0]['school_id'];

		$active_session = parent::GetUserActiveSession();
		

		//$subjectslist = parent::GetSubjectsByClass($classid, $semesterid);

		$lesson = $this->operation->GetRowsByQyery("SELECT * FROM defaultlessonplan WHERE classid=" . $classid . " AND semesterid =" . $semesterid . " AND sessionid =" . $active_session[0]->id . " GROUP BY concept ORDER BY day ASC");
		
		if (count($lesson))
		{
			foreach($lesson as $key => $value)
			{
				$isPresent = $this->operation->GetRowsByQyery("SELECT * FROM grade_lesson_plan WHERE uniquecode= '" . $value->uniquecode . "'" . " AND classid= " . $classid . " AND semesterid =" . $semesterid . " AND sessionid =" . $active_session[0]->id);

				if (!count($isPresent))
				{

					// Assign seq
					$seq = 0;
					$this->operation->table_name = 'grade_lesson_plan';
					$res = $this->operation->GetRowsByQyery("SELECT d.seq FROM grade_lesson_plan d WHERE d.classid=" . $classid . " AND d.semesterid = " . $semesterid . " AND d.sessionid = " . $active_session[0]->id . " AND d.schoolid =" . $schoolid . " ORDER BY d.seq DESC");

					if (count($res)) $seq = $res[0]->seq + 1;

					$newdata = array(
						'concept' => $value->concept,
						'subjectid' => $value->subjectid,
						'classid' => $classid,
						'seq' => $seq,
						'last_update' => date("Y-m-d H:i") ,
						'created' => date("Y-m-d H:i") ,
						'uniquecode' => $value->uniquecode,
						'semesterid' => $semesterid,
						'schoolid' => $schoolid,
						'sessionid' => $active_session[0]->id,
					);

					$this->operation->table_name = 'grade_lesson_plan';
					$this->operation->primary_key = 'id';
					$id = $this->operation->Create($newdata);
				}
				else
				{

					$newdata = array(
						'concept' => $value->concept,
						'subjectid' => $value->subjectid,
						'last_update' => date("Y-m-d H:i")
					);

					$this->operation->table_name = 'grade_lesson_plan';
					$this->operation->Create($newdata, $isPresent[0]->id);
				}
			}
		}

		$result['message'] = true;
		echo json_encode($result);
	}

	public function UpdateSemesterLessonPlan()
	{
		if (!($this->session->userdata('id')))
		{
			parent::redirectUrl('signin');
		}

		$newdata = array();
		$classid = $_POST['select_class'];
		$sectionid = $_POST['inputSection'];
		$subjectid = $_POST['select_subject'];
		$Is_Plane_Delete = $_POST['DeleteLessonPlan'];
		$semesterid = $this->input->post('inputSemester');
		$active_session = parent::GetUserActiveSession();
		$this->operation->table_name = 'semester_dates';
		$active_semester = $this->operation->GetByWhere(array(
			'session_id' => $active_session[0]->id,
			'semester_id' => $semesterid
		));
		$lesson = $this->operation->GetRowsByQyery("select * from defaultlessonplan where classid=" . $classid . " and subjectid=" . $subjectid . " and semesterid =" . $active_semester[0]->semester_id . " And sessionid =" . $active_session[0]->id);
		if (count($lesson))
		{
			foreach($lesson as $key => $value)
			{
				$isPresent = $this->operation->GetRowsByQyery("select * from semester_lesson_plan where uniquecode= '" . $value->uniquecode . "'" . "and sectionid= " . $sectionid);
				$newdata = array(
					'concept' => $value->concept,
					'content' => $value->content,
					'topic' => $value->topic,
					'classid' => $classid,
					'sectionid' => $sectionid,
					'subjectid' => $subjectid,
					'type' => $value->type,
					'lesson' => $value->lesson,
					'last_update' => date("Y-m-d H:i") ,
					'created' => date("Y-m-d H:i") ,
					'uniquecode' => $value->uniquecode,
					'semesterid' => $active_semester[0]->semester_id,
					'sessionid' => $active_session[0]->id,
				);
				$this->operation->table_name = 'semester_lesson_plan';
				$this->operation->primary_key = 'id';
				if (!count($isPresent))
				{
					$id = $this->operation->Create($newdata);
				}
				else
				{
					$this->operation->Create($newdata, $isPresent[0]->id);
				}
			}
		}

		$data = $this->operation->GetRowsByQyery("select * from semester_lesson_plan where classid=" . $classid . " and sectionid=" . $sectionid . " and subjectid=" . $subjectid . " and semesterid=" . $active_semester[0]->semester_id . " AND sessionid =" . $active_session[0]->id);
		echo json_encode($data);
	}

	public

	function ResetLessonPlan()
	{
		if (!($this->session->userdata('id')))
		{
			parent::redirectUrl('signin');
		}

		$classid = $_POST['select_class'];
		$sectionid = $_POST['inputSection'];
		$subjectid = $_POST['select_subject'];
		$semesterid = $this->input->post('inputSemester');
		$check = $this->db->query("delete from semester_lesson_plan where classid=" . $classid . " and subjectid=" . $subjectid . " and semesterid =" . $semesterid . " and sectionid =" . $sectionid);
		echo json_encode(true);
	}

	function setting_semester()
	{
		
		$this->load->view('principal/setting');

	}
}