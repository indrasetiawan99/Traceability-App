const timer = document.querySelector('#dandory-timer');
var time = 0,
    interval;

function showTime() {
    time += 1;
    timer.innerHTML = toHHMMSS(time);
}

function start() {
    interval = setInterval(showTime, 1000);
}

function pause() {
    clearInterval(interval);
    interval = null;
}

function reset() {
    clearInterval(interval);
    interval = null;
    time = 0;
    timer.innerHTML = toHHMMSS(time);
}

function toHHMMSS(time) {
    let hours = Math.floor(time / 3600);
    let minutes = Math.floor((time - hours * 3600) / 60);
    let seconds = time - hours * 3600 - minutes * 60;

    hours = `${hours}`.padStart(2, '0');
    minutes = `${minutes}`.padStart(2, '0');
    seconds = `${seconds}`.padStart(2, '0');

    return hours + ':' + minutes + ':' + seconds;
}

$(document).ready(function () {
    $("#submit-dandory-time").on("click", function() {
        $.ajax({
            type: "POST",
            url: "http://10.14.134.44/project/database/web/dandory.php",
            data: 'action=Input&total-time='+time,
            success: function (data) {
                Swal.fire({
                    title: "Success!",
                    text: "Waktu dandory berhasil di input",
                    icon: "success",
                    confirmButtonText: "OK",
                }).then(() => {
                    location.replace(
                      "http://10.14.134.44/project/main/operator.php"
                    );
                });
            },
        });
    });
});