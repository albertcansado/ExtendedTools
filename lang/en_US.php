<?php

$lang['friendlyname'] = 'Extended Tools';
$lang['postinstall'] = 'Extended Tools was successful installed';
$lang['postuninstall'] = 'Extended Tools was successful uninstalled';
$lang['really_uninstall'] = 'Really? Are you sure
you want to unsinstall this fine module?';
$lang['uninstalled'] = 'Module Uninstalled.';
$lang['installed'] = 'Module version %s installed.';
$lang['upgraded'] = 'Module upgraded to version %s.';
$lang['moddescription'] = 'This module adds extended functions and smarty plugins for CMS Made Simple. ';
$lang['info_success'] = 'Succes';
$lang['optionsupdated'] = 'Options updated';
$lang['module_missing'] = 'Please, instal module %s';

$lang['error'] = 'Error!';
$land['admin_title'] = 'Admin Panel';
$lang['admindescription'] = '';
$lang['accessdenied'] = 'Access Denied. Please check your permissions.';
$lang['postinstall'] = 'Module installed. Congrat!:)';

$lang['changelog'] = '<ul>
<li>Version May, 2011 -  init release</li></ul>';

$lang['help'] = '

    <h2>What Does This Do?</h2>
<p>Extended Tools added some smarty tools for CMSMS modules without hacking your code.</p>

<h2>Modifiers</h2>
<h3>|url (modifier)</h3>
<p>convert all http:// and www. strings to hypertext <br ><br >{$content|url:\'_blank\':\'nofollow\'}</p>
<p>Params</p>
<ul>
    <li>second param - target</li>
    <li>third param - rel</li>
</ul>

<h3>|nonbreaking</h3> 
<p>nonbreaking for some slovak chars <br ><br >{$string|nonbreaking}</p>

<h3>|md5</h3> 
<p>md5 hash <br ><br >{$string|md5}</p>

<h3>|truefalse</h3> 
<p>return system true/false icon <br ><br >{$string|truefalse}</p>

<h3>|filename</h3> 
<p>return filename without extension<<br />applicable to the image alt</p>

<h2>Blocks</h2>

<h3>{fresh_files}{/fresh_files}</h3>
<p>add time param to relative path for you tags
<br ><strong>Example</strong>: {fresh_files tag_script="src" tag_link="href" timeparam="p"}{/fresh_files}
<br /><strong>Syntax</strong>: tag_{mytag}="param_with_url"
</p>

<h2>Tags</h2>


<h3>{extended_cgfb_api}</h3>
<p>
Extended CGFB api call without user authentification
<br />
<strong>Example</strong>: {extended_cgfb_api call="/1594202800"}</p>
<p>Params</p>
<ul>
<li>call (required) - graph api call (<a href="https://developers.facebook.com/docs/reference/api/">https://developers.facebook.com/docs/reference/api/</a>)</li>
<li>method (optional) - GET/POST</li>
<li>other params if graph api  need it</li>
<li>assign (optional) - smarty assign</li>
</ul>

<h3>{get_alias_from_id}</h3>
<p><strong>Example</strong>: {get_alias_from_id page_id=$content_id}</p>
<p>Params</p>
<ul>
<li>page_id (required) - page id</li>
<li>assign (optional) - smarty assign</li>
</ul>
<h3>{get_id_from_alias}</h3>
<p><strong>Example</strong>: {get_id_from_alias alias=$page_alias}</p>
<p>Params</p>
<ul>
<li>alias (required) - alias</li>
<li>assign (optional) - smarty assign</li>
</ul>

<h3>{get_config}</h3> 
<p><strong>Example</strong>: {get_config key="root_url"}</p>
<p>Params</p>
<ul>
<li>key (required) - key from config file</li>
<li>assign (optional) - smarty assign</li>
</ul>

<h3>{array_assign}</h3> 
<p><strong>Example</strong>: {array_assign array=$node par="category_name" value=$node.extra assign="node"}</p>
<p>Params</p>
<ul>
<li>array (required) - array</li>
<li>par (required) - parameter</li>
<li>value (required) - value</li>
<li>assign (optional) - smarty assign</li>
</ul>
<h3>{string_to_date}</h3> 
<p><strong>Example</strong>: {string_to_date string="12. 4. 2010" assign="time"}</p>
<p>Params</p>
<ul>
<li>string (required) - input date string</li>
<li>assign (optional) - smarty assign</li>
</ul>

<h3>{date_countdown}</h3>
<p> <strong>Example</strong>: {date_countdown date=$date|date_format:"%Y-%m-%d" date_out=$date|cms_date_format today="today" yesterday="yesterday"} </p>
<p>Params</p>
<ul>
<li>date (required) - input date (Y-m-d)</li>
<li>date_out (required) - output date (if havent today, yesterday output)</li>
<li>tomorow (optiona) - string for tomorow label</li>
<li>today (optiona) - string for today label</li>
<li>yesterday (optional) - string for yesterday label</li>
<li>assign (optional) - smarty assign</li>
</ul>

<h2>Classes for developers</h2>
<p>
copy_dir - manipulation with dirs and files
</p>


         <h3>Like it? Donate :)</h3>
    <p><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</p>
<h3>Do you want priority support/bug fixes?</h3> 
<p><a href="http://cmsmadesimple.sk/paid-support/">Buy paid support ticket</a> from 10 Eur</p>          
    
';
?>
