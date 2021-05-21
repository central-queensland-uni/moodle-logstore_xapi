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