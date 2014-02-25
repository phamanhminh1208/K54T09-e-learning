<?php
if($this->Session->check('User.id')){		
	
	$left_panel = array(
		1		=>	array(
		),
		2		=>	array(
		),
		3		=>	array(
			"ホーム"			=>	array(
					'controller'	=>	'students',
					'action'		=>	'homepage'
			),
			"授業"			=>	array(
					"リスト"		=>	array(
							'controller'	=>	'users',
							'action'		=>	'logout'
					),
					"受けたリスト"	=>	array(
							'controller'	=>	'users',
							'action'		=>	'logout'
					),
			),
			"受けたテスト"		=>	array(
					'controller'	=>	'users',
					'action'		=>	'logout'
			),
			"先生リスト"		=>	array(
					'controller'	=>	'users',
					'action'		=>	'logout'
			),
		),
	);
	
	$right_panel = array(
		$this->Session->read('User.RealName')	=>	array(
			"プロフィール"		=>	array(
					'controller'	=>	'users',
					'action'		=>	'logout'
			),
			"ログアウト"		=>	array(
					'controller'	=>	'users',
					'action'		=>	'logout'
			),
		)
	);		
?>

<script type="text/javascript">
    function activeParentMenu(){
        $("#sub_active").parent().parent().addClass("active");
    }
</script>


<div id="top_menu_nav" style="margin: 20px;">
    <ul class="nav nav-pills">
        <?php			
            foreach($left_panel[$this->Session->read('User.UserType')] as $menu => $link){
                if(array_key_exists('action', $link)){					
                    echo "<li ";
                    if($this->action==$link['action']){
                        echo "class='active'";
                    }
                    echo ">".$this->Html->link($menu, $link)."</li>";
                }else{
        ?>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle"><?php echo $menu; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
        <?php 
                    foreach($link as $submenu => $sublink){
                        echo "<li ";
                        if($this->action == $sublink['action']){
                            echo "class='active' id='sub_active'";
                        }
                        echo ">".$this->Html->link($submenu, $sublink)."</li>";
                        if($this->action==$sublink['action']){
        ?>
                            <script type="text/javascript">
                                activeParentMenu();
                            </script>
        <?php
                        }
                    }
        ?>
            </ul>
        </li>
        <?php
                }
            }
        ?>      
            
        <li class="navbar-nav pull-right">
        <?php
			foreach($right_panel as $menu => $link_arr){
				echo "<a href='#' data-toggle='dropdown' class='dropdown-toggle'>". $menu ."<b class='caret'></b></a>";
				echo "<ul class='dropdown-menu'>";
				$num = count($link_arr);
				$count = 1;
				foreach($link_arr as $submenu => $sublink){
					echo "<li>".$this->Html->link($submenu, $sublink)."</li>";
					if(++$count==$num){
						echo "<li class='divider'></li>";
					}
				}
				echo "</ul>";
			}
            /*foreach($right_panel as $menu => $link){
                echo "<a href='".$link."'>".$menu." <b class=;caret'></b></a>";
            }*/
        ?>                    
        </li>
    </ul>
</div>
<?php
}
?>