<?php
/**
 * @author MinhPA
 * @website 
 * @email phamanhminh1208@gmail.com
 * @copyright by MinhPA
 * @license 
 * */
App::import('Model', 'Lesson');
?>

<div id="page-content">
    <h2 id="page-title" align="center">ホームページ</h2>

    <div align="right">
        <button class="btn btn-primary"> 抹消 </button>
        <button class="btn btn-primary"> 警告リスト </button>
    </div>

    <p align="left" style="font-weight:bold; color:#0000CC">授業リスト</p>
    <table width="100%" border="1" class="table table-bordered table-hover table-striped">
        <thead>
            <tr class="frame">
                <th class="col-sm-1" style="text-align: center;">
                    順番 
        <div>&nbsp;</div>
        </th>

        <th class="col-sm-6" style="text-align: center;">
            授業
            <span style="display:block;">
                <?php
                echo $this->Paginator->sort('Lesson.LessonName', "<b>" . $this->Html->image('btn_down.png', array('alt' => 'down', 'width' => '16', 'height' => '16')) . "</b>", array(
                    'direction' => 'desc',
                    'escape' => false
                        )
                );

                echo $this->Paginator->sort('Lesson.LessonName', "<b>" . $this->Html->image('btn_up.png', array('alt' => 'up', 'width' => '16', 'height' => '16')) . "</b>", array(
                    'direction' => 'asc',
                    'escape' => false
                        )
                );
                ?>								
            </span>
        </th>

        <th class="col-sm-2" style="text-align: center;">
            作った時間
            <span style="display:block;">
            <?php
            echo $this->Paginator->sort('Lesson.MakeTime', "<b>" . $this->Html->image('btn_down.png', array('alt' => 'down', 'width' => '16', 'height' => '16')) . "</b>", array(
                'direction' => 'desc',
                'escape' => false
                    )
            );

            echo $this->Paginator->sort('Lesson.MakeTime', "<b>" . $this->Html->image('btn_up.png', array('alt' => 'up', 'width' => '16', 'height' => '16')) . "</b>", array(
                'direction' => 'asc',
                'escape' => false
                    )
            );
            ?>								
            </span>
        </th>

        <th class="col-sm-2" style="text-align: center;">
            受けた学生
            <span style="display:block;">            
            								
            </span>
        </th>

        <th class="col-sm-1">
            <span style="display:block;"></span>
        </th>
        </tr>
        </thead>

        <tbody>
        <?php
        $this->Paginator->options(array(
            'update' => '#content',
            'before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),
            'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false))
        ));

        $count = 0;
        foreach ($data as $ls) {
            echo "<tr>";
            echo "<td>" . ( ++$count) . "</td>";

            if ($ls['Lesson']['Status'] == Lesson::_STATUS_NORMAL) {
                echo "<td><a href='" . Router::url(array(
                    'controller' => 'lessons',
                    'action' => 'view',
                    $ls['Lesson']['id']
                )) . "'>" . $ls['Lesson']['LessonName'] . "</a></td>";
            } else if ($ls['Lesson']['Status'] == Lesson::_STATUS_LOCKED) {
                echo "<td>" . $ls['Lesson']['LessonName'] . "</td>";
            }

            echo "<td>" . $ls['Lesson']['MakeTime'] . "</td>";

            echo "<td>" . count($ls['LessonStudent']) . "</td>";

            echo "<td><a class='btn btn-primary' href='" . Router::url(array(
                'controller' => 'reports',
                'action' => 'report',
                $ls['Lesson']['id'],
            )) . "'>通報</a></td>";

            echo "</tr>";
        }
        ?>            
        </tbody>
    </table>

    <div class="paging btn-group">
        <?php
        echo $this->Paginator->prev('前へ', array('class' => 'prev btn disabled'));

        if (!$this->Paginator->hasPage('Lesson', 2)) {
            echo "<span class='btn disabled'>1</span>";
        } else {
            echo $this->Paginator->numbers(array('separator' => '  ', 'class' => 'btn'));
        }

        echo $this->Paginator->next('次へ', array('class' => 'btn', 'rel' => 'next'));
        ?>        
    </div>
    <br>

    <div align="right">
        <button class="btn btn-primary"> 授業を追加 </button>
    </div>
    <hr>

    <p align="left" style="font-weight:bold; color:#0000CC">課金ファイル</p>
    <table width="60%">
        <tr>
            <th>ファイルを作成の月</th>
            <td width="40%">
                <select class="input_txt">
                    <option>2013/11</option>
                    <option>2012/10</option>
                </select>
            </td>
            <td style="border: 0px;">
                <button class="btn btn-primary"> 課金情報 	></button>
            </td>
        </tr>
    </table>

</div>