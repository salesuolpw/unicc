<div class="container" id="menu-con">
	<div class="wrapper">
			<ul id="dash-b">
					<li><form action="<?=base_url()."dailytimerecord";?>" method="POST">
			View Daily Time Record | Year: 
			<select name="yr" style="height:30px;text-align:center">
			<option value="2012">2012</option>
			</select>
				Cut Off 
				<select name="c_off" style="margin-right:9px;height:30px;text-align:center">
				<option value="01-1" <?=selected($i,'01-1');?>>January, 8 - January, 23</option>	
				<option value="01-0" <?=selected($i,'01-0');?>>January, 24 - February, 7</option>	
				<option value="02-1" <?=selected($i,'02-1');?>>February, 8 - February, 23</option>	
				<option value="02-0" <?=selected($i,'02-0');?>>February, 24 - March, 7</option>	
				<option value="03-1" <?=selected($i,'03-1');?>>March, 8 - March, 23</option>	
				<option value="03-0" <?=selected($i,'03-0');?>>March, 24 - April, 7</option>	
				<option value="04-1" <?=selected($i,'04-1');?>>April, 8 - April, 23</option>	
				<option value="04-0" <?=selected($i,'04-0');?>>April, 24 - May, 7</option>	
				<option value="05-1" <?=selected($i,'05-1');?>>May, 8 - May, 23</option>	
				<option value="05-0" <?=selected($i,'05-0');?>>May, 24 - June, 7</option>	
				<option value="06-1" <?=selected($i,'06-1');?>>June, 8 - June, 23</option>	
				<option value="06-0" <?=selected($i,'06-0');?>>June, 24 - July, 7</option>	
				<option value="07-1" <?=selected($i,'07-1');?>>July, 8 - July, 23</option>	
				<option value="07-0" <?=selected($i,'07-0');?>>July, 24 - August, 7</option>	
				<option value="08-1" <?=selected($i,'08-1');?>>August, 8 - August, 23</option>	
				<option value="08-0" <?=selected($i,'08-0');?>>August, 24 - September, 7</option>	
				<option value="09-1" <?=selected($i,'09-1');?>>September, 8 - September, 23</option>	
				<option value="09-0" <?=selected($i,'09-0');?>>September, 24 - October, 7</option>	
				<option value="10-1" <?=selected($i,'10-1');?>>October, 8 - October, 23</option>	
				<option value="10-0" <?=selected($i,'10-0');?>>October, 24 - November, 7</option>	
				<option value="11-1" <?=selected($i,'11-1');?>>November, 8 - November, 23</option>	
				<option value="11-0" <?=selected($i,'11-0');?>>November, 24 - December, 7</option>	
				<option value="12-1" <?=selected($i,'12-1');?>>December, 8 - December, 23</option>	
				<option value="12-0" <?=selected($i,'12-0');?>>December, 24 - January, 7</option>	
				
				</select>
			<button name="s-dtr" class="g-button blue right" ><i class="icon-search icon-white"></i> Submit</button>
				
			
			</form></li>
					
				</ul>
	</div>
</div>
<div class="container" id="admin">
	<div class="wrapper minh">
					<h1 class="title2">Daily Time Record (<?=(isset($title))? $title : "Current";?>)</h1>
					
					
		<div class="datagrid">
		<table width="100%" class="cstm-t toboxshadow dt" cellspacing="0" style="margin-bottom:20px">
		<thead>
			<tr><th>EId</th><th>Employee Name</th> <th>Time-in</th><th>Lates</th><th>Time-out</th><th>Undertime</th><th>Date</th></tr>
		</thead>
		<tbody>
		<?php
		
		$ctr = 0;
		foreach($dtr as $key){
		//short and simple logic odd and even
		$oddoreven = (($ctr++)%2) ? "even" : "odd";
		echo "<tr  class=".$oddoreven."><td>".$key['id']."</td><td>".$key['lastname'].",".$key['firstname']." ".$key['mid_name']."</td><td>".$key['in']."</td><td>".get_hm($key['in'],$key['date'])."</td><td>".$key['out']."</td><td>".udr_time($key['out'],$key['date'])."</td><td>".$key['date']."</td></tr>";
	
		}
		
		?>
		</tbody>
		</table>
	
		<?php
		if(!empty($dtr)){
			?>
			<div class="action-con">
			<form action="<?=base_url()."dtr/summary";?>" method="POST" style="margin-bottom:30px">
			<input type="hidden" value="<?=$fora;?>" name="dte" />
			<input type="submit" value="Summary" name="smry" class="g-button green" />
			</form>
		</div>
					
			<?php
		}
		?>
									
					
				
							
	</div>
</div>