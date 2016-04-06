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
 * Description of class
 *
 * @author @kuzmany
 */

class extended_tools_opts {

    public function __construct() {

// construct
    }

    public static function where_statement($output, $subject) {
        return substr($output, 0, strlen($subject));
    }

    /*
     * re-arrange an array of arrays into a hash of arrays
     * by a specified key/value.
     */

    static public function to_hash($input, $key, $value) {
        $tmp = array();
        if (is_array($input)) {
            foreach ($input as $one) {
                if (!isset($one[$key]) || !isset($one[$value]))
                    continue;
                $tmp[$one[$key]] = $one[$value];
            }
        }
        return $tmp;
    }

    /*
     * re-arrange an array of objects into a hash of arrays
     * by a specified key/value.
     */

    static public function object_to_hash($input, $key, $value) {
        $tmp = array();
        if (is_array($input)) {
            foreach ($input as $one) {
                if (!isset($one->$key) || !isset($one->$value))
                    continue;
                $tmp[$one->$key] = $one->$value;
            }
        }
        return $tmp;
    }

    public static function make_clickable($text, $target, $rel) {
        $ret = " " . $text;
        $ret = preg_replace("#([\n ])([a-z]+?)://([^, <>{}\n\r]+)#i", "\\1<a href=\"\\2://\\3\" target=\"_blank\">\\2://\\3</a>", $ret);
        $ret = preg_replace("#([\n ])www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[^,< \n\r]*)?)#i", "\\1<a href=\"http://www.\\2.\\3\\4\" " . (empty($rel) == false ? "rel=\"" . $rel . "\"" : "") . " target=\"" . $target . "\">www.\\2.\\3\\4</a>", $ret);
        $ret = substr($ret, 1);
        return $ret;
    }

    public static function is_ajax() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest")
            return true;

        return false;
    }

    public static function detailpage(&$params, $detailpage = null) {

        $gCms = cmsms();

        if (empty($detailpage) OR $detailpage == -1)
            $detailpage = cms_utils::get_current_alias();

        if (isset($params['detailpage'])) {
            $detailpage = trim($params['detailpage']);
        }

        if (!empty($detailpage)) {
            $manager = $gCms->GetHierarchyManager();
            $node = $manager->sureGetNodeByAlias($detailpage);
            if (isset($node)) {
                $content = & $node->GetContent();
                if (isset($content)) {
                    $detailpage = $content->Id();
                }
            } else {
                $node = & $manager->sureGetNodeById($detailpage);
                if (!isset($node)) {
                    $detailpage = '';
                }
            }

            if ($detailpage != '') {
                $params['cd_origpage'] = (isset($params['returnid'])) ? $params['returnid'] : '';
            }
        }
        return $detailpage;
    }

    public static function get_page_id_from_alias($alias) {

        $gCms = cmsms();
        $manager = $gCms->GetHierarchyManager();
        $node = $manager->sureGetNodeByAlias($alias);
        if (isset($node)) {
            $content = & $node->GetContent();
            if (isset($content)) {
                $page_id = $content->Id();
            }
            return $page_id;
        }
    }

    /**
     * mass set preferences
     * @param array $preferences
     * @param array $params
     * @param object $mod 
     */
    public static function set_preferences(array $preferences, array $params, $mod) {
        if (empty($preferences) == false) {
            foreach ($preferences as $preference) {
                if (empty($preference))
                    continue;

                if (isSet($params[$preference])) {
                    $mod->SetPreference($preference, $params[$preference]);
                } else {
                    $mod->RemovePreference($preference);
                }
            }
        }
    }

    private static function _adjustParam($url, $s) {
        if (preg_match('/(.*?)\?/', $url, $matches))
            $urlWithoutParams = $matches[1];
        else
            $urlWithoutParams = $url;

        parse_str(parse_url($url, PHP_URL_QUERY), $params);

        if (strpos($s, '=') !== false) {
            list($var, $value) = split('=', $s);
            $params[$var] = urldecode($value);
            return $urlWithoutParams . '?' . http_build_query($params);
        } else {
            unset($params[$s]);
            $newQueryString = http_build_query($params);
            if ($newQueryString)
                return $urlWithoutParams . '?' . $newQueryString;
            else
                return $urlWithoutParams;
        }
    }

    public static function addParam($url, $s) {
        return self::_adjustParam($url, $s);
    }

    public static function removeParams($src) {
        $parts = explode('?', $src);
        return $parts[0];
    }

    public static function get_last_cmsms_version() {
        $req = new cge_cached_remote_file('http://dev.cmsmadesimple.org/latest_version.php', 3600 * 24);
        $result = $req->file_get_contents();

        if (!$result)
            return false;
        return str_replace('cmsmadesimple:', '', $result);
    }

    public function array_random_assoc($arr, $num = 1) {
        $keys = array_keys($arr);
        shuffle($keys);

        $r = array();
        for ($i = 0; $i < $num; $i++) {
            if (!$arr[$keys[$i]])
                continue;
            if ($num == 1) {
                $r = $arr[$keys[$i]];
            } else {
                $r[$keys[$i]] = $arr[$keys[$i]];
            }
        }
        return $r;
    }

}

?>
