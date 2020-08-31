@extends('Admin::layouts.master')
@section('title', 'Dashboard')

@section('head')

    <link href="/assets/css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

    <style>
        .panel-heading{
            background: white;
            padding: 1%;
        }
        .panel-heading a {
            background: #66ddff;
            padding: 3px 15px;
            border-radius: 3px;
        }

        .btn-col{
            padding-top: 20px;
            text-align: right;
        }


        p {
            margin: 0;
        }
        .alert-danger{
            border: 2px solid red;
            border-radius: 3px;
            padding: 7px;
            width: 50%;
        }
        .alert-success {
            padding: 7px;
            border: 1px solid green;
            border-radius: 3px;
            width: 50%;
        }
        .col-md-12.form-rows {
            margin-top: 2%;
        }
        .input-box {
            width: 50%;
            border: none;
            border-bottom: 1px solid #80808063;
            outline: none;
        }
        button#submit-admission-form {
            background: #52b7ff;
            border: none;
            border-radius: 3px;
            color: white;
            padding: 5px 2%;
            margin-bottom: 5%;
        }
        .input-group.date {
            width: 50%;
        }
        textarea#address {
            height: 70px;
        }

    </style>

@endsection

@section('content')

    <div class="right-sidebar">
        <div class="nav-div">
            <div class="col-md-12 panel-heading">
                <div class="col-md-6">
                    <h3>Quiz panel</h3>
                </div>
                <div class="col-md-6 btn-col">
                    <a onclick="openModal('createQuiz')">Create Quiz</a>
                    <a onclick="openModal('UploadQuiz')">Upload Quiz</a>
                </div>

            </div>
            <div class="panel panel-default">
                <table id="table_id" class="display">
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createQuiz" role="dialog">
        <div class="modal-dialog">


            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create Quiz</h4>
                </div>
                <div class="modal-body">

                    <form id="quizQuestion" class="panel-body">
                        <div class="col-md-12 form-rows">
                            <div class="col-md-4">
                                <h4>Question:</h4>
                            </div>
                            <div class="col-md-8">
                                <textarea id="question" class="input-box" placeholder="" required></textarea>
                            </div>
                        </div>

                        <div class="col-md-12 form-rows">
                            <div class="col-md-4">
                                <h4>Option A</h4>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="option_1" class="input-box" placeholder="" required>
                            </div>
                        </div>

                        <div class="col-md-12 form-rows">
                            <div class="col-md-4">
                                <h4>Option B</h4>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="option_2" class="input-box" placeholder="" required>
                            </div>
                        </div>

                        <div class="col-md-12 form-rows">
                            <div class="col-md-4">
                                <h4>Option C</h4>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="option_3" class="input-box" placeholder="" required>
                            </div>
                        </div>

                        <div class="col-md-12 form-rows">
                            <div class="col-md-4">
                                <h4>Option D</h4>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="option_4" class="input-box" placeholder="" required>
                            </div>
                        </div>

                        <div class="col-md-12 form-rows">
                            <div class="col-md-4">
                                <h4>Correct Answer</h4>
                            </div>
                            <div class="col-md-8">
                                <input type="radio" name="answer" value="1" class="input-box" placeholder="" required>Option A<br>
                                <input type="radio" name="answer" value="2" class="input-box" placeholder="" required>Option B<br>
                                <input type="radio" name="answer" value="3" class="input-box" placeholder="" required>Option C<br>
                                <input type="radio" name="answer" value="4" class="input-box" placeholder="" required>Option D<br>
                            </div>
                        </div>

                        <div class="col-md-12 form-rows">
                            <div class="col-md-4">
                                <h4>Mark</h4>
                            </div>
                            <div class="col-md-8">
                                <input type="number" id="mark" class="input-box" placeholder="" required>
                            </div>
                        </div>

                        <div class="col-md-12 form-rows">
                            <div class="alert-danger hide">
                                <p id="error-message"></p>
                            </div>
                            <div class="alert-success hide">
                                <p id="success-message"></p>
                            </div>
                        </div>

                        <div class="col-md-12 form-rows align-right">
                            <div>
                                <button id="submit-quiz-question">Submit</button>
                                <img class="loading-gif hide" src="/assets/images/loding.gif">
                            </div>
                        </div>
                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

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

    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

    var timeStamp = new Date($.now());
    let now = timeStamp.getFullYear()+"-"+(timeStamp.getMonth() + 1)+"-"+timeStamp.getDate()+" "+timeStamp.getHours()+":"+timeStamp.getMinutes()+":"+timeStamp.getSeconds();


    $('#table_id').DataTable( {
        serverSide: false,
        bProcessing: true,
        bServerSide: false,
        ajax: {
            url: '/admin/data-source',
            type: 'POST',
            dataSrc: 'data'
        },
        columns: [
            { title: 'Question', data: 'question', "width": "15%" },
            { title: 'Option A', data: 'option_a', "width": "20%" },
            { title: 'Option B', data: 'option_b', "width": "15%" },
            { title: 'Option C', data: 'option_c', "width": "12%" },
            { title: 'Option D', data: 'option_d', "width": "10%" },
            { title: 'Correct Answer', data: 'correct_answer', "width": "10%" },
            { title: 'Mark', data: 'mark', "width": "10%" },
        ]
    } );

    function openModal(data) {
        $("#"+data).modal('show');
    }

    $(document).ready(function() {
        $("#quizQuestion").submit(function(e) {
            e.preventDefault();

            var answerVal = $("input[name='answer']:checked").val();
            var formData = new FormData();
            formData.append('question', $('#question').val());
            formData.append('option_a', $('#option_1').val());
            formData.append('option_b', $('#option_2').val());
            formData.append('option_c', $('#option_3').val());
            formData.append('option_d', $('#option_4').val());
            formData.append('mark', $('#mark').val());

            if (answerVal == "1"){
                formData.append('correct_answer', $('#option_1').val());
            }else if (answerVal == "2"){
                formData.append('correct_answer', $('#option_2').val());
            }else if (answerVal == "3"){
                formData.append('correct_answer', $('#option_3').val());
            }else if (answerVal == "4"){
                formData.append('correct_answer', $('#option_4').val());
            }
            formData.append('created_at', now);
            formData.append('updated_at', now);
            showLoader('loading-gif');
            $.ajax({
                url: '/admin/input-question',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    hideLoader('loading-gif');
                    if (data.code == 200) {
                        $("#success-message").text(data.message);
                        $(".alert-success").removeClass('hide');
                        setTimeout(function() { window.location=window.location;},1000);
                    } else {
                        $("#error-message").text(data.message);
                        $(".alert-danger").removeClass('hide');
                    }
                }
            });
        })
    });
</script>
@endsection


