a<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>User Profile</h4>
                    <hr />
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input readonly id="email" placeholder="User Email" class="form-control"
                                    type="email" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Full Name</label>
                                <input id="name" placeholder="First Name" class="form-control" type="text" />
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2 d-flex">
                                <button onclick="onUpdate()" class="btn mt-3 w-100  bg-gradient-primary">Update</button>
                                <button onclick="window.location.href='/dashboard'"
                                    class="btn mt-3 ms-2 w-100 bg-gradient-primary">Dashboard</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    getProfile();
    async function getProfile() {
        showLoader();
        let res = await axios.get("/user-profile")
        hideLoader();
        if (res.status === 200 && res.data['status'] === 'success') {
            let data = res.data['data'];
            document.getElementById('email').value = data['email'];
            document.getElementById('name').value = data['name'];

        } else {
            errorToast(res.data['msg'])
        }

    }

    async function onUpdate() {

        let name = document.getElementById('name').value;

        if (name.length === 0) {
            errorToast('Name is required')
        } else {
            showLoader();
            let res = await axios.post("/user-update", {
                name: name,
            })
            hideLoader();
            if (res.status === 200 && res.data['status'] === 'success') {
                successToast(res.data['msg']);
                await getProfile();
            } else {
                errorToast(res.data['msg'])
            }
        }
    }
</script>
