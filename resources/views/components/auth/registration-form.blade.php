<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 center-screen">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>Registration</h4>
                    <hr />
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Full Name</label>
                                <input id="name" placeholder="Full Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input id="email" placeholder="Email Address" class="form-control" type="email" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="Password" class="form-control" type="password" />
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onRegistration()"
                                    class="btn mt-3 w-100  bg-gradient-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function onRegistration() {

        let name = document.getElementById('name').value;
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;

        if (name.length === 0) {
            errorToast('Name is required')
        } else if (email.length === 0) {
            errorToast('Email is required')
        } else if (password.length === 0) {
            errorToast('Password is required')
        } else {

            let postData = {
                name: name,
                email: email,
                password: password
            }
            showLoader();
            let res = await axios.post("/user-register", postData)
            hideLoader();
            if (res.status === 200 && res.data['status'] === 'success') {
                successToast(res.data['msg']);
                setTimeout(function() {
                    window.location.href = '/login'
                }, 1000)
            } else {
                errorToast(res.data['msg'])
            }
        }
    }
</script>
