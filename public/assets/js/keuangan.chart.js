
$.get(serviceUrl+'/chart.php?s=dataKeuangan', function(data) {

/*set statistikChartData */
var statistikData = data.statistikChartData;
var statistikChartData = {
  labels : statistikData.bulan,
  datasets : [
    {
      label: "Pemasukan",
        fillColor : "rgba(220,220,220,0.2)",
        strokeColor : "rgba(220,220,220,1)",
        pointColor : "rgba(220,220,220,1)",
        pointStrokeColor : "#fff",
        pointHighlightFill : "#fff",
        pointHighlightStroke : "rgba(220,220,220,1)",
        data : statistikData.pemasukan
    },
    {
      label: "Pengeluaran",
        fillColor : "rgba(151,187,205,0.2)",
        strokeColor : "rgba(151,187,205,1)",
        pointColor : "rgba(151,187,205,1)",
        pointStrokeColor : "#fff",
        pointHighlightFill : "#fff",
        pointHighlightStroke : "rgba(151,187,205,1)",
        data : statistikData.pengeluaran
        }
      ]
}
/*end set statisticData */


/*set sumber pemasukan Data */
var sumberKeuanganData = data.sumberKeuangan;
$.each(sumberKeuanganData, function(index, data) {
  $("#sumber-chart-ket").append('<li style="color:'+data.color+'"><span class="fa fa-square"></span>'+data.label+'</li>')
});
/*end set sumber pemasukan data */

/*set sumber pemasukan Data */
var pengeluaranData = data.pengeluaranData;
$.each(pengeluaranData, function(index, data) {
  $("#pengeluaran-chart-ket").append('<li style="color:'+data.color+'"><span class="fa fa-square"></span>'+data.label+'</li>')
});
/*end set sumber pemasukan data */

var statistikChart = document.getElementById("kondisi-keuangan").getContext("2d");
window.myLine = new Chart(statistikChart).Line(statistikChartData, {responsive: true});

var sumberKeuanganChart = document.getElementById("sumber-pemasukan").getContext("2d");
window.myDoughnut = new Chart(sumberKeuanganChart).Doughnut(sumberKeuanganData, {responsive : true});
var pengeluaranChart = document.getElementById("pengeluaran").getContext("2d");
window.myDoughnut = new Chart(pengeluaranChart).Doughnut(pengeluaranData, {responsive : true, animateScale : true});

}, 'json');