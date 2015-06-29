@inject('nginx', 'App\Resources\Nginx')
@inject('mysql', 'App\Resources\Mysql')

<ul class="list-group">
    <li class="list-group-item clearfix">
        <strong class="pull-left text-primary">Nginx</strong>
        <div class="pull-right">
            @if ($nginx->status)
                {!! HTML::linkRoute('home', 'Stop', [], ['class' => 'btn btn-xs btn-primary']) !!}
            @else
                {!! HTML::linkRoute('home', 'Start', [], ['class' => 'btn btn-primary']) !!}
            @endif
        </div>
    </li>
    <li class="list-group-item clearfix">
        <strong class="pull-left text-primary">MySQL</strong>
        <div class="pull-right">
            @if ($mysql->status)
                {!! HTML::linkRoute('home', 'Stop', [], ['class' => 'btn btn-xs btn-primary']) !!}
            @else
                {!! HTML::linkRoute('home', 'Start', [], ['class' => 'btn btn-primary']) !!}
            @endif
        </div>
    </li>
</ul>