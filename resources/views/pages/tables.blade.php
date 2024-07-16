<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="Tables"></x-navbars.navs.auth>
            <!-- End Navbar -->
             <div>
                <?php
                    if(DB::connection()->getPdo()) {
                        echo "Successfully Connected";
                    }
                ?>
             </div>
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">Authors table</h6>
                                </div>
                            </div>
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Author</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Function</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Status</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Employed</th>
                                                <th class="text-secondary opacity-7"></th>
                                                <th>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    Add User
                                                    </button>
                                                </th>
                                            </tr>
                                            
                                        </thead>
                                        <tbody>
                                            @foreach($userList as $userElement)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="{{ asset('assets') }}/img/team-2.jpg"
                                                                class="avatar avatar-sm me-3 border-radius-lg"
                                                                alt="user1">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{$userElement->author}}</h6>
                                                            <p class="text-xs text-secondary mb-0">john@creative-tim.com
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{$userElement->function}}</p>
                                                    <p class="text-xs text-secondary mb-0">Organization</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="badge badge-sm bg-gradient-success">{{$userElement->status}}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{$userElement->employed}}</span>
                                                </td>
                                                <td class="align-middle">
                                                    <a href="javascript:;"
                                                        class="text-secondary font-weight-bold text-xs"
                                                        data-toggle="tooltip" data-original-title="Edit user">
                                                        Edit
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <x-footers.auth></x-footers.auth>
            </div>
        </main>
        <x-plugins></x-plugins>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Insert here the new user's datas:</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form class="modal-body" id="user-form">
                                                                <div>
                                                                    <label for="author">Author:</label>
                                                                    <input type="text" id="author"/>
                                                                </div>
                                                                <div>
                                                                    <label for="function">Function:</label>
                                                                    <input type="text" id="function"/>
                                                                </div>
                                                                <div>
                                                                    <label for="status">Status:</label>
                                                                    <input type="text" id="status"/>
                                                                </div>
                                                                <div>
                                                                    <label for="employed">Employed:</label>
                                                                    <input type="text" id="employed"/>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" value="submit" class="btn btn-primary" onclick=addUser()>Add User</button>
                                                                </div>
                                                        </form>
                                                        
                                                        </div>
                                                    </div>
                                                    </div>
                                                    
                                                    <script>
                                                       async function addUser() {
                                                        event.preventDefault();
                                                        const author = document.getElementById("author").value;
                                                        const function1 = document.getElementById("function").value;
                                                        const status = document.getElementById("status").value;
                                                        const employed = document.getElementById("employed").value;

                                                        const dataObject = {author: author, function: function1, status: status, employed: employed};
                                                            try{
                                                                const request1 = await fetch("http://127.0.0.1:8000/add-user", {
                                                                    method: "POST",
                                                                    headers: {
                                                                        'Content-Type': 'application/json',
                                                                        'X-CSRF-Token': '{{ csrf_token() }}',
                                                                    },
                                                                    body: JSON.stringify(dataObject),
                                                                });
                                                                const jsonResponse = await request1.json() 
                                                                console.log(jsonResponse);                                             
                                                            }catch(error){
                                                                //console.error(error)
                                                            }
                                                        }
                                                    </script>
                                                    

</x-layout>
