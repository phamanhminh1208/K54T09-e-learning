<div id="page-content">
    <h2 id="page-title">授業情報</h2>
    <div id="top-function" align="right">
        <?php
        switch ($this->Session->read('User.UserType')) {
            case User::_TYPE_STUDENT:                
                if (count($data['LessonStudent']) > 0) {//when studying
                    echo "<button class='btn btn-primary'> いいね </button>";
                } else {//when not studying
                    echo "<button class='btn btn-primary'> 支払う </button>";
                }
                echo $this->Html->link('通報', array(
                    'controller' => 'reports',
                    'action' => 'report',
                    //type
                    $data['Lesson']['id'],
                ), array('class' => 'btn btn-primary'));
                break;

            case User::_TYPE_TEACHER:
                echo $this->Html->link('変更', array(
                    'controller' => 'lessons',
                    'action' => 'update',
                    $data['Lesson']['id'],
                ), array('class' => 'btn btn-primary'));
                echo $this->Html->link('削除', array(
                    'controller' => 'lessons',
                    'action' => 'delete',
                    $data['Lesson']['id'],
                ), array('class' => 'btn btn-primary'));
                break;

            case User::_TYPE_MANAGER:
                echo $this->Html->link('ロック', array(
                    'controller' => 'lessons',
                    'action' => 'lock',
                    //type
                    $data['Lesson']['id'],
                ), array('class' => 'btn btn-primary'));
                echo $this->Html->link('削除', array(
                    'controller' => 'lessons',
                    'action' => 'delete',
                    $data['Lesson']['id'],
                ), array('class' => 'btn btn-primary'));
                break;
        }
        ?>        
    </div>

    <table id="lesson_information" width="60%">
        <tr>
            <th style="text-align:right;" class="col-sm-4">授業の名前:</th>
            <td style="text-align:left" class="col-sm-8">
                <?php echo $data['Lesson']['LessonName'] ?>
            </td>
        </tr>
        <tr>
            <th style="text-align:right;">授業の説明:</th>
            <td style="text-align:left">
                <?php echo $data['Lesson']['Description'] ?>
            </td>
        </tr>
        <tr>
            <th style="text-align:right;">タグ:</th>
            <td style="text-align:left">
                <?php
                $count = 0;
                foreach ($data['LessonTag'] as $tag) {
                    if ($count++ > 0) {
                        echo "; ";
                    }
                    echo $tag['Tag'];
                }
                ?>
            </td>
        </tr>
    </table>
    <br />
    <hr />

    <div id='files-list'>
        <b><font color="#000099">ファイルリスト</font></b>
        <br />
        <table id='files' width="100%" border="1" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th class='col-sm-1'>順番</th>
                    <th class='col-sm-3'>名前</th>
                    <th class='col-sm-4'>説明</th>
                    <th class='col-sm-2'>時刻</th>
                    <th class='col-sm-2'>
                        <?php
                        if ($this->Session->read('User.UserType') == User::_TYPE_STUDENT) {
                            echo "通報";
                        } else if ($this->Session->read('User.UserType') == User::_TYPE_TEACHER) {
                            echo "削除";
                        }
                        ?>
                    </th>
                </tr>
            </thead>

            <tbody>
                <?php
                $count = 1;
                foreach ($data['File'] as $file) {
                    echo "<tr id='file". $file['id'] ."' class='file'>";
                    echo "<td class='file_count'>" . $count++ . "</td>";
                    echo "<td>" . $file['FileName'] . "</td>";
                    echo "<td>" . $file['Description'] . "</td>";
                    echo "<td>" . date('Y-d-m', strtotime($file['UploadTime'])) . "</td>";
                    
                    echo "<td align='center'>";
                    switch ($this->Session->read('User.UserType')) {
                        case User::_TYPE_STUDENT:
                            echo $this->Html->link('通報', array(
                                'controller' => 'reports',
                                'action' => 'report',
                                //type
                                $test['id'],
                            ), array('class' => 'btn btn-primary'));
                            break;

                        case User::_TYPE_TEACHER:
                            echo "<button class='btn btn-primary' onclick='deleteFile(". $file['id'] .");'>削除</button>";
                            break;

                        case User::_TYPE_MANAGER:
                            echo $this->Html->link('ロック', array(
                                'controller' => 'files',
                                'action' => 'lock',                                
                                $file['id'],
                            ), array('class' => 'btn btn-primary'));
                            echo "<button class='btn btn-primary' onclick='deleteFile(". $file['id'] .");'>削除</button>";
                            break;
                    }
                    echo "</td>";
                    
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id='tests-list'>
        <b><font color="#000099">テストリスト</font></b>
        <br />
        <table id='tests' width="100%" border="1" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th class="col-sm-1">順番</th>
                    <th class="col-sm-2">名前</th>
                    <th class="col-sm-3">説明</th>
                    <th class="col-sm-2">時刻</th>
                    <?php
                    if ($this->Session->read('User.UserType') != User::_TYPE_STUDENT) {
                        echo "<th class='col-sm-2'>受けた学生</th>";
                    }                    
                    ?>
                    <th class="col-sm-2">
                        <?php
                        if ($this->Session->read('User.UserType') == User::_TYPE_STUDENT) {
                            echo "通報";
                        } else if ($this->Session->read('User.UserType') == User::_TYPE_TEACHER) {
                            echo "削除";
                        }
                        ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($data['Test'] as $test) {
                    echo "<tr id='test". $test['id'] ."' class='test'>";
                    echo "<td class='test_count'>" . ($count++) . "</td>";
                    echo "<td>" . $test['TestName'] . "</td>";
                    echo "<td>" . $test['Description'] . "</td>";
                    echo "<td>" . date('Y-d-m', strtotime($test['UploadTime'])) . "</td>";
                    
                    if($this->Session->read('User.UserType') != User::_TYPE_STUDENT){
                        echo "<td class='detail-link'>". $this->Html->link('詳細', array(
                            'controller'        =>  'tests',
                            'action'            =>  'listStudent',
                            $test['id']
                        )) ."</td>";
                    }
                    
                    echo "<td align='center'>";
                    switch ($this->Session->read('User.UserType')) {
                        case User::_TYPE_STUDENT:
                            echo $this->Html->link('通報', array(
                                'controller' => 'reports',
                                'action' => 'report',
                                //type
                                $test['id'],
                            ), array('class' => 'btn btn-primary'));
                            break;

                        case User::_TYPE_TEACHER:
                            echo "<button class='btn btn-primary' onclick='deleteTest(". $test['id'] .");'>削除</button>";
                            break;

                        case User::_TYPE_MANAGER:
                            echo $this->Html->link('ロック', array(
                                'controller' => 'tests',
                                'action' => 'lock',                                
                                $test['id'],
                            ), array('class' => 'btn btn-primary'));
                            echo "<button class='btn btn-primary' onclick='deleteTest(". $test['id'] .");'>削除</button>";
                            break;
                    }
                    echo "</td>";
                    
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <br />
    <hr>

    <div id="comments-list">
        <b><font color="#000099">コンメントリスト</font></b>
        <br />
        <br />
        <?php
        if ($this->Session->read('User.UserType')!=User::_TYPE_STUDENT || count($data['LessonStudent']) > 0) {
            echo "<div id='new_comment' align='left' style='left-margin:20%'>";            
            echo "<textarea id='new_comment_content' class='textarea-xxlarge' placeholder='コンメント'></textarea>";
            echo "<button id='comment-btn' class='btn btn-primary' onclick='newComment(". 
                    $data['Lesson']['id'] .",". $this->Session->read('User.id') .",". $this->Session->read('User.UserType') .");'>コンメント</button>";            
            echo "</div>";
        }
        ?>
        <hr>
        <table id="comments" border="1" class="table table-bordered table-striped">
           
        </table>							
    </div>
    
    <script>
        var timer = setInterval(function() {
            updateComment("<?php echo $data['Lesson']['id']; ?>", 
                                <?php echo $this->Session->read('User.id'); ?>, 
                                <?php echo $this->Session->read('User.UserType');?>);
        }, 1000);
        updateComment("<?php echo $data['Lesson']['id']; ?>", 
                                <?php echo $this->Session->read('User.id'); ?>, 
                                <?php echo $this->Session->read('User.UserType');?>);
    </script>
</div>
