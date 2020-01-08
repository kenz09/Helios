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

            <div class="card card-new-task">
                <div class="card-header">New Project</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('projects.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" name="title" type="text" maxlength="255" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" autocomplete="off" />
                            @if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                            <label for="title">Description</label>
                            <input id="description" name="description" type="text" maxlength="255" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" autocomplete="off" />
                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">projects</div>

                <div class="card-body">
                   <table class="table table-striped">
                       @foreach ($projects as $project)
                           <tr>
                               <td>
                                  {{ $project->title }}
                               </td>
                               <td class="text-right">
                                    <form method="GET" action="{{ 'project/{{$project->id}}/members' }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-primary">Show Members</button>
                                    </form>
                               </td>
                           </tr>
                       @endforeach
                   </table>

                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
