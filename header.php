<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width">
		<title><?php bloginfo("name"); ?></title>
		<?php wp_head(); ?>
	</head>
	
	<?php 
		//$coins = array("nitro"=>"9474");
		$coins = array("nitro"=>"9474", "bitcoin"=>"0.05", "litecoin"=>"17.7", "lisk"=>"79.9", "naga"=>"730",
    							"Xfermoney"=>"30600", "MARK.SPACE"=>"0", "Sapien"=>"0");
    	 $i = 0;
    	 $runtot = 0.00;
       $url = "https://api.fixer.io/latest?base=USD";
       $json=file_get_contents($url);
       $data =  json_decode($json);
       $GBP = $data->rates->GBP;
    ?>
	
<body <?php body_class(); ?>>

	<div class="container">

		<!-- site-header -->
		<header class="site-header">
	
			<h1><a href="<?php echo home_url(); ?>"<?php bloginfo("name"); ?></a></h1>
			<h3><?php bloginfo("description"); ?></h3>
		
		</header>
		
		<table class="table">
      <thead>
        <tr>
          <th>Symbol</th>
          <th>Holding</th>
          <th>Price</th>
          <th>Tot USD</th>
          <th>Tot GBP</th>
          <th>Notes</th>
        </tr>
      </thead>
      <tbody>
				<?php
				    foreach ($coins as $x => $x_value) {
				      $i++;
				      $url = "https://api.coinmarketcap.com/v1/ticker/" . $x;
				      $json=file_get_contents($url);
				      $data =  json_decode($json);
							$altSymbol = $data[0]->name;
							if (empty($altSymbol)) {
									$altSymbol = $x;
							}
				      $priceUSD = $data[0]->price_usd;
				      $holding = $x_value;
				      $valUSD = round($priceUSD * $holding, 2);
				      $runtot = $runtot + $valUSD;
				      echo '
										<tr>
											<td>'	. $altSymbol . '</td>
											<td>'	. $holding . '</td>
											<td>'	. number_format($priceUSD,2) . '</td>
											<td>'	. number_format($valUSD,2) . '</td>
											<td>' . number_format($GBP * $valUSD,2) . '</td>
											<td><a href="#" data-toggle="tooltip" title="Hooray!">Notes</a></td>
										</tr>
				          ';
				    }
						echo '
								<tfoot>
									<tr>
										<th></th>
										<th></th>
										<th></th>
										<th>' . number_format($runtot,2) . '</th>
										<th>' . number_format($GBP * $runtot,2) . '</th>
										<th></th>
									</tr>
							 </tfoot>
						';
				?>
      </tbody>
    </table>
