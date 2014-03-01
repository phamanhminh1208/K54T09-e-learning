<?php
/**
* @author MinhPA
* @website 
* @email phamanhminh1208@gmail.com
* @copyright by MinhPA
* @license 
**/

?>

<div id="page-content">
	<h2 id="page-title" align="center"> ホームページ </h2>
	
	<div align="left">
		<a class="btn btn-primary"> バックアップ/復元" </a>
		<a class="btn btn-primary"> 統計 </a>
		<a class="btn btn-primary"> 定数を変更 </a>
		<a class="btn btn-primary"> ユーザー・リスト </a>
	</div>
	
	<br>
	<div align="left">
		<a class="btn btn-primary"> 授業リスト </a>
		<a class="btn btn-primary"> 通報-覧 </a>
		<a class="btn btn-primary" href="<?php echo Router::url(array(
													'controller'	=>	'managers',
													'action'		=>	'add'
											));?>"> 管理者を追加 </a>
	</div>
</div>