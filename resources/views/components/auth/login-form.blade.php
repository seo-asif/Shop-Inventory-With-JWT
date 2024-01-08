<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
            <div class="card w-90  p-4">
                <div class="card-body">
                    <h4>LOG IN</h4>
                    <br />
                    <input id="email" placeholder="User Email" class="form-control" type="email" />
                    <br />
                    <input id="password" placeholder="User Password" class="form-control" type="password" />
                    <br />
                    <button onclick="SubmitLogin()" class="btn w-100 bg-gradient-primary">Next</button>
                    <hr />
                    <div class="float-end mt-3">
                        <span>
                            <a class="text-center ms-3 h6" href="{{ url('/registration') }}">Registration </a>
                            <span class="ms-1">|</span>
                            <a class="text-center ms-3 h6" href="{{ url('/sendotp') }}">Forget Password</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    async function SubmitLogin() {
        try {
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email.trim() === "" || password.trim() === "") {
                errorToast("Both email and Password Required");
            } else if (!emailRegex.test(email)) {
                errorToast('Invalid email format');
            } else if (password.length <= 3) {
                errorToast('Password should be more than 3 characters');
            } else {
                showLoader();

                let res = await axios.post("/user-login", {
                    email: email,
                    password: password
                });
                hideLoader();

                if (res.status === 200 && res.data['status'] == 'success') {
                    successToast('Login successful');
                    setTimeout(() => {
                        window.location.href = "/dashboard";
                    }, 1000);
                } else {
                    hideLoader();
                    errorToast(res.data['msg']);

                }
            }
        } catch (error) {
            hideLoader();
            // console.error("An error occurred:", error.message);
            // errorToast("An error occurred. Please try again.");
        }
    }
</script>
