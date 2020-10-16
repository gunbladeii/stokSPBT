google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          
          ['Sabah',  165,      938,         522,             998,           450,      614.6],
          ['Sarawak',  135,      1120,        599,             1268,          288,      682],
          ['WP Labuan',  157,      1167,        587,             807,           397,      623],
          ['WP Kuala Lumpur',  139,      1110,        615,             968,           215,      609.4],
          ['WP Putrajaya',  136,      691,         629,             1026,          366,      569.6]
        ]);

        var options = {
          title : 'Perolehan Sebut Harga Setiap Negeri',
          vAxis: {title: 'Nilai(RM)'},
          hAxis: {title: 'Negeri'},
          seriesType: 'bars',
          series: {5: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }