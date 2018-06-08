<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Privacy Subsystem implementation for block_myoverview.
 *
 * @package    block_annulab_lrs
 * @copyright  2018 Howard Miller
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_annulab_lrs\privacy;

defined('MOODLE_INTERNAL') || die();

use \core_privacy\local\metadata\collection;

/**
 * Privacy Subsystem for block_annulab_lrs.
 *
 * @copyright  2018 Howard Miller
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements \core_privacy\local\metadata\provider {

    /**
     * Returns meta-data information about the annulab_lrs block.
     *
     * @param  collection $collection A collection of meta-data.
     * @return collection Return the collection of meta-data.
     */
     public static function get_metadata(collection $collection) : collection {
            $collection->add_external_location_link('annulab_lrs', [
                      'fullname' => 'privacy:metadata:annulab_lrs:fullname',
                   ], 'privacy:metadata:annulab_lrs:externalpurpose');
        return $collection;
    }
}
?>
