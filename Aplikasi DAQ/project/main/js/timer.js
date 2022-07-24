$(document).ready(function () {
  var jam = document.getElementById("jam");
  var tanggal = document.getElementById("tanggal");

  setInterval(function () {
    var t = new Date();
    jam.innerHTML =
      ("0" + t.getHours()).slice(-2) +
      ":" +
      ("0" + t.getMinutes()).slice(-2) +
      ":" +
      ("0" + t.getSeconds()).slice(-2);
    tanggal.innerHTML = 
      ("0" + t.getDate()).slice(-2) +
      "/" +
      ("0" + (t.getMonth()+1)).slice(-2) +
      "/" +
      t.getFullYear();
  }, 1000); // update about every second
});