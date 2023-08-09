<style>
    #anim {
        width: 250px;
        height: 188px;
        animation: anim 1.0s steps(10) infinite;
    }
    @keyframes anim {
        100% { background-position: -2500px; }
    }
</style>
@extends('layouts.app')

@section('content')

    <div class="main">
        <input type="file" class="form-control mb-3" id="choose_file" onchange="PreviewImageBG('choose_file', 'anim')">

        <img id="anim" title="Animated Bat by Calciumtrice" style="height: 300px"></img>
        <button onclick="play()">Play</button>
        <button onclick="pause()">Pause</button>
        <button onclick="reset()">Reset</button>
        <button onclick="stop()">Stop</button>
    </div>
    <script type="text/javascript">
        function PreviewImageBG(imgInput, imgOut)
        {
            var input = document.getElementById(imgInput);
            var output = document.getElementById(imgOut);

            var [file] = input.files;

            output.backgroundImage  = URL.createObjectURL(file);
        }

        window.onload = function()
        {
            HisSpinner(false);
        };

        var el = document.getElementById('anim');

        function play() {
            el.style.animationPlayState = 'running';
        }
        function pause() {
            el.style.animationPlayState = 'paused';
        }
        function reset() {
            el.style.animation = 'none';
            el.offsetHeight; /* trigger reflow to apply the change immediately */
            el.style.animation = null;
        }
        function stop() {
            reset();
            pause();
        }

    </script>
@endsection
