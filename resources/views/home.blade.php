@extends('layouts.app')

@section('content')
<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebarHeader">
            <h3>Admin</h3>
        </div>

        <!-- <ul class="list-unstyled components">
            <li class="active">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Users</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li>
                        <a href="#">B2C</a>
                    </li>
                    <li>
                        <a href="#">B2B</a>
                    </li>

                </ul>
            </li>

        </ul> -->
    </nav>

    <!-- Main Content  -->
    <div id="main">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Users</div>

                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                        @endif
                        <table class="table">
                            <thead>
                                <tr>

                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Created On</th>
                                    <th scope="col">Revoke Access</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($users))
                                @foreach ($users as $user)
                                <tr>

                                    <td>{{ $user->name}}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role == 2 ? 'B2C' : 'B2B' }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td><a href="{{ route('revoke', ['id' => $user->id]) }}">Revoke</a></td>
                                </tr>
                                @endforeach

                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection