<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="/get-user-list"></x-navbars.sidebar>
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
            <div id="tableContainer" class="container-fluid py-4">
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
                                                    <button id="add-user-button" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    Add User
                                                    </button>
                                                </th>
                                            </tr>                                            
                                        </thead>
                                        <tbody id="tableBody">
                                            <div class="d-flex justify-content-center" id="loadSpinner">
                                                <div class="spinner-border" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                        </tbody>
                                    </table>
                                    <script>
                                        $(function() {
                                            updateUserListTable();
                                        });

                                        async function updateUserListTable() {
                                            try{
                                                const request = await fetch("http://127.0.0.1:8000/get-user-list2", {
                                                    method: "POST",
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-Token': '{{ csrf_token() }}',
                                                    },
                                                });
                                                const response = await request.json();

                                                let html = '';

                                                for (const [key, value] of Object.entries(response)) {
                                                    html += `
                                                        <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="{{ asset('assets') }}/img/team-2.jpg"
                                                                class="avatar avatar-sm me-3 border-radius-lg"
                                                                alt="user1">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">${value.author}</h6>
                                                            <p class="text-xs text-secondary mb-0">john@creative-tim.com
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">${value.function}</p>
                                                    <p class="text-xs text-secondary mb-0">Organization</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="badge badge-sm bg-gradient-success">${value.status}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">${value.employed}</span>
                                                </td>
                                                <td class="align-middle">
                                                    <a href="javascript:;"
                                                        class="text-secondary font-weight-bold text-xs"
                                                        data-toggle="tooltip" data-original-title="Edit user" 
                                                        onclick=editUser()>
                                                        Edit
                                                    </a>
                                                </td>
                                            </tr>
                                                    `;
                                                    console.log(`${key}: ${value.author}`);
                                                }
                                                document.getElementById("loadSpinner").remove();
                                                document.getElementById("tableBody").innerHTML = html;

                                                //html
                                            }catch(error){
                                                console.error(error);
                                            }
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <x-footers.auth></x-footers.auth>
            </div>
        </main>

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
                            <button type="button" class="btn btn-secondary" onclick=clearFields()>Clear all fields</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" value="submit" class="btn btn-primary" onclick=addUser()>Add User</button>
                            <div id="alert-success" class="alert alert-success" role="alert" style="display: none">Utente registrato correttamente! A breve la pagina verrà aggiornata.<div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
    <script>

        const alert = document.getElementById("alert-success");
        const tableTag = document.getElementById("#tableBody");

        async function addUser() {

            event.preventDefault();

            const author = document.getElementById("author").value;
            const function1 = document.getElementById("function").value;
            const status = document.getElementById("status").value;
            const employed = document.getElementById("employed").value;

            // controllare campi obbligatori
            if (author === '' || author === null) {
                alert.classList.remove("alert-success");
                alert.classList.add("alert-warning");
                alert.innerHTML = "Compila il campo 'author'";
                alert.style.display = "block";
                return false;
            }
            if (function1 === '' || function1 === null) {
                alert.classList.remove("alert-success");
                alert.classList.add("alert-warning");
                alert.innerHTML = "Compila il campo 'function'";
                alert.style.display = "block";
                return false;
            }
            if (status === '' || status === null) {
                alert.classList.remove("alert-success");
                alert.classList.add("alert-warning");
                alert.innerHTML = "Compila il campo 'status'";
                alert.style.display = "block";
                return false;
            }
            if (employed === '' || employed === null) {
                alert.classList.remove("alert-success");
                alert.classList.add("alert-warning");
                alert.innerHTML = "Compila il campo 'employed'";
                alert.style.display = "block";
                return false;
            }

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
                    const jsonResponse = await request1.json();
                    if (jsonResponse.status) {
                        alert.classList.remove("alert-danger");
                        alert.classList.remove("alert-warning");
                        alert.classList.add("alert-success");
                        alert.innerHTML = "Utente registrato correttamente!";
                        alert.style.display = "block";

                        await updateUserListTable();
                        await setTimeout(function() {
                            clearFields();
                            $('#exampleModal').modal('hide');
                        }, 2500);
                        await setTimeout(function () {
                            window.scrollTo(0, 3000);
                        },500);

                    } else {
                        alert.classList.remove("alert-success");
                        alert.classList.add("alert-danger");
                        alert.innerHTML = jsonResponse.message;
                        alert.style.display = "block";
                    }                                         
                }catch(error){
                    console.error(error);
                }
        }

        const clearFields = () => {
            document.getElementById("user-form").reset();
            alert.style.display = "none";
        }
        
        const editUser = () => {

        }
    </script>
</x-layout>
