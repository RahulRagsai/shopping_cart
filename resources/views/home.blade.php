@extends('layouts.app')

@section('content')
<div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebarHeader">
                <h3>Admin</h3>
            </div>

            <ul class="list-unstyled components">
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
          
            </ul>
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
                     <table class="table">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Name</th>
			      <th scope="col">Email</th>
			      <th scope="col">Role</th>
			      <th scope="col">Created On</th>
			      <th scope="col">View Purchases</th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr>
			      <th scope="row">1</th>
			      <td>Mark</td>
			      <td>Otto@gmail.com</td>
			      <td>Admin</td>
			      <td>23/02/2023</td>
			      <td> - </td>
			    </tr>
			    <tr>
			      <th scope="row">2</th>
			      <td>Jacob</td>
			      <td>Thornton</td>
			      <td>B2C Customer</td>
			      <td>22/02/2023</td>
			      <td><a href="">View</a></td>
			    </tr>
			    <tr>
			      <th scope="row">3</th>
			      <td>Larry</td>
			      <td>the Bird</td>
			      <td>B2B Customer</td>
			      <td>22/02/2023</td>
			      <td><a href="">View</a></td>
			    </tr>
			  </tbody>
		  </table>
                    
                </div>
            </div>
        </div>
</div>
            
        </div>
    </div>
@endsection
