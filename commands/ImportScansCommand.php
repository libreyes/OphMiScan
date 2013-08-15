<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

class ImportScansCommand extends CConsoleCommand {
	public function run($args) {
		$path = Yii::app()->params['scan_directory'];

		if (!$source = ProtectedFileSource::model()->find('name=?',array('Scanner'))) {
			$source = new ProtectedFileSource;
			$source->name = 'Scanner';
			if (!$source->save()) {
				throw new Exception("Unable to save protected file source: ".print_r($source->getErrors(),true));
			}
		}

		$dh = opendir($path);

		while ($file = readdir($dh)) {
			if (is_file("$path/$file") && preg_match('/\.pdf$/',$file)) {
				echo "Importing: $path/$file ... \n";
				$scan = ProtectedFile::createFromFile("$path/$file");

				$scan->source_id = $source->id;

				if (!$scan->save()) {
					throw new Exception("Unable to save protected file: ".print_r($scan->getErrors(),true));
				}

				@unlink("$path/$file");
			}
		}

		closedir($dh);
	}
}
