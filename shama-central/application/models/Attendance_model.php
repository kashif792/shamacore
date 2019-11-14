<?php
class Attendance_Model extends CI_Model
{
	public function getPresentStaffToday()
	{
		$date= new DateTime();

		$date->setTimezone(new DateTimeZone('Asia/Karachi'));

		$date = '2017-02-03';

		$present =	 $this->db->query("SELECT * FROM staff_attendance WHERE status = 'Present' AND date = '$date'");

		return $present->num_rows();
	}

	public function getAbsentStaffToday()
	{
		$date= new DateTime();

		$date->setTimezone(new DateTimeZone('Asia/Karachi'));

		$date = '2017-02-03';

		$present = $this->db->query("SELECT * FROM staff_attendance WHERE status = 'Absent' AND date = '$date'");

		return $present->num_rows();
	}

	public function getLeaveStaffToday()
	{
		$date= new DateTime();

		$date->setTimezone(new DateTimeZone('Asia/Karachi'));

		$date = '2017-02-03';

		$present = $this->db->query("SELECT * FROM staff_attendance WHERE status = 'Leave' AND date = '$date'");

		return $present->num_rows();
	}

	public function getCurrentWeekPresentAttendance()
	{
		//set date

		$day = date('w'); // current day of week
		// $week_start = date('Y-m-d', strtotime('-'.$day.' days'));
		// $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
		$week_start ='2017-02-06';
		$week_end = '2017-02-12';

		$result = $this->db->query("SELECT * FROM staff_attendance WHERE check_in IS NOT NULL AND date >= '$week_start' AND date <= '$week_end'");

		return $result->num_rows();
	}



	public function getCurrentWeekAbsentAttendance()
	{
		//set date

		$day = date('w'); // current day of week
		// $week_start = date('Y-m-d', strtotime('-'.$day.' days'));
		// $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
		$week_start ='2017-02-06';
		$week_end = '2017-02-12';

		$result = $this->db->query("SELECT * FROM staff_attendance WHERE check_in IS NULL AND date >= '$week_start' AND date <= '$week_end'");

		return $result->num_rows();
	}



	public function getCurrentWeekLeaveAttendance()
	{
		//set date
		$day = date('w'); // current day of week
		// $week_start = date('Y-m-d', strtotime('-'.$day.' days'));

		// $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
		$week_start ='2017-02-06';
		$week_end = '2017-02-12';

		$result = $this->db->query("SELECT * FROM staff_attendance WHERE status = 'Leave' AND date >= '$week_start' AND date <= '$week_end'");

		return $result->num_rows();
	}


	//Weekly Present Attendance

	public function getCurrentMondayPresentAttendance()
	{
		//set date

		$day = date('w'); // current day of week

		// $monday = date('Y-m-d', strtotime('+'.(1-$day).' days'));

		$monday = '2017-02-06';

		$result = $this->db->query("SELECT * FROM staff_attendance WHERE check_in IS NOT NULL AND date = '$monday'");

		return $result->num_rows();
	}

	public function getCurrentTuesdayPresentAttendance()
	{
		//set date

		$day = date('w'); // current day of week

		// $tuesday = date('Y-m-d', strtotime('+'.(2-$day).' days'));

		$tuesday = '2017-02-07';

		$result = $this->db->query("SELECT * FROM staff_attendance WHERE check_in IS NOT NULL AND date = '$tuesday'");

		return $result->num_rows();
	}

	public function getCurrentWednesdayPresentAttendance()
	{
		//set date

		$day = date('w'); // current day of week

		// $wednesday = date('Y-m-d', strtotime('+'.(3-$day).' days'));

		$wednesday = '2017-02-08';

		$result = $this->db->query("SELECT * FROM staff_attendance WHERE check_in IS NOT NULL AND date = '$wednesday'");

		return $result->num_rows();
	}

	public function getCurrentThursdayPresentAttendance()
	{
		//set date

		$day = date('w'); // current day of week

		// $thursday = date('Y-m-d', strtotime('+'.(4-$day).' days'));

		$thursday = '2017-02-09';

		$result = $this->db->query("SELECT * FROM staff_attendance WHERE check_in IS NOT NULL AND date = '$thursday'");

		return $result->num_rows();
	}

	public function getCurrentFridayPresentAttendance()
	{
		//set date

		$day = date('w'); // current day of week

		// $friday = date('Y-m-d', strtotime('+'.(5-$day).' days'));

		$friday = '2017-02-10';

		$result = $this->db->query("SELECT * FROM staff_attendance WHERE check_in IS NOT NULL AND date = '$friday'");

		return $result->num_rows();
	}

	public function getCurrentSaturdayPresentAttendance()
	{
		//set date

		$day = date('w'); // current day of week

		// $saturday = date('Y-m-d', strtotime('+'.(6-$day).' days'));

		$saturday = '2017-02-11';

		$result = $this->db->query("SELECT * FROM staff_attendance WHERE check_in IS NOT NULL AND date = '$saturday'");

		return $result->num_rows();
	}

	public function getCurrentSundayPresentAttendance()
	{
		//set date

		$day = date('w'); // current day of week

		// $sunday = date('Y-m-d', strtotime('-'.$day.' days'));

		$sunday = '2017-02-12';

		$result = $this->db->query("SELECT * FROM staff_attendance WHERE check_in IS NOT NULL AND date = '$sunday'");

		return $result->num_rows();
	}



	//Weekly Absent Attendance

	public function getCurrentMondayAbsentAttendance()
	{
		//set date

		$day = date('w'); // current day of week

		// $monday = date('Y-m-d', strtotime('+'.(1-$day).' days'));

		$monday = '2017-02-06';

		$result = $this->db->query("SELECT * FROM staff_attendance WHERE check_in IS NULL AND date = '$monday'");

		return $result->num_rows();
	}

	public function getCurrentTuesdayAbsentAttendance()
	{
		//set date

		$day = date('w'); // current day of week

		// $tuesday = date('Y-m-d', strtotime('+'.(2-$day).' days'));

		$tuesday = '2017-02-07';

		$result = $this->db->query("SELECT * FROM staff_attendance WHERE check_in IS NULL AND date ='$tuesday'");

		return $result->num_rows();
	}

	public function getCurrentWednesdayAbsentAttendance()
	{
		//set date

		$day = date('w'); // current day of week

		// $wednesday = date('Y-m-d', strtotime('+'.(3-$day).' days'));

		$wednesday = '2017-02-08';

		$result = $this->db->query("SELECT * FROM staff_attendance WHERE check_in IS NULL AND date = '$wednesday'");

		return $result->num_rows();
	}

	public function getCurrentThursdayAbsentAttendance()
	{
		//set date

		$day = date('w'); // current day of week

		// $thursday = date('Y-m-d', strtotime('+'.(4-$day).' days'));

		$thursday = '2017-02-09';

		$result = $this->db->query("SELECT * FROM staff_attendance WHERE check_in IS NULL AND date = '$thursday'");

		return $result->num_rows();
	}

	public function getCurrentFridayAbsentAttendance()
	{
		//set date

		$day = date('w'); // current day of week

		// $friday = date('Y-m-d', strtotime('+'.(5-$day).' days'));

		$friday = '2017-02-10';

		$result = $this->db->query("SELECT * FROM staff_attendance WHERE check_in IS NULL AND date = '$friday'");

		return $result->num_rows();
	}

	public function getCurrentSaturdayAbsentAttendance()
	{
		//set date
		$day = date('w'); // current day of week
		// $saturday = date('Y-m-d', strtotime('+'.(6-$day).' days'));
		$saturday = '2017-02-11';
		$result = $this->db->query("SELECT * FROM staff_attendance WHERE check_in IS NULL AND date = '$saturday'");

		return $result->num_rows();
	}

	public function getCurrentSundayAbsentAttendance()
	{
		//set date

		$day = date('w'); // current day of week

		// $sunday = date('Y-m-d', strtotime('-'.$day.' days'));

		$sunday = '2017-02-12';

		$result = $this->db->query("SELECT * FROM staff_attendance WHERE check_in IS NULL AND date = '$sunday'");

		return $result->num_rows();
	}
}