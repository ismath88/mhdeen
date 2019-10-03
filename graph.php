<?php // content="text/plain; charset=utf-8"
 
 include('includes/dbconnect.php');
 	
		$query = mysql_query(" select src,unit,curry,b.csell,cbuy, DATE_FORMAT(FROM_UNIXTIME(cto_date),'%m/%e/%y') as rates_on from unitprices a LEFT OUTER JOIN yester_unitprices b on b.cid= a.id where a.id = '".$_GET['id']."' and a.in_exchange = 1 order by cto_date DESC limit 1,14");
		
		while($rows = mysql_fetch_object($query)):
			
				$buy[] = $rows->cbuy;
				$sell[] = $rows->csell;
				$date[] = $rows->rates_on;
				
		endwhile;
		
		$buy  = array_reverse($buy);$sell  = array_reverse($sell);$date  = array_reverse($date);
		
		$date[count($date)-1] = $date[count($date)-1].'00';

//$minponit = floor(min(array_unique(array_merge($buy,$sell))));	$buy[] = $minponit; $sell[] = $minponit;	

require_once ('graph/jpgraph.php');
require_once ('graph/jpgraph_line.php');





// Setup the graph
$graph = new Graph(1050,300);
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('Buy/Sell Rates Graph For Last 14 Days');
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();

$graph->xgrid->SetLineStyle("solid");
$graph->xaxis->SetTickLabels($date);
$graph->xgrid->SetColor('#E3E3E3');


// Create the first line
$p1 = new LinePlot($buy);
$graph->Add($p1);
$p1->setWeight(3);
$p1->SetColor("#0076DC");
$p1->SetLegend('Buy');

// Create the second line
$p2 = new LinePlot($sell);
$graph->Add($p2);
$p2->setWeight(3);
$p2->SetColor("#00FF00");
$p2->SetLegend('Sell');

$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();

?>

