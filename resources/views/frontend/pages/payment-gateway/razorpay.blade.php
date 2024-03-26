<div class="tab-pane fade show" id="v-pills-razorpay" role="tabpanel" aria-labelledby="v-pills-razorpay-tab">
    <div class="row">
        <div class="col-xl-12 m-auto">
            <div class="wsus__payment_area">
                <form action="{{ route('user.razorpay.payment') }}" method="POST">
                    @csrf
                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="{{}}"
                    >
                    </script>
                </form>
            </div>
        </div>
    </div>
</div>
