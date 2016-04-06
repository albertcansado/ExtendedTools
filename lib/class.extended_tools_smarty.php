<?php

#-------------------------------------------------------------------------
# Module: Extended tools for CMS Made Simple (@kuzmany)
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/mediacenter/
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------

/**
 *
 */
class extended_tools_smarty {

    /**
     * Initialize the smarty plugins.
     */
    public static function init() {

        $smarty = cmsms()->GetSmarty();
        $smarty->register_function('extended_nms_list', array('extended_tools_smarty', 'nms_list')); 
        $smarty->register_function('get_alias_from_id', array('extended_tools_smarty', 'get_alias_from_id'));
        $smarty->register_function('get_id_from_alias', array('extended_tools_smarty', 'get_id_from_alias'));
        $smarty->register_function('get_config', array('extended_tools_smarty', 'get_config'));
        $smarty->register_function('date_countdown', array('extended_tools_smarty', 'date_countdown'));
        $smarty->register_modifier('url', array('extended_tools_smarty', 'url_from_text'));
        $smarty->register_modifier('md5', array('extended_tools_smarty', 'extended_md5'));
        $smarty->register_modifier('nonbreaking', array('extended_tools_smarty', 'nonbreaking'));
        $smarty->register_modifier('truefalse', array('extended_tools_smarty', 'truefalse'));
        $smarty->register_modifier('filename', array('extended_tools_smarty', 'filename'));
        $smarty->register_function('value_compare', array('extended_tools_smarty', 'value_compare'));
        $smarty->register_function('string_to_date', array('extended_tools_smarty', 'string_to_date'));
        $smarty->register_function('array_assign', array('extended_tools_smarty', 'array_assign'));
        $smarty->register_function('extended_cgfb_api', array('extended_tools_smarty', 'extended_cgfb_api'));
        $smarty->register_block('fresh_files', array('extended_tools_smarty', 'fresh_files'));
        $smarty->assign('is_ajax', extended_tools_opts::is_ajax());
    }

    /**
     * A smarty plugin to perform an api call using the users access token.
     *
     * special paramters:
     * call: string - contains the URL to call
     * assign: string - assign the results to the specified smarty variable.
     */
    public static function extended_cgfb_api($params, &$smarty) {
        if (!isset($params['call']))
            return;

        $call = trim($params['call']);
        unset($params['call']);


        $res = extended_cgfb::cgfb_api($call, 'GET', $params);
        if (!$res)
            return;

        if (isset($params['assign'])) {
            $smarty->assign($params['assign'], $res);
            return;
        }

        return $res;
    }

    public static function fresh_files($params, $content, &$smarty, $repeat) {
        if (!$content)
            return;

        $timeparam = 't';
        if (isSet($params["timeparam"]))
            $timeparam = $params["timeparam"];


        $old_errorval = libxml_use_internal_errors(true);
        $dom = new CGDomDocument();
        $dom->loadHTML($content);

        $config = cmsms()->GetConfig();
        $newContent = "";
        foreach ($params as $tag => $attr) {
            if (startswith($tag, 'tag_')) {
                $tag = strtolower(substr($tag, strlen('tag_')));
                $scripts = $dom->getElementsByTagName($tag);
                if (is_object($scripts) && $scripts->length) {
                    for ($i = 0; $i < $scripts->length; $i++) {
                        $node = $scripts->item($i);
                        $sxe = simplexml_import_dom($node);
                        $src = extended_tools_opts::removeParams($sxe->attributes()->$attr);
                        if (strpos($src, 'http') !== FALSE) {
                            $sxe[0] = "";
                            $newContent.=$sxe->asXML() . "\n";
                            continue;
                        } else {
                            $file = cms_join_path($config["root_path"], $src);
                        }
                        if (!file_exists($file))
                            continue;
                        $filetime = filemtime($file);
                        $sxe->attributes()->$attr = extended_tools_opts::addParam($src, $timeparam . '=' . $filetime);
                        $sxe[0] = "";
                        $newContent.=$sxe->asXML() . "\n";
                    }
                }
            }
        }
        if ($newContent)
            $content = $newContent;

        if (isset($params['assign'])) {
            $smarty->assign($params['assign'], $content);
            return;
        }
        return $content;
    }

    public static function set_data($params, &$smarty) {

        if (!isSet($params["data"]))
            return;

        if (!isSet($params["key1"]))
            return;

        $data = $params["data"];
        $key1 = $params["key1"];

        $key2 = '';
        $key3 = '';
        $key4 = '';

        if (isSet($params["key2"]))
            $key2 = $params["key2"];
        if (isSet($params["key3"]))
            $key3 = $params["key3"];
        if (isSet($params["key4"]))
            $key3 = $params["key4"];

        $datastore = new cge_datastore();
        $datastore->store(json_encode($data), $key1, $key2, $key3, $key4);
    }

    public static function get_data($params, &$smarty) {

        if (!isSet($params["key1"]))
            return;

        $key1 = $params["key1"];

        $key2 = '';
        $key3 = '';
        $key4 = '';

        if (isSet($params["key2"]))
            $key2 = $params["key2"];
        if (isSet($params["key3"]))
            $key3 = $params["key3"];
        if (isSet($params["key4"]))
            $key3 = $params["key4"];


        $datastore = new cge_datastore();
        $data = $datastore->get($key1, $key2, $key3, $key4);

        if (!$data)
            $output = '';
        else
            $output = json_decode($data);



        if (isset($params['assign'])) {
            $smarty->assign($params['assign'], $output);
            return;
        }

        return $output;
    }

    /**
     * deprecated
     * @param type $params
     * @param type $smarty
     * @return boolean
     * @throws Exception 
     */
    public static function extended_nms_list($params, &$smarty) {

        $output = '';

        // job id require
        if (!iSSet($params["job_id"]))
            return FALSE;

        // module check
        $nmstrack = cms_utils::get_module('NMSTrack');
        if (!$nmstrack)
            throw new Exception('NMSTrack isn\'t installed.');

        $nms = cms_utils::get_module('NMS');
        if (!$nsm)
            throw new Exception('NMS isn\'t installed.');

        $separator = ', ';
        if (isSet($params["separator"]))
            $separator = $params["separator"];

        $q = "SELECT name, description FROM " .
                NMS_LIST_TABLE . " A left join " .
                NMS_JOB_PARTS_TABLE . " B on A.listid = B.listid
	  WHERE B.jobid = ? ";
        $lists = $db->GetAll($q, array($messages[$i]['job_id']));
        if ($lists) {
            foreach ($lists as $list) {
                $output .= $list["name"] - $list["description"] . $separator;
            }
        }

        $output = extended_tools_opts::where_statement($output, $separator);

        if (isset($params['assign'])) {
            $smarty->assign($params['assign'], $output);
            return;
        }

        return $output;
    }

    public static function get_alias_from_id($params, &$smarty) {

        if (!isSet($params["page_id"]))
            return FALSE;

        $output = '';

        $contentops = cmsms()->GetContentOperations();
        $smarty = cmsms()->GetSmarty();

        $output = $contentops->GetPageAliasFromId($params["page_id"]);


        if (isset($params['assign'])) {
            $smarty->assign($params['assign'], $output);
            return;
        }

        return $output;
    }

    public static function get_id_from_alias($params, &$smarty) {

        if (!isSet($params["alias"]))
            return FALSE;

        $output = '';

        $output = cms_content_cache::get_id_from_alias($params["alias"]);

        if (isset($params['assign'])) {
            $smarty->assign($params['assign'], $output);
            return;
        }

        return $output;
    }

    public static function url_from_text($string, $target = '_self', $rel = '') {
        return extended_tools_opts::make_clickable($string, $target, $rel);
    }

    public static function extended_md5($string) {
        return md5($string);
    }

    public static function truefalse($input) {

        $admintheme = cmsms()->get_variable('admintheme');

        if ($input) {
            return $admintheme->DisplayImage('icons/system/true.gif', lang('true'), '', '', 'systemicon');
        } else {
            return $admintheme->DisplayImage('icons/system/false.gif', lang('false'), '', '', 'systemicon');
        }
    }

    public static function filename($file) {

        $info = pathinfo($file);
        $file_name = basename($file, '.' . $info['extension']);
        return $file_name;
    }

    public static function get_config($params, &$smarty) {

        if (!isSet($params["key"]))
            return;

        $config = cmsms()->GetConfig();

        $output = $config[$params["key"]];

        if (isset($params['assign'])) {
            $smarty->assign($params['assign'], $output);
            return;
        }
        return $output;
    }

    public static function date_countdown($params, &$smarty) {

        if (!isSet($params["date"]))
            return;

        $output = '';

        if ($params["date"] == date("Y-m-d", time())) {
            $output = !isSet($params["today"]) ? '' : $params["today"];
        } else if ($params["date"] == date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")))) {
            $output = !isSet($params["yesterday"]) ? '' : $params["yesterday"];
        } else if ($params["date"] == date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")))) {
            $output = !isSet($params["tomorow"]) ? '' : $params["tomorow"];
        }

        if (!$output)
            $output = isSet($params["date_out"]) ? $params["date_out"] : $params["date"];

        if (isset($params['assign'])) {
            $smarty->assign($params['assign'], $output);
            return;
        }
        return $output;
    }

    public function value_compare($params, &$smarty) {

        if (!isSet($params["object"]) || !isSet($params["par"]) || !isSet($params["cache"]) || !isSet($params["value"]))
            return;

        $object = $params["object"];
        $par = $params["par"];
        $cache = $params["cache"];
        $value = $params["value"];


// get cache
        $tmp = cms_utils::get_app_data($cache);

        if (!is_array($tmp)) {
            $tmp = array();
            foreach ($object as $item) {
                if (isSet($item->$par)) {
                    $tmp[$item->$par] = 1;
                } else if (isSet($item[$par])) {
                    $tmp[$item[$par]] = 1;
                }
            }
        }

// set cache
        cms_utils::set_app_data($cache, $tmp);

        $return = false;
        if (isSet($tmp[$value])) {
            $return = true;
        }


        if (isSet($params["assign"]))
            $smarty->assign($params["assign"], $return);
        else
            echo $return;
    }

    public function string_to_date($params, &$smarty) {

        if (!isSet($params["string"]))
            return;

        $string = $params["string"];

        $return = strtotime($string);


        if (isSet($params["assign"]))
            $smarty->assign($params["assign"], $return);
        else
            echo $return;
    }

    /**
     * array assign
     * @param array type $params
     * @param object type $smarty
     * @return array type 
     */
    public static function array_assign($params, &$smarty) {
        if (!isSet($params["array"]) || !is_array($params["array"]) || !isSet($params["par"]) || !isSet($params["value"]))
            return;

        $array = $params["array"];
        $par = $params["par"];
        $value = $params["value"];

        $array[$par] = $value;

        if (isSet($params["assign"]))
            $smarty->assign($params["assign"], $array);
        else
            echo $array;
    }

    public static function nonbreaking($string) {
        $search_array = array(' i ', ' a ', ' u ', ' o ', ' v ');
        $replace_array = array(' i&nbsp;', ' a&nbsp;', ' u&nbsp;', ' o&nbsp;', ' v&nbsp;');
        return str_replace($search_array, $replace_array, $string);
    }

}

// end of class
#
# EOF
#
?>
