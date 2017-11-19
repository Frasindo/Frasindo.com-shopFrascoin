
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
 $('#calendar').datepicker();
 $('.chating').pubstrapchat();
});
//Charts
$(function(){

  var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
       var config = {
           type: 'line',
           data: {
               labels: ["January", "February", "March", "April", "May", "June", "July"],
               datasets: [{
                   label: "My First dataset",
                   backgroundColor: "#99265A",
                   borderColor: "#99265A",
                   data: [
                       1,
                       2,
                       3,
                       4,
                       15,
                       112,
                       1
                   ],
                   fill: false,
               }]
           },
           options: {
               responsive: true,
               title:{
                   display:true,
                   text:'Chart.js Line Chart'
               },
               tooltips: {
                   mode: 'index',
                   intersect: false,
               },
               hover: {
                   mode: 'nearest',
                   intersect: true
               },
               scales: {
                   xAxes: [{
                       display: true,
                       scaleLabel: {
                           display: true,
                           labelString: 'Month'
                       }
                   }],
                   yAxes: [{
                       display: true,
                       scaleLabel: {
                           display: true,
                           labelString: 'Value'
                       }
                   }]
               }
           }
       };

       window.onload = function() {
         var ctx = document.getElementById("m_myfras").getContext("2d");
         var ctx2 = document.getElementById("m_car").getContext("2d");
         var ctx3 = document.getElementById("m_dividend").getContext("2d");
           var fras = new Chart(ctx, config);
           var car = new Chart(ctx2, config);
           var divi = new Chart(ctx3, config);
       };
});
</script>
</html>
