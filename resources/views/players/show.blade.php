<div class ="container_user">
    <div class="avatar">
        <img src="{{url($player->avatar)}}";>
    </div>
    <div class="username">
        <span>{{$player->name}}</span>
    </div>
    <div class="mail">
        <span>{{$user->mail}}</span>
    </div>
    <div class="stats">
        <span>{{$player->bestScore}}</span>
        <span>{{$player->totalPlayTime}}</span>
    </div>
    <div class="parties">
        @foreach($parties as $p)
            <li>{{$p->score}} {{$p->time}} {{$p->enemiesKilled}}</li>
        @endforeach
    </div>
</div>
