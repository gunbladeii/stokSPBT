google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Negeri', { role: 'annotation' },'Nilai(RM)', { role: 'style' }],
          ['Sabah', 'RM',  21655, '#b87333'],
          ['Sarawak', 'RM',  134500, 'silver'],
          ['WP Labuan', 'RM',  215000, 'gold'],
          ['WP Kuala Lumpur', 'RM',  139000, '#65eb34'],
          ['Kedah', 'RM',  14000, '#eb34dc'],
          ['Perlis', 'RM',  219000, '#eb3493'],
          ['Pulau Pinang', 'RM',  34000, '#8034eb'],
          ['Melaka', 'RM',  13901, '#5c34eb'],
          ['Selangor', 'RM',  145000, '#5c34eb'],
          ['Perak', 'RM',  150000, '#6c6096'],
          ['Negeri Sembilan', 'RM',  230000, '#609196'],
          ['Pahang', 'RM',  254000, '#609692'],
          ['Kelantan',  415000, 'RM', '#609689'],
          ['Terengganu', 'RM',  23000, '#609676'],
          ['Johor', 'RM',  111000, '#609662'],
          ['WP Putrajaya', 'RM',  13126, '#ae34eb']
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

        var options = {
        title: "Perolehan Sebut Harga setiap negeri",
        width: 1800,
        height: 600,
        bar: {groupWidth: "85%"},
        legend: { position: "none" },
        };

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
        chart.draw(view, options);
      }