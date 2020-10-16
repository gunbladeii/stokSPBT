google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Negeri', 'Nilai(RM)', { role: 'style' }],
          ['Sabah',  21655, '#b87333'],
          ['Sarawak',  134500, 'silver'],
          ['WP Labuan',  215000, 'gold'],
          ['WP Kuala Lumpur',  139000, '#65eb34'],
          ['Kedah',  14000, '#eb34dc'],
          ['Perlis',  219000, '#eb3493'],
          ['Pulau Pinang',  34000, '#8034eb'],
          ['Melaka',  13901, '#5c34eb'],
          ['Selangor',  145000, '#5c34eb'],
          ['Perak',  150000, '#6c6096'],
          ['Negeri Sembilan',  230000, '#609196'],
          ['Pahang',  254000, '#609692'],
          ['Kelantan',  415000, '#609689'],
          ['Terengganu',  23000, '#609676'],
          ['Johor',  111000, '#609662'],
          ['WP Putrajaya',  13126, '#ae34eb']
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
        legend: { position: "center" },
        };

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
        chart.draw(view, options);
      }