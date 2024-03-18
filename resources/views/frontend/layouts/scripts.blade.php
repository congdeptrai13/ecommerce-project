<script>
    $(document).ready(function() {
        simplyCountdown('.simply-countdown-one', {
            year: {{ date('Y', strtotime($flashSale->end_date)) }},
            month: {{ date('m', strtotime($flashSale->end_date)) }},
            day: {{ date('d', strtotime($flashSale->end_date)) }},
            enableUtc: true
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".shopping-cart-form").on("submit", function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                method: "POST",
                data: formData,
                url: "{{ route('add-to-cart') }}",
                success: function(data) {
                    updateCartCount();
                    fetchCartContent();
                    fetchMiniCartAmount();
                    $(".mini_cart_actions").removeClass("d-none");
                    toastr.success(data.message);
                },
                error: function(data) {

                }
            })
        })

        function updateCartCount() {
            $.ajax({
                method: "GET",
                url: "{{ route('cart-count') }}",
                success: function(data) {
                    $("#cart-count").text(data);
                },
                error: function(data) {

                }
            })
        }

        function fetchCartContent() {
            $.ajax({
                type: 'GET',
                url: "{{ route('cart-content') }}",
                success: function(data) {
                    $(".mini_cart_wrapper").html("");
                    let html = "";
                    for (let item in data) {
                        let product = data[item];
                        var totalPrice = (product.price + product.options.variants_total) * product
                            .qty;
                        html += `
                                        <li id="mini_cart_${product.rowId}">
                                            <div class="wsus__cart_img">
                                                <a href="#"><img src="{{ asset('/') }}${product.options.image} " alt="product"
                                                        class="img-fluid w-70"></a>
                                                <a class="wsis__del_icon remove_sidebar_product" href="#"
                                                    data-rowId="${product.rowId}"><i class="fas fa-minus-circle"></i></a>
                                            </div>
                                            <div class="wsus__cart_text">
                                                <a class="wsus__cart_title"
                                                    href="${product.options.slug}">${product.name}</a>
                                                <p>{{ $settings->currency_icon }}${totalPrice}
                                                </p>
                                            </div>
                                        </li>
                                        `;
                    }
                    $('.mini_cart_wrapper').html(html);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(error);
                }
            })
        }

        $("body").on("click", ".remove_sidebar_product", function(e) {
            e.preventDefault();
            let rowId = $(this).data('rowid');
            $.ajax({
                type: 'POST',
                url: "{{ route('mini-cart-remove') }}",
                data: {
                    rowId: rowId
                },
                success: function(data) {
                    let cartId = "#mini_cart_" + rowId;
                    $(cartId).remove();
                    fetchMiniCartAmount();
                    if ($(".mini_cart_wrapper").find("li").length === 0) {
                        $(".mini_cart_actions").addClass("d-none");
                        $(".mini_cart_wrapper").html(
                            "<p class='text-center'>Mini cart Empty</p>");
                    }
                    toastr.success(data.message);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(error);
                }
            })
        })


        //fetch amount mini cart
        function fetchMiniCartAmount() {
            $.ajax({
                type: 'GET',
                url: "{{ route('mini-cart-amount') }}",
                success: function(data) {
                    console.log(data);
                    $(".mini-cart-amount").text(
                        `{{ $settings->currency_icon }}${data}`);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(error);
                }
            })
        }


    })
</script>
