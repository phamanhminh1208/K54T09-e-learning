<?php
/**
 * @author MinhPA
 * @website 
 * @email phamanhminh1208@gmail.com
 * @copyright 
 * @license by MinhPA
 * */
?>

<div id="page-content">
    
    <h2 id="page-title" align="center">ホームページ</h2>

    <div align="right">
        <button class="btn btn-primary"> 抹消 </button>
        <button class="btn btn-primary"> 警告リスト </button>
    </div>

    <p align="left" style="font-weight:bold; color:#0000CC">勉強している授業</p>
    <table width="100%" border="1" class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th class="col-sm-1">
                    順番                    
                </th>

                <th class="col-sm-6">
                    授業
                    <span style="display:block;">
                        <?php
                            echo $this->Paginator->sort('Lesson.LessonName', 
                                    "<b>".$this->Html->image('btn_down.png', array('alt' => 'down', 'width' => '16', 'height' => '16'))."</b>", 
                                    array(
                                        'direction' => 'desc', 
                                        'escape' => false
                                    )
                            );
                            
                            echo $this->Paginator->sort('Lesson.LessonName', 
                                    "<b>".$this->Html->image('btn_up.png', array('alt' => 'up', 'width' => '16', 'height' => '16'))."</b>", 
                                    array(
                                        'direction' => 'asc', 
                                        'escape' => false
                                    )
                            );                        
                        ?>								
                    </span>
                </th>

                <th class="col-sm-2">
                    受けた時間
                    <span style="display:block;">
                        <?php
                            echo $this->Paginator->sort('LessonStudent.Time', 
                                    "<b>".$this->Html->image('btn_down.png', array('alt' => 'down', 'width' => '16', 'height' => '16'))."</b>", 
                                    array(
                                        'direction' => 'desc', 
                                        'escape' => false
                                    )
                            );
                            
                            echo $this->Paginator->sort('LessonStudent.Time', 
                                    "<b>".$this->Html->image('btn_up.png', array('alt' => 'up', 'width' => '16', 'height' => '16'))."</b>", 
                                    array(
                                        'direction' => 'asc', 
                                        'escape' => false
                                    )
                            );
                        ?>								
                    </span>
                </th>

                <th class="col-sm-2">
                    終わり時間
                    <span style="display:block;">
                        <?php
                            echo $this->Paginator->sort('LessonStudent.EndTime', 
                                    "<b>".$this->Html->image('btn_down.png', array('alt' => 'down', 'width' => '16', 'height' => '16'))."</b>", 
                                    array(
                                        'direction' => 'desc', 
                                        'escape' => false
                                    )
                            );
                            
                            echo $this->Paginator->sort('LessonStudent.EndTime', 
                                    "<b>".$this->Html->image('btn_up.png', array('alt' => 'up', 'width' => '16', 'height' => '16'))."</b>", 
                                    array(
                                        'direction' => 'asc', 
                                        'escape' => false
                                    )
                            );
                        ?>								
                    </span>
                </th>

                <th class="col-sm-1">
                    <span style="display:block;"></span>
                </th>
            </tr>
        </thead>

        <tbody id="studying_lessons_list">
            <?php 
                $this->Paginator->options(array(
                    'update' => '#content', 
                    'before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),
                    'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false))
                ));
                
                $count = 0;
                foreach($data as $ls){
                    echo "<tr>";
                        echo "<td>".(++$count)."</td>";
                        
                        if($ls['Lesson']['Status'] == Lesson::_STATUS_NORMAL){
                            echo "<td><a href='".Router::url(array(
                                    'controller'=>'lessons', 
                                    'action'=>'view',
                                    $ls['Lesson']['id']
                            ))."'>".$ls['Lesson']['LessonName']."</a></td>";
                        }else if($ls['Lesson']['Status'] == Lesson::_STATUS_LOCKED){
                            echo "<td>".$ls['Lesson']['LessonName']."</td>";
                        }
                        
                        echo "<td>".$ls['LessonStudent']['Time']."</td>";
                        
                        echo "<td>".$ls['LessonStudent']['EndTime']."</td>";
                        
                        echo "<td><a class='btn btn-primary' href='".Router::url(array(
                                    'controller'    =>  'reports',
                                    'action'        =>  'report',
                                    $ls['Lesson']['id'],
                            ))."'>通報</a></td>";
                        
                    echo "</tr>";
                }
            ?>            
        </tbody>
    </table>

    <div class="paging btn-group">
        <?php 
            echo $this->Paginator->prev('前へ', array('class'=>'prev btn disabled'));
        
            if(!$this->Paginator->hasPage('LessonStudent', 2)){
                echo "<span class='btn disabled'>1</span>";
            }else{
                echo $this->Paginator->numbers(array('separator'=>'  ', 'class'=>'btn')); 
            }            
        
            echo $this->Paginator->next('次へ', array('class'=>'btn', 'rel'=>'next')); 
        ?>        
    </div>
    <br>

    <div align="right">
        <button class="btn btn-primary">受けた授業リスト </button>
        <button class="btn btn-primary">受けたテスト・リスト </button>
    </div>
    <hr>

    <p align="left" style="font-weight:bold; color:#0000CC">課金ファイル</p>
    <table width="40%">
        <tr>
            <th>ファイルを作成の月</th>
            <td width="40%">
                <select class="input_txt">
                    <option>2013/11</option>
                    <option>2012/10</option>
                </select>
            </td>
            <td style="border: 0px;">
                <button class="btn btn-primary">課金情報 </button>
            </td>
        </tr>
    </table>
</div>