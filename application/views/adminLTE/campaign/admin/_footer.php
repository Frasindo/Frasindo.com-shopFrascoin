
<!-- FastClick -->
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url("assets/") ?>dist/js/adminlte.js"></script>
<!-- Sparkline -->
<script src="<?= base_url("assets/") ?>plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?= base_url("assets/") ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?= base_url("assets/") ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?= base_url("assets/") ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url("assets/") ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url("assets/") ?>dist/js/demo.js"></script>
<!-- Chart Dashboard Script -->
<script>
//Jvector
$(function() {
 $('#bd').datepicker();
  $('.datepick').datepicker({
    format: 'yyyy-mm-dd 00:00:00'
  });

  // jvectormap data
  var visitorsData = {
    US: 398, // USA
    SA: 400, // Saudi Arabia
    CA: 1000, // Canada
    DE: 500, // Germany
    FR: 760, // France
    CN: 300, // China
    AU: 700, // Australia
    BR: 600, // Brazil
    IN: 800, // India
    GB: 320, // Great Britain
    RU: 3000 // Russia
  };
  // World map by jvectormap
  $('#world-map').vectorMap({
    map              : 'world_mill_en',
    backgroundColor  : 'transparent',
    regionStyle      : {
      initial: {
        fill            : '#e4e4e4',
        'fill-opacity'  : 1,
        stroke          : 'none',
        'stroke-width'  : 0,
        'stroke-opacity': 1
      }
    },
    series           : {
      regions: [
        {
          values           : visitorsData,
          scale            : ['#92c1dc', '#ebf4f9'],
          normalizeFunction: 'polynomial'
        }
      ]
    },
    onRegionLabelShow: function (e, el, code) {
      if (typeof visitorsData[code] != 'undefined')
        el.html(el.html() + ': ' + visitorsData[code] + ' new visitors');
    }
  });
});
//Charts
$(function(){
// The Calender
  $('#calendar').datepicker();
var frasMarket = document.getElementById("frascoinMarket").getContext('2d');
var myIncome = document.getElementById("myIncome").getContext('2d');
var frasChart = new Chart(frasMarket, {
    type: 'line',
    data: {
    labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
    datasets: [{
      label: 'Frascoin Market',
      data: [12, 19, 3, 17, 6, 3, 7],
      backgroundColor: "rgba(22, 160, 133,1.0)"
    }]},
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
var incChart = new Chart(myIncome, {
    type: 'line',
    data: {
    labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
    datasets: [{
      label: 'My Income',
      data: [1, 22, 3, 44, 12, 9, 10],
      backgroundColor: "rgba(192, 57, 43,1.0)"
    }]},
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
});
</script>
</html>
