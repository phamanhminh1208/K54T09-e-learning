<?php ?>

<div id="page-content">
    <h2 id="page-title" align='center'>登録</h2>

    <?php
        echo $this->Form->create('User', array(
                'type'				=>	'post',
                'inputDefaults'		=>	array(
                        'label'				=>	false,
                        'div'				=>	false,
                ),
                'novalidate'		=>	true,
        ));
    ?>
    <div style="text-align: center; margin-top: 20px; margin-bottom: 5px;">
        <label class="label-info" id="term_of_use_label">利用規約</label>
    </div>
    
    <div id="term_of_use">
        <br/>
        規約がない
        <br/>
        <br/>
    </div>
    
    
    <div style="margin: 0 auto; text-align: center; font-size: 1.8em;">
        <span class="required"><a>ユーザーの種類を選択してください:</a></span>
        
        <?php 
            echo $this->Form->radio('Type', 
                    array(
                        User::_TYPE_STUDENT         =>  '学生',
                        User::_TYPE_TEACHER         =>  '先生'
                    ), 
                    array(
                        'default'   =>  User::_TYPE_STUDENT,
                        'escape'    =>  false,
                        'legend'    =>  false,
                        'style'     =>  'margin-right: 15px; margin-bottom: 30px;'
                    )
                );
        ?>
        
        <?php
            echo $this->Form->end(array(
                'label'     =>  '登録',
                'class'     =>  'btn btn-primary',                 
            ));
        ?>
    </div>
</div>