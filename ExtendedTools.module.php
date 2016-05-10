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

class ExtendedTools extends CGExtensions {
    /* ---------------------------------------------------------
      Constructor
      --------------------------------------------------------- */

    public function __construct() {
        parent::__construct();
    }

    /* ---------------------------------------------------------
      SetParameters
      --------------------------------------------------------- */

    public function InitializeFrontend() {
        extended_tools_smarty::init();
    }

    public function InitializeAdmin() {
            extended_tools_smarty::init();
    }

    public function LazyLoadFrontend() {
        return FALSE;
    }

    public function GetName() {
        return 'ExtendedTools';
    }

    public function GetFriendlyName() {
        return $this->Lang('friendlyname');
    }

    public function GetVersion() {
        return '2.0.0';
    }

    public function GetHelp() {
        return $this->Lang('help');
    }

    public function GetAuthor() {
        return '@kuzmany';
    }

    public function GetAuthorEmail() {
        return 'zdeno@kuzmany.biz';
    }

    public function GetChangeLog() {
        return $this->Lang('changelog');
    }

    public function IsPluginModule() {
        return true;
    }

    public function HasAdmin() {
        return false;
    }

    public function GetAdminDescription() {
        return $this->Lang('moddescription');
    }

    public function GetDependencies() {
        return array('CGExtensions' => '1.26');
    }

    public function MinimumCMSVersion() {
        return "1.10";
    }

    public function GetEventDescription($eventname) {
        return $this->Lang('event_info_' . $eventname);
    }

    public function GetEventHelp($eventname) {
        return $this->Lang('event_help_' . $eventname);
    }

    public function InstallPostMessage() {
        return $this->Lang('postinstall');
    }

    public function UninstallPostMessage() {
        return $this->Lang('postuninstall');
    }

    public function UninstallPreMessage() {
        return $this->Lang('really_uninstall');
    }

}

?>
