<?php

?>

<div style="height:30px;"></div>
<div id="error-message-handler" class="alert alert-warning">
    <center>
        <div class="h2">あなたは最後の操作から<?php echo ($timeout/3600); ?>時間経過しても、<br>
                    何も操作が無いので、自動的にログアウトする。</div>
		<br/><br/>
        <button type="button" class="btn btn-lg btn-success">
			それで、システムの機能を使うために、ログインしてください
            <a id="countdown_time">2</a>
		</button>
        <script>
            $('.btn-success').click(function(){
                $(location).attr('href', 'index.php?view=home');
            })
            var sec = 2;
            var timer = setInterval(function() {
                if (sec == -1) {
                    clearInterval(timer);
                    $(location).attr('href', "<?php echo Router::url(array('controller'=>'users', 'action'=>'login')) ?>");
                }else{
                    $('#countdown_time').text(sec--);
                }
            }, 1000);
        </script>
    </center>
</div>
<div style="height:30px;"></div>
