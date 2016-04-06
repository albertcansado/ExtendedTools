 {*<fieldset>
<legend>Upload</legend>
<form action="http://upload.divshare.com/api/upload" method="post" enctype="multipart/form-data"> 

    <input type="hidden" name="upload_ticket" value="{$upload_ticket}" />
    <input type="hidden" name="response_url" value="{$return_link}" />
    <div class="pageoverflow">
  <p class="pageinput">{$mod->Lang('file')}: <input type="file" name="file1" />
  {$mod->Lang('folder')}:
  <select name="folder_id">
        <option value="534952">audio</option>
        <option value="536302">video</option>
    </select>
    
    <input type="submit" value="Upload" />
  </p>
</div>

</form>
</fieldset>
<br /><br />*}
<p>{$addlink}</p>
<table cellspacing="0" class="pagetable">
	<thead>
		<tr>
			<th>{$mod->Lang('image')}</th>
			<th>{$mod->Lang('title')}</th>
			<th>&nbsp;</th>			
			<th>&nbsp;</th>			
		</tr>
	</thead>
	<tbody>
{foreach from=$items item=entry}
	{cycle values="row1,row2" assign='rowclass'}
		<tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">				
			<td><img src="{$entry->thumb}" alt="{$entry->title}" /></td>		
			<td>{$entry->title}</td>
			<td>{$entry->editlink}</td>
			<td>{$entry->deletelink}</td>
		</tr>
{/foreach}
	</tbody>
</table>
