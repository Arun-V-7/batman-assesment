@extends('User::layouts.master')
@section('title', 'Dashboard')

@section('head')

    <link href="/assets/css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

    <style>
        .panel.panel-default a {
            background: #00c100;
            padding: 5px 24px;
            border-radius: 3px;
            color: white;
        }

        input[type="radio"] {
            margin: 5px 15px;
        }

        .start-loading-gif {
            width: 3%;
        }
    </style>
@endsection

@section('content')

    <div class="right-sidebar">
        <div class="nav-div">

            @if(isset($totalScore))
                <div class="panel panel-default" style="padding: 2%;">
                    <div style="    display: flex;">
                        <div class="col-md-6"><h3>Your Score</h3></div>
                        <div class="col-md-6">
                            <h3>{{$correctScore}}/{{$totalScore}}</h3>
                        </div></div>
                </div>
                @else
            <div class="panel panel-default" style="padding: 2%;">
                <div>
                    <h2>Quiz</h2>
                </div>
                <div class="align-center">
                    <img class="start-loading-gif hide" src="/assets/images/loding.gif">
                    <a id="startQuiz" onclick="getQuizQuestions()">Start</a>
                </div>
                <div id="quiz">

                </div>
            </div>
                @endif
        </div>
    </div>


@endsection

@section('scripts')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script language="JavaScript"  src="http://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>


<script>
    $( ".side-menu" ).removeClass( "active" );
    $( ".dashboard" ).addClass( "active" );

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function getQuizQuestions() {
        showLoader('start-loading-gif');
        $.ajax({
            url: '/user/get-quiz-questions',
            type: 'POST',
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                hideLoader('start-loading-gif');
                if (data.code == 200) {
                    $("#startQuiz").hide();
                    $("#quiz").append(data.messageData);
                } else {

                }
            }
        });
    }

    function getNextQuestion(questionNo) {
        if ($("input[name='answer']:checked").val()) {
            var formData = new FormData();
            formData.append('answer', $('input[name="answer"]:checked').val());
            formData.append('quiz_id', $('#quiz_id').val());
            formData.append('mark', $('#mark').val());
            formData.append('questionNo', questionNo);
            showLoader('loading-gif');
            $.ajax({
                url: '/user/get-next-question',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    hideLoader('loading-gif');
                    if (data.code == 200) {
                        $("#startQuiz").hide();
                        $("#quiz").html(data.messageData);
                    } else {

                    }
                }
            });
        }else{
            alert('Nothing is checked! Please select an option');
        }
    }

    function submitQuiz() {
        if ($("input[name='answer']:checked").val()) {
            var formData = new FormData();
            formData.append('answer', $('input[name="answer"]:checked').val());
            formData.append('quiz_id', $('#quiz_id').val());
            formData.append('mark', $('#mark').val());
            showLoader('loading-gif');
            $.ajax({
                url: '/user/submit-quiz',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    hideLoader('loading-gif');
                    if (data.code == 200) {
                        $("#startQuiz").hide();
                        $("#quiz").html(data.messageData);
                    } else {

                    }
                }
            });
        } else {
            alert('Nothing is checked! Please select an option');
        }
    }


</script>
@endsection


