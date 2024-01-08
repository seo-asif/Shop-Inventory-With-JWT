<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>EMAIL ADDRESS</h4>
                    <br/>
                    <label>Your email address</label>
                    <input id="email" placeholder="User Email" class="form-control" type="email"/>
                    <br/>
                    <button onclick="verifyEmail()"  class="btn w-100 float-end bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

async function verifyEmail() {
    let email = document.getElementById("email").value.trim();

    if (email.length === 0) {
        errorToast("Please enter your email address");
    } else {
        showLoader();

        try {
            let res = await axios.post("/send-otp", { email: email });
            hideLoader();

            if (res.status === 200 && res.data['status'] === 'success') {
                successToast(res.data['msg']);
                sessionStorage.setItem('email', email);
                setTimeout(() => {
                    window.location.href = '/verifyotp';
                }, 1000);
            } else {
                errorToast(res.data['msg']);
            }
        } catch (error) {

            console.error("Error:", error.message);
            hideLoader();
            errorToast("An error occurred while processing your request");
        }
    }
}
</script>
