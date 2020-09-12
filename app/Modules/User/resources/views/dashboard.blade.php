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
                <div id="quiz">
                    @if(isset($quiz))
                        <?php $a = 1?>
                        @foreach($quiz as $data)
                            <div>
                                <h3>{{$a}}) {{$data['question']}}</h3>
                                <input type="radio" name="answer_{{$a}}"
                                       value="{{$data['option_a']}}">{{$data['option_a']}}<br>
                                <input type="radio" name="answer_{{$a}}"
                                       value="{{$data['option_b']}}">{{$data['option_b']}}<br>
                                <input type="radio" name="answer_{{$a}}"
                                       value="{{$data['option_c']}}">{{$data['option_c']}}<br>
                                <input type="radio" name="answer_{{$a}}"
                                       value="{{$data['option_d']}}">{{$data['option_d']}}<br>
                                <input type="hidden" id="mark" value="{{$data['mark']}}">
                                <input type="hidden" id="quiz_id" value="{{$data['quiz_id']}}">
                                <hr>
                            </div>
                            <?php $a++?>
                        @endforeach
                            <input type="hidden" id="total-quiz" value="{{$totalQuiz}}">
                            <div class="col-md-12 form-rows">
                                <div class="alert-danger hide">
                                    <p id="error-message"></p>
                                </div>
                            </div>
                        <div class="align-right">
                            <img class="loading-gif hide" src="/assets/images/loding.gif">
                            <a onclick="submitQuizResult()">Submit</a>
                        </div>
                    @else
                        <div>
                            <h3>No Questions added to the Quiz</h3>
                        </div>
                    @endif
                </div>
            </div>
                <div id="result-response" class="panel panel-default hide" style="padding: 2%;">
                    <div style="    display: flex;">
                        <div class="col-md-6"><h3>Your Score</h3></div>
                        <div class="col-md-6">
                            <h3 id="quiz-score"></h3>
                        </div></div>
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

    function submitQuizResult() {
        var answer = [];
        var totalQuiz = $('#total-quiz').val();
        for (var i=1;i<=totalQuiz;i++){
            answer.push($('input[name="answer_'+i+'"]:checked').val());
        }
        if (!answer.includes(undefined)) {
            var formData = new FormData();
            for (var j=0;j< answer.length;j++){
                formData.append('answer[]', answer[j]);
            }
            showLoader('loading-gif');
            $.ajax({
                url: '/user/submit-quiz-answer',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    hideLoader('loading-gif');
                    if (data.code == 200) {
                        $("#quiz").hide();
                        $("#result-response").removeClass('hide');
                        $("#quiz-score").html(data.message['correct_count']+'/'+data.message['total_score']);
                    } else {
                        $(".alert-danger").removeClass('hide');
                        $("#error-message").text(data.message);
                    }
                }
            });
        } else {
            alert('Answer all the question');
        }
    }


</script>
@endsection


