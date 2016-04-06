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

class extended_tools_hash {

    private static $hash_string = 'big';

    public function __construct() {
        
    }

    public static function hash($key, & $params) {

        $salt = self::hash_strong($key);
        $hash = self::hash_strong($salt . self::$hash_string . $_SERVER["REMOTE_ADDR"]);

        $params["salt"] = $salt;
        $params["hash"] = $hash;
    }

    public static function hash_compare($params) {

        if (!isSet($params["hash"]) || !isSet($params["salt"]))
            return FALSE;
        $salt = $params["salt"];
        $hash = $params["hash"];

        $hash2 = self::hash_strong($salt . self::$hash_string . $_SERVER["REMOTE_ADDR"]);
        if ($hash == $hash2)
            return TRUE;
        else
            return FALSE;
    }
    
    public static function hash_params($params) {

        if (!isSet($params["hash"]) || !isSet($params["salt"]))
            return array();
        
        $parms = array();
        $parms["salt"] = $params["salt"];
        $parms["hash"] = $params["hash"];
        
        return $parms;
    }
    
    private static function hash_strong($hash, $repeat = 100) {
        for ($i = 0; $i < $repeat; $i++) {
            $hash = md5($hash);
        }
        return $hash;
    }

}

?>
