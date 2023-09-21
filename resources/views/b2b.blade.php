@extends('layouts.app')

@section('content')
<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebarHeader">
        @if(isset($lastOrder))
            <h3>{{$lastOrder->product->type == 1 ? 'B2B' : 'B2C'}}</h3>
        @endif
        </div>


    </nav>

    <!-- Main Content  -->
    <div id="main">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Last Order</div>

                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Order Id</th>
                                    <th scope="col">Payment ID</th>
                                    <th scope="col">Created On</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($lastOrder))
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{$lastOrder->product->name}}
                                    </td>
                                    <td>Otto@gmail.com</td>
                                    <td>Admin</td>
                                    <td>23/02/2023</td>
                                    <td> - </td>
                                </tr>
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