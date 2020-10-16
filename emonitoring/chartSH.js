google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Negeri', 'Nilai(RM)'],
          ['Sabah',  165],
          ['Sarawak',  135],
          ['WP Labuan',  157],
          ['WP Kuala Lumpur',  139],
          ['WP Putrajaya',  136]
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