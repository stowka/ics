<?php
	/*
	 * ICS - A VEVENT event in a VCALENDAR - iCalendar format.
	 * Output = File
	 * @author Antoine De Gieter
	 */
	class ICS {
		# Object attributes	
		protected $uid;
		protected $dtstart;
		protected $dtend;
		protected $summary;
		protected $categories;
		protected $status;
		protected $location;
		protected $description;
		protected $lastModified;

		# Class attributes
		private static $DATE_FORMAT='Ymd\THis\Z';

		# Magic methods
		function __construct($uid, $dtstart, $dtend, $summary, $categories, $status, $location, $description, $lastModified=0) {
			$this->uid=$uid;
			$this->dtstart=$dtstart;
			$this->dtend=$dtend;
			$this->summary=$summary;
			$this->categories=$categories;
			$this->status=$status;
			$this->location=$location;
			$this->description=$description;
			$this->lastModified=$lastModified;
		}

		# Format : UID#\n SUMMARY\n DTSTART\n DTEND
		public function __toString() {
			return $this->uid.'# '.$this->summary.chr(10).$this->formatDate($this->dtstart).chr(10).$this->formatDate($this->dtend).chr(10);
		}

		# Linearly serialize the object
		public function __sleep() {
			return array($this->iud, $this->dtstart, $this->dtend, 
							$this->summary, $this->categories, $this->status,
							$this->location, $this->description, $this->lastModified);
		}

		# Unserialize the object
		public function __wakeup() {
			# TODO
		}

		# Other methods
		private function formatDate($timestamp) {
			return @date(ICS::$DATE_FORMAT, $timestamp-3600);
		}

		public function generateICS() {
			# VCALENDAR BEGIN
			$output="BEGIN:VCALENDAR".chr(10);
			$output.="METHOD:PUBLISH".chr(10);
			$output.="VERSION:2.0".chr(10);
			$output.="PRODID:-//Antoine De Gieter//contact@adegieter.com//FR".chr(10);
			# VEVENT
			$output.="BEGIN:VEVENT".chr(10);
			$output.="SUMMARY:".$this->summary.chr(10);
			$output.="UID:".$this->uid.chr(10);
			$output.="CATEGORIES:".$this->categories.chr(10);
			$output.="STATUS:".$this->status.chr(10);
			$output.="DTSTART:".$this->formatDate($this->dtstart).chr(10);
			$output.="DTEND:".$this->formatDate($this->dtend).chr(10);
			$output.="LAST-MODIFIED:".$this->formatDate($this->lastModified).chr(10);
			$output.="LOCATION:".$this->location.chr(10);
			$output.="DESCRIPTION:".$this->description.chr(10);
			$output.="END:VEVENT".chr(10);
			# VCALENDAR END
			$output.="END:VCALENDAR";
			echo 'ICS generated'.chr(10);
			return $output;
		}

		public function createFile($output) {
			$fileName=$this->uid.'-'.preg_replace("/ /", "_", strtolower($this->summary)).'.ics';
			$file=fopen($fileName, 'w');
			fwrite($file, $output);
			fclose($file);
			echo 'The file "'.$fileName.'"" has been created with the content :'.chr(10).chr(10);
			echo $output.chr(10).chr(10);
		}
	}
?>