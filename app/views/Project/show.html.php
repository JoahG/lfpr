<div class="row">
	<div class="page-header">
		<h1>
			Stats for project: <small><?=$this->project->name?></small>
		<?=link_to(project_list_path(), "&lt;&lt; Back to list", array("class" => "btn btn-large pull-right"))?>
		</h1>
	</div>

	<ul class="breadcrumb">
	  <li><a href="<?=home_root_path_path()?>">Home</a> <span class="divider">/</span></li>
	  <li ><a href="<?=project_list_path()?>">List of projects</a> <span class="divider">/</span></li>
	  <li class="active">Stats for project</li>
	</ul>
	<h2 class="pull-left">Current data</h2>
	<h3 class="pull-right" >
		by
		<?=link_to(developer_show_path($this->project->owner()),
										$this->project->owner()->name,
										array("class" => "dev-link", "data-title" => "See all projects by this user"))?>
		<?=image_tag($this->project->owner()->avatar(), array("class" => "avatar"))?> 
	</h3>
	<div class="clearfix"></div>
	<div class="well">
		<ul class="simple-data span4">
			<li><span class="fui-menu-24"></span> <?=$this->project->forks?> forks</li>
			<li><span class="fui-heart-24"></span> <?=$this->project->stars?> stars</li>
			<li><span class="fui-settings-24"></span> <?=$this->project->language()?> </li>

			<li><span class="fui-eye-24"></span> <?=link_to($this->project->url, "GitHub URL", array("target" => "_blank"))?></li>
		</ul>
		<div class="span7">
			<p>
				<?=$this->project->description?>
			</p>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<!--- issues here -->
<div id="issues-cont"></div>

<div class="well">
    <div class="pull-left">
        Filter data by a date range...
    </div>
    <div class="pull-right">
        from <input type="text" id="from" /> to  <input type="text" id="to" /> 
        <a href="#" class="btn btn-large btn-success" id="refresh-charts-btn">Refresh charts</a>
    </div>
    <div class="clearfix"></div>
</div>
<div class="row">
	<div class="span6 pull-left">
		<h2>Popularity over time</h2>
		<div class="well" id="main-stats" style="height:300px;">
		</div>
	</div>
	<div class="span6 pull-left">
		<h2>Commits activity</h2>
		<div class="well " id="commits-stats" style="height:300px;">
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="span12">
		<h2>Pull requests activity</h2>
		<div class="well " id="pull-stats" style="height:400px;">
		</div>
	</div>
</div>
<script type="text/javascript" src="/javascripts/highcharts/js/highcharts.js"></script>
<script >
<?php
//TODO: Improve following code...
$stats = $this->project->getStats();

$forks = array();
$stars = array();
$dates = array();
$commits = array();
$commits_dates = array();
$new_dates = array();
foreach($stats as $st) {
	if($st->forks != -99) {
		$forks[] 		= $st->forks;
		$stars[] 		= $st->stars;
		$new_dates[] 	= array_shift(explode(" ", $st->sample_date));
	}
	$dates[] 		= array_shift(explode(" ", $st->sample_date));
	$commits[] 		= ($st->commits_count === null) ? 0 : $st->commits_count;
	$new_pulls[] 	= ($st->new_pulls === null) ? 0 : $st->new_pulls;
	$closed_pulls[] = ($st->closed_pulls === null) ? 0 : $st->closed_pulls;
	$merged_pulls[] = ($st->merged_pulls === null) ? 0 : $st->merged_pulls;
}

?>

var new_dates =  ['<?=implode("','", $new_dates)?>'];
var regular_dates = ['<?=implode("','", $dates)?>'];
var forks_values = [<?=implode(",", $forks)?>];
var stars_values = [<?=implode(",", $stars)?>];
var commits_values = [<?=implode(",", $commits)?>];
var merged_pulls = [<?=implode(",", $merged_pulls)?>];
var closed_pulls = [<?=implode(",", $closed_pulls)?>];
var new_pulls = [<?=implode(",", $new_pulls)?>];


$(document).ready(function() {
function updateCharts() {
    var from_date = $("#from").val().split("/");
    from_date = (from_date[2] + from_date[0] + from_date[1]) * 1;
    var to_date = $("#to").val().split("/");
    to_date = (to_date [2] + to_date [0] + to_date [1]) * 1;

    var local_new_dates = $.map(new_dates, function(date) {
        var current_date = date.split("-").join("") * 1;
        if(from_date <= current_date && current_date <= to_date) {
            return date;
        }
    });

    var local_regular_dates = $.map(regular_dates, function(date) {
        var current_date = date.split("-").join("") * 1;
        if(from_date <= current_date && current_date <= to_date) {
            return date;
        }
    });

    chart1_options.xAxis.categories = local_new_dates;
    chart1_options.series[0].data = (local_new_dates.length == 0) ? [] : forks_values.slice(local_new_dates.length * -1);
    chart1_options.series[1].data = (local_new_dates.length == 0) ? [] : stars_values.slice(local_new_dates.length * -1);
    new Highcharts.Chart(chart1_options);

    chart2_options.xAxis.categories = local_regular_dates;
    chart2_options.series[0].data = (local_regular_dates.length == 0) ? [] : commits_values.slice(local_regular_dates.length * -1);
    new Highcharts.Chart(chart2_options);

    chart3_options.xAxis.categories = local_regular_dates;
    chart3_options.series[0].data = (local_regular_dates.length == 0) ? [] : merged_pulls.slice(local_regular_dates.length * -1);
    chart3_options.series[1].data = (local_regular_dates.length == 0) ? [] :  closed_pulls.slice(local_regular_dates.length * -1);
    chart3_options.series[2].data = (local_regular_dates.length == 0) ? [] : new_pulls.slice(local_regular_dates.length * -1);
    new Highcharts.Chart(chart3_options);
}

    $("#refresh-charts-btn").click(function() {
        updateCharts();        
        return false;

    });

    var dropkickOpts = {
            change: function(val, label) {
                $("select.ui-datepicker-month").change();
                $("select.ui-datepicker-month").dropkick(dropkickOpts);
            }
        };
    $("#from, #to, a.ui-datepicker-prev, a.ui-datepicker-next").live('click', function(){
        $("select.ui-datepicker-month").dropkick(dropkickOpts);
    });

     $( "#from" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        dateFormat: "mm/dd/yy",
        numberOfMonths: 3,
        onClose: function( selectedDate ) {
            $( "#to" ).datepicker( "option", "minDate", selectedDate );
        }
    });
    $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3,
        dateFormat: "mm/dd/yy",
        onClose: function( selectedDate ) {
            $( "#from" ).datepicker( "option", "maxDate", selectedDate );
        }
     });

    var now = new Date();
    var lastWeek = new Date();
    lastWeek.setDate(now.getDate() - 7);
    $("#to").val(formatDate(now));
    $("#from").val(formatDate(lastWeek));

  var chart1_options = {
        chart: {
            renderTo: 'main-stats',
            type: 'column'
        },
        title: {
            text: 'Stars & Forks over time'
        },
        xAxis: {
        	categories: [],
            title: {
            	text: "Dates"
            }
        },
        yAxis: {
                    },
        series: [{
            name: 'Forks',
            type: 'column',
            data: [],
        }, {
            name: 'Stars',
            type: 'spline',
            data: [],
        }]
    };


  var chart2_options = {
        chart: {
            renderTo: 'commits-stats',
            type: 'spline'
        },
        title: {
            text: 'Commits activity'
        },
        xAxis: {
        	categories: [],
            title: {
            	text: "Dates"
            },
            tickInterval: 7
         },
        yAxis: {
        	title: {
        		text: "# of commits"
        	}
        },
        series: [{
            name: 'Commits ',
            data: []
        }]
    };


	var chart3_options = {
        chart: {
            renderTo: 'pull-stats',
            type: ''
        },
        title: {
            text: 'Pull requests activity'
        },
        xAxis: {
        	categories: [],
            title: {
            	text: "Dates"
            },
            tickInterval: 7
        },
        yAxis: {
        	title: {
        		text: "# of Pull Requests"
        	}
        },
        series: [{
            name: 'Merged',
            type: 'column',
            data: []
        },
        {
            type: 'spline',
            name: 'Closed',
            data: []
        },
        {
            type: 'areaspline',
            name: 'Opened',
            data: []
        }]
    };

    new Highcharts.Chart(chart1_options);
    new Highcharts.Chart(chart2_options);
    new Highcharts.Chart(chart3_options);
    updateCharts();

    $.get("/issue/<?=$this->project->id?>?p=0",  function(data) {
        $("#issues-cont").html(data);
        $(".has-tooltip").tooltip();
    });
});

</script>