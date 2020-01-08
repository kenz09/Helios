@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <h1> Members </h1>
            <div class="card">
                <div class="card-header">Tasks</div>

                <div class="card-body">
                   <table class="table table-striped">
                       @foreach ($members as $member)
                           <tr>
                               <td>
                                   {{$member->name}}
                               </td>
                               <td class="text-right">
                                   Member
                               </td>
                           </tr>
                       @endforeach
                   </table>

                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
