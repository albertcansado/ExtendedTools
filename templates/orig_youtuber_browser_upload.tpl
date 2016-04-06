<form action="{$post_url}?nexturl={$next_url}" method="post" enctype="multipart/form-data">
<input name="file" type="file"/>
<input name="token" type="hidden" value="{$token_value}"/>
<input value="{$mod->Lang('upload')}" type="submit" />
</form>