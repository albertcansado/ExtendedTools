<form action="{$upload_url}" method="post" enctype="multipart/form-data">
<input name="token" type="hidden" value="{$upload_token}"/>
<fieldset>
<legend>{$mod->Lang('title')}</legend>
	<div class="pageoverflow">
			<p class="pagetext">*{$prompttitle}:</p>
			<p class="pageinput">{$inputtitle}</p>
	</div>
	<div class="pageoverflow">
			<p class="pagetext">*{$promptdescription}:</p>
			<p class="pageinput">{$inputdescription}</p>
	</div>
	<div class="pageoverflow">
			<p class="pagetext">*{$promptcategory}:</p>
			<p class="pageinput">{$inputcategory}</p>
	</div>		
	<div class="pageoverflow">
			<p class="pagetext">*{$prompttags}:</p>
			<p class="pageinput">{$inputtags}</p>
	</div>
	<div class="pageoverflow">
			<p class="pagetext">*{$promptfile}:</p>
			<p class="pageinput">{$inputfile}</p>
	</div>			
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$hidden}{$submit} {$cancel}</p>
	</div>


</fieldset>
{$endform}