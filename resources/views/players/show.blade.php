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
        <span>{{$player->playTime}}</span>
    </div>
</div>
