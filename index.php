
<!DOCTYPE HTML> 
<html>
<body> 

<?php

if (!isset($_POST["show_info"]) && !isset($_POST["update_inventory"]) && !isset($_POST["actually_submit_data_and_email"]) &&  !isset($_POST["calculate_submit"]) )  {
	
	if (isset($_POST["end_tour"])){	
		$current_tour_start_date =  file_get_contents("current_tour_start_date.html");
		file_put_contents("current_tour_start_date.html", "");	
		//echo "Tour " .$current_tour_start_date . " ended.<br>";
	}	
	$current_tour_start_date =  substr( file_get_contents("current_tour_start_date.html"), 0, 10);
	if ($current_tour_start_date != "") {
		?>
		<form id="tour_ender"  method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
		On tour that started <?php echo $current_tour_start_date;?>
		<input type="submit" class="look_like_link" name="end_tour" value="End Tour">		
		</form>
		<?php 	
	}

	$bandsintown_start_date = date("Y-m-d", strtotime("-1000 days"));
	$bandsintown_end_date  = date("Y-m-d");
	$url = "http://api.bandsintown.com/artists/Bombadil/events?format=xml&app_id=YOUR_APP_ID&date=".$bandsintown_start_date .",".$bandsintown_end_date;
	$xml = simplexml_load_file($url);

	$counter = 0;
	
	
	?><form id="bandsintown_selector" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>"><?php
	for ($i = 1001; $i >= 0 && $counter < 5; $i--) {	

		if (strlen( $xml->event[$i]->datetime ) > 1 ){
			$counter++;
			$show_date = substr( $xml->event[$i]->datetime, 0, 10) ;
			$venue = $xml->event[$i]->venue->name;
			$city = $xml->event[$i]->venue->city;
			$state = $xml->event[$i]->venue->region;

			$finalString = $show_date . ",  " . $venue . ",  " . $city . ",  " . $state;
			
			$prettyDate = date("D, M j", strtotime($show_date));
			?>
			<button type="submit" name="show_info"   value="<?php echo $finalString; ?>">
			
			<?php 
			echo $prettyDate . "<br/>" . $venue . "<br/><b>" . $city . ", " . $state . "</b>";
			?>
			</button>
                   
			<br/>

		
<?php
		}
	}
	
	?>
	<button type="submit" name="update_inventory">Update Inventory</button>
	
	</form><?php 
}
elseif (isset($_POST["show_info"]) || isset($_POST["update_inventory"]) || isset($_POST["actually_submit_data_and_email"]) || isset($_POST["calculate_submit"])) {
	
	//	<!--/* ******************************************************** emily calc*****************************************************/ -->

	
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
		
	if (!isset($_POST["update_inventory"])) {
	
		$WL_pri			= 15;	
		$WLMT_pri   	= 15;
		$WLGT_pri   	= 15;	
		$BSHIP_pri  	= 15;	
		$BBI_pri    	= 15;	
		
		$EP___CD_pri	= 5;	
		$Buzz_CD_pri    = 15; 	
		$Tarp_CD_pri	= 15;	
		$ATTR_CD_pri	= 15;	
		$Metr_CD_pri	= 15;	
					
		$Tarp_Vnl_pri	= 30;	
		$Metr_Vnl_pri	= 20;	
						
		
		$WL_XS		=	test_input($_POST["WL_XS"]);			
		$WL_S		=	test_input($_POST["WL_S"]);				
		$WL_M		=	test_input($_POST["WL_M"]);				
		$WL_L		=	test_input($_POST["WL_L"]);				
		$WL_XL		=	test_input($_POST["WL_XL"]);	
																			 
		$WLMT_XS	=	test_input($_POST["WLMT_XS"]);		
		$WLMT_S		=	test_input($_POST["WLMT_S"]);			
		$WLMT_M		=	test_input($_POST["WLMT_M"]);			
		$WLMT_L		=	test_input($_POST["WLMT_L"]);			
		$WLMT_XL	=	test_input($_POST["WLMT_XL"]);		
									 
		$WLGT_XS	=	test_input($_POST["WLGT_XS"]);		
		$WLGT_S		=	test_input($_POST["WLGT_S"]);			
		$WLGT_M		=	test_input($_POST["WLGT_M"]);			
		$WLGT_L		=	test_input($_POST["WLGT_L"]);			
		$WLGT_XL	=	test_input($_POST["WLGT_XL"]);		
									 
		$BSHIP_XS	=	test_input($_POST["BSHIP_XS"]);		
		$BSHIP_S	=	test_input($_POST["BSHIP_S"]);		
		$BSHIP_M	=	test_input($_POST["BSHIP_M"]);		
		$BSHIP_L	=	test_input($_POST["BSHIP_L"]);		
		$BSHIP_XL	=	test_input($_POST["BSHIP_XL"]);		
									 
		$BBI_XS		=	test_input($_POST["BBI_XS"]);			
		$BBI_S		=	test_input($_POST["BBI_S"]);			
		$BBI_M		=	test_input($_POST["BBI_M"]);			
		$BBI_L		=	test_input($_POST["BBI_L"]);			
		$BBI_XL		=	test_input($_POST["BBI_XL"]);			
						
		$shirts_XS	= 	$WL_XS + $WLMT_XS + $WLGT_XS + $BSHIP_XS + $BBI_XS;
		$shirts_S	= 	$WL_S + $WLMT_S + $WLGT_S + $BSHIP_S + $BBI_S;
		$shirts_M	= 	$WL_M + $WLMT_M + $WLGT_M + $BSHIP_M + $BBI_M;
		$shirts_L	= 	$WL_L + $WLMT_L + $WLGT_L + $BSHIP_L + $BBI_L;
		$shirts_XL	= 	$WL_XL + $WLMT_XL + $WLGT_XL + $BSHIP_XL + $BBI_XL;
		$shirts		= 	$shirts_XS + $shirts_S + $shirts_M + $shirts_L + $shirts_XL;
							
		$EP___CD	=	test_input($_POST["EP___CD"]);			
		$Buzz_CD	=	test_input($_POST["Buzz_CD"]);			
		$Tarp_CD	=	test_input($_POST["Tarp_CD"]);			
		$ATTR_CD	=	test_input($_POST["ATTR_CD"]);			
		$Metr_CD	=	test_input($_POST["Metr_CD"]);	
		$CDs		= 	$EP___CD + $Buzz_CD + $Tarp_CD + $ATTR_CD + $Metr_CD;
						
		$Tarp_Vnl	=	test_input($_POST["Tarp_Vnl"]);			
		$Metr_Vnl	=	test_input($_POST["Metr_Vnl"]);
		$Vinyls		=	$Tarp_Vnl + $Metr_Vnl;
		
		$merch_cash = 	test_input($_POST["merch_cash"]);
		$merch_card = 	test_input($_POST["merch_card"]);
		$clctd_cash = 	test_input($_POST["clctd_cash"]);
		$clctd_check = 	test_input($_POST["clctd_check"]);

		$metr_totMoney = 	$Metr_CD * $Metr_CD_pri +  $Metr_Vnl* $Metr_Vnl_pri;
		
		$merch_tot = 	$merch_cash		+ $merch_card;
		$clctd_tot = 	$clctd_cash 		+ $clctd_check;
		$cash_tot = 	$merch_cash 	+ $clctd_cash;
		$emily = 		$merch_tot*0.1  + $clctd_tot * 0.04;
		$z = 			$cash_tot 			- $emily;
		$boys = 		floor($z/3);
		$uncle_bombi =	$z 				- $boys*3;
		$nonMetrMerch = $merch_tot		- $metr_totMoney;
		$ramseur =  	$clctd_tot*0.15	+ $nonMetrMerch*0.15	+$metr_totMoney*0.5;
		$high_road = 	$clctd_tot*0.1;
		
		
		if (!empty($_POST["show_info"])) {
			$show_info = test_input($_POST["show_info"]);
			//$show_info =  str_replace("\\", "", $show_info);
			list($show_date, $venue, $city, $state) = explode(",  ", $show_info);
		}
		else {
			$show_date		=	test_input($_POST["show_date"]);
			$city			=	test_input($_POST["city"]);
			$state			=	test_input($_POST["state"]);
			$venue			=	test_input($_POST["venue"]);
			$on_bill		=	test_input($_POST["on_bill"]);
			$attendance		=	test_input($_POST["attendance"]);
			$distance		=	test_input($_POST["distance"]);
			$guarantee		=	test_input($_POST["guarantee"]);
			$ticket_price	=	test_input($_POST["ticket_price"]);
			$weather		=	test_input($_POST["weather"]);
			$bad_news		=	test_input($_POST["bad_news"]);
			$good_news		=	test_input($_POST["good_news"]);
			$other			=	test_input($_POST["other"]);
			$play_again		=	test_input($_POST["play_again"]);
		}
				
		if (isset($_POST["actually_submit_data_and_email"])){
			echo "<font color=\"red\"><b>Show report submitted!</b></font><br> ";
		}
		
		$prettyDate = date("D M j", strtotime($show_date));
		$finalString =  $venue ."<br><b>".$prettyDate . " - " . $city . ", " . $state . "</b>"  ;
		echo $finalString."<br><hr>";
	
		?>		
		<form class="five_inputs" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
		<table class="emily">
		<tr><td>Merch Cash:		</td><td><input class="merch"	type="tel" name="merch_cash"   value="<?php echo $merch_cash;?>"></td></tr>
		<tr><td>Merch Card: 	</td><td><input class="merch"	type="tel" name="merch_card"   value="<?php echo $merch_card;?>"></td></tr>
		<tr><td>Collected Cash: 		</td><td><input class="clctd"	type="tel" name="clctd_cash"    value="<?php echo $clctd_cash;?>"></td></tr>
		<tr><td>Collected Check:		</td><td><input class="clctd"	type="tel" name="clctd_check"   value="<?php echo $clctd_check;?>"></td></tr>
		</table>
		
		<input type="submit" name="calculate_submit" value="Submit">
		<table class="emily">
		<tr><td><b>Merch Total:</b>	</td>	<td><input class="merch_tot"	 type="tel" value="<?php echo $merch_tot;?>"	readonly	></td></tr>
		<tr><td>Merch Cash:  		</td> 	<td><input class="merch"		 type="tel" value="<?php echo $merch_cash;?>"	readonly	></td></tr>
		<tr><td>Merch Card:			</td> 	<td><input class="merch"		 type="tel" value="<?php echo $merch_card;?>"	readonly	></td></tr>
		<tr><td><b>Collected Total:</b>  </td> 	<td><input class="clctd_tot" type="tel" value="<?php echo $clctd_tot;?>"	readonly	></td></tr>
		<tr><td>Collected Cash:  		</td> 	<td><input class="clctd"	 type="tel" value="<?php echo $clctd_cash;?>"	readonly	></td></tr>
		<tr><td>Collected Check:  		</td> 	<td><input class="clctd"	 type="tel" value="<?php echo $clctd_check;?>"	readonly	></td></tr>
		<tr><td><b>Total Cash:</b>  </td> 	<td><input class="cash_tot"		 type="tel" value="<?php echo $cash_tot;?>"	 	readonly	></td></tr>
		<tr><td>Emily:				</td> 	<td><input class="emily"		 type="tel" value="<?php echo $emily;?>"		readonly	></td></tr>
		<tr><td>Daniel:  			</td> 	<td><input class="boys"			 type="tel" value="<?php echo $boys;?>"			readonly	></td></tr>
		<tr><td>James:				</td> 	<td><input class="boys"			 type="tel" value="<?php echo $boys;?>"			readonly	></td></tr>
		<tr><td>Stuart:				</td> 	<td><input class="boys"			 type="tel" value="<?php echo $boys;?>"			readonly	></td></tr>
		<tr><td>Uncle Bombi:		</td> 	<td><input class="bombi"		 type="tel" value="<?php echo $uncle_bombi;?>"	readonly	></td></tr>
		</table><hr>
		
		<table class="emily">
		<tr><td>Metrics:			</td>   <td><input  class="other"		type="tel" value="<?php echo $metr_totMoney;?>" 		readonly	></td></tr>
		<tr><td>Other Merch:		</td>   <td><input  class="other"		type="tel" value="<?php echo $nonMetrMerch;?>"	readonly	></td></tr>
		<tr><td>Ramseur:			</td>   <td><input  class="other"		type="tel" value="<?php echo $ramseur;?>"		readonly	></td></tr>
		<tr><td>High Road:			</td>   <td><input  class="other"		type="tel" value="<?php echo $high_road;?>"		readonly	></td></tr>
		</table><hr>
		
		<!--/* ******************************************************** end emily calc*****************************************************/ -->
		<?php
	}
	else {
		?>
		Inventory Cost: <input type="number" name="inventory_cost" placeholder="inventory cost"><br><br>
		<?php
	}
	?>
	
	
	
	
	<b>CD's</b>         
	<table class="albums">   
	<tr>                     
		<td><div class="albumsdiv1"><input type="tel" name="EP___CD"	value="<?php echo $EP___CD;?>"	></div></td>	
		<td><div class="albumsdiv2"><input type="tel" name="Buzz_CD"	value="<?php echo $Buzz_CD;?>"	></div></td>	
		<td><div class="albumsdiv3"><input type="tel" name="Tarp_CD"	value="<?php echo $Tarp_CD;?>"	></div></td>	
		<td><div class="albumsdiv4"><input type="tel" name="ATTR_CD"	value="<?php echo $ATTR_CD;?>"	></div></td>	
		<td><div class="albumsdiv5"><input type="tel" name="Metr_CD"	value="<?php echo $Metr_CD;?>"	></div></td>
	</tr>
	</table>		
	<br/>
	<b>Vinyls</b>
	<table class="albums">
	<tr>	
		<td><div class="albumsdiv4"><input type="tel" name="Tarp_Vnl"	value="<?php echo $Tarp_Vnl;?>"	></div></td>	
		<td><div class="albumsdiv5"><input type="tel" name="Metr_Vnl"	value="<?php echo $Metr_Vnl;?>"	></div></td>
	</tr>
	</table>
	<table  title="shirts" class="merchGrid" >
	<tr><th></th><th>XS</th><th>S</th><th>M</th><th>L</th><th>XL</th></tr> 	
	<tr><td>wl</td>
		<td><input type="tel" name="WL_XS"		value="<?php echo $WL_XS;?>"	></td>
		<td><input type="tel" name="WL_S"		value="<?php echo $WL_S;?>"		></td>
		<td><input type="tel" name="WL_M"		value="<?php echo $WL_M;?>"		></td>
		<td><input type="tel" name="WL_L"		value="<?php echo $WL_L;?>"		></td>
		<td><input type="tel" name="WL_XL"		value="<?php echo $WL_XL;?>"	></td>
	</tr>                                       	               
	<tr><td>wlmt</td>                               	               
		<td><input type="tel" name="WLMT_XS"	value="<?php echo $WLMT_XS;?>"	></td>
		<td><input type="tel" name="WLMT_S"		value="<?php echo $WLMT_S;?>"	></td>
		<td><input type="tel" name="WLMT_M"		value="<?php echo $WLMT_M;?>"	></td>
		<td><input type="tel" name="WLMT_L"		value="<?php echo $WLMT_L;?>"	></td>
		<td><input type="tel" name="WLMT_XL"	value="<?php echo $WLMT_XL;?>"	></td>
	</tr>                                                          
	<tr><td>wlgt</td>                                                  
		<td><input type="tel" name="WLGT_XS"	value="<?php echo $WLGT_XS;?>"	></td>
		<td><input type="tel" name="WLGT_S"		value="<?php echo $WLGT_S;?>"	></td>
		<td><input type="tel" name="WLGT_M"		value="<?php echo $WLGT_M;?>"	></td>
		<td><input type="tel" name="WLGT_L"		value="<?php echo $WLGT_L;?>"	></td>
		<td><input type="tel" name="WLGT_XL"	value="<?php echo $WLGT_XL;?>"	></td>
	</tr>        	                                               
	<tr><td>bship</td>                                                 
		<td><input type="tel" name="BSHIP_XS"	value="<?php echo $BSHIP_XS;?>"	></td>
		<td><input type="tel" name="BSHIP_S"	value="<?php echo $BSHIP_S;?>"	></td>
		<td><input type="tel" name="BSHIP_M"	value="<?php echo $BSHIP_M;?>"	></td>
		<td><input type="tel" name="BSHIP_L"	value="<?php echo $BSHIP_L;?>"	></td>
		<td><input type="tel" name="BSHIP_XL"	value="<?php echo $BSHIP_XL;?>"	></td>
	</tr>                                                          
	<tr><td>BBI</td>                                                   
		<td><input type="tel" name="BBI_XS"		value="<?php echo $BBI_XS;?>"	></td>
		<td><input type="tel" name="BBI_S"		value="<?php echo $BBI_S;?>"	></td>
		<td><input type="tel" name="BBI_M"		value="<?php echo $BBI_M;?>"	></td>
		<td><input type="tel" name="BBI_L"		value="<?php echo $BBI_L;?>"	></td>
		<td><input type="tel" name="BBI_XL"		value="<?php echo $BBI_XL;?>"	></td>
	</tr>			                            	
	</table>                                    	
	<br><hr>                                  
	
	<?php
	if (!isset($_POST["update_inventory"])) {
		?>
		<input hidden name="show_date"	value="<?php echo $show_date;?>">
		<input hidden name="city" 		value="<?php echo $city;?>">
		<input hidden name="state" 		value="<?php echo $state;?>">
		<input hidden name="venue"		value="<?php echo $venue;?>">
		
		<!--<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">-->
		<table class="listingstable">
		<tr><td><input type="tel"						 	class="listed"  name="attendance" 	placeholder="attendance"	value=	"<?php echo $attendance;?>"	></td><td> &nbsp; Attendance</td></tr>
		<tr><td><input type="tel"                       	class="listed"  name="distance" 	placeholder="distance"		value=	"<?php echo $distance;?>"	></td><td> &nbsp; Miles Driven</td></tr>
		<tr><td><input type="tel"                       	class="listed"  name="guarantee" 	placeholder="guarantee"		value=	"<?php echo $guarantee;?>"	></td><td> &nbsp; Guarantee</td></tr>
		<tr><td><input type="number"                       	class="listed"  name="ticket_price"	placeholder="ticket price"	value=	"<?php echo $ticket_price;?>"	></td><td> &nbsp; Ticket Price</td></tr>
		<tr><td><input type="text"                       	class="listed"  name="weather" 		placeholder="weather"		value=	"<?php echo $weather;?>"    ></td><td> &nbsp; Weather</td></tr>
		<tr><td><textarea id="comments1"  class="common" 	class="listed"  name="on_bill" 		placeholder="on bill"				><?php echo $on_bill;?></textarea	></td><td> &nbsp; On Bill</td></tr>
		<tr><td><textarea id="comments2"  class="common" 	class="listed"  name="bad_news" 	placeholder="bad news"				><?php echo $bad_news;?></textarea	></td><td> &nbsp; Bad News</td></tr>
		<tr><td><textarea id="comments3"  class="common" 	class="listed"  name="good_news" 	placeholder="good news"				><?php echo $good_news;?></textarea	></td><td> &nbsp; Good News</td></tr>
		<tr><td><textarea id="comments4"  class="common" 	class="listed"  name="other" 		placeholder="other"					><?php echo $other;?></textarea		></td><td> &nbsp; Other</td></tr>
		</table>
		<br> Play Again?:
		
		<?php
		$yes_checked = "";
		$no_checked = "";
		
		if ($play_again == "yes")
			$yes_checked = "checked";
		if ($play_again == "no")
			$no_checked = "checked";		
		?>
		
		<input type="radio" name="play_again"   value="yes" <?php echo $yes_checked; ?>> Yes
		<input type="radio" name="play_again"   value="no" 	<?php echo $no_checked; ?>> No
		<br><br>
		
		<br>
		<?php
	}
	?>
	<div style="text-align:center;">
	
	<?php
	if (!isset($_POST["update_inventory"])) {
		?>
		<input type="submit" class="big" 		name="calculate_submit" 				value="Preview"><br><br><br>
		<input type="submit" class="emailer" 	name="actually_submit_data_and_email" 	value="Submit">
		<?php
	}
	else {
	?>
		<input type="submit" class="emailer" 	name="submit_inventory_update" 	value="Submit">
		<?php
	}
	?>
	</div>
	<br>
	<br>
	</form>
	
	<?php 
	
	if ( !isset($_POST["update_inventory"]) ) {
	
		$message = "			
			<table class=\"message\">
			<tr><td valign=\"top\" style=\"min-width:100px\"><b>Show Date:</b></td><td valign=\"top\" style=\"min-width:100px\">" . $show_date . "</td></tr>
			<tr><td valign=\"top\" style=\"min-width:100px\"><b>City:</b></td><td valign=\"top\" style=\"min-width:100px\">" . $city . "</td></tr>
			<tr><td valign=\"top\" style=\"min-width:100px\"><b>State:</b></td><td valign=\"top\" style=\"min-width:100px\">" . $state . "</td></tr>
			<tr><td valign=\"top\" style=\"min-width:100px\"><b>Venue:</b></td><td valign=\"top\" style=\"min-width:100px\">" . $venue . "</td></tr>
			<tr><td valign=\"top\" style=\"min-width:100px\"><b>On Bill:</b></td><td valign=\"top\" style=\"min-width:100px\">" . $on_bill . "</td></tr>
			<tr><td valign=\"top\" style=\"min-width:100px\"><b>Attendance:</b></td><td valign=\"top\" style=\"min-width:100px\">" . $attendance . "</td></tr>
			<tr><td valign=\"top\" style=\"min-width:100px\"><b>Ticket Price:</b></td><td valign=\"top\" style=\"min-width:100px\">" . $ticket_price . "</td></tr>
			<tr><td valign=\"top\" style=\"min-width:100px\"><b>Weather:</b></td><td valign=\"top\" style=\"min-width:100px\">" . $weather . "</td></tr>
			<tr><td valign=\"top\" style=\"min-width:100px\"><b>Bad News:</b></td><td valign=\"top\" style=\"min-width:100px\">" . $bad_news . "</td></tr>
			<tr><td valign=\"top\" style=\"min-width:100px\"><b>Good News:</b></td><td valign=\"top\" style=\"min-width:100px\">" . $good_news . "</td></tr>
			<tr><td valign=\"top\" style=\"min-width:100px\"><b>Other:</b></td><td valign=\"top\" style=\"min-width:100px\">" . $other . "</td></tr>
			<tr><td valign=\"top\" style=\"min-width:100px\"><b>Collected:</b></td><td valign=\"top\" style=\"min-width:100px\">" . $clctd_tot . "</td></tr>
			<tr><td valign=\"top\" style=\"min-width:100px\"><b>Merch Sold:</b></td><td valign=\"top\" style=\"min-width:100px\">" . $merch_tot . "</td></tr>
			<tr><td valign=\"top\" style=\"min-width:100px\"><b>Play Again?:</b></td><td valign=\"top\" style=\"min-width:100px\">" . $play_again . "</td></tr>
			</table>
		";

		$subject = "SHOW REPORT: " . $show_date . " " . $city;
		
		$headers = "MIME-Version: 1.0" . "\r\n";							//content type important for html mail
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: Emily Tucker <emilyallyn16@gmail.com>' . "\r\n";
		$headers .= 'Reply-To: emilyallyn16@gmail.com' . "\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion();
		
		$to = "emilyallyn16@gmail.com, stuart.clifford@gmail.com";

		if (isset($_POST["actually_submit_data_and_email"])  ){
			

	
			$current_tour_start_date =  file_get_contents("current_tour_start_date.html");
			if ($current_tour_start_date == "")
				file_put_contents("current_tour_start_date.html", date("Y-m-d"));	
			$current_tour_start_date =  file_get_contents("current_tour_start_date.html");
			echo "On tour that started " .$current_tour_start_date . ".<br>";

			mail($to,$subject,$message,$headers);
			
			echo "<br>Thank you for submitting a show report!<br> ";
			
			
		}
		else {
			echo "Show Report preview:<br>";
		}
		echo "<b>to:</b> " . $to . "<br>";
		echo "<b>subject:</b>" . $subject . "<br>";
		echo "<b>headers:</b> " . $headers . "<br><br>";
		echo  $message . "<br>";
	}
	
	//submit data to xml database!
	
	?>
	<br>
	<a href=".">start over</a>
	<?php	
	
}
?>

</body>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1., user-scalable=no, target-densityDpi=device-dpi" />
	<link rel="shortcut icon" href="http://25.media.tumblr.com/avatar_76a950268897_128.png" />
	<link rel="apple-touch-icon" href="http://25.media.tumblr.com/avatar_76a950268897_128.png"/>
		
		
<style>
/******************************************** emilys calculator *******************************/

	body {
		font-family: Georgia, serif;
		/* background-image:url("http://www.w3schools.com/css/paper.gif"); */
	}
	form.five_inputs input[type="tel"] {
		width: 100px;
		text-align: center;
	}
	table.emily {
		width: 300px;
	}
	table.emily td{
		text-align: left;
		
		width: 140px;
			
	}
	
	input[type="tel"].merch_tot {
		background-color : #FFE5CC;
		font-weight:bold;
	}
	input[type="tel"].merch {
		background-color : #FFE5CC;
	}
	input[type="tel"].clctd_tot {
		background-color : #FDFEDF;
		font-weight:bold;
	}
	input[type="tel"].clctd {
		background-color : #FDFEDF;
	}
	input[type="tel"].cash_tot {
		background-color : #DFFEDF;
		font-weight:bold;
	}
	input[type="tel"].emily {
		background-color : #EFCCFF;
	}
	input[type="tel"].boys {
		background-color : #CCECFF;
	}
	input[type="tel"].bombi {
		background-color : #FDDBDB; 
	}
	
	/***************************************************************************/
	.hi	ddendiv {
		display: none;
		white-space: pre-wrap;
		word-wrap: break-word;
		overflow-wrap: break-word; /* future version of deprecated 'word-wrap' */
	}

	.common {
		/* width: 200px; */
		width: 100%;
		overflow: hidden;
		/* padding: 5px;  this made it get super huge */
	}
	
	input[type="submit"].big {
		-webkit-appearance: none;
	
		border:2px solid #a1a1a1;
		padding:10px 40px; 
		background:#dddddd;
		width: 100%;
		height: 90px;
		font-size: 20px;
		border-radius: 1px;
	}

	input[type="submit"].emailer {
		-webkit-appearance: none;
	
		border:2px solid #B20000;
		/*padding:10px 40px; */
		padding: 0;
		background:#FF0000;
		width: 20%;
		height: 30px;
		font-size: 15px;
		font-weight: bold;
		border-radius: 1px;
	}
	
	
	input.look_like_link  {
		-webkit-appearance: none;
	

		background: none;
		border: none;
		color: blue;
		text-decoration: underline;
		cursor: pointer;
	}
	
	
	
	button {
		width: 300px;
		height: 90px;
		font-size: 15px;
		border-radius: 1px;
	}
	input.listed {
		/*width: 200px; */
		
		width: 97%;
		
	}
	table {
		width: 100%;
		padding: 0px;
	}
	table.albums td {
		text-align: center;	
	}
	
	/*whyeowiehi!!!*/
	
	table.listingstable {
		width: 100%;
		text-align: left;
		vertical-align: middle;
	}
	table.listingstable td{
		text-align: left;
		vertical-align: middle;
	}
	/****************************************************** tshirts merchGrid ****************/)
	
	th { vertical-align:bottom;}
	
	table.merchGrid input {
		width: 80%;
		font-size:25px; 
		text-align: center;
		padding: 0px;
	}
	
	/************************************************** albums *****************/
	
	
	.albums div {			
		background-position: center;
		background-size: 100%;
		background-repeat:no-repeat;
		/*height: 70px; 
		padding-top:30%;*/	
		border: 1;
		
		width: 100%;
		height: 0;
		padding-bottom: 100%;
		
	}
	.albums input {
		/*background: transparent;*/
	    /* border: none; */
	    
		width: 60%;
		font-size:25px; 
		text-align: center;
		padding: 0px;
		background: rgba(255, 255, 255, .8);
	}
	
	.albumsdiv1 {
		title="EP";
		background-image:url("http://f0.bcbits.com/img/a1539171824_2.jpg");
	}
	.albumsdiv2 {
		title="buzz";
		background-image:url("http://ecx.images-amazon.com/images/I/41M7H8MVK1L._SY300_.jpg");
	}	
	.albumsdiv3 {
		title="all that the rain promises";
		background-image:url("http://ecx.images-amazon.com/images/I/51OOl93P1dL._SL500_AA280_.jpg");
	}	
	.albumsdiv4 {
		title="tarpits and canyonlands";
		background-image:url("http://f0.bcbits.com/img/a2288132851_2.jpg");
	}
	.albumsdiv5 {
		title="metrics of affection";
		background-image:url("http://ecx.images-amazon.com/images/I/51l3CxkHNbL._SY300_.jpg");
	}		
</style>	
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.js"></script>
	<script>
		//-webkit-appearance: none;
		//TODO table input cells width too big :(
		$(function ()  {
			var txt1 = $('#comments1'),
				txt2 = $('#comments2'),
				txt3 = $('#comments3'),
				txt4 = $('#comments4'),
				hiddenDiv = $(document.createElement('div')),
				content = null;

			txt1.addClass('txtstuff');
			txt2.addClass('txtstuff');
			txt3.addClass('txtstuff');
			txt4.addClass('txtstuff');
			hiddenDiv.addClass('hiddendiv common');

			$('body').append(hiddenDiv);
			txt1.on('keyup', function (){
				content = $(this).val();
				content = content.replace(/\n/g, '<br>');
				hiddenDiv.html(content + '<br class="lbr">');
				$(this).css('height', hiddenDiv.height());
			});
			txt2.on('keyup', function (){
				content = $(this).val();
				content = content.replace(/\n/g, '<br>');
				hiddenDiv.html(content + '<br class="lbr">');
				$(this).css('height', hiddenDiv.height());
			});
			txt3.on('keyup', function (){
				content = $(this).val();
				content = content.replace(/\n/g, '<br>');
				hiddenDiv.html(content + '<br class="lbr">');
				$(this).css('height', hiddenDiv.height());
			});
			txt4.on('keyup', function () {
				content = $(this).val();
				content = content.replace(/\n/g, '<br>');
				hiddenDiv.html(content + '<br class="lbr">');
				$(this).css('height', hiddenDiv.height());
			});
		});
	</script>
</head>
</html>
				

						
