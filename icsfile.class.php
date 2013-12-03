<?php
	require_once 'ics.class.php';

	/*
	 * ICSFile - Model a VEVENT event in a VCALENDAR with the iCalendar format.
	 * Input = File
	 * @author Antoine De Gieter
	 */
	class ICSFile extends ICS {
		private $data = array(
			'UID' => "", 
			'DTSTART' => "", 
			'DTEND' => "", 
			'SUMMARY' => "", 
			'CATEGORIES' => "", 
			'STATUS' => "", 
			'LOCATION' => "", 
			'DESCRIPTION' => "", 
			'LASTMODEIFIED' => ""
		);

		# Magic Methods
		function __construct($file) {
			$input = fopen($file, 'r');

			if($input):
				while(!feof($input)):
					$line = fgets($input);
					foreach(array_keys($this->data) as $keyword):
						if(preg_match("#$keyword#", $line)):
							$this->data[$keyword] = preg_replace("/^".$keyword.": ?([A-Za-z -_,\.]+)$/", "$1", $line).chr(10);
						endif;
					endforeach;
				endwhile;
			endif;

			fclose($input);
		}

		/*
		 * Getters
		 */

		# UID
		public function getUid() {
			return $this->data['UID'];
		}

		# DATE START
		public function getDtstart() {
			return $this->data['DTSTART'];
		}

		# DATE END
		public function getDtend() {
			return $this->data['DTEND'];
		}

		# SUMMARY
		public function getSummary() {
			return $this->data['SUMMARY'];
		}

		# CATEGORIES
		public function getCategories() {
			return $this->data['CATEGORIES'];
		}

		# STATUS
		public function getStatus() {
			return $this->data['STATUS'];
		}

		# LOCATION
		public function getLocation() {
			return $this->data['LOCATION'];
		}

		# DESCRIPTION
		public function getDescription() {
			return $this->data['DESCRIPTION'];
		}

		# DATE LAST MODIFIED
		public function getLastModified() {
			return $this->data['LASTMODIFIED'];
		}

		/*
		 *	Auxiliary methods
		 */
		private function formatedDateToTimestamp($date) {
			$year = substr($date, 0, 4);
			$month = substr($date, 4, 2);
			$day = substr($date, 6, 2);
			$hour = substr($date, 9, 2);
			$minute = substr($date, 11, 2);
			$seconds = substr($date, 13, 2);
			return mktime($hour, $minute, $second, $year, $month, $day);
		}
	}
?>