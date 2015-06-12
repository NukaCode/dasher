@section('css')
    @parent
    <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

    <style>
        body {
            margin:      0;
            padding:     0;
            width:       100%;
            height:      100%;
            color:       #B0BEC5;
            display:     table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            vertical-align: middle;
            padding-top: 50px;
            text-align: center;
        }

        .content {
            text-align: center;
            display:    inline-block;
        }

        .title {
            font-size:     96px;
        }

        .sub-title {
            font-size: 35px;
            margin-bottom: 40px;
        }

        .quote {
            font-size: 24px;
        }
    </style>
@stop

<div class="container">
    <div class="content">
        <div class="title">Laravel 5</div>
        <div class="sub-title">with NukaCode</div>
        <div class="quote">{{ Inspiring::quote() }}</div>
    </div>
</div>