<h1 class="ttle brd">Add Positions</h1>
				<form action="<?=base_url()."jobanddep";?>" name="add_dep" method="post">
					<?=(isset($rs)) ? $rs : null;?>
					<?=(isset($error)) ? $error : null;?>
			

<div class="g-button-group tdepcon" id="dep-c" >
									  <a class="g-button dropdown-toggle blue department"  data-toggle="dropdown" href="#">
											<span id="tdep" title="Select Department"><?=$current[0]['dep_name'];?></span> <span class="caret"></span>
						
									  </a>
									  <ul class="dropdown-menu">
										<?php
							
										
										foreach($gdep as $key){
										echo "<li><a href='".base_url()."jobanddep/department/view/".$key['id']."' class='slectdep' id='dp_".$key['id']."' title='".$key['dep_name']."'>".$key['dep_name']."</a></li>";
										}
										
										
										?>
									  </ul>
								
									</div>
			<p>Department Name:<br />
			


			<input type="text" name="dep_n" value="" class="inp-search">
			</p>
			<p>Add Position<br />
			<input type="text" value="" name="pos[]" class="inp-search"> <a href="#" onClick="addmore()">[+]Add more</a>
			</p>
			<span id="addmorespan">
			</span>
			<p><input type="submit" name="adddep" value="Save" class="g-button blue small"/></p>
			</form>
		