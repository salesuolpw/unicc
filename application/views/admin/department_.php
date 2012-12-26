
<div class="container" id="admin">
	<div class="wrapper minh">
					<h1 class="title2">Departments and Positions</h1>
					<form action="<?=base_url()."employees/add";?>" method="POST" onsubmit="return validate();">
					<div class="thebox">
					
					<h1 class="ttle">Departments</h1>
					<div class="g-button-group tdepcon" id="dep-c" >
									  <a class="g-button dropdown-toggle blue department"  data-toggle="dropdown" href="#">
											<span id="tdep" title="Select Department"><?=$current[0]['dep_name'];?></span> <span class="caret"></span>
						
									  </a>
									  <ul class="dropdown-menu">
										<?php
							
										
										foreach($gdep as $key){
										echo "<li><a href='".base_url()."jobanddep/department/".$key['id']."' class='slectdep' id='dp_".$key['id']."' title='".$key['dep_name']."'>".$key['dep_name']."</a></li>";
										}
										
										
										?>
									  </ul>
								
									</div>
									<br class="clear" />
					<h1 class="ttle">Positions</h1>
					<div class="datagrid left" style="margin-top:10px;width:400px">
					<table width="100%" cellspacing="0" id="deptbl">
						<thead>
						<tr>
							<th class="jtr">Positions</th>
							<th>Action</th>
						</tr>
						<?php
							foreach($jobs as $key){
							
							?>
							<tr><td class='jtr'><?=$key['job_name'];?></td>
							<td>
							<a href="<?=base_url()."jobanddep/jobs/".$key['id'];?>" class="to_modf g-button green mini no-text" title="Modify" data-reveal-id='myModal' id="to_modf/<?=$key['id'];?>"><i class="icon-edit icon-white"></i></a>
							<a onclick="return confirm('Are you sure you want to delete this Department?')" href="<?=base_url()."jobanddep/delete/jobs/".$key['id'];?>" class="g-button red mini no-text" class="Delete" title="Delete"><i class="icon-trash icon-white"></i></a>
							</td></tr>
								<?php
								}
						?>
						</table>
					</div>
					<div class="right">
							asdflasjdflkjlkj
					</div>
					<br class="clear" />
					</div>
					
							
	</div>
</div>