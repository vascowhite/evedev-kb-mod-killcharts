var barGraph = new RGraph.Bar('KCbarchart', data);
barGraph.Set('chart.background.barcolor1', bgColour);
barGraph.Set('chart.background.barcolor2', bgColour);
barGraph.Set('chart.background.grid', false);
barGraph.Set('chart.labels', ticks);
barGraph.Set('chart.key', ['Losses', 'Kills']);
barGraph.Set('chart.key.position', 'graph');
barGraph.Set('chart.key.background', 'rgb(255,255,255)');
barGraph.Set('chart.colors', ['red', 'green']);
barGraph.Set('chart.yaxispos', 'left');
barGraph.Set('chart.strokestyle', 'grey');
barGraph.Set('chart.text.size', 8);
barGraph.Set('chart.text.color', 'white');
barGraph.Set('chart.height', '200');
barGraph.Set('chart.gutter.left', 15);
barGraph.Set('chart.gutter.right', 5);
barGraph.Set('chart.tooltips', toolTips);
barGraph.Set('tooltips.effect', 'expand');
barGraph.Set('chart.ymax', maxKills);

function ShowCombination(obj)
    {
        RGraph.Effects.Fade.In(obj);
        RGraph.Effects.Bar.Grow(obj);
    }