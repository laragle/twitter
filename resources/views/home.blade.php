@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="{{ route('tweet.store', ['username' => $loggedUser->username]) }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <textarea name="body" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Tweet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
