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

namespace src\transformer\utils\get_activity;
defined('MOODLE_INTERNAL') || die();

use src\transformer\utils as utils;

/**
 * Returns the object element in the xAPI call.
 *
 * @param array $config
 * @param int $cmid
 * @return array
 */
function spa(array $config, $cmid)
{
    $lang = $config['source_lang'];
    $repo = $config['repo'];
    $xapitype = 'http://activitystrea.ms/schema/1.0/review';

    $coursemodule = $repo->read_record_by_id('course_modules', $cmid);
    $module = $repo->read_record_by_id('modules', $coursemodule->module);
    $instance = $repo->read_record_by_id($module->name, $coursemodule->instance);

    $coursemoduleurl = $config['app_url'].'/mod/'.$module->name.'/view.php?id='.$cmid;
    $instancename = property_exists($instance, 'name') ? $instance->name : $module->name;

    $object = [
        'id' => $coursemoduleurl,
        'definition' => [
            'type' => $xapitype,
            'name' => [
                $lang => $instancename,
            ],
        ],
    ];

    if (utils\is_enabled_config($config, 'send_course_and_module_idnumber')) {
        $moduleidnumber = property_exists($coursemodule, 'idnumber') ? $coursemodule->idnumber : null;
        $object['definition']['extensions']['https://w3id.org/learning-analytics/learning-management-system/external-id'] =
            $moduleidnumber;
    }

    return $object;
}

/**
 * Returns the object element in the xAPI call.
 *
 * @param array $config
 * @param int $categoryid
 * @return array
 */
function spa_category(array $config, $categoryid)
{
    $lang = $config['source_lang'];
    $repo = $config['repo'];
    $xapitype = 'http://id.tincanapi.com/activitytype/category';

    $category = $repo->read_record_by_id('spa_category', $categoryid);

    // If the category exists in the database use it's name as instance name, otherwise just use SPA category.
    $instancename = ($category !== null) ? $category->name : 'SPA category';
    $categoryurl = $config['app_url'].'/mod/spa/editcategory.php?id='.$categoryid;

    $object = [
        'id' => $categoryurl,
        'definition' => [
            'type' => $xapitype,
            'name' => [
                $lang => $instancename,
            ],
        ],
    ];

    return $object;
}

/**
 * Returns the object element in the xAPI call.
 *
 * @param array $config
 * @param int $questionid
 * @return array
 */
function spa_question(array $config, $questionid)
{
    $lang = $config['source_lang'];
    $repo = $config['repo'];
    $xapitype = 'http://activitystrea.ms/schema/1.0/question';

    $question = $repo->read_record_by_id('spa_question', $questionid);

    // If the question exists in the database use it's name as instance name, otherwise just use SPA question.
    $instancename = ($question !== null) ? $question->name : 'SPA question';
    $questionurl = $config['app_url'].'/mod/spa/editquestion.php?id='.$questionid;

    $object = [
        'id' => $questionurl,
        'definition' => [
            'type' => $xapitype,
            'name' => [
                $lang => $instancename,
            ],
        ],
    ];

    return $object;
}