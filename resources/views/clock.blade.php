@extends('new')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Animated CSS Clock</title>

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: radial-gradient(circle at top, #1c1f3a, #0b0e1a);
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
        }

        .clock-wrapper {
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 2rem;
            background: linear-gradient(90deg, #5ee7df, #b490ca);
            -webkit-background-clip: text;
            color: transparent;
        }

        .analog-clock {
            position: relative;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: radial-gradient(circle, #1b3b6f, #0a1a2f);
            box-shadow:
                inset 0 0 20px rgba(0,0,0,.7),
                0 0 30px rgba(0,0,0,.8);
            margin: auto;
        }

        .number {
            position: absolute;
            width: 100%;
            height: 100%;
            text-align: center;
            font-size: 1.3rem;
            font-weight: bold;
        }

        .number span {
            position: absolute;
            transform: translate(-50%, -50%);
        }

        @for ($i = 1; $i <= 12; $i++)
            .num{{ $i }} span {
                top: {{ 50 - 40 * cos(deg2rad($i * 30 - 90)) }}%;
                left: {{ 50 + 40 * sin(deg2rad($i * 30 - 90)) }}%;
            }
        @endfor

        .hand {
            position: absolute;
            width: 50%;
            height: 2px;
            background: white;
            top: 50%;
            transform-origin: 100%;
            transform: rotate(90deg);
            transition: transform 0.5s ease-in-out;
        }

        .hour {
            width: 35%;
            height: 4px;
        }

        .minute {
            width: 45%;
            height: 3px;
        }

        .second {
            background: #ff6b6b;
            height: 2px;
        }

        .center-dot {
            position: absolute;
            width: 14px;
            height: 14px;
            background: #ff6b6b;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
        }

        .digital {
            margin-top: 25px;
            font-size: 1.8rem;
            letter-spacing: 2px;
            padding: 10px 20px;
            border-radius: 10px;
            background: rgba(255,255,255,0.05);
            box-shadow: inset 0 0 10px rgba(0,0,0,.6);
            color: #ff8f6b;
        }
    </style>
</head>
<body>

<div class="clock-wrapper">
    <h1>Animated CSS Clock</h1>

    <div class="analog-clock">
        @for ($i = 1; $i <= 12; $i++)
            <div class="number num{{ $i }}"><span>{{ $i }}</span></div>
        @endfor
        <div class="hand hour" id="hourHand"></div>
        <div class="hand minute" id="minuteHand"></div>
        <div class="hand second" id="secondHand"></div>
        <div class="center-dot"></div>
    </div>

    <div class="digital" id="digitalClock">00:00:00</div>
</div>

<script>
    function updateClock() {
        const now = new Date();

        const seconds = now.getSeconds();
        const minutes = now.getMinutes();
        const hours = now.getHours();

        const secondDeg = seconds * 6;
        const minuteDeg = minutes * 6 + seconds * 0.1;
        const hourDeg = (hours % 12) * 30 + minutes * 0.5;

        document.getElementById('secondHand').style.transform = `rotate(${secondDeg}deg)`;
        document.getElementById('minuteHand').style.transform = `rotate(${minuteDeg}deg)`;
        document.getElementById('hourHand').style.transform = `rotate(${hourDeg}deg)`;

        const ampm = hours >= 12 ? 'PM' : 'AM';
        const hh = String(hours % 12 || 12).padStart(2, '0');
        const mm = String(minutes).padStart(2, '0');
        const ss = String(seconds).padStart(2, '0');

        document.getElementById('digitalClock').innerText =
            `${hh}:${mm}:${ss} ${ampm}`;
    }

    setInterval(updateClock, 1000);
    updateClock();
</script>

</body>
</html>
@endsection