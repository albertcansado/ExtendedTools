{$startform}
<fieldset>
    <legend>{$mod->Lang('app_settings')}</legend>
        <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('app_api_key')}:</p>
        <p class="pageinput">
                  {$app_api_key}<br /><a href="http://code.google.com/apis/youtube/dashboard/gwt/index.html#">http://code.google.com/apis/youtube/dashboard/gwt/index.html#</a>
        </p>
    </div>
        <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('app_description')}:</p>
        <p class="pageinput">
                  {$app_description}
        </p>
    </div>
        <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('app_localization')}:</p>
        <p class="pageinput">
                  {$app_localization}
        </p>
    </div>
</fieldset>
<fieldset>
<legend>{$mod->Lang('user_settings')}</legend>
    <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('youtube_username')}:</p>
        <p class="pageinput">
                  {$youtube_username}
        </p>
    </div>
    <div class="pageoverflow">
        <p class="pagetext">{$mod->Lang('youtube_password')}:</p>
        <p class="pageinput">
                  {$youtube_password}
        </p>
    </div>
   </fieldset>
<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}</p>
</div>
{$endform}
