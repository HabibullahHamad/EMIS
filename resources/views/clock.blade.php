@extends('new')
@section('content')


<head>
<meta charset="UTF-8">

<!-- Alarm Popup Dialog -->
<div id="alarmPopup" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:999; justify-content:center; align-items:center;">
    <div style="background:#fff; padding:40px 30px; border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,0.2); text-align:center;">
        <h2 style="color:#ff5c5c;">Alarm!</h2>
        <p style="font-size:20px; color:#333;">It's time! Your alarm has gone off.</p>
        <script>
        function closeAlarmPopup() {
            document.getElementById("alarmPopup").style.display = "none";
            document.getElementById("alarmSound").pause();
            document.getElementById("alarmSound").currentTime = 0;
            alarmTriggered = false;
        }
        </script>
        <button onclick="closeAlarmPopup()" style="margin-top:20px; padding:10px 30px; background:#30ffd2; border:none; border-radius:8px; font-size:18px; cursor:pointer;">Dismiss</button>
    </div>
</div>

<script>
function showAlarmPopup() {
    document.getElementById("alarmPopup").style.display = "flex";
}

function closeAlarmPopup() {
    document.getElementById("alarmPopup").style.display = "none";
    document.getElementById("alarmSound").pause();
    document.getElementById("alarmSound").currentTime = 0;
}
</script>


<style>

body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#0c1445;
    font-family:Arial;
}

/* Layout */
.container{
    display:flex;
    gap:60px;
    align-items:center;
}

/* Title */
.title{
    position:absolute;
    top:40px;
    left:50%;
    transform:translateX(-50%);
    font-size:42px;
    background:linear-gradient(90deg,#30ffd2,#8ea2ff);
    -webkit-background-clip:text;
    color:transparent;
}

/* Clock */

.clock{
    width:340px;
    height:340px;
    background:#1f3b66;
    border-radius:50%;
    position:relative;
}

/* Numbers */

.number{
    position:absolute;
    width:100%;
    height:100%;
    text-align:center;
    transform:rotate(calc(30deg * var(--n)));
}

.number span{
    display:inline-block;
    color:white;
    font-size:22px;
    transform:rotate(calc(-30deg * var(--n)));
}

/* Hands */

.hand{
    position:absolute;
    bottom:50%;
    left:50%;
    transform-origin:bottom;
    transform:translateX(-50%);
}

.hour{
    width:6px;
    height:80px;
    background:white;
}

.minute{
    width:4px;
    height:110px;
    background:#ddd;
}

.second{
    width:2px;
    height:130px;
    background:#ff5c5c;
}

/* center */

.center{
    width:12px;
    height:12px;
    background:#ff5c5c;
    border-radius:50%;
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
}

/* digital */

.digital{
    position:absolute;
    bottom:-90px;
    left:50%;
    transform:translateX(-50%);
    padding:15px 40px;
    background:#1a2148;
    border-radius:12px;
    font-size:32px;
    color:#ff8866;
}

/* Alarm panel */

.alarm-box{
    background:#1a2148;
    padding:30px;
    border-radius:10px;
    color:white;
    width:220px;
}

.alarm-box h3{
    margin-top:0;
}

input{
    width:100%;
    padding:10px;
    font-size:16px;
}

button{
    margin-top:10px;
    width:100%;
    padding:10px;
    background:#30ffd2;
    border:none;
    cursor:pointer;
}

</style>
</head>

<body>

<div class="title"> Clock</div>

<div class="container">

<!-- CLOCK -->
<div class="clock">

<div class="number" style="--n:1"><span>1</span></div>
<div class="number" style="--n:2"><span>2</span></div>
<div class="number" style="--n:3"><span>3</span></div>
<div class="number" style="--n:4"><span>4</span></div>
<div class="number" style="--n:5"><span>5</span></div>
<div class="number" style="--n:6"><span>6</span></div>
<div class="number" style="--n:7"><span>7</span></div>
<div class="number" style="--n:8"><span>8</span></div>
<div class="number" style="--n:9"><span>9</span></div>
<div class="number" style="--n:10"><span>10</span></div>
<div class="number" style="--n:11"><span>11</span></div>
<div class="number" style="--n:12"><span>12</span></div>

<div class="hand hour" id="hour"></div>
<div class="hand minute" id="minute"></div>
<div class="hand second" id="second"></div>

<div class="center"></div>

<div class="digital" id="digital"></div>

</div>


<!-- ALARM -->
<div class="alarm-box">

<h3>Set Alarm</h3>

<input type="time" id="alarmTime">

<button onclick="setAlarm()">Set Alarm</button>

<p id="alarmStatus"></p>




<audio id="alarmSound">
    
<source src="https://actions.google.com/sounds/v1/alarms/alarm_clock.ogg">
</audio>

<script>

let alarmTime = null;
let alarmTriggered = false;

function setAlarm(){

alarmTime = document.getElementById("alarmTime").value;
alarmTriggered = false;

document.getElementById("alarmStatus").innerText =
"Alarm set for " + alarmTime;

}

function updateClock(){

let now = new Date();

let sec = now.getSeconds();
let min = now.getMinutes();
let hr = now.getHours();

let secDeg = sec * 6;
let minDeg = min * 6 + sec*0.1;
let hrDeg = hr * 30 + min*0.5;

document.getElementById("second").style.transform =
"translateX(-50%) rotate("+secDeg+"deg)";

document.getElementById("minute").style.transform =
"translateX(-50%) rotate("+minDeg+"deg)";

document.getElementById("hour").style.transform =
"translateX(-50%) rotate("+hrDeg+"deg)";


/* Digital clock */
/* Move digital clock to right side of main clock */
document.getElementById("digital").style.position = "absolute";
document.getElementById("digital").style.bottom = "50%";
document.getElementById("digital").style.left = "110%";
document.getElementById("digital").style.transform = "translateY(50%)";
let ampm = hr>=12 ? "PM":"AM";
let hr12 = hr%12;
hr12 = hr12 ? hr12 : 12;

let time =
ampm+" "+
String(hr12).padStart(2,"0")+":"+
String(min).padStart(2,"0")+":"+
String(sec).padStart(2,"0");

document.getElementById("digital").innerText = time;


/* Alarm check */

let current =
String(hr).padStart(2,"0")+":"+
String(min).padStart(2,"0");

if(alarmTime === current && !alarmTriggered){

document.getElementById("alarmSound").play();
showAlarmPopup();
alarmTriggered = true;

}

}

setInterval(updateClock,1000);

updateClock();

</script>

</body>
</html>
@endsection