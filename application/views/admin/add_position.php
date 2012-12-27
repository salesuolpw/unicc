<h1 class="ttle brd">Add Positions</h1>
					<?=(isset($rs)) ? $rs : null;?>
					<?=(isset($error)) ? $error : null;?>
			

<div class="g-button-group tdepcon" id="dep-c" >
									  <a class="g-button dropdown-toggle blue department"  data-toggle="dropdown" href="#">
											<span id="tdep" title="Select Department">Select Department</span> <span class="caret"></span>
						
									  </a>
									  <ul class="dropdown-menu">
										<?php
							
										
										foreach($deps as $key){
										echo "<li><a href='#' class='slectdep' onClick=\"thisdep("."'".$key['dep_name']."'".",".$key['id'].")\" id='dp_".$key['id']."' title='".$key['dep_name']."'>".$key['dep_name']."</a></li>";
										}
										
										
										?>
									  </ul>
								
									</div>
			
			
			<input type="hidden" id="dep_n" value="" class="inp-search">
		
			<p>Position<br />
			<input type="text" value="" name="pos[]" class="inp-search positionko"> <a href="#" onClick="addmore()">[+]Add more</a>
			</p>
			<span id="addmorespan">
			</span>
			<p><input type="button" onClick="validate()" name="adddep" value="Save" class="g-button blue small"/></p>
			
		