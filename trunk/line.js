
var lineGraph = new RGraph.Line('KClinechart', killLine, lossLine);
lineGraph.Set('chart.background.grid', false);
lineGraph.Set('chart.labels', ticks);
lineGraph.Set('chart.key', ['Kills', 'Losses']);
lineGraph.Set('chart.key.position', 'graph');
lineGraph.Set('chart.key.background', 'rgb(255,255,255)');
lineGraph.Set('chart.colors', [kbarColour, lbarColour]);
lineGraph.Set('chart.linewidth', 2);
lineGraph.Set('chart.yaxispos', 'left');
lineGraph.Set('chart.text.size', 8);
lineGraph.Set('chart.text.color', 'white');
lineGraph.Set('chart.height', '200');
lineGraph.Set('chart.gutter.left', 25);
lineGraph.Set('chart.gutter.top', 5);
lineGraph.Set('chart.gutter.bottom', 15);
lineGraph.Set('chart.tooltips', function () { return '<canvas id="TTbarchart" width="400" height="200">[No canvas support]</canvas>';});
lineGraph.Set('chart.ymax', maxKills);
lineGraph.Set('chart.shadow.offsety', RGraph.isIE8() ? 3 : 0);
lineGraph.Set('chart.shadow.offsetx', RGraph.isIE8() ? 3 : 0);
lineGraph.Set('chart.shadow.blur', 20);
lineGraph.Set('chart.shadow.color', '#ddd');
lineGraph.Set('chart.tooltips.highlight', false);
lineGraph.Set('chart.background.barcolor1', bgColour);
lineGraph.Set('chart.background.barcolor2', bgColour);

RGraph.AddCustomEventListener(lineGraph, 'ontooltip', createTTChart);

function ShowCombination(obj)
    {
        RGraph.Effects.Fade.In(obj);
        RGraph.Effects.Line.Unfold(obj);
    }
    
function createTTChart(obj)
{
    var idx = RGraph.Registry.Get('chart.tooltip').__index__;
    
    var ttData = toolTips[idx].data;
    var ttTicks = toolTips[idx].ticks;
    
    var dKills = killLine[idx % numDays];
    var dLosses = lossLine[idx % numDays];
    
    var canvas = document.getElementById('TTbarchart');
    var canvasHt = (dKills + dLosses)* 12;
    if(canvasHt < 40) canvasHt = 40;
    canvas.height = canvasHt;
    
    var div = RGraph.Registry.Get('chart.tooltip');
    var divHTML = div.innerHTML;
    div.innerHTML = "<div class=\"kb-kills-header\">Details for " + TTDates[idx] + " <small>(Kills = " + dKills + " : Losses = " + dLosses + ")</small></div>\n";
    div.innerHTML += divHTML;
    div.innerHTML += "<a href = '" + KB_HOST + "?a=killcharts&d=" + TTDates[idx] + "'>" + "Click to view details for " + TTDates[idx] + "</a>";
    div.style.backgroundColor = 'rgba(0, 0, 0, 0.9)';
    div.style.padding = '5px';
    
    var hBar = new RGraph.HBar('TTbarchart', ttData);
    hBar.Set('chart.labels', ttTicks);
    hBar.Set('chart.colors', [kbarColour, lbarColour]);
    hBar.Set('chart.gutter.left', 130);
    hBar.Set('chart.gutter.right', 10);
    hBar.Set('chart.gutter.top', 5);
    hBar.Set('chart.gutter.bottom', 10);
    hBar.Set('chart.background.grid', false);
    hBar.Set('chart.background.barcolor1', bgColour);
    hBar.Set('chart.background.barcolor2', bgColour);
    hBar.Set('chart.text.color', 'white');
    hBar.Set('chart.title.color', 'white');
    hBar.Set('chart.text.size', 8);
    hBar.Set('chart.title.hpos', 0.2);
    ShowCombination(hBar);
}