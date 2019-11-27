<!-- upper row -->

		<!-- bread crump -->
		
			  <ul class="breadcrumb">
  				<?php 
  					if($this->uri->segment(1) == 'reports' || $this->uri->segment(1) == 'reportdetail'){
						echo "<li class=''>Report</li>";
						echo "<li class='active'>View</li>";
					}
					else if($this->uri->segment(1) == 'announcement'){
						echo "<li><i>Announcement</i></li>";
						echo "<li class='active'>View</li>";
					}
					else if($this->uri->segment(1) == 'saveannouncement'){
						echo "<li><i>Announcement</i></li>";
						echo "<li class='active'>Save</li>";
					}
					
					else if($this->uri->segment(1) == 'form'){
						echo "<li><i>Form</i></li>";
						echo "<li class='active'>View</li>";
					}
					else if($this->uri->segment(1) == 'saveform'){
						echo "<li><i>Form</i></li>";
						echo "<li class='active'>Save</li>";
					}
					else if($this->uri->segment(1) == 'settings'){
						echo "<li><i>Setting</i></li>";
						echo "<li class='active'>View</li>";
					}
					else if($this->uri->segment(1) == 'profile'){
						echo "<li><i>Profile</i></li>";
						echo "<li class='active'>View</li>";
					}
					
					else if($this->uri->segment(1) == 'newuser'){
						echo "<li><i>User</i></li>";
						echo "<li class='active'>Save</li>";
					}
					else if($this->uri->segment(1) == 'payroll'){
						echo "<li><i>Payroll</i></li>";
						echo "<li class='active'>View</li>";
					}
					else if($this->uri->segment(1) == 'savepayroll'){
						echo "<li><i>Payroll</i></li>";
						echo "<li class='active'>Save</li>";
					}
					else if($this->uri->segment(1) == 'savestore'){
						echo "<li><i>Store</i></li>";
						echo "<li class='active'>Save</li>";
					}
					else if($this->uri->segment(1) == 'saveparent'){
						echo "<li><i>Parent</i></li>";
						echo "<li class='active'>Save</li>";
					}
					else if($this->uri->segment(1) == 'show_std_list'){
						echo "<li><i> Students Record</i></li>";

					
					}
					else if($this->uri->segment(1) == 'savestudent'){
						echo "<li><i>Students</i></li>";
						echo "<li class='active'>Form</li>";
					}
					else if($this->uri->segment(1) == 'newclass'){
						echo "<li><i>Class</i></li>";
						echo "<li class='active'>Save</li>";
					}
					else if($this->uri->segment(1) == 'newsubject'){
						echo "<li><i>Subjects</i></li>";
						echo "<li class='active'>Save</li>";
					}
					else if($this->uri->segment(1) == 'show_teacher_list'){
						echo "<li><i>Teachers Record</i></li>";
						
					}
					else if($this->uri->segment(1) == 'show_class_list'){
						echo "<li><i>Grade Record</i></li>";
					
					}
					else if($this->uri->segment(1) == 'show_subject_list'){
						echo "<li><i>Subjects Record</i></li>";
						
					}
					else if($this->uri->segment(1) == 'add_teacher'){
						echo "<li><i>Teacher</i></li>";
						echo "<li class='active'>Save</li>";
						
					}
					else if($this->uri->segment(1) == 'controlldashboard'){
						echo "<li><i>Principal</i></li>";
						echo "<li class='active'>Dashboard</li>";
						
					}
					else if($this->uri->segment(1) == 'show_subject_list'){
						echo "<li><i>Subjects Record</i></li>";
						
					}
					else if($this->uri->segment(1) == 'promotestudents'){
						echo "<li><i>Promote Students</i></li>";
						
					}
					else if($this->uri->segment(1) == 'show_timtbl_list'){
						echo "<li><i>Schedules Record</i></li>";
						
					}
						else if($this->uri->segment(1) == 'setting'){
						echo "<li><i>General Setting</i></li>";
						
					}
							else if($this->uri->segment(1) == 'add_timtble'){
						echo "<li><i>Schedule</i></li>";
						echo "<li class='active'>Save</li>";
						
					}
									else if($this->uri->segment(1) == 'show_prinicpal_list'){
						echo "<li><i>Principal Record</i></li>";
						
					}
					else if($this->uri->segment(1) == 'lesson_plan_form'){
						echo "<li><i>Default Lesson Plans</i></li>";
						echo "<li class='active'>Save</li>";
						
					}
					else if($this->uri->segment(1) == 'show_prinicpal_list'){
						echo "<li><i>Principal Record</i></li>";
						
					}
					else if($this->uri->segment(1) == 'semester_lesson_plan_form'){
						echo "<li><i>Home</i></li>
						<li><i>Semester Lessons</i></li>";
						
					}
					else if($this->uri->segment(1) == 'holiday'){
							echo "<li><i>Holiday</i></li>";
						echo "<li class='active'>Save</li>";
						
					}
					else if($this->uri->segment(1) == 'classreport'){
							echo "<li><i>Report</i></li>";
						echo "<li class='active'>Class Report</li>";
						
					}
					else if($this->uri->segment(1) == 'activities'){
							echo "<li class='active'><i>Activity</i></li>";
					}
					else if($this->uri->segment(1) == 'studentreport'){
							echo "<li><i>Report</i></li>";
						echo "<li class='active'>Student Report</li>";
						
					}
					else if($this->uri->segment(1) == 'admindashboard'){
						echo "<li><i>Dashboard</i></li>";
						
					}
					else if($this->uri->segment(1) == 'tasks'){
						echo "<li><i>Assignment</i></li>";
						echo "<li class='active'>Records</li>";
					}
					else if($this->uri->segment(1) == 'savetask'){
						echo "<li><i>Assignment</i></li>";
						echo "<li class='active'>Form</li>";
					} 
					else if($this->uri->segment(1) == 'datesheetlist'){
						echo "<li><i>Datesheet list</i></li>";
						
					}
					else if($this->uri->segment(1) == 'add_datesheet'){
						echo "<li><i>Datesheet</i></li>";
						echo "<li class='active'>Save</li>";
					}
					else if($this->uri->segment(1) == 'update_datesheet'){
						echo "<li><i>Datesheet</i></li>";
						echo "<li class='active'>Update</li>";
					}
					else if($this->uri->segment(1) == 'midreport'){
						echo "<li><i>Reports</i></li>";
						echo "<li class='active'>Mid Term Report</li>";
						
					}
					else if($this->uri->segment(1) == 'finalreport'){
						echo "<li><i>Reports</i></li>";
						echo "<li class='active'>Final Result Card</li>";
						
					}
					else{
						echo "<li class='active'>Home</li>";
					} 
				?>
			</ul>  
			<ul class="lms-notification-popup">
				<li>
					<div class="user-message">
						<div class="message-text">
						</div>
					</div>
				</li>
			</ul>
		<!-- right side -->
