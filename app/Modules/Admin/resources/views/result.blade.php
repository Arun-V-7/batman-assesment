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
                    <h3>Quiz Result panel</h3>
                </div>


            </div>
            <div class="panel panel-default">
                <table id="table_id" class="display">
                </table>
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
        $( ".result" ).addClass( "active" );

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
                url: '/admin/result-data-source',
                type: 'POST',
                dataSrc: 'data'
            },
            columns: [
                { title: 'Name', data: 'name', "width": "15%" },
                { title: 'Correct Answer', data: 'correct_count', "width": "20%" },
                { title: 'Wrong Answer', data: 'wrong_count', "width": "15%" },
                { title: 'Total Score', data: 'total_score', "width": "12%" },
            ]
        } );

    </script>
@endsection


