<div id="register_success_div" class="alert alert-success">
    <center>
        <h2>あなたの管理者追加が成功した。</h2>
		<br/><br/>
        <button type="button" class="btn btn-lg btn-success">
			ホームページを行く。
            <a id="countdown_time">2</a>
		</button>
        <script>
            $('.btn-success').click(function(){
                $(location).attr('href', "<?php echo Router::url(array('controller'=>'managers', 'action'=>'homepage')) ?>");
            });
            var sec = 2;
            var timer = setInterval(function() {
                if (sec == -1) {
                    clearInterval(timer);
                    $(location).attr('href', "<?php echo Router::url(array('controller'=>'managers', 'action'=>'homepage')) ?>");
                }else{
                    $('#countdown_time').text(sec--);
                }
            }, 1000);
        </script>
    </center>
</div>