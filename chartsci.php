<?php

require_once("db_ci.php");
require_once("header.php");
require_once("user_logic.php");
checkUser();

#Top Colaborators data collect
$topcolaborators = getTopColaborators($db);
$topc = "";
foreach($topcolaborators as $topcolab) :
    $topc = $topc.",['".$topcolab['label']."',".(int)$topcolab['value']."]";
endforeach;

#Visitors count data collect
$visitors = getVisitorsCount($db);
$visitors = json_encode($visitors, JSON_NUMERIC_CHECK);

$visittotal = getAllVisitors($db);
?>
<div class="col-md-10">
<?php if($_SESSION['level'] == 'admin'){ ?>   
  <a data-toggle="collapse" href="#thisvisitor">
  <div><b>Visitors Count -> <?=$visittotal['number']?><span id="visitors" class="pull-right glyphicon glyphicon-chevron-right"></span></b></div>
  </a>
  <div id="thisvisitor" class="collapse">
    <div id="visitCount"></div>
  </div>
<?php } ?>    
    <div id="topcolab"></div>
</div>

<!--Change chevron-->
<script>
$(document).ready(function () {
     $('.collapse')
         .on('shown.bs.collapse', function() {
             $("#visitors")
                 .parent()
                 .find(".glyphicon-chevron-right")
                 .removeClass("glyphicon-chevron-right")
                 .addClass("glyphicon-chevron-down");
             })
         .on('hidden.bs.collapse', function() {
             $("#visitors")
                 .parent()
                 .find(".glyphicon-chevron-down")
                 .removeClass("glyphicon-chevron-down")
                 .addClass("glyphicon-chevron-right");
             });
         });
</script>


<!--Top Colaborators pie graph-->
<script>
$(document).ready(function() {
            var chart = {
               plotBackgroundColor: null,
               plotBorderWidth: null,
               plotShadow: false
            };
            var title = {
               text: 'Top Colaborators'  
            };     
            var tooltip = {
               pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            };
            var plotOptions = {
               pie: {
                  allowPointSelect: true,
                  cursor: 'pointer',
                 
                  dataLabels: {
                     enabled: false          
                  },
                  
                  showInLegend: true
               }
            };
            var series = [{
               type: 'pie',
               name: 'Browser share',
               data: [
                  <?=trim($topc, ',')?>
               ]
                 
            }];    
            var json = {};  
            json.chart = chart; 
            json.title = title;    
            json.tooltip = tooltip; 
            json.series = series;
            json.plotOptions = plotOptions;
            $('#topcolab').highcharts(json); 
         });
</script>

<!--Visitors line graph-->
<script>
    Highcharts.stockChart('visitCount', {
        title: {
            text: 'Visitors Count'
        },

        series: [{
            name: 'Qtd',
            data: (<?=$visitors?>),

        }]
    });
</script>


<?php
require_once("foot.php");
?>
     
