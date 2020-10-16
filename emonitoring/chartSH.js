google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
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

        var options = {
          title : 'Perolehan Sebut Harga Setiap Negeri',
          vAxis: {title: 'Nilai(RM)'},
          hAxis: {title: 'Negeri'},
          seriesType: 'bars',
          series: {16: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }