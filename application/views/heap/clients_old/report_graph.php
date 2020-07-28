<?php
error_reporting(E_ERROR | E_PARSE);
//require_once('class.financials.php');

//$CI =& get_instance();
//$CI->load->library('financials');

$r = $report;
$original_post = unserialize($r['POST']);
$total_original_term_months = $original_post['total_original_term_months'];
$original_mortgage_balance    = $r['original_mortgage_balance'];
$heloc_start_term = $r['heloc_start_term'];

$mort_term = $total_original_term_months;

$max_months_display = $mort_term; // use $mort_term to display full chart

if(empty($mort_term)) echo "Missing required value 'mortgage_term'";

$graphFileName = $rep['calc_file'];
// ../mortgage-parole/calc_data/924-4.txt
$graphFileName = str_replace("calc_data/","",$graphFileName);
$graphFileName = str_replace("../mortgage-parole/","",$graphFileName);
$graphFileName = str_replace(".txt",".png",$graphFileName);
//die($graphFileName);

/* NEW DIRECTOY UPDATE */
$r['calc_file'] = $r['calc_file'];
if ( !file_exists($r['calc_file']) ) {
    if( !file_exists("assets/".$r['calc_file']) ) {
        $r['calc_file'] = $_SERVER['DOCUMENT_ROOT']."/advisors_a/".$r['calc_file'];
    } else {
        $r['calc_file'] = "assets/".$r['calc_file'];
    }
}
//$r['calc_file'] = "../mortgage-parole/" . $r['calc_file'];

$input_file = $r['calc_file'];

if(!file_exists($input_file)) die("Could not find input file '$input_file'");

$data = file($input_file);

//$f = new phpfinancials();

// create category labels
$chart[ 'chart_data' ][0][0] = null; // This value is always null!
for($year = 1; $year <= ceil($max_months_display / 12); $year++)
{
    if($year % 2) $label = '';
    else $label = "Year ".$year;

    $chart[ 'chart_data' ][0][] = $label;
}

//Add data for 2nd & 3rd dataset (HEAP Schedule + HELOC)
$chart[ 'chart_data' ][1][0] = 'HELOC';
$chart[ 'chart_data' ][2][0] = 'H.E.A.P. Schedule';
$year = 0;
$month = 0;
$display_mort_balance = false;
$mort_balance = 0;
foreach($data as $key => $value) {
    if($key == 0 || $key == 1) continue;
    if(substr($value,0,5) == "Total") break;

    $month++;
    if($month > $max_months_display) break;
    if($month % 12 == 0 || $month == $max_months_display)
    {
        $year++;
        list($term,$mort_balance,$mort_principle,$mort_int,$mort_tot,$HBal,$Hprinc,$HInt,$HTotal) = explode(" : ",trim($value));

        $chart[ 'chart_data' ][1][] = $HBal;
        if($HBal > 0) $display_mort_balance = true;
        if($display_mort_balance)
            $chart[ 'chart_data' ][2][] = $mort_balance;
        else
            $chart[ 'chart_data' ][2][] = 0;;
    }

    if($key == 2)
    {
        $total_mort = $mort_balance;
    }
}

//Add data for first dataset (Original Mortgage)
$chart[ 'chart_data' ][3][0] = 'Standard Mortgage Schedule';
$year = 0;
for($m = 1; $m <= $max_months_display; $m++)
{
    if($m % 12 == 0 || $m == $max_months_display)
    {
        //$pv = abs($f->PV($r['mortgage_rate']/100/12,$mort_term - $m,$r['est_mortgage_payment']));
        $pv = abs($this->financials->PV($r['mortgage_rate']/100/12,$mort_term - $m,$r['est_mortgage_payment']));
        $chart[ 'chart_data' ][3][] = $pv;
    }
}

$tot = count($chart['chart_data'][3]);
$labels 	= "";
$frontBar 	= "";
$midBar 	= "";
$backBar 	= "";

for ( $i=1;$i<$tot;$i++ ) {
	if ( isset($chart['chart_data'][0][$i]) && $chart['chart_data'][0][$i] != '' )
		$labels 	.= '"' . $chart['chart_data'][0][$i] . '",';

	if ( isset($chart['chart_data'][1][$i]) && $chart['chart_data'][1][$i] != '' )
		$frontBar	.= $chart['chart_data'][1][$i] . ",";
	else
		$frontBar	.= "0,";

	if ( isset($chart['chart_data'][2][$i]) && $chart['chart_data'][2][$i] != '' )
		$midBar	.= $chart['chart_data'][2][$i] . ",";
	else
		$midBar	.= "0,";

	if ( isset($chart['chart_data'][3][$i]) && $chart['chart_data'][3][$i] != '' )
		$backBar	.= $chart['chart_data'][3][$i] . ",";
	else
		$backBar	.= "0,";
}

$labels = substr($labels,0,-1);
$frontBar = substr($frontBar,0,-1);
$midBar = substr($midBar,0,-1);
$backBar = substr($backBar,0,-1);

?>

<script src="<?php echo base_url() ?>assets/libraries/RGraph.common.core.js" ></script>
<script src="<?php echo base_url() ?>assets/libraries/RGraph.bar.js" ></script>

<canvas id="cvs" width="650" height="370">[No canvas support]</canvas>

    <script>
        var gutterLeft   = 85,
            gutterRight  = 0,
            gutterTop    = 45,
            gutterBottom = 125,
                 hmargin = 1,
                    ymax = <?php echo $original_mortgage_balance;?>,

            data = [

                // null, // [12,16,10,12,13,15,16]
                [<?php echo $frontBar;?>],
                [<?php echo $midBar;?>],
                [<?php echo $backBar;?>]
            ],

            colors = [
                'Gradient(#f28500:#f28500:#f28500)',
				'Gradient(#0a6a0a:#0a6a0a:#0a6a0a)',
				'Gradient(#830a0a:#830a0a:#830a0a)'
            ],

            labels = [<?php echo $labels;?>];




        var bar = new RGraph.Bar({
            id: 'cvs',
            data: data[2],
            options: {
                variant: '3d',
                variantThreedYaxis: false,
                variantThreedXaxis: false,
                strokestyle: 'rgba(0,0,0,0)',
                colors: [colors[2]],
                shadow: true,
                shadowOffsetx: 10,
                //backgroundGrid: false,
                backgroundGridColor: '#ccc',
                backgroundGridAutofitNumhlines: 5,
                backgroundGridAutofitNumvlines: 14,
                scaleZerostart: true,
                axisColor: '#ddd',
                ylabels: false,
                gutterBottom: gutterBottom,
                gutterTop: gutterTop,
                gutterLeft: gutterLeft,
                gutterRight: gutterRight,
                hmargin: hmargin,
                ymax: ymax,
                noaxes: true
            }
        }).draw();

        var bar2 = new RGraph.Bar({
            id: 'cvs',
            data: data[1],
            options: {
                variant: '3d',
                variantThreedYaxis: false,
                variantThreedXaxis: false,
                strokestyle: 'rgba(0,0,0,0)',
                colors: [colors[1]],
                shadow: true,
                shadowOffsetx: 10,
                shadowColor: 'rgba(0,0,0,0.5)',
                backgroundGrid: false,
                axisColor: '#ddd',
                ylabels: !data[0] ? true : false,
                labels: !data[0] ? labels : [],
                gutterBottom: gutterBottom - 10,
                gutterTop: gutterTop + 10,
                gutterLeft: gutterLeft - 20,
                gutterRight: gutterRight + 20,
                hmargin: hmargin,
                ymax: ymax,
                noaxes: true
            }
        }).draw();


        if (data[0]) {
            var bar = new RGraph.Bar({
                id: 'cvs',
                data: data[0],
                options: {
                    variant: '3d',
                    variantThreedYaxis: false,
                    variantThreedXaxis: false,
                    strokestyle: 'rgba(0,0,0,0)',
                    colors: [colors[0]],
                    labels: labels,
					textAngle:30,
					textSize:8,
                    shadow: true,
                    shadowOffsetx: 10,
                    shadowColor: 'rgba(0,0,0,0.5)',
                    backgroundGrid: false,
                    axisColor: '#ddd',
                    unitsPost: '',
                    gutterTop: gutterTop + 20,
                    gutterBottom: gutterBottom - 20,
                    gutterLeft: gutterLeft - 40,
                    gutterRight: gutterRight + 40,
                    hmargin: hmargin,
                    ymax: ymax,
                    noaxes: true,
                    scaleZerostart: true
                }
            }).on('draw', function (obj)
            {
                RGraph.path2(
                    obj.context,
                    'gco destination-over b m % % l % % l % % l % % c s #ddd f rgba(0,0,0,0)',
                    gutterLeft  - 40, gutterTop + 20,
                    gutterLeft + 10, gutterTop - 5,
                    gutterLeft + 10, gutterTop - 5 + (obj.canvas.height - gutterTop - gutterBottom),
                    gutterLeft + 10 - 50, gutterTop - 5 + (obj.canvas.height - gutterTop - gutterBottom) + 25
                );

                // Fioll the left-side back face again with a gradient
                var grad = obj.context.createLinearGradient(0,0,0,300);
                grad.addColorStop(0, 'white');
                grad.addColorStop(0.75, '#999');

                obj.context.fillStyle = grad;
                obj.context.fill();


            }).draw();
        }

        console.log('<?php echo $graphFileName;?>');
        var base_url = '<?php echo base_url() ?>';
		var image_data = cvs.toDataURL("image/png");
        $.post(base_url+"report/saveChart/", { src: image_data,filename: "<?php echo $graphFileName;?>" } );
		//$.post("save_chart.php", { src: image_data,filename: "<?php echo $graphFileName;?>" } );
		//$.post("save_chart.php", { src: image_data,filename: "924-3.png" } );
    </script>
